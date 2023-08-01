<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InsertLead;
use App\Models\Smtp;
use App\Models\Message;
use App\Models\Image;
use App\Models\User;
use App\Models\CampaignName;
use App\Models\ReplyTo;
use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;
use Auth;
use Hash;
use Carbon\Carbon;
class InsertLeadsController extends Controller
{
    public function insertLeadStore(Request $request){
        if(!empty($request->emails)){
            $emails_arr = explode("\r\n", $request->emails);
            foreach($emails_arr as $email){
                $this->validate($request, [
                    'emails'     => 'required|email',
                ]);
                $insert_lead           = new InsertLead;
                
                $insert_lead->emails   = $email;
                $insert_lead->user_id  = auth::user()->id;
                $insert_lead->save();
            }
        }
        if(!empty($request->txt_emails)){
            $this->validate($request, [
                'txt_emails'     => 'required|mimes:txt',
            ]);

            foreach(file($request->txt_emails) as $email){
                $txt_email             = str_replace("\r\n",'',$email);
                $insert_lead           = new InsertLead;
                
                $insert_lead->emails   = $email;
                $insert_lead->user_id  = auth::user()->id;
                $insert_lead->save();
            }
    
        }
        return redirect('/insertleads')->with('success','Insert Leads Added Successfully');
    }
    public function deleteAllMail(){
        InsertLead::query()->where('user_id',auth::user()->id)->delete();
        return back()->with('danger','Insert leads mail deleted Successfully');
    }
    public function deleteMail($id){
        $dlt_smtp = InsertLead::find($id);
        $dlt_smtp->delete();
        return back()->with('danger','Insert leads mail deleted Successfully');
    }
    public function regularSmtpStore(Request $request){
  
        $smtp = new Smtp;
        $smtp->from_email  = $request->from_email;
        $smtp->emails     = $request->emails; 
        $smtp->email_pass = $request->email_pass;
        $smtp->host_name  = $request->host_name;
        $smtp->imap_port  = $request->imap_port;
        
        $smtp->limit      = $request->limit;
        $smtp->save();    
        return redirect('/regular/smtp')->with('success','Regular SMTP Added Successfully');
    }
    public function messageStore(Request $request,$id){
        $message           = Message::where('user_id',auth::user()->id)->first();

            $message = Message::find($id);
            
            $message->subject  = $request->subject;
            $message->msg_body = $request->msg_body;
            $message->file_status = $request->file_status;
            $message->user_id  = auth::user()->id;
            $message->save();
            $images = [];
            if ($request->images){
                foreach($request->images as $key => $image)
                {
                    $imageName = time().rand(1,99).'.'.$image->extension();  
                    $image->move(public_path('/backend/message'), $imageName);
            
                    $newImage = new Image;
                    $newImage->name = $imageName;
                    $newImage->message_id = $message->id;
                    $newImage->save();
                }

        }
  
        return back()->with('success','Message Added Successfully');

    }
    public function deleteSmtp($id){
        $smtp = Smtp::find($id);
        $smtp->delete();
        return back()->with('danger','Smtp Deleted Successfully');
    }

    public function deleteallSmtp(){
        Smtp::truncate();
        
        return back()->with('danger','Smtp Deleted Successfully');
    }
    public function editSmtp($id){

        $smtp = Smtp::find($id);
        return view('admin.edit_smtp',compact('smtp'));
    }
    public function testSmtp($id){

        $smtp = Smtp::find($id);
        return view('admin.test_smtp',compact('smtp'));
    }

