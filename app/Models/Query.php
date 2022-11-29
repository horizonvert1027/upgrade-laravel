<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Request as Input;
use Illuminate\Support\Str;
use App\Models\Images;
use App\Models\User;
use App\Models\AdminSettings;
use App\Models\Categories;
use App\subcategories;
use App\Helper;


class Query extends Model
{

	protected $guarded = array();
	public $timestamps = false;


	public static function users() {

		$settings = AdminSettings::first();
	 	$page      = Input::get('page');
	 	$sort      =  Input::get('sort');
	 
		 if( $sort == 'latest' ) 
		 {
		 	$sortQuery = 'users.id';
		 } 
		 else if( $sort == 'photos'  ) 
		 {
		 	$sortQuery = 'COUNT(images.id)';
		 } 
		 else 
		 {
		 	$sortQuery = 'users.role';
		 }

		$data = User::where('users.status','active'); 

	 	// PHOTOS
		if( $sort == 'photos' ) 
		{
			$data->leftjoin('images', 'users.id', '=', \DB::raw('images.user_id AND images.status = "active"'));
		}

		$query = $data->where('users.status', '=', 'active')
			->groupBy('users.id')
			->orderBy(\DB::raw($sortQuery), 'DESC')
			->orderBy('users.id', 'ASC')
			->select('users.*')
			->paginate($settings->result_request)->onEachSide(1);
		$location = "";
		return ['data' => $query, 'page' => $page, 'sort' => $sort, 'location' => $location];

	}//<---- End Method

	//Search
	public static function searchImages() {

		$settings = AdminSettings::first();

		$q    = request()->get('q');
		$q = str_replace('-', ' ', $q);
		$page = request()->get('page');
		$words = explode(' ', $q);

		if( count($words) > 0 )
		{
			$images = Images::where('subgroup','LIKE', '%'.$q.'%')->where('status','active')->orderBy('date','DESC')->paginate($settings->result_request)->onEachSide(1);	

			if( $images->total() == 0 )
			{
				$images = Images::where('metakeywords','LIKE', '%'.$q.'%')->orWhere('subgroup','LIKE', '%'.$q.'%')->where('status','active')->orderBy('id','DESC')->paginate($settings->result_request)->onEachSide(1);
			}
		}
		else
		{
			$images = Images::where('metakeywords','LIKE', '%'.$q.'%')->orWhere('subgroup','LIKE', '%'.$q.'%')->where('status','active')->orderBy('id','DESC')->paginate($settings->result_request)->onEachSide(1);
		}

		
		if($images->total() == 0) {

		}

		$title = trans('misc.result_of').' '. $q .' - ';
		$total = $images->total();

		return ['images' => $images, 'page' => $page, 'title' => $title, 'total' => $total, 'q' => $q];

	}//<---- End Method

	public static function latestImages() {

		$settings = AdminSettings::first();

		$data = Images::where('status','active')->orderBy('date','DESC')->paginate($settings->result_request)->onEachSide(1);

		return $data;

	}//<---- End Method

	public static function featuredImages() {

		$settings = AdminSettings::first();

		$data = Images::where('featured', 'yes')->where('status','active')->orderBy('featured_date','DESC')->paginate($settings->result_request)->onEachSide(1);

		return $data;

	}//<---- End Method


	public static function categoryImages($slug) {

		$settings = AdminSettings::first();
		
		$category = Categories::where('slug','=',$slug)->first();

		if( !$category )
		{
			return Query::subcategoriesImages($slug);
		}
		$images = Images::where('status', 'active')->where('categories_id',$category->id)->orderBy('date','DESC')->paginate($settings->result_request)->onEachSide(1);
		$total = $images->total();

		return ['images' => $images, 'category' => $category, 'total' => $total];

	}//<---- End Method

	public static function subcategoriesImages($slug) 
	{
		$settings = AdminSettings::first();

		$subcategory = Subcategories::where('slug','=',$slug)->firstOrFail();
	
	    $images   = Images::where('status', 'active')->where('subcategories_id',$subcategory->id)->orderBy('date','DESC')->paginate($settings->result_request)->onEachSide(1);

		return ['images' => $images, 'subcategory' => $subcategory];
	}//<---- End Method

	public static function subcategoryIdImages($id) 
	{
		$settings = AdminSettings::first();
	    $images   = Images::where('status', 'active')->where('subcategories_id',$id)->orderBy('id','DESC')->paginate(6)->onEachSide(1);
		return ['images' => $images];
	}

	public static function subgroupImages($tags) {

		$settings = AdminSettings::first();

		$page = Input::get('page');

		$images = Images::where( 'subgroup','LIKE', '%'.$tags.'%' )
		->where('status', 'active' )
		->groupBy('id')
		->orderBy('date', 'desc' )
		->paginate($settings->result_request,['*'], 'page', (int)$page)->onEachSide(1);

		$title = 'Group - '. $tags;

		$total = $images->total();

		return ['images' => $images, 'title' => $title, 'total' => $total, 'subgroup' => $tags];

	}//<---- End Method


	public static function userImages($id){

		$settings = AdminSettings::first();

		$images      = Images::where('user_id',$id)
		->where('status', 'active' )
		->groupBy('id')
		->orderBy('id', 'desc' )
		->paginate($settings->result_request)->onEachSide(1);

		return $images;

	}//<---- End Method


	public static function getSubcategoriesCount($memberid)
	{
		$subcategories = subcategories::where('created_by', $memberid)->get();	
		return $subcategories->count();
	}

}
