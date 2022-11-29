<?php namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\AdminSettings;
use App\Models\User;
use App\Models\Images;
use App\Models\Notifications;
use App\Models\Pages;
use Illuminate\Http\Request;

trait userTraits {

    public function deleteUser($id) {

		$user = User::findOrFail($id);

		// Delete Notification
		$notifications = Notifications::where('author',$id)
		->orWhere('destination', $id)
		->get();

		if(  isset( $notifications ) ){
			foreach($notifications as $notification){
				$notification->delete();
			}
		}

		// Images Reported
		$images_reporteds = ImagesReported::where('user_id', '=', $id)->get();

		if(  isset( $images_reporteds ) ){
			foreach ($images_reporteds as $images_reported ) {
					$images_reported->delete();
				}// End
		}

		// Images
	    //$images = Images::where('user_id', '=', $id)->get();
		
		// User Reported
		$users_reporteds = UsersReported::where('user_id', '=', $id)->orWhere('id_reported', '=', $id)->get();

		if(  isset( $users_reporteds ) ){
			foreach ($users_reporteds as $users_reported ) {
					$users_reported->delete();
				}// End
		}

		//<<<-- Delete Avatar -->>>/
		$fileAvatar    = 'public/avatar/'.$user->avatar;

		if ( \File::exists($fileAvatar) && $user->avatar != 'default.jpg' ) {
			\File::delete($fileAvatar);
		}//<--- IF FILE EXISTS

		//<<<-- Delete Cover -->>>/
		$fileCover  = 'public/cover/'.$user->cover;

		if ( \File::exists($fileCover) && $user->cover != 'cover.jpg' ) {
			\File::delete($fileCover);
		}//<--- IF FILE EXISTS

		// User Delete
		$user->delete();

    }//<-- End Method
}
