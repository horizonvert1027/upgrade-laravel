<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model {

	protected $guarded = array();
	public $timestamps = false;
	
	public function images() {
		return $this->hasMany('App\Models\Images')->where('status','active');
	}
	
}