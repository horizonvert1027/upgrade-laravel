<?php

namespace App\Http\Controllers;
use app\Mail\ContactFormMail;
use Illuminate\Http\Request;
use App\Models\AdminSettings;
use Response;
use DB;
use session;
use Mail;
use Validator;


class ContactController extends Controller
{
    public function index()
    {
        $title = 'Contact Us';
        $description = 'helpline Contact Us regarding Suggestion, issue, advertisments, etc.';
        $keywords = 'contact us,contact page,help,helpline,help desk,number,email,help form,advertise,suggestion form,suggestion help, help contact';
        $thumbimage = url('/').'/public/img/apple/android-chrome-512x512.png';
        $sitemap = '';
        $contenturl = url('/').'/contact-us';
        $rssfeed = '';
        return view('default.contact',compact(['title', 'description', 'keywords','thumbimage','rssfeed','contenturl','sitemap']));
    }
    
    public function sendmail(Request $request)
    {
        $settings = AdminSettings::first();
        $data = request()->all();
        $validator = Validator::make(request()->all(),[
            'txtName' =>'required|max:25',
            'txtEmail' =>'required|email|max:100',
            'txtSubject' =>'required|max:125',
            'txtMsg' =>'required|max:500',
            'status' =>'required',
            'purpose' =>'required|not_in:0',
            'g-recaptcha-response' => 'recaptcha',
        ]);

        if($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withErrors($errors);
        }

        $name =  $data['txtName'];
        $email =  $data['txtEmail'];
        $subject =  $data['txtSubject'];     
        $msg =  $data['txtMsg'];
        $status =  $data['status'];
        $purpose =  $data['purpose'];
        $values = array(
            'name' => $name , 
            'email' => $email , 
            'subject' => $subject , 
            'message' => $msg , 
            'status' => $status , 
            'purpose' => $purpose , 
        );
        DB::table('subscribers')->insert($values);

        $fullname    = $name;
        $email_user  = $email;
        $title_site  = $settings->title;
        $email_reply = $settings->email_admin;

        // Check contactus_email is set ON.
        if( $settings->contactus_email == '1' )
        {
            Mail::send('emails.contact-email', array(
             'full_name' => $fullname,
             'purpose' => $purpose,
             'email' => $email,
             'subject' => $subject,
             '_message' => $msg
            ),
             function($message) use (
                 $fullname,
                 $email_user,
                 $title_site,
                 $email_reply,
                 $subject
             ) {
                $message->from($email_reply, $fullname);
                $message->subject(trans('misc.message').' - '.$subject.' - '.$email_user);
                $message->to($email_reply, $title_site);
                $message->replyTo($email_user);
            });
        }

        return redirect()->back()->with('message' , 'hasmessage');
        //Mail::to('test@test.com')->send(new ContactFormMail());
    }

     public function sendmailsubscribers()
    {
        $data = request()->validate([
            'txtEmail' =>'required|email',
            'txnNumber' =>'required',
            'status' =>'required',

        ]);

        $email =  $data['txtEmail'];
        $number =  $data['txnNumber'];
        $status =  $data['status'];
        $values = array(
            'email' => $email , 
            'number' => $number , 
            'status' => $status , 
        );
         DB::table('subscribers')->insert($values);
         return redirect()->back();

        //Mail::to('test@test.com')->send(new ContactFormMail());
    }

    public  function csv()
    {
        $csv = $_GET['csv'];
        if($csv == 'all'){
            $table = DB::table('subscribers')->get();
        }
        else{
            $table = DB::table('subscribers')->where('status' , $csv )->get();
        }

        if($csv == 'all' || $csv == 'subscriber' ||  $csv == 'contact')
        {
            $filename = "subscribers.csv";
            $handle = fopen($filename, 'w+');
            fputcsv($handle, array( 'Name', 'Email' , 'Number' , 'Message'));

            foreach($table as $row) {
                fputcsv($handle, array($row->name , $row->email , $row->number ,$row->message ));
            }

            fclose($handle);
            $headers = array(
                'Content-Type' => 'text/csv',
            );
            return Response::download($filename, 'subscribers.csv', $headers);
        }
        else
        {
            $table = DB::table('users')->get();
            $filename = "subscribers.csv";
            $handle = fopen($filename, 'w+');
            fputcsv($handle, array( 'Name' , 'Number', 'Email' ));

            foreach($table as $row) {
                fputcsv($handle, array('OBS '.''.''.$row->name, '+'.$row->phonecode.$row->numberm, $row->email ));
            }

            fclose($handle);
            $headers = array(
                'Content-Type' => 'text/csv',
            );
            return Response::download($filename, 'allusers.csv', $headers);
        }
    }
}
