<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
Class Emptysearches
Saving searche query which got empty responses.
*/

class Emptysearches extends Model {

	protected $guarded = array();
	public $timestamps = false;

	protected $fillable = [
        'q', 'responses'
    ];
	
    	
}