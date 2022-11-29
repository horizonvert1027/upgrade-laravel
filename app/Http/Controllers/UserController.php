<?php
 namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Query;
use App\Models\AdminSettings;
use App\Models\UsersReported;
use App\Models\ImagesReported;
use App\Models\Images;
use App\Models\Notifications;
use App\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Image;
use DB;

class UserController extends Controller {

	use Traits\userTraits;

	public function __construct( AdminSettings $settings) {
		$this->settings = $settings::first();
	}

	protected function validator(array $data, $id = null) {

    	Validator::extend('ascii_only', function($attribute, $value, $parameters){
    		return !preg_match('/[^x00-x7F\-]/i', $value);
		});

			// Validate if have one letter
		Validator::extend('letters', function($attribute, $value, $parameters){
	    	return preg_match('/[a-zA-Z0-9]/', $value);
		});

		return Validator::make($data, [
	        'full_name' => 'required|min:3|max:25',
			'username'  => 'required|min:3|max:15|ascii_only|alpha_dash|letters|unique:pages,slug|unique:reserved,name|unique:users,username,'.$id,
			'email'     => 'required|email|unique:users,email,'.$id,
			'numberm'   =>  'required|min:10|max:10',
	        'website'   => 'url',
	        'facebook'   => 'url',
	        'twitter'   => 'url',
			'instagram'   => 'url',
	        'description' => 'max:200',
	    ]);
    }//<--- End Method

    public function profile($slug, Request $request) 
    {
    	$slug 	= Str::replaceArray('~', [''], urldecode($slug));
		$user   = User::where('username', '=', $slug )->firstOrFail();
		$title  = e( $user->username );

		if($user->status == 'suspended') {
			return view('errors.user_suspended');
		}
		
		$images = Query::userImages($user->id);
		if( $request->input('page') > $images->lastPage() ) 
		{
			abort('404');
		}

		//<<<-- * Redirect the user real name * -->>>
		$uri = request()->path();
		$uri = Str::replaceArray('~', [''],$uri);
		$uri = Str::replaceArray('%20', [''],$uri);
		$uriCanonical = $user->username;
		// //echo $uri."{".$uriCanonical;die();
		// if( $uri != $uriCanonical ) 
		// {
		// 	return redirect($uriCanonical);
		// }

	
        $description = $title;
        $keywords = $title . 'Member, User, Oye be smartest user' ;
        $thumbimage = url(config('path.avatars')) . '/' . $user->avatar ;
        $sitemap = '';
        $contenturl = url('/');
        $rssfeed = url('/').'/rssfeeds';
		return view('users.profile',compact(['user', 'title', 'description', 'keywords','thumbimage','rssfeed','contenturl','sitemap','images']));

    }//<--- End Method

      

    

    public function account()
    {
		return view('users.account');
    }//<--- End Method

	public function update_account(Request $request)
    {
    	$input = $request->all();
	   	$id = Auth::user()->id;

	   	$validator = $this->validator($input,$id);

		if ($validator->fails()) {
        	return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
    	}

	   $user = User::find($id);
	   $user->name        = $input['full_name'];
	   $user->email        = trim($input['email']);
	   $user->username = $input['username'];
	   $user->numberm = $input['numberm'];
	   
	   $user->countries_id    = $input['countries_id'];
	   $user->website     = trim(strtolower($input['website']));
	   $user->facebook  = trim(strtolower($input['facebook']));
	   $user->twitter       = trim(strtolower($input['twitter']));
	   $user->instagram  = trim(strtolower($input['instagram']));
	   $user->bio = $input['description'];
	   $user->save();

	   \Session::flash('notification',trans('auth.success_update'));

	   return redirect('account');

	}//<--- End Method

	public function password()
    {
		return view('users.password');
    }//<--- End Method

    public function update_password(Request $request)
    {

	   $input = $request->all();
	   $id = Auth::user()->id;

		   $validator = Validator::make($input, [
			'old_password' => 'required|min:6',
	        'password'     => 'required|min:6',
    	]);

			if ($validator->fails()) {
         return redirect()->back()
						 ->withErrors($validator)
						 ->withInput();
					 }

	   if (!\Hash::check($input['old_password'], Auth::user()->password) ) {
		    return redirect('account/password')->with( array( 'incorrect_pass' => trans('misc.password_incorrect') ) );
		}

	   $user = User::find($id);
	   $user->password  = \Hash::make($input[ "password"] );
	   $user->save();

	   \Session::flash('notification',trans('auth.success_update_password'));

	   return redirect('account/password');

	}//<--- End Method

	public function delete()
    {
    	if( Auth::user()->id == 1 ) {
    		return redirect('account');
    	}
		return view('users.delete');
    }//<--- End Method

    public function delete_account(){

	$id = Auth::user()->id;

	$user = User::findOrFail($id);

	 if( $user->id == 1 ) {
	 	return redirect('account');
		exit;
	 }

	 $this->deleteUser($id);

      return redirect('account');

    }//<--- End Method

 


