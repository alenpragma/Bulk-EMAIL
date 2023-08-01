<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InsertLead;
use App\Models\Smtp;
use App\Models\Message;
use App\Models\User;
use App\Models\Image;
use App\Models\CampaignName;
use App\Models\ReplyTo;
use DB;
use Hash;
use Auth;
use Artisan;
use Illuminate\Support\Carbon;
use App\Imports\SmtpImport;
use App\Exports\SmtpExport;
use Maatwebsite\Excel\Facades\Excel;
use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;
class HomeController extends Controller
{
    public function mailSend(){
        $userIds = User::where('limit', '>', 0)->select('id')->get()->pluck('id')->toArray();

        foreach ($userIds as $key => $userIds) {
           
        
        $message = Message::where('user_id',$userIds)->first()->msg_body;
        $Subject = Message::where('user_id',$userIds)->first()->subject;
        
        $message_id = Message::where('user_id',$userIds)->first();
        $Campaignname = CampaignName::where('user_id',$userIds)->first()->name;
        $ReplyTo = ReplyTo::where('user_id',$userIds)->first()->name;
    
        require base_path("vendor/autoload.php");
        $Email_list = InsertLead::where('user_id',$userIds)->where('status',1)->get();
        
        foreach ($Email_list as $key=>$Email_lists) {
            
            
            
            $Smtp = Smtp::get()->toArray();
            $cc               = (int)count($Smtp);
            $smpt_ser         = $key%$cc;
            $sstm             = $Smtp[$smpt_ser];
       
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
     
        try {
            //Server settings
            $mail->SMTPDebug = false;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
           
            
            
           
            $mail->Host       = $sstm['host_name'];                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $sstm['emails'];                    //SMTP username
            $mail->Password   = $sstm['email_pass'];                               //SMTP password
            $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
            $mail->Port       = $sstm['imap_port'];
            
                                         
            $mail->setFrom($sstm['from_email'], $Campaignname);
        
            $mail->addReplyTo($ReplyTo, $Campaignname);
        
            
            $mail->addAddress($Email_lists->emails);
            
            

            $mid = $message_id->id;
            
            $images = Image::where('message_id', $mid)->get();
            
            foreach ($images as $image) {
                // dd($image->name);
                $mail->addAttachment(public_path('/backend/message/') . $image->name, $image->name);
            }
 
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $Subject;
            $mail->Body    = $message;
            
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->send();
            InsertLead::where('id',$Email_lists->id)->update(['status'=>0]);
            Smtp::where('id',$sstm['id'])->increment('limit','1');
            User::where('id',$userIds)->where('limit','>',0)->decrement('limit','1');
            
        } catch (Exception $e) {
           
        }
    }
    }
    return back()->with('success','Your Mails Have been sent');

    }
    public function showLogin(){
        return view('admin.login');
    }

    public function deleteOldImage($id){
        $msg = Message::where('user_id',auth::user()->id)->first();
        $img = Image::where('message_id',$msg->id)->first();
        $pp = public_path().'/backend/message/'.$img->name;
        $imgdel = Image::find($id);
        $imgdel->delete();
        
        if(file_exists($pp)){
            unlink($pp);
        }

        
       
       return back()->with('danger','User Deleted Successfully');

    }


    
    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if(auth()->attempt(['email' => $request->email, 'password' => $request->password])){
            if (auth()->user()->type == 1 || auth()->user()->type == 2) {
                return redirect()->route('home');
            }else{
                return redirect()->route('show_login');
            }
        }else{
            return redirect()->route('show_login')
                ->with('error','Email & Password are incorrect.');
        } 
    }
    public function logout() {
        Auth::logout();
        return redirect()->route('show_login');
    }
    public function index(){
        $total_mails = InsertLead::where('user_id',auth::user()->id)->count();
        $send_mails = InsertLead::where('user_id',auth::user()->id)->where('status',0)->count();
        $pending_mails = InsertLead::where('user_id',auth::user()->id)->where('status',1)->count();
        $message = Message::where('user_id',auth::user()->id)->count();
        $total_smtp = Smtp::count();
        
        return view('admin.index',compact('total_mails','send_mails','pending_mails','message','total_smtp'));
    }
    public function insertLeadShow(){
        return view('admin.create_insertleads');
    }
    public function regularSmtpShow(){
        return view('admin.create_regular_smtp');
    }

    public function insertLeads(){
  
        $insert_leads = DB::table('insert_leads')->where('user_id',auth::user()->id)->simplePaginate(100);
 
        return view('admin.insertleads',compact('insert_leads'));
    }
    public function regularSmtp(){
        
        
        $smtps = Smtp::all();
        return view('admin.regular_smtp',compact('smtps'));
    }

    public function message(){
        $msg = Message::where('user_id',auth::user()->id)->first();
        
        $image = Image::where('message_id',$msg->id)->first();
        return view('admin.create_message',compact('msg','image'));
    }

    public function smtpdownload(Request $request){
        return Excel::download(new SmtpExport, 'backup.csv');
    }

    public function smtpimport(Request $request)
    {
        $file = $request->file('file');
    
        if (($handle = fopen($file, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $smtp = new Smtp([
                    'host_name' => $data[0],
                    'imap_port' => $data[1],
                    'emails' => $data[2],
                    'email_pass' => $data[3],
                    'from_email' => $data[4],
                ]);
                // Save the SMTP object to the database or perform any other operations as needed
                $smtp->save();
            }
            fclose($handle);
        }
    
        return redirect('/regular/smtp')->with('success','Regular SMTP Added Successfully');
    }
    
    
    
   
    public function changePassword()
{
   return view('change-password');
}

public function updatePassword(Request $request)
{
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->with("error", "Old Password Doesn't match!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
}

public function sentsmtp(Request $request){
    

    $hostname = $request->hostname;
    $username = $request->username;
    $password = $request->password;
    $port = $request->port;
    $to = $request->to;
    $from_email = $request->from_email;
   

    require base_path("vendor/autoload.php");

    

       
           
    $mail = new PHPMailer(); 
	$mail->SMTPDebug  = 1;
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	 $mail->Host       = $hostname;
	 $mail->Port       = $port;
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = $username;
	$mail->Password =  $password;
	$mail->setFrom($from_email, 'Mailer');
	$mail->Subject = 'Here is the Test subject';
	$mail->Body  = 'Here is the Test Body';
	$mail->addAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo "<h1 style='color:Tomato;'>Send Message Faield</h1> <p>Check Your Smtp Server</p>";

	}else{
		echo "<h1 style='color:DodgerBlue;'>Send Message Successful</h1> <p>Check Your Mail Inbox/Spam</p>";
		
	}
}
    

}