    public function updateLimit(Request $request)
{
    $newLimit = $request->input('limit');

    Smtp::query()->update(['limit' => $newLimit]);

    return redirect()->back()->with('success', 'Limit updated successfully');
}



    
    public function updateSmtp(Request $request,$id){
        $smtp             = Smtp::find($id);
        $smtp->from_email  = $request->from_email;
        $smtp->emails     = $request->emails; 
        $smtp->email_pass = $request->email_pass;
        $smtp->host_name  = $request->host_name;
        $smtp->imap_port  = $request->imap_port;
         
        $smtp->limit      = $request->limit; 
        $smtp->save();    
        return redirect('/regular/smtp')->with('success','Regular SMTP Updated Successfully');

    }
    public function status($id){

        $status = Smtp::find($id);

        if($status->status==0){
            $status->status = 1;
            $status->save();
            return back()->with('status','Your Status Inactive  Successfully');
        }else{
            $status->status = 0;
            $status->save();
            return back()->with('status','Your Status Active Successfully');
        }
    }

    public function users(){
        $users = User::all();
        return view('admin.users',compact('users'));
    }

    public function user_make(){
        
        return view('admin.user_make');
    }

    public function user_post(Request $request){
        $user          = new User;
        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->password = Hash::make($request->password);
        $user->sender_group   = $request->sender_group;
        $user->limit   = $request->limit;
        $user->type   = $request->type;
        $user->created_at   = Carbon::now()->toDateString();
        $user->save();

        $message = new Message;
        $message->subject  = "test";
        $message->msg_body = "test";
        $message->user_id  = $user->id;
        $message->save();

        $CampaignName = new CampaignName;
        $CampaignName->name = "test";
        $CampaignName->user_id = $user->id;
        $CampaignName->save();

        $ReplyTo = new ReplyTo;
        $ReplyTo->name = $request->email;
        $ReplyTo->user_id = $user->id;
        $ReplyTo->save();

        return redirect('/users')->with('success','Regular SMTP Updated Successfully');
}

public function user_edit($id){
    $user_edit = User::find($id);
    return view('admin.user_edit',compact('user_edit'));
}

public function user_edit_post(Request $request,$id){
    $user = User::find($id);
    $user->name  = $request->name;
    $user->email     = $request->email;
    $user->sender_group   = $request->sender_group;
    $user->limit = $request->limit;
    $user->save();
    return redirect('/users')->with('success','pop / imap edit Successfully');
}

public function delete_user($id)
{
    
    $user_delete = User::find($id);
    $id = $user_delete->id;
    $user_msg = Message::where('user_id',$id)->first();
    $user_msg->delete();
    $user_Campaign = CampaignName::where('user_id',$id)->first();
    $user_Campaign->delete();
    $ReplyTo = ReplyTo::where('user_id',$id)->first();
    $ReplyTo->delete();
    $user_delete->delete();

    return redirect()->back()->with('success', 'User deleted successfully');
}

    public function limitupdate()
        {
            
            $oneDayAgo = Carbon::now()->subDay()->toDateString();
            $now = Carbon::now()->toDateString();

            $Email_list_Third = User::where('created_at', '=', $oneDayAgo)->get();
            dd($Email_list_Third);
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

            $Smtp = Smtp::get()->first();
            $Smtp->limit = 0;
            $Smtp->save();
            
        }

        public function Campaign_Name(){
            $Campaign_Name = CampaignName::where('user_id',auth::user()->id)->first();

            
            return view('admin.Campaign_Name',compact('Campaign_Name'));
        }

        public function ReplyTo(){
            $ReplyTo = ReplyTo::where('user_id',auth::user()->id)->first();

            
            return view('ReplyTo',compact('ReplyTo'));
        }

        public function Campaign_Name_update(Request $request,$id){
            $Campaign_Name           = CampaignName::where('user_id',auth::user()->id)->first();

            $Campaign_Name = CampaignName::find($id);
            
            $Campaign_Name->name  = $request->name;
            $Campaign_Name->save();
            return redirect('Campaign_Name')->with('success','Campaign Update Successfully');
        }

        public function ReplyTo_update(Request $request,$id){
            $Campaign_Name           = ReplyTo::where('user_id',auth::user()->id)->first();

            $Campaign_Name = ReplyTo::find($id);
            
            $Campaign_Name->name  = $request->name;
            $Campaign_Name->save();
            return redirect('ReplyTo')->with('success','ReplyTo Update Successfully');
        }

}
