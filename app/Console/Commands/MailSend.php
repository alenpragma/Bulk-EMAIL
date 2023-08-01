<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\InsertLead;
use App\Models\Smtp;
use App\Models\Message;
use App\Models\User;
use App\Models\Image;
use App\Models\CampaignName;
use App\Models\ReplyTo;
use DB;
use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Carbon;
use Auth;
class MailSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

     public function handle()
     {
        $this->send();
        $this->limit();
     }
    public function send()
    {
        $userIds = User::where('limit', '>', 0)->select('id')->get()->pluck('id')->toArray();
        // $userIds = [1, 9, 10];
        // dd($userIds);
        foreach ($userIds as $key => $userIds) {
            # code...
        
        $message = Message::where('user_id',$userIds)->first()->msg_body;
        $Subject = Message::where('user_id',$userIds)->first()->subject;
        
        $message_id = Message::where('user_id',$userIds)->first();
        $Campaignname = CampaignName::where('user_id',$userIds)->first()->name;
        $ReplyTo = ReplyTo::where('user_id',$userIds)->first()->name;
    // dd($ReplyTo);
        require base_path("vendor/autoload.php");
        $Email_list = InsertLead::where('user_id',$userIds)->where('status',1)->get();
        
        foreach ($Email_list as $key=>$Email_lists) {
            // dd($Email_lists);
            
            
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
           
            // dd($FristSmtp);
            
           
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
}
    public function limit()
    {
        $oneDayAgo = Carbon::now()->subDay()->toDateString();
        $now = Carbon::now()->toDateString();

        $Email_list_Third = User::where('created_at', '=', $oneDayAgo)->get();
        // dd($Email_list_Third);
        $userRecords = User::where('created_at', '=', $oneDayAgo)->whereIn('sender_group', ['100k', '200k','300k'])->get();
        // dd($userRecords);
        foreach ($userRecords as $user) {
            if ($user->sender_group == '100k') {
                $newLimit = 100000;
                
            } elseif ($user->sender_group == '200k') {
                $newLimit = 200000;
                
            }else {
                $newLimit = 300000;
            }
    
            $user->limit = $newLimit;
            $user->created_at = $now;
            $user->save();
        }
    }
}


