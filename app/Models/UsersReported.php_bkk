<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersReported extends Model {

	protected $guarded = array();
	public $timestamps = false;
	
	public function user(){
		return $this->belongsTo('App\Models\User')->first();
	}
	 
	 public function user_reported(){
		return $this->belongsTo('App\Models\User','id_reported')->first();
	}

}