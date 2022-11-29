<?php
namespace App\Http\Controllers;
use App\Helper;
use App\Http\Requests;
use App\Models\DeviceToken;
use App\Models\User;
use App\Models\Images;
use App\Models\AdminSettings;
use App\Models\Categories;
use App\subcategories;
use App\Models\Visits;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Psr\SimpleCache\CacheInterface;
use Image;
use DB;
class ImagesController extends Controller {
	 public function __construct( AdminSettings $settings, Request $request) {
		$this->settings = $settings::first();
		$this->request = $request;
	}

	public function show($id, $slug = null )
	{
		$response = Images::find($id);
		$slugr = Helper::removedash($slug);
		if( $response ==''){
			return redirect('search?q='.Helper::first3words($slugr));
		}
        $subcat = subcategories::find($response->subcategories_id);
        $response->subcat = $subcat;
		if( Auth::check() && $response->user_id != Auth::user()->id && $response->status == 'pending' && Auth::user()->role != 'admin' ) {
			abort(404);
		} else if(Auth::guest() && $response->status == 'pending'){
			abort(404);
		}
		$uri = $this->request->path();
		if( Str::slug( $response->title ) == '' ) {
			$slugUrl  = '';
		} else {
			$slugUrl  = '/'.Str::slug( $response->title );
		}
		$url_image = 'photo/'.$response->id.$slugUrl;
		if(isset($response->opt_file_source) && $response->opt_file_source != ""){
			$url_image = 'file/'.$response->id.$slugUrl;

			   $filename = 'File';
}
else {
   $filename = 'Picture';
}
		
		//<<<-- * Redirect the user real page * -->>>
		$uriImage     =  $this->request->path();
		$uriCanonical = $url_image;
		if( $uriImage != $uriCanonical ) {
			return redirect($uriCanonical);
		}
		$resolution = explode('x', $response->resolution);
		$newWidth = $resolution[0];
		$newHeight = $resolution[1];
		 if(isset($response->opt_file_source) && $response->opt_file_source != "") {$part  = '/file';$aageka  = strtoupper($response->extension).' Free Download';} else {$part  = '/photo';$aageka  = 'Free Download';};
		$contenturl=url('/').($part).("/$response->id").'/'.Str::slug($response->title);
		$slug = $response->category->slug;
		$categories = DB::table('categories')->where('slug','=',$slug)->get();
		$title= '🔥 '.($response->title).' | '.($aageka);
		$credits= $response->credits;
		$description= Helper::removetags($subcat->spdescr);
		$imgdescrtrue= ($subcat->spdescr);
		$imglarge = config('app.filesurl').(config('path.uploads').'large/'.$response->large);
		 
		 if ($response->extension == 'gif') {
      $thumbimage = config('app.filesurl').(config('path.large').$response->large); }
      else {
      			$thumbimage=config('app.filesurl').('uploads/preview').'/'.($response->preview);

      }


	
		$multilangLink = config('app.topsiteurl').($part).("/$response->id").'/'.Str::slug($response->title);

		$imgtitletrue=($response->title);
		$imgalt = Str::limit($imgtitletrue, 28, '');
		$catname= ($response->category->name);
		$subcatname= ($response->subcat->name);
		$subcatlink=url('s').'/'.($subcat->slug);
		$catlink=url('c').'/'.($response->category->slug);
		$subgroups= ($response->subcat->keyword);
		$keywords=$response->metakeywords;
		$arrayTags=explode(",",$keywords);
		$countTags=count($arrayTags);
		$rssfeed=$subcatlink.'/rssfeeds';
		$maincategoryID = $categories[0]->main_cat_id;
		//update category id
		DeviceToken::updateToken($maincategoryID);


	$images=Images::where('subcategories_id',$response->subcategories_id)->whereStatus('active')->where(function($query)use($arrayTags,$countTags){for($k=0;$k<$countTags;++$k){$query->orWhere('metakeywords','LIKE','%'.$arrayTags[$k].'%');}})->where('images.id','<>',$response->id)
		->orderByRaw('RAND()')->take(28)->get();
		


		// $images=Images::where('subcategories_id',$response->subcategories_id)
		// ->whereStatus('active')
		// ->where(function($query)use($arrayTags,$countTags){for($k=0;$k<$countTags;++$k){$query
		// ->orWhere('metakeywords','LIKE','%'.$arrayTags[$k].'%');}})
		// ->where('images.id','<>',$response->id)
		// ->orderBy(function ($query) use ($arrayTags) {
		// 		$query->select('id')->orWhere('metakeywords', 'LIKE', '%' . $arrayTags[0] . '%');
		// },'desc')
		// ->orderByRaw('RAND()')
		// ->take(55)
		// ->get();

		$png = '';
		if($maincategoryID == '1')
		{ $png = 'background: url('.asset('public/img/png_bg.png').')  ';
		};
		$previousimageurl = "";
		$nextimageurl = "";
		$nextimgthumbnail = "";
		$previousimgthumbnail = "";
		$previousimage = Helper::getPreviousImage($response->id, $response->category->id, $response->subcategories_id);
		if( $previousimage )
		{
		if(isset($previousimage->opt_file_source) && $previousimage->opt_file_source != "") { $part  = '/file';  } else { $part  = '/photo';  }
		$previousimageurl = url('/').($part).("/$previousimage->id").'/'.Str::slug($previousimage->title);
		$previousimgthumbnail= config('app.filesurl').('uploads/thumbnail').'/'.($previousimage->thumbnail);
		} ;
		$nextimage = Helper::getNextImage($response->id, $response->category->id, $response->subcategories_id);

		if( $nextimage )
		{
		if(isset($nextimage->opt_file_source) && $nextimage->opt_file_source != "")
		{  $part  = '/file'; } else { $part  = '/photo';}
		$nextimageurl = url('/').($part).("/$nextimage->id").'/'.Str::slug($nextimage->title);
		$nextimgthumbnail= config('app.filesurl').('uploads/thumbnail').'/'.($nextimage->thumbnail);
		};
    	return view('images.show', compact('newWidth','contenturl','keywords', 'thumbimage', 'newHeight', 'title', 'description', 'part', 'catname', 'subcatname', 'imgtitletrue', 'subcatlink', 'catlink', 'arrayTags','rssfeed','images','credits', 'imgalt', 'subgroups', 'imgdescrtrue', 'imglarge','png','previousimageurl','previousimage','previousimgthumbnail','nextimageurl','nextimage','nextimgthumbnail','maincategoryID', 'filename','multilangLink'))->withResponse($response);
	}

}
