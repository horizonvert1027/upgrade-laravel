<?php

namespace App\Models;

// use Laravel\Cashier\Billable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
	use Notifiable; //, Billable;

    public $timestamps = false;

    protected $fillable = [
        'username',
				'name',
				'userlevel',
				'bio',
				'email',
				'phonecode',
				'numberm',
				'password',
				'avatar',
				'cover',
				'status',
				'countries_id',
				'type_account',
				'website',
				'twitter',
				'paypal_account',
				'activation_code',
				'oauth_uid',
				'oauth_provider',
				'token',
				'authorized_to_upload',
				'role',
				'ip'
    ];

  
    protected $hidden = [
        'password', 'remember_token',
    ];

		public function sendPasswordResetNotification($token) {

        $this->notify(new ResetPasswordNotification($token));
    }

	public function images() {
        return $this->hasMany('App\Models\Images')->where('status','active');
    }

	public function images_pending() {
        return $this->hasMany('App\Models\Images')->where('status','pending');
    }

	public function country() {
        return $this->belongsTo('App\Models\Countries', 'countries_id')->first();
    }

	public static function totalImages($id){
		return \App\Models\Images::where('user_id', '=', $id )->where('status','active')->count();
	}



}
