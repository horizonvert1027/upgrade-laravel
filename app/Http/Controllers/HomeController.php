<?php
namespace App\Http\Controllers;
use App\subcategories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Helper;
use App\Models\User;
use App\Models\Images;
use App\Models\DeviceToken;
use Illuminate\Http\Request;
use App\Models\AdminSettings;
use App\Models\Categories;
use App\Models\Emptysearches;
use App\Models\Query;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Support\Str;
use DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
		public function __construct( Request $request) {
			$this->request = $request;
			$this->badwords = array('porn', 'sexy', 'sex', 'nude', 'boobs', 'penis', 'dick', 'fuck', 'ass', 'asshole', 'tits', 'pussy', 'chut' , 'chudai');
		}
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$categories = Categories::where('mode','on')->orderBy('name')->paginate(12);
		$images     = Query::latestImages();
		$referer = request()->headers->get('referer');
		$registerUrl = url('/').'/register';
		if( Auth::check() && $referer==$registerUrl && session('register_referer') && session('register_referer') != "")
			{
				$loc = session('register_referer');
				session(['register_referer' => '']);
				return redirect()->to($loc);
			}
		$m = date('m');
		$m = intval($m);
		$d = date('d');
		$d = intval($d);
		$settings = AdminSettings::first();
		$title = $settings->sitename . ' - ' . $settings->title;
        $description = $settings->description;
        $keywords = $settings->keywords;
        $thumbimage = url('/').'/public/img/apple/android-chrome-512x512.png';
        $sitemap = '';

		$multilangLink = config('app.topsiteurl');
		
        $contenturl = url('/');
        $rssfeed = url('/').'/rssfeeds';
        $maincategoryID = '';
		$subcategories = subcategories::where(\DB::raw('MONTH(special_date)'), $m)->where(\DB::raw('DAY(special_date)'), $d)->get();
		$sitearr=explode(" ",$settings->sitename,2);
		return view('default.home',compact(['title', 'description', 'keywords','thumbimage','rssfeed','contenturl','sitemap','subcategories','images','maincategoryID','sitearr','multilangLink']));
	}

		public function members() {
		$data = Query::users();
		$total = count($data);
		$settings = AdminSettings::first();
		$title = 'Members of ' . $settings->sitename . ' - ' . $settings->title;
        $description = $settings->description;
        $keywords = $settings->keywords;
        $thumbimage = url('/').'/public/img/apple/android-chrome-512x512.png';
        $sitemap = '';

		$multilangLink = config('app.topsiteurl').'/members';
		

        $contenturl = url('/members');
        $rssfeed = url('/').'/rssfeeds';
		return view('default.members',compact(['title', 'description', 'keywords','thumbimage','rssfeed','contenturl','sitemap','multilangLink']))->with($data);

		}

	public function usernameValidate(Request $request)
    {
    	if( isset($request->username) )
    	{
    		if( strlen($request->username) < 6 )
    		{
    			echo "error";
    			die();
    		}
    		$user = User::where('username', '=', $request->username )->get();
    		if( count($user) > 0 )
    		{
    			echo "1";
    		}
    		else
    		{
    			echo "0";
    		}
		} else {
			echo "error";
		}
    }

	public function getVerifyAccount( $confirmation_code ) {

		if( !Auth::check() ) {
			$user = User::where( 'activation_code', $confirmation_code )->where('status','pending')->first();

		if( $user ) {

			$update = User::where( 'activation_code', $confirmation_code )
			->where('status','pending')
			->update( array( 'status' => 'active', 'activation_code' => '' ) );


			Auth::loginUsingId($user->id);

			 return redirect('/')
					->with([
						'success_verify' => true,
					]);
			} else {
			return redirect('/')
					->with([
						'error_verify' => true,
					]);
			}
		} else {
			 return redirect('/');
		}
	}// End Method

	public function getSearcher()
	{
		$images = Query::searchImages();
		if( Input::get('q') == '' || strlen( Input::get('q') ) <= 1 ){
			return redirect('/');
		}

		$q = str_replace('-', ' ', Input::get('q'));
		$searchedp = str_replace('-', ' ', $q);
		$searched = ucwords($searchedp);
		// Save query string which got empty responses.
		$banstring = ($q != str_ireplace($this->badwords,"XX",$q))? true: false;
		if( $images['total'] == 0 && $banstring === false)
		{
			$sql = new Emptysearches();
			$sql->q = $searched;
			$sql->responses = $images['total'];
			$sql->save();
		}

		$q = Input::get('q');

		return view('default.searcher', compact('q'))->with($images);
	}

	public function getSearch()
	{
		$images = Query::searchImages();
		if( Input::get('q') == '' || strlen( Input::get('q') ) <= 1 )
		{
			return redirect('/');
		}

		$q = Input::get('q');

		$q_slug = Helper::removesymbols($q);
		$q_slug = preg_replace('!\s+!', '+', $q_slug);

		// if input has any unnece symbols,
		if (preg_match('/[\'^£$%&*()}{@#~?><>,:;"|=_¬-]/', $q))
		{
		    return redirect('/search?q='.$q_slug);
		}

		// if input has any beginning space, more than one innbetween or after,
		$input = $_GET['q'];
		if(preg_match("/^\s+/", $input) || preg_match("/\s{2,}/", $input)) {
			return redirect('/search?q='.$q_slug);
		}

		$q = str_replace('-', ' ', $q);
		$searchedp = str_replace('-', ' ', $q);
		$searched = ucwords($searchedp);
		$banstring = ($q != str_ireplace($this->badwords,"XX",$q))? true: false;

		if($banstring === false)
		{
		$qrecords = DB::table('searchkeywords')->where('query','=',Helper::spacesUrl(trim($q)))->get();
		if( $qrecords->count() < 6 )
		{
			DB::table('searchkeywords')->insert( array('query' => Helper::spacesUrl(trim($q))) );
		}
		}

		if( $images['total'] == 0 && $banstring === false)
		{
			$e = Emptysearches::where('q', $q)->get();
			if( count($e) == 0 ){
				$sql = new Emptysearches();
				$sql->q = $searched;
				$sql->responses = $images['total'];
				$sql->save();
			}
		}
		if( $images['total'] < 20 )
		{
			return view('default.searcher', compact('q'))->with($images);
		}
		else
		{
			$tags = "";
			$source = array();
			$idata = $images['images']->items();
			foreach($idata as $value)
			{
				$itags = explode(",", $value->metakeywords);
			    foreach ($itags as $item)
			    {
			    	$item = trim($item);
			        if( $item != "" && $item != $q)
			        {
			            $source[] = trim($item);
			        }
			    }
			}
			$source = array_chunk(array_unique($source), 20);
			$tags = implode(",", $source[0]);

			return view('default.search', compact('tags'))->with($images);
		}
	}

	public function latest() {
		$settings = AdminSettings::first();
		$images = Query::latestImages();
		$title = 'Latest Contents - ' . $settings->title;
        $description = 'Get all most recently uploaded contents ' . $settings->description;
        $keywords = 'Latest contents, new images, new contents, new wallpapers, latest wallpapers, recent';
        $thumbimage = url('/').'/public/img/apple/android-chrome-512x512.png';
        $sitemap = '';

		$multilangLink = config('app.topsiteurl').'/latest';
		
        $contenturl = url('/').'/latest';
        $rssfeed = url('/').'/rssfeeds';
        return view('default.latest',compact(['title', 'description', 'keywords','thumbimage','rssfeed','contenturl','sitemap','images','multilangLink']));
	}

	public function featured() {
		$settings = AdminSettings::first();
		$images = Query::featuredImages();
		$title = 'Featured Contents - ' . $settings->title;
        $description = 'Get all Featured Contents which are exclusively selected as per as most viewed, downloaded a liked content. ' . $settings->description;
        $keywords = 'Featured Images, featured, most downloaded, most viewed, most liked, best content, exclusive content, best wallpapers';
        $thumbimage = url('/').'/public/img/apple/android-chrome-512x512.png';
        $sitemap = '';

	
		$multilangLink = config('app.topsiteurl').'/featured';
		
        $contenturl = url('/').'/featured';
        $rssfeed = url('/').'/rssfeeds/featured';
        return view('default.featured',compact(['title', 'description', 'keywords','thumbimage','rssfeed','contenturl','sitemap','images','multilangLink']));
	}

	   public function typeslug($slug) {
    	$main_categorys_id = DB::table('main_categorys')->where('slug',$slug )->get();
	    	if( $main_categorys_id->count() == 0 )
				{
					abort('404');
				}
    	$main_id = $main_categorys_id[0]->id;
    	$main_name = $main_categorys_id[0]->name;
    	$keywords = $main_categorys_id[0]->titleahead;
    	$data = categories::where('mode','on')->where('main_cat_id','=' , $main_id)->orderBy('name')->get();
    	$settings = AdminSettings::first();
		$title = 'Browse by ‘' . $main_name  . '’ - ' . $settings->title;
        $description = 'Browse contents by types and download ' . $settings->description;
        $thumbimage = url('/').'/public/img/apple/android-chrome-512x512.png';
        $sitemap = '';

		$multilangLink = config('app.topsiteurl').'/type/'.Str::slug($slug);
		
        $contenturl = url('/').'/type/'.Str::slug($slug);
        $rssfeed = url('/').'/rssfeeds';
        $maincategoryID = $main_id;
        // DeviceToken::updateToken($maincategoryID);
    	return view('default.main-category' , compact('title', 'description', 'keywords','thumbimage','rssfeed','contenturl','sitemap','slug', 'main_name', 'keywords','maincategoryID','multilangLink'))->withData($data);
    }



	public function category($slug)
	{	
		$settings = AdminSettings::first();
		$categories = DB::table('categories')->where('mode','on')->where('slug','=',$slug)->get();

		$q_slug = Str::slug( $slug );
		$uriImage     =  str_replace('%20', ' ', $this->request->fullUrl());
		$uriCanonical = str_replace($slug, $q_slug,$uriImage);
		if( $uriImage != $uriCanonical ) {
			return redirect($uriCanonical);
		}

		if( $categories->count() == 0 )
		{
			return redirect('search?q='.$slug);
		}
		$sublimit = 40;
		$main_cat_id = $categories[0]->main_cat_id;
		$main_categories = DB::table('main_categorys')->where('id','=',$main_cat_id)->get();
		$images = Query::categoryImages($slug);

		if( $images['total'] == 0 ){
			abort('404');
		}

		$subcattitle= $categories[0]->name;
		$categorydescr= $categories[0]->cpdescr;
		$titleahead = $categories[0]->main_cat_id;
		$keyword = explode(',', $categories[0]->keyword);
		$title = Helper::counts($images['total']).'+ Best '. $subcattitle . ' ' . Helper::titleahead($titleahead);
		$rssfeed = url('/').'/rssfeeds'.'/c/'.$slug.'';


		$multilangLink = config('app.topsiteurl').'/c/'.$slug;
		
		$contenturl = url('/').'/c/'.$slug;
		$description = Helper::removetags($categorydescr);
		$keywords = $categories[0]->keyword;
		$maincategoryID = $main_cat_id;
		if($settings->notifications == 'on') {
			DeviceToken::updateToken($maincategoryID);
		}
		$thumbimage = config('app.filesurl').'/public/img-category/'.$categories[0]->thumbnail;
		if(isset($images->opt_file_source) && $images->opt_file_source != "") {$slugUrl1  = 'file';} else {$slugUrl1  = 'photo';
		}
		if ( strlen( $slug ) < 0 )
		{
			abort('404');
		}
		else
		{
			return view('default.category', compact('main_categories','title','rssfeed','contenturl','description','keywords','thumbimage', 'sublimit', 'subcattitle', 'titleahead','categorydescr','slugUrl1','keyword','maincategoryID','multilangLink'))->with($images);
		}
	}
 	public function subcategory($slug)
  	{
		$settings = AdminSettings::first();
		$subcategory = DB::table('subcategories')->where('mode','on')->where('slug','=',$slug)->first();

		if(! isset($subcategory) )
		{
			return redirect('search?q='.$slug);
		}
		
		$category_id = $subcategory->categories_id;
		$category = DB::table('categories')->where('id',$category_id)->get(['name','id','slug', 'main_cat_id']);
		$images   = Images::where('status', 'active')->where('subcategories_id',$subcategory->id)->orderBy('date','DESC')->paginate($settings->result_request);
		$main_cat_id = $category[0]->main_cat_id;
		$main_categories = DB::table('main_categorys')->where('id','=',$main_cat_id)->get();
		
		$maincatname = $main_categories[0]->name;
    	$maincatlink = url('/').'/type/'.$main_categories[0]->slug;
    	$categoryname = $category[0]->name;
    	$categorylink = url('/').'/c/'.$category[0]->slug;
    	$subcategoryname = $subcategory->name;
    	$subcategorylink = url('/').'/s/'.$subcategory->slug;

		$arrayTags = explode(',', $subcategory->metakeywords);
		$titleahead = $main_cat_id;
		$tags=explode(',',$subcategory->keyword);
   		$count_tags=count($tags);
		$q_slug = Str::slug( $slug );
		$uriImage     =  str_replace('%20', ' ', $this->request->fullUrl());
		$uriCanonical = str_replace($slug, $q_slug,$uriImage);

		$multilangLink = config('app.topsiteurl').'/s/'.$slug;
		
		$contenturl = url('/').'/s/'.$slug;
		$title = Helper::counts($images->total()).'+'. ' Best ' . $subcategoryname . ' ' .Helper::titleahead($titleahead);
		$description = Helper::removetags($subcategory->spdescr);
		$keywords = $subcategory->keyword .', ' . $subcategory->metakeywords;
		$thumbimage = config('app.filesurl').'public/img-subcategory/'.$subcategory->sthumbnail;
		$rssfeed = url('/').'/rssfeeds'.'/s/'.$slug;
		$sitemap = url('/').'/sg/subgroupsof/'.$slug;
		$maincategoryID = $main_cat_id;
		if($settings->notifications == 'on') {
			DeviceToken::updateToken($maincategoryID);
		}
		if( $uriImage != $uriCanonical ) {
			return redirect($uriCanonical);
		}

		if(isset($images->opt_file_source) && $images->opt_file_source != "") {$slugUrl1  = 'file';} else {$slugUrl1  = 'photo';}
  		return view('default.subcategory',compact(['settings','tags','count_tags','subcategory','images','main_categories','slugUrl1','title', 'description', 'keywords','thumbimage', 'titleahead', 'category','arrayTags','rssfeed','contenturl','sitemap','maincatlink','maincatname','categorylink','categoryname','subcategorylink','subcategoryname','maincategoryID','multilangLink']));
  	}

  	public function tags($slug)
  	{
		$slug1 = Helper::hyphenated($slug);
		return redirect('search?q='.($slug1));
  	}

  	public function subgroup($slug)
  	{
		$settings = AdminSettings::first();
		$slugreal = $slug;
		$slug = str_replace("-", " ", $slug);
		$category = $subcategory = $main_categories = '';
		$subcategory = subcategories::where('keyword', 'LIKE', '%'.$slug.'%' )->get();
		
		if( $subcategory->count() == 0)
		{
			return redirect('search?q='.$slug);
		}
		$category = Categories::where('id', $subcategory[0]->categories_id)->first();
		$main_categories = DB::table('main_categorys')->where('id','=',$category->main_cat_id)->first();
		$images = Images::where( 'subgroup','LIKE', '%'.$slug.'%' )
		->where('status', 'active' )
		->groupBy('id')
		->orderBy('date', 'desc' )
		->paginate($settings->result_request);
		$lastimage = Images::where( 'subgroup','LIKE', '%'.$slug.'%' )->where('status', 'active' )->groupBy('id')->orderBy('id', 'DESC' )->first();
		if( $lastimage == '' )
		{
			return redirect('search?q='.$slug);
		}
		$q_slug = Str::slug( $slug );
		if( $slugreal != $q_slug ) {
			return redirect('g/'.$q_slug);
		}
		 $tags = $titleahead = $descr = $preview = $thumbnail = '';
		   if( $lastimage )
		   {
		       $titleahead = $lastimage->category->main_cat_id;
		       $tags = $lastimage->metakeywords;
		       $descr = $lastimage->descr;
		       $preview = $lastimage->preview;
		       $thumbnail = $lastimage->thumbnail;
		   }
    		if(isset($images->opt_file_source) && $images->opt_file_source != "") {$slugUrl1  = 'file';} else {$slugUrl1  = 'photo';}
    	$subgroup = ucwords($slug);
    	$rssfeed = url('/').'/rssfeeds'.'/s/'.$subcategory[0]->slug.'';
    	$title = Helper::counts($images->total()).'+ '.$subgroup.' '.Helper::titleahead($titleahead);
    	
		$multilangLink = config('app.topsiteurl').'/g/'.Str::slug($subgroup);
		
    	$contenturl = url('/').'/g/'.Str::slug($subgroup);
    	$description = Helper::removetags($subcategory[0]->spdescr);
    	$keywords = $subcategory[0]->metakeywords;
    	$thumbimage = config('app.filesurl').('uploads/preview/').($preview);
    	$maincatname = $main_categories->name;
    	$maincatlink = url('/').'/type/'.$main_categories->slug;
    	$categoryname = $category->name;
    	$categorylink = url('/').'/c/'.$category->slug;
    	$subcategoryname = $subcategory[0]->name;
    	$subcategorylink = url('/').'/s/'.$subcategory[0]->slug;
    	$maincategoryID = $category->main_cat_id;
    	if($settings->notifications == 'on') {
			DeviceToken::updateToken($maincategoryID);
		}

		return view('default.subgroup-show',compact(['lastimage','q_slug','rssfeed','title', 'category', 'subcategory','contenturl','description','keywords','thumbimage', 'main_categories', 'tags', 'titleahead', 'descr', 'preview', 'thumbnail', 'slugUrl1','subgroup','images','maincatlink','maincatname','categorylink','categoryname','subcategorylink','subcategoryname','maincategoryID','multilangLink']));


	}


	public function latestFeed(Request $request)
	{
		$images = Query::latestImages();
		return response()->view('rss.latestfeeds', ['images'=> $images])->header('Content-Type', 'application/xml');
	}

	public function featuredFeed(Request $request)
	{
		$images = Query::featuredImages();
		return response()->view('rss.featuredfeeds', ['images' => $images])->header('Content-Type', 'application/xml');
	}

	public function categoryrss($role)
	{
		$categories = DB::table('categories')->where('mode','on')->where('slug',$role)->get();
		$ca = $categories[0]->id;
		$images = DB::table('images')->where('categories_id',$ca)->orderBy('date' , 'desc')->limit(30)->get();
		return response()->view('rss.catfeeds', ['images'=> $images, 'categories'=> $categories])->header('Content-Type', 'application/xml');
	}

	public function subcategories($slug)
	{
		$categories = DB::table('subcategories')->where('mode','on')->where('slug','=',$slug)->get();
		if(isset($categories[0])){
		$ca = $categories[0]->id;
		$images = DB::table('images')->where('subcategories_id',$ca)->where('status','active')->orderBy('date' , 'desc')->limit(30)->get();
		return response()->view('rss.feeds', ['images'=> $images, 'categories'=> $categories])->header('Content-Type', 'application/xml');
		}
		else
			return redirect('/');
	}




	public function subgrouprss($slug)
	{
		$settings = AdminSettings::first();
		$slugreal = $slug;
		$slug = str_replace("-", " ", $slug);
		$category = $subcategory = $main_categories = '';
		$subcategory = subcategories::where('keyword', 'LIKE', '%'.$slug.'%' )->get();
		
		if( $subcategory->count() == 0)
		{
			return redirect('search?q='.$slug);
		}
		$category = Categories::where('id', $subcategory[0]->categories_id)->first();
		$main_categories = DB::table('main_categorys')->where('id','=',$category->main_cat_id)->first();
		$images = Images::where( 'subgroup','LIKE', '%'.$slug.'%' )
		->where('status', 'active' )
		->groupBy('id')
		->orderBy('date', 'desc' )
		->limit(30)->get();
		$lastimage = Images::where( 'subgroup','LIKE', '%'.$slug.'%' )->where('status', 'active' )->groupBy('id')->orderBy('id', 'DESC' )->first();
		if( $lastimage == '' )
		{
			return redirect('search?q='.$slug);
		}
		$q_slug = Str::slug( $slug );
		if( $slugreal != $q_slug ) {
			return redirect('g/'.$q_slug);
		}
		 $tags = $titleahead = $descr = $preview = $thumbnail = '';
		   if( $lastimage )
		   {
		       $titleahead = $lastimage->category->main_cat_id;
		       $tags = $lastimage->metakeywords;
		       $descr = $lastimage->descr;
		       $preview = $lastimage->preview;
		       $thumbnail = $lastimage->thumbnail;
		   }
    		if(isset($images->opt_file_source) && $images->opt_file_source != "") {$slugUrl1  = 'file';} else {$slugUrl1  = 'photo';}
    	$subgroup = ucwords($slug);
    	$rssfeed = url('/').'/rssfeeds'.'/s/'.$subcategory[0]->slug.'';
    	$title = $subgroup.' '.Helper::titleahead($titleahead);
    	$contenturl = url('/').'/g/'.Str::slug($subgroup);
    	$description = Helper::removetags($subcategory[0]->spdescr);
    	$keywords = $subcategory[0]->metakeywords;
    	$thumbimage = config('app.filesurl').('uploads/preview/').($preview);
    	$maincatname = $main_categories->name;
    	$maincatlink = url('/').'/type/'.$main_categories->slug;
    	$categoryname = $category->name;
    	$categorylink = url('/').'/c/'.$category->slug;
    	$subcategoryname = $subcategory[0]->name;
    	$subcategorylink = url('/').'/s/'.$subcategory[0]->slug;

		return response()->view('rss.subgroup',compact(['lastimage','q_slug','rssfeed','title', 'category', 'subcategory','contenturl','description','keywords','thumbimage', 'main_categories', 'tags', 'titleahead', 'descr', 'preview', 'thumbnail', 'slugUrl1','subgroup','images','maincatlink','maincatname','categorylink','categoryname','subcategorylink','subcategoryname']))->header('Content-Type', 'application/xml');

	}





	public function searchkeywords()
	{
		$searchkeywords = DB::select('SELECT query, count(*) as count FROM searchkeywords GROUP BY query HAVING count > 5');
		return response()->view('sitemap.ok-search', ['searchkeywords'=> $searchkeywords])->header('Content-Type', 'application/xml');
	}

	public function imgsitemaps(Request $request)
	{
		$page = isset($page) ? $page : 0;
		$offset = $page * 100;
		$images = DB::table('images')->where('status','active')->orderBy('date' , 'desc')->get();
		return response()->view('sitemap.ok-imgsitemap', ['images'=> $images])->header('Content-Type', 'application/xml');
	}

	public function allsubcatxml(Request $request)
	{
		return response()->view('sitemap.ok-sub-category-sitemap')->header('Content-Type', 'application/xml');
	}

	public function imgpagexml($page)
	{
		return response()->view('sitemap.ok-imgsitemap', compact('page'))->header('Content-Type', 'application/xml');
	}

		public function subgroupxml(Request $request)
	{
		return response()->view('sitemap.ok-subgroups')->header('Content-Type', 'application/xml');
	}

		public function subgrouppagexml($page)
	{
		return response()->view('sitemap.ok-subgroups', compact('page'))->header('Content-Type', 'application/xml');
	}

		public function imgxml(Request $request)
	{
		return response()->view('sitemap.ok-imgsitemap')->header('Content-Type', 'application/xml');
	}

		public function imglistxml(Request $request)
	{
		return response()->view('sitemap.ok-imgsitemapslist')->header('Content-Type', 'application/xml');
	}

	public function userssitemap(Request $request)
	{
		return response()->view('sitemap.ok-users-sitemap')->header('Content-Type', 'application/xml');
	}

	public function pagesitemaps(Request $request)
	{
		return response()->view('sitemap.ok-page-sitemap')->header('Content-Type', 'application/xml');
	}

	public function frequentsitemaps(Request $request)
	{
		return response()->view('sitemap.ok-frequent')->header('Content-Type', 'application/xml');
	}

	public function catxml(Request $request)
	{
		return response()->view('sitemap.ok-category')->header('Content-Type', 'application/xml');
	}

