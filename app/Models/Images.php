<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Traits\Search;

class Images extends Model
{
	use Search;
	protected $guarded = array();
	public $timestamps = false;
	protected $fillable = [
        'title', 'description', 'categories_id', 'tags', 'hash'];

		protected $searchable = [
	        'title',
	        'tags'
	    ];
	public function user() {
        return $this->belongsTo('App\Models\User')->first();
    }
	 public function category() {
	 	 return $this->belongsTo('App\Models\Categories', 'categories_id');
	 }
	  public function subcategories() {
	 	 return $this->belongsTo('App\subcategories', 'subcategories_id');
	 }
	  public function tags() {
	 	 return $this->hasMany('App\Models\Images', 'tags');
	 }
}
