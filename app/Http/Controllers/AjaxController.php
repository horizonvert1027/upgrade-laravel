<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AdminSettings;
use App\Models\Images;
use App\Models\Query;
use App\Helper;
use App\subcategories;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;

class AjaxController extends Controller {

	public function __construct( AdminSettings $settings) {
		$this->settings = $settings::first();
	}
	public function notifications() {

		if( Auth::check() ) {

		   if(request()->ajax()) {
			$notifications_count = Notifications::where('destination',Auth::user()->id)->where('status','0')->count();

			if( $notifications_count == 0 ){
				$notifications_count = '0';
			}

			return response()->json( array ( 'notifications' => $notifications_count ) );

		   } else {
				return response()->json( array ( 'error' => 1 ) );
			}
	  }//Auth
	  else {
				return response()->json( array ( 'error' => 1 ) );
			}

   	}//<---- * End Method

   	public function users() {

	 	$data = Query::users();
	 	return view('ajax.users-ajax')->with($data)->render();

	}//<---- End Method

	public function search() {

		 $images = Query::searchImages();

		 return view('ajax.images-ajax')->with($images)->render();

	}//<---- End Method

	public function latest() {

	 $images = Query::latestImages();

	 return view('ajax.images-ajax',['images' => $images])->render();

	}//<---- End Method

	public function featured() {

	 $images = Query::featuredImages();

	 return view('ajax.images-ajax',['images' => $images])->render();

	}//<---- End Method


	public function category( Request $request )
	{
		$slug = trim($request->slug);
	 	$images = Query::categoryImages($slug);
	 	return view('ajax.images-ajax')->with($images)->render();
	}//<---- End Method

	public function subcategories( Request $request ) {

		 $slug = trim($request->slug);

		 $images = Query::subcategoriesImages($slug);

		 return view('ajax.images-ajax')->with($images)->render();

	}//<---- End Method


	public function subgroup( Request $request ) {

		 $slug = trim($request->q);
		 // recently edited
		if (! $request->q){
			abort('404');
		}
         $slug = str_replace("-", " ", $slug);
		 $images = Query::subgroupImages($slug);

		 return view('ajax.images-ajax')->with($images)->render();

	}//<---- End Method

	public function getSimilarImages( Request $request ) {

		 $subcategory_id = trim($request->subcategory_id);
		 $page = trim($request->page);
		 $images = Query::subcategoryIdImages($subcategory_id);

		 return view('ajax.similarimages-ajax', compact('page'))->with($images)->render();

	}//<---- End Method


	public function getSubcatlinks(Request $request)
	{
		$data['subcatlinks'] = array();
		$subcategory_id = trim($request->subcategory_id);
		$subcat = subcategories::find($subcategory_id);
		if( $subcat )
		{
			$tgs = explode(",", $subcat->tags);
	        $countTgs = count($tgs);
	        if( $countTgs > 0 )
	        {
	        	$query = DB::table('subcategories');
				for($k = 0; $k < $countTgs;++$k)
				{
					$query->orWhere('tags', 'LIKE', '%'.$tgs[$k].'%');
				}
				$subs = $query->get();
				if( $subs->count() > 0 )
				{
					foreach ($subs as $s => $sub)
					{
						if( $sub->id != $subcategory_id )
						$data['subcatlinks'][ $sub->id ] = $sub;
					}
				}
	        }
		}
		return view('ajax.subcatlinks-ajax')->with($data)->render();
	}

	public function moresubcategories(Request $request)
	{	

		$limit = trim($request->limit);
		$category_id = trim($request->category_id);
		$page = trim($request->page);
		// recently edited
		if (! $request->page){
			abort('404');
		}
		$subcategories['subcategories'] = subcategories::where('categories_id',$category_id)->orderBy('name')->paginate($limit)->onEachSide(1);
		return view('ajax.subcategory-ajax', compact('page','limit'))->with($subcategories)->render();
	}

	public function searchtags(Request $request)
	{
		if(request()->ajax())
		{
			$search = trim($request->q);
			$index = trim($request->index);
			if( $search != "" && strlen($search) >= 1)
			{
				$result = array("index" => $index, "data" => array());
				$tags = subcategories::where( 'keyword', 'LIKE', '%'.strtolower($search).'%' )->orWhere( 'metakeywords', 'LIKE', '%'.strtolower($search).'%' )->skip(0)->take(1000)->get();
				if( count($tags) > 0 )
				{
					$source = array();
                    $image = array();
					foreach ($tags as $key => $value)
					{
						$itags = explode(",", $value->keyword);
					    foreach ($itags as $item)
					    {
					    	$item = trim($item);
					        if (false !== stristr($item, $search) && !in_array($item, $source))
					        {
					            $source[] = $item;
					        }
					    }
					    $itags = explode(",", $value->metakeywords);
					    foreach ($itags as $item)
					    {
					    	$item = trim($item);
					        if (false !== stristr($item, $search) && !in_array($item, $source))
					        {
					            $source[] = $item;
					        }
					    }
					}
					$source = array_chunk(array_unique($source), 10);
					foreach ($source[0] as $src){
                        $img = Helper::getFristImageSearch(strtolower($src));
                        if ($img == ''){
                            $image[] = $img;
                        }else{
                            $image[] = config('app.filesurl').('uploads/thumbnail/').$img;
                        }
                    }
					$result["data"] = $source[0];
					$result["image"] = $image;

                }
				return response()->json( $result );
			}
			else
			{
				return response()->json( array ( 'error' => 1 ) );
			}
	   	} else {
			return response()->json( array ( 'error' => 2 ) );
		}
   	}

	public function userImages( Request $request ) {

		 $id = $request->id;

		 $images = Query::userImages($id);

		 return view('ajax.images-ajax',['images' => $images])->render();

	}

}