public function maincat(Request $request)
	{
		return response()->view('sitemap.ok-main-category-sitemap')->header('Content-Type', 'application/xml');
	}




	public function sitemaps(Request $request)
	{
		return response()->view('sitemap.ok-sitemap')->header('Content-Type', 'application/xml');
	}

	public function sgsitemaps(Request $request)
	{
		$ca = DB::table('subcategories')->where('mode','on')->paginate(20);
		return response()->view('sitemap.ok-sgsitemap', ['subcategories'=> $ca])->header('Content-Type', 'application/xml');
	}

	public function sgsitemapslist(Request $request)
	{
		$ca = DB::table('subcategories')->where('mode','on')->orderBy('id' , 'desc')->get();
		return response()->view('sitemap.ok-sgsitemapslist', ['subcategories'=> $ca])->header('Content-Type', 'application/xml');
	}

	public function instantsubgroup($role)
	{
		$ca = DB::table('subcategories')->where('mode','on')->where('slug', $role)->get();
		return response()->view('sitemap.ok-instantsubgroup', ['subcategories'=> $ca])->header('Content-Type', 'application/xml');
	}

	public function cat_subcats($slug, $page=0)
	{
		$ca = DB::table('categories')->where('mode','on')->where('slug', $slug)->get();
		$ca = $ca[0]->id;
		$page = isset($page) ? $page : 0;
		$subcatlimit = 100;
		$offset = $page * $subcatlimit;
		$subcat = DB::table('subcategories')->where('categories_id', $ca)->where('mode','on')->offset($offset)->limit($subcatlimit)->get();
		$limit = 100;
		return response()->view('sitemap.ok-categoryssubcategory', ['subcat'=> $subcat, 'limit'=>$limit])->header('Content-Type', 'application/xml');
	}

}
