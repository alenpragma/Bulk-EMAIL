<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\InsertLead;
use App\Models\Smtp;
use App\Models\Message;
use DB;
use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;

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
        require base_path("vendor/autoload.php");
        




        $insert_leads = InsertLead::all();
        $msg          = Message::first();
        $smtps        = Smtp::where('limit','>',0)->get()->toArray();
        $cc           = (int)count($smtps);


        $temp = 0;
        $max =  count($smtps)-1;

     
        foreach($insert_leads as $key=>$user) {
        
            $sstm     = $smtps[$temp];
            print_r($sstm);
            $mail = new PHPMailer(true); 
            try{
                $mail->SMTPDebug = false;
                $mail->isSMTP();
                $mail->Host       = $sstm['host_name'];             
                $mail->SMTPAuth   = true;
                $mail->Username   = $sstm['emails'];  
                $mail->Password   = $sstm['email_pass'];    
                $mail->SMTPSecure = 'tls';               
                $mail->Port       = $sstm['imap_port'];                         

                $mail->setFrom($sstm['emails'], $sstm['from_name']);

                $mail->addAddress($user->emails);                
            
                $mail->isHTML(true);              

                $mail->Subject = $msg->subject;
                $mail->Body    = $msg->msg_body;

                if($mail->send()) {
                    Smtp::where('id',$sstm['id'])->where('limit','>',0)->decrement('limit','1');
                    InsertLead::where('id',$user->id)->update(['status'=>0]);
                    echo  "Email has been sent.";
                }
            }catch (Exception $e) {
                //
            }
            
            if($temp == $max){
                $temp = 0;
            }else{
                $temp++;
            }
            
        }
  
    }
}

