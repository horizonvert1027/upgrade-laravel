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


class DmcaController extends Controller
{
    public function dmca()
    {   
        $title = 'DMCA Infringement';
        $description = 'DMCA Report/complaint to get your content(s) removed. The Digital Millennium Copyright Act (DMCA) is a United States copyright law that provides online service providers who have content on their sites to be relieved from liability for copyright infringement if they promptly remove the offending content once notified of an alleged infringement by the Copyright owner or his designated Agent.';
        $keywords = 'dmca, dmca copyright,Copyright Act,cpmplaint,report,report file,copyright infringement,infringement';
        $thumbimage = url('/').'/public/img/apple/android-chrome-512x512.png';
        $sitemap = '';
        $contenturl = url('/').'/dmca';
        $rssfeed = '';
        return view('default.dmca',compact(['title', 'description', 'keywords','thumbimage','rssfeed','contenturl','sitemap']));
    }

    public function senddmca(Request $request)
    {
        $settings = AdminSettings::first();
        $data = request()->all();
        $validator = Validator::make(request()->all(),[
            'txtName' =>'required|max:255',
            'txtEmail' =>'required|email|max:25',
            'txtSubject' =>'required|max:100',
            'txtMsg' =>'required|max:255',
            'link' =>'required|max:255',
            'checkbox' =>'required',
            'number' =>'required|max:15',
            'address' =>'required|max:255',
        ]);

        if($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->with('error','haserror');
        }

        $name =  $data['txtName'];
        $email =  $data['txtEmail'];
        $subject =  $data['txtSubject'];     
        $msg =  $data['txtMsg'];
        $link =  $data['link'];
        $address = $data['address'];
        $number = $data['number'];
        $values = array(
            'name' => $name , 
            'email' => $email , 
            'subject' => $subject , 
            'message' => $msg ,  
            'link' => $link ,
            'address' => $address ,
            'number' => $number ,
        );
        DB::table('dmca')->insert($values);
        $fullname    = $name;
        $email_user  = $email;
        $title_site  = $settings->title;
        $email_reply = $settings->email_admin;
        return redirect()->back()->with('message' , 'hasmessage');
    }
}
