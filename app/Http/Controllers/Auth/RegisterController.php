<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Validator;
use App\Models\AdminSettings;
use App\Models\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

		$messages = array (
			"letters"    => trans('validation.letters')
        );

		 Validator::extend('ascii_only', function($attribute, $value, $parameters){
    		return !preg_match('/[^x00-x7F\-]/i', $value);
		});

		// Validate if have one letter
    	Validator::extend('letters', function($attribute, $value, $parameters){
        	return preg_match('/[a-zA-Z0-9]/', $value);
    	});

        return Validator::make($data, [
        //    'username'  => 'required|min:3|max:15|ascii_only|alpha_dash|letters|unique:users|unique:pages,slug|unique:reserved,name',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:4',
            'numberm' => 'required|min:10|max:10',
            'name' => 'required',

            
        ],$messages);
    }

	public function showRegistrationForm() {

     	$settings    = AdminSettings::first();

        $title = 'Register - ' . $settings->sitename;
        $description = 'Login - ' . $settings->sitename;
        $keywords = 'Register, sign up,';
        $thumbimage = url('/').'/public/img/apple/android-chrome-512x512.png';
        $sitemap = '';
        $contenturl = url('/register');
        $rssfeed = '';

       

        
		if( $settings->registration_active == 1 ) 
        {
            if( !session('register_referer') )
            {
                $referer = request()->headers->get('referer');
                session(['register_referer' => $referer]);    
            }
			 return view('auth.register',compact(['title', 'description', 'keywords','thumbimage','rssfeed','contenturl','sitemap']));
		} 
        else 
        {
            return redirect('/');
		}

     }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
    	$settings    = AdminSettings::first();
        $_name          = $data['name'];
        if( !isset($data['username']) )
        {
			$_username         = strtolower(Str::slug(" ", "", $_name))."_".Str::random(5);
	        $data['username']  = $_username;
        }else{
        	$_username = $data['username'];
        }

		// Verify Settings Admin
		if( $settings->email_verification == '1' ) 
		{

			$confirmation_code = Str::random(100);
			$status = 'pending';

			//send verification mail to user
			$_name          = $data['name'];
         	$_email_user    = $data['email'];
		 	$_title_site    = 'Verification for'.config('app.urlname');
		 	$_email_noreply = 'no-reply@'.config('app.urlname');

		 	Mail::send('emails.verify', array('confirmation_code' => $confirmation_code),
		 	function($message) use (
				 $_username,
				 $_email_user,
				 $_title_site,
				 $_email_noreply
		 	) {
                $message->from($_email_noreply, $_title_site);
                $message->subject(trans('users.title_email_verify'));
                $message->to($_email_user,$_username);
            });

		} else {
			$confirmation_code = '';
			$status            = 'active';
		}

		$token = Str::random(75);

        $countries = Countries::where('phonecode',$data['phonecode'])->get();
        if( $countries ){
            $country = $countries[0];
            $data['countries_id'] = $country->id;
        } else 
        {
            $data['countries_id'] = "";
        }   

        return User::create([
			'username'        => $data['username'],
			'name'            => $data['name'],
			'password'        => bcrypt($data['password']),
            'phonecode'       => $data['phonecode'],
            'numberm'         => $data['numberm'],
			'email'           => strtolower($data['email']),
			'avatar'          => 'default.jpg',
			'cover'           => 'cover.jpg',
			'status'          => $status,
            'countries_id'    => $data['countries_id'],
			'type_account'    => '1',
            'authorized_to_upload' => 'no',
            'website'         => '',
			'activation_code' => $confirmation_code,
			'token'           => $token,
		]);
    }

}
