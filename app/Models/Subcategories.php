<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subcategories extends Model
    {

	protected $guarded = array();
	public $timestamps = false;
	
	public function images() {
		return $this->hasMany('App\Models\Images')->where('status','active');
	}
}