    public function upload_avatar(Request $request){

	   	$id = Auth::user()->id;

		$validator = Validator::make($request->all(), [
		'photo' => 'required|mimes:jpg,gif,png,jpe,jpeg|dimensions:min_width=180,min_height=180|max:'.$this->settings->file_size_allowed.'',]);

		if ($validator->fails()) {
	        return response()->json([
			        'success' => false,
			        'errors' => $validator->getMessageBag()->toArray(),
			    ]);
		}

		// PATHS
		$temp    = 'public/temp/';
	    $path    = config('path.avatars');
		$imgOld  = $path.Auth::user()->avatar;

		 //<--- HASFILE PHOTO
	    if( $request->hasFile('photo') )	{

			$extension  = $request->file('photo')->getClientOriginalExtension();
			$avatar       = strtolower(Auth::user()->username.'-'.Auth::user()->id.time().Str::random(10).'.'.$extension );

			if( $request->file('photo')->move($temp, $avatar) ) 
			{
				set_time_limit(0);
				Helper::resizeImageFixed( $temp.$avatar, 180, 180, $temp.$avatar );

				// Copy folder
				if ( \File::exists($temp.$avatar) ) {
					/* Avatar */
					\File::copy($temp.$avatar, $path.$avatar);
					\File::delete($temp.$avatar);
				}//<--- IF FILE EXISTS

				//<<<-- Delete old image -->>>/
				if ( \File::exists($imgOld) && $imgOld != $path.'default.jpg' ) 
				{
					\File::delete($temp.$avatar);
					Storage::delete($imgOld);
					\File::delete($imgOld);
				}//<--- IF FILE EXISTS #1

				$image = Image::make($path.$avatar);
				Storage::put($path.$avatar, $image, 'public');
				Storage::url($path.$avatar);

				// Update Database
				User::where( 'id', Auth::user()->id )->update( array( 'avatar' => $avatar ) );

				return response()->json([
				        'success' => true,
				        'avatar' => url($path.$avatar),
				    ]);

			}// Move
	    }//<--- HASFILE PHOTO
    }//<--- End Method Avatar

    public function upload_cover(Request $request){

	   $settings  = AdminSettings::first();
	   $id = Auth::user()->id;

		$validator = Validator::make($request->all(), [
		'photo' => 'required|mimes:jpg,gif,png,jpe,jpeg|dimensions:min_width=800,min_height=600|max:'.$settings->file_size_allowed.'',
	]);

		   if ($validator->fails()) {
		        return response()->json([
				        'success' => false,
				        'errors' => $validator->getMessageBag()->toArray(),
				    ]);
		    }

		// PATHS
		$temp    = 'public/temp/';
	    $path    = config('path.covers');
		$imgOld      = $path.Auth::user()->cover;

		 //<--- HASFILE PHOTO
	    if( $request->hasFile('photo') )	{

			$extension  = $request->file('photo')->getClientOriginalExtension();
			$cover       = strtolower(Auth::user()->username.'-'.Auth::user()->id.time().Str::random(10).'.'.$extension );

			if( $request->file('photo')->move($temp, $cover) ) {

				set_time_limit(0);

				//=============== Image Large =================//
				$width  = Helper::getWidth( $temp.$cover );
				$height = Helper::getHeight( $temp.$cover );
				$max_width = '1500';

				if( $width < $height ) {
					$max_width = '800';
				}

				if ( $width > $max_width ) {
					$scale = $max_width / $width;
					$uploaded = Helper::resizeImage( $temp.$cover, $width, $height, $scale, $temp.$cover );
				} else {
					$scale = 1;
					$uploaded = Helper::resizeImage( $temp.$cover, $width, $height, $scale, $temp.$cover );
				}

				// Copy folder
				if ( \File::exists($temp.$cover) ) {
					/* Avatar */
					\File::copy($temp.$cover, $path.$cover);
					\File::delete($temp.$cover);
				}//<--- IF FILE EXISTS

				//<<<-- Delete old image -->>>/
				if ( \File::exists($imgOld)  && $imgOld != $path.'cover.jpg'  ) 
				{
					\File::delete($temp.$cover);
					\File::delete($imgOld);
					Storage::delete($imgOld);
				}//<--- IF FILE EXISTS #1

				$image = Image::make($path.$cover);
				Storage::put($path.$cover, $image, 'public');

				Storage::url($path.$cover);

				// Update Database
				User::where( 'id', Auth::user()->id )->update( array( 'cover' => $cover ) );

				return response()->json([
				        'success' => true,
				        'cover' => url($path.$cover),
				    ]);

			}// Move
	    }//<--- HASFILE PHOTO
    }//<--- End Method Cover

   

   
   

	public function photosPending(Request $request) {

		$images = Images::where('user_id',Auth::user()->id)->where('status','pending')->paginate( $this->settings->result_request );

		if( $request->input('page') > $images->lastPage() ) {
			abort('404');
		}

 		return view('users.photos-pending', [ 'images' => $images] );
    }//<--- End Method

}
