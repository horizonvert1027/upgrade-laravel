<?php 

namespace App\Http\Controllers;

use App\subcategories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request as Input;
use App\Models\User;
use App\Models\AdminSettings;
use App\Models\Notifications;
use App\Models\Categories;
use App\Models\UsersReported;
use App\Models\ImagesReported;
use App\Models\Images;
use Illuminate\Http\UploadedFile;
use ImageOptimizer;
use App\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Str;
use App\Models\DeviceToken;
use Image;
use Mail;


class AdminController extends Controller {

	public function __construct( AdminSettings $settings) {
		$this->settings = $settings::first();
	}
	// START
	public function admin() {

		$main_categorys = DB::table('main_categorys')->get();
		$allsubcategories = subcategories::all();
		$allinstasubs = DB::table('subcategories')->where('allinsta','=','yes')->where('insta_username','!=','')->get();

		return view('admin.dashboard', compact('allinstasubs','main_categorys','allsubcategories'));

	}//<--- END METHOD

	public function index() {
	 	$data = Images::all();
    	return view('admin.images')->withData($data);
	}

public function sendNotification(){
	$subscribers = DB::table('device_tokens')->get();
	$counts = count($subscribers);
	    return view('admin.notification', compact('subscribers','counts'));
    }
   
	
	public function recentsubcategories(){
	$subcategories = DB::table('subcategories')->get();
	
	    return view('admin.recentsubcategories');
    }
   

public function saveToken(Request $request)
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        $token = \App\Models\DeviceToken::where('ip', $ip)->first();
        if (!empty($token)) {
            $token->update(['token' => $request->token]);
        } else {
            \App\Models\DeviceToken::create(['ip' => $ip, 'token' => $request->token]);
        }
        return ['success' => true];
    }

public function notifyUser($request, $token) {
        $data = [
            "registration_ids" => $token,
            "notification"     => [
                "title"        => $request->title,
                "body"         => $request->body,
                "icon"         => $request->icon,
                "click_action" => $request->url
            ]
        ];
        $dataString = json_encode($data);

        $server_key = env('PUSH_NOTIFICATION_SERVER_KEY') ?? 'AAAAhznmRm4:APA91bGyYDaIoWf3HbnIIzsiLfzgveLE5UCrAVus4Xx0zBdP10nc88ug-ml4b1ogeGr566wc7XcH0e2Eyh2grELGOhwExOgDlE9DOlaejteXwbi-3Ap6CBO8MWrbHyzXEA4D5QDccYRl';

        $headers = [
            'Authorization: key=' . $server_key,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }
    
 // public function sendNotificationProcess(Request $request) {
 //        try {
 //            if (!$request->has('category') && $request->category == ''){
 //                return redirect()->back()->with(['error_message' => __('Category required')]);
 //            }

 //            $firebaseToken = DeviceToken::whereNotNull('token');
 //            if ($request->has('category') && $request->category != ''){
 //                $firebaseToken = $firebaseToken->hasCategory($request->category);
 //            }
 //            $firebaseToken = $firebaseToken->pluck('token')->all();


 //            $success = 0;
 //            $failed = 0;
 //            $length = env("MAX_NOTIFIED_USER") ?? 500;

 //            foreach (array_chunk($firebaseToken, $length, FALSE) as $token) {
 //                $response = $this->notifyUser($request, $token);
 //                if (isset($response->success) && isset($response->failure)) {
 //                    $success += $response->success;
 //                    $failed += $response->failure;
 //                }
 //            }

 //            return redirect()->back()
 //                             ->with('success_message', "Notification sent to $success successfully and failed for $failed subscribers!");
 //        } catch (\Exception $exception) {
 //            return redirect()->back()->with(['error_message' => __('Something went wrong!')]);
 //        }
 //    }

    public function sendNotificationProcess(Request $request) {
        try {
            if (!$request->has('category') && $request->category == ''){
                return redirect()->back()->with(['error_message' => __('Category required')]);
            }

            $firebaseToken = DeviceToken::distinct()->whereNotNull('token');
            if ($request->has('category') && $request->category != ''){
                $firebaseToken = $firebaseToken->hasCategory($request->category);
            }
            $firebaseToken = $firebaseToken->groupBy(['ip','token'])->pluck('token')->all();


            $success = 0;
            $failed = 0;
            $length = env("MAX_NOTIFIED_USER") ?? 500;

            foreach (array_chunk($firebaseToken, $length, FALSE) as $token) {
                $response = $this->notifyUser($request, $token);
                if (isset($response->success) && isset($response->failure)) {
                    $success += $response->success;
                    $failed += $response->failure;
                }
            }

            return redirect()->back()
                             ->with('success_message', "Notification sent to $success successfully and failed for $failed subscribers!");
        } catch (\Exception $exception) {
            return redirect()->back()->with(['error_message' => __('Something went wrong!')]);
        }
    }
	public function webscrapper(Request $request) 
	{
		$allsubcategories = subcategories::all();
		$pagination = 20;
		$webscrappers = DB::table('webscrapper')->orderBy('id','DESC')->paginate($pagination);
		$url = '';
		$autocron = $request->autocron;
		$image_status = $request->image_status;
		$response = '';
		$class = '';
		$element = 'div';
		$verify = $request->verify;
		$metakeywords = $request->metakeywords;
		$credits = $request->credits;
		$title = isset($request->title)?$request->title : "";
		$category_id = isset($request->category_id) ? $request->category_id : "";
		$subcategory_id = isset($request->subcategory_id) ? $request->subcategory_id : "";
		// All InstaCron Subcategories
		
		$logfile = "public/logs/webscrapper.log";
		$f = fopen($logfile, 'w+');
		if( isset($request->url) && isset($request->verify) && $request->verify == 'yes' )
		{
			$url = $request->url;
			$element = $request->element;//"div"; 
    		$class = $request->class; //"png_png png_imgs";
    		$arr = array();

    		$context = stream_context_create(
        array(
            "http" => array(
                'method'=>"GET",
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) 
                            AppleWebKit/537.36 (KHTML, like Gecko) 
                            Chrome/50.0.2661.102 Safari/537.36\r\n" .
                            "accept: text/html,application/xhtml+xml,application/xml;q=0.9,
                            image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3\r\n" .
                            "accept-language: es-ES,es;q=0.9,en;q=0.8,it;q=0.7\r\n" . 
                            "accept-encoding: gzip, deflate, br\r\n"
            )
        )
    );

			$ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            $html = curl_exec($ch);
            
			file_put_contents($logfile, $html);
		    libxml_use_internal_errors(true);
		    $dom = new \DOMDocument();
		    $dom->loadHTML($html);
		    if( !$dom )
		    {
		    	$response = "Error loading DOM";
		    }
		    else
		    {
		    	//echo "Dom loaded.\n";
		    	$u = explode("/", $url);
            	$baseurl = $u[0].'/'.$u[1].'/'.$u[2];

		    	$xpath = new \DOMXPath($dom);
		    	$domItems = $xpath->query('//'.$element.'[@class=\''.$class.'\']');
		    	if( is_object($domItems) && $domItems->length == 0 )
		    	{
		    		echo "Q1 - failed .\n";
		    		$domItems = $xpath->query('//'.$element.'[contains(@class, \''.$class.'\')]');
		    		if( is_object($domItems) && $domItems->length == 0 )
		    		{
		    			echo "Q2 - failed .\n";
		    			$response .= 'Query failed : //'.$element.'[contains(@class, \''.$class.'\')]';
		    		}
		    	}
		    	if( !is_object($domItems) )
		    	{
		    		echo "Q3 - failed .\n";
		    		//div[contains(@class, 'measure-tab')
		    		$domItems = $xpath->query('//'.$element.'[contains(@class, \''.$class.'\')]');
		    		if( !is_object($domItems) )
		    		{
		    			echo "Q4 - failed .\n";
		    			$response .= 'Query failed : //'.$element.'[contains(@class, "'.$class.'")]';
		    		}
		    		else if( is_object($domItems) && $domItems->length == 0 )
		    		{
		    			$response .= 'Query failed : //'.$element.'[contains(@class, "'.$class.'")]';	
		    		}
		    	}

		    	if( is_object($domItems) )
		    	{
		    		
		    		foreach($domItems as $item) 
				    {
				    	//echo "i";
				    	$all = $item->getElementsByTagName("img");
					    foreach($all as $child) 
					    {
					    	$src = "";
					    	foreach ($child->attributes as $attr) 
					    	{
					    		if( $attr->localName == "src" && $attr->nodeValue != "" )
					    		{
					    			$src = $attr->nodeValue;	
					    		}
				            }
				            if( $child->getAttribute("src") != "" )
					    	{
					        	$src = $child->getAttribute("src");
					    	}
					    	if( $src != "" )
					    	{
					    		if( strstr($src, "http") == false )
					    		{
					    			$src = $baseurl.$src;
					    		}
					    		if( strstr($src, "data:image") == false ){
					    			$arr[] = $src;
					    		}
					    	}
					    }
				    }
				}
			    if( count($arr) == 0 )
			    {
			    	$response .= 'Query failed :  //'.$element.'[@class="'.$class.'"]';
			    }
			    else
			    {
			    	$response = array_filter($arr);
			    }
			}
		}
		else if( isset($request->url) )
		{
			$url = $request->url;
			$element = $request->element;//"div"; 
    		$class = $request->scrapclass; //"png_png png_imgs";

			if( $request->url == "" || $request->category_id == "" || $request->subcategory_id == "" || $request->element == "" || $request->class == "" || $request->title == ""  )
			{
				$response = "Error : Invalid data.";
			}
			else
			{
				DB::table('webscrapper')->insert([ 'category_id' => $request->category_id, 'subcategory_id' => $request->subcategory_id, 'subgroup' => $request->subgroup, 'url' => $request->url, 'element' => $request->element, 'class' => $request->class, 'autocron' => $request->autocron, 'image_status' => $request->image_status, 'title' => $request->title, 'metakeywords' =>$request->metakeywords ]);
				$response = "Record added to Cron.";
				$url = $element = $title = $class = '';
			}
		}

		return view('admin.webscrapper', compact('allsubcategories', 'webscrappers','category_id','title', 'url', 'class', 'element','verify','autocron','image_status', 'response', 'credits'));;

	}//<--- END METHOD

	public function webscrapperdelete($id)
	{
		DB::table('webscrapper')->where('id', $id)->delete();

		\Session::flash('success_message', trans('admin.success_delete_webscrapper'));

    	return redirect('panel/admin/webscrapper');
	}

	public function checkwebscrapperurl(Request $request)
	{
		$result = "";
		if( isset($request->url) )
		{
			$response = DB::table('webscrapper')->where('url', $request->url)->get();
			if( count($response) > 0 )
			{
				foreach ($response as $key => $row) 
				{
					$result = "URL already exists which you entered!";	
				}
			}
		}
		echo $result;
	}

	public function updatewebscrapper(Request $request)
	{
		$result = "";
		if( isset($request->id) )
		{
			$autocron = $request->autocron;
			$response = DB::table('webscrapper')
			        ->where('id', $request->id)
			        ->update(['autocron' => $autocron ]);
			if( $response )
			{
				$result = "webscrapper record updated.";	
			}
			else
			{
				$result = "Updated failed.";	
			}
		}
		echo $result;
	}


	public function updatewebscrappertitle(Request $request)
	{
		$result = "";
		if( isset($request->id) )
		{
			$title = $request->title;
			$response = DB::table('webscrapper')
			        ->where('id', $request->id)
			        ->update(['title' => $title ]);
			if( $response )
			{
				$result = "webscrapper record updated.";	
			}
			else
			{
				$result = "Updated failed.";	
			}
		}
		echo $result;
	}



	// START
	public function categories($id=null) 
	{
		if( $id != null )
		{
			$main_categorys = DB::table('main_categorys')->select('id', 'name as main_categorys_name', 'slug as main_slug')->get();
			$data  = Categories::where('main_cat_id', $id)->orderBy('name')->get();
			$namec = DB::table('main_categorys')->where('id', $id)->get();
			$name = $namec[0]->name;
		}
		else
		{	
			$main_categorys = DB::table('main_categorys')->select('id', 'name as main_categorys_name', 'slug as main_slug')->get();
			$data  = Categories::orderBy('name')->get();
			$name = '__';
		}

		return view('admin.categories', compact('id','main_categorys','name'))->withData($data);

	}//<--- END METHOD

    public function main_category() {

        $main_categorys = DB::table('main_categorys')->get();

        return view('admin.main_category' , compact('main_categorys'));

    }//<--- END METHOD

    

	public function addCategories($id) 
	{
		return view('admin.add-categories', compact('id'));
	}//<--- END METHOD

	public function updateMainCatTitleahead(Request $request)
	{
		if( $request->id )
		{
			$request->id = str_replace("main_category", "", $request->id);
			$ids = explode(",", $request->id);
			if( count($ids) == 1 )
			{
				if( $request->titleahead && $request->titleahead != "" )
				{
					$response = DB::table('main_categorys')
			        ->where('id', $request->id)
			        ->update(['titleahead' => $request->titleahead ]);
			    }
			} else {
				foreach ($ids as $key => $categoryid) 
				{
					if( $request->titleahead && $request->titleahead != "" )
					{
						$response = DB::table('main_categorys')
				        ->where('id', $categoryid)
				        ->update(['titleahead' => $request->titleahead ]);
				    }
				}
			}
		} 
		else 
		{
			$response = 0;
		}
		echo $response;
	}	

	public function updateCatTitleahead(Request $request)
	{
		if( $request->id )
		{
			$ids = explode(",", $request->id);
			if( count($ids) == 1 )
			{
				$category = Categories::find($request->id);

				if( Auth::user()->role != 'admin' && $category->created_by != Auth::user()->id )
				{
					echo "0";
					die();
				}

				if( $request->titleahead && $request->titleahead != "" ){
					$category->titleahead = $request->titleahead;
				}
				$response = $category->save();
			} else {
				foreach ($ids as $key => $categoryid) 
				{
					$category = Categories::find($categoryid);
					if( Auth::user()->role != 'admin' && $category->created_by != Auth::user()->id )
					{
						echo "0";
						die();
					}
				
					if( $request->titleahead && $request->titleahead != "" )
					{
						$category->titleahead = $request->titleahead;
					}
					$response = $category->save();		
				}
			}
		} else {
			$response = 0;
		}
		echo $response;
	}	

	public function updateCatTags(Request $request)
	{
		if( $request->id )
		{
			$ids = explode(",", $request->id);
			if( count($ids) == 1 )
			{
				$category = Categories::find($request->id);
				if( Auth::user()->role != 'admin' && $category->created_by != Auth::user()->id )
				{
					echo "0";
					die();
				}
				if( $request->tags && $request->tags != "" ){
					$category->keyword = $request->tags;
				}
				$response = $category->save();
			} else {
				foreach ($ids as $key => $categoryid) 
				{
					$category = Categories::find($categoryid);
					if( Auth::user()->role != 'admin' && $category->created_by != Auth::user()->id )
					{
						echo "0";
						die();
					}
					if( $request->tags && $request->tags != "" )
					{
						$category->keyword = $request->tags;
					}
					$response = $category->save();		
				}
			}
		} else {
			$response = 0;
		}
		echo $response;
	}

	public function storeCategories($id, Request $request) {

		$temp            = 'public/temp/';
	    $path            = config('path.img-category'); 

		Validator::extend('ascii_only', function($attribute, $value, $parameters){
    		return !preg_match('/[^x00-x7F\-]/i', $value);
		});

		$rules = array(
            'name'        => 'required',
	        'slug'        => 'required|ascii_only|unique:categories',
	        'keyword'  => 'required',
	        'cpdescr'  => 'required',

        );

		$this->validate($request, $rules);

		if( $request->hasFile('thumbnail') )
		{
			$extension              = $request->file('thumbnail')->getClientOriginalExtension();
			$type_mime_shot   = $request->file('thumbnail')->getMimeType();
			$sizeFile                 = $request->file('thumbnail')->getSize();
			$thumbnail              = $request->slug.'-'.Str::random(6).'.'.$extension;

			if( $request->file('thumbnail')->move($temp, $thumbnail) ) 
			{
				$image = Image::make($temp.$thumbnail);
				if(  $image->width() == 457 && $image->height() == 359 ) {

					\File::copy($temp.$thumbnail, $path.$thumbnail);					
					\File::delete($temp.$thumbnail);

				} else {
					$image->fit(457, 359)->save($temp.$thumbnail);

					\File::copy($temp.$thumbnail, $path.$thumbnail);
					\File::delete($temp.$thumbnail);
				}

				ImageOptimizer::optimize($path.$thumbnail);
				Storage::put($path.$thumbnail, $image, 'public');

				$url = Storage::url($path.$thumbnail);
				\File::delete($path.$thumbnail);

			}// End File
		} // HasFile

		else {
			$thumbnail = '';
		}

		$sql              	= New Categories;
		$sql->main_cat_id	= $id;
		$sql->name        	= trim($request->name);
		$sql->slug        	= strtolower($request->slug);
		$sql->thumbnail 	= $thumbnail;
		$sql->mode        	= $request->mode;
		$sql->keyword       = $request->keyword;
		$sql->showathome    = $request->showathome;
		$sql->titleahead    = $request->titleahead;
		$sql->relatedtags   = $request->relatedtags;
		$sql->cpdescr       = $request->cpdescr; //Category Post Description
		$sql->created_by	= Auth::user()->id;
		$sql->save();

		\Session::flash('success_message', trans('admin.success_add_category'));

    	return redirect('panel/admin/categories/'.$id);

	}//<--- END METHOD

	public function membersSubcategories($mid)
	{
		$query = subcategories::where('created_by', $mid);
		$user = User::find($mid);

		$pagination = 25;

		$data = $query->orderBy('id', 'DESC')->paginate($pagination);
				
		return view('admin.viewmembersubcat',compact([ 'data', 'mid', 'user']));	
	}

	public function subCategories($id)
	{
		$sort = Input::get('sort');
		$q = Input::get('q');

		$query = subcategories::join('users', function($join){
				$join->on('users.id', '=', 'subcategories.created_by');
			});
		$query->where('subcategories.categories_id', $id);
		if( isset($q) && $q != "" )
		{
			$query->where('subcategories.name', 'LIKE', '%'.$q.'%');
		}

		$pagination = 25;
		if( !isset($sort) || $sort == '' )
		{
			$query->orderBy( \DB::raw('subcategories.id'), 'desc');
		}
		else if( $sort == 'created_by' )
		{
			$query->where('subcategories.created_by', Auth::user()->id)->orderBy( \DB::raw('subcategories.created_by'), 'desc');
		}
		else if( $sort == 'allinsta' )
		{
			$query->where( \DB::raw('subcategories.allinsta'), 'yes')->orderBy( \DB::raw('subcategories.last_updated'), 'DESC' );
		}

		else if( $sort == 'instacronstatus' )
		{
			$query->where( \DB::raw('subcategories.instacronstatus'), 'on')->orderBy( \DB::raw('subcategories.last_updated'), 'DESC' );
		}

		else if( $sort == 'name' )
		{
			$query->orderBy( \DB::raw('subcategories.name'), 'asc' );
		}
		else if( $sort == 'id' )
		{
			$query->orderBy( \DB::raw('subcategories.id'), 'desc' );
		}
		else if( $sort == 'date' )
		{
			$query->orderBy( \DB::raw('subcategories.created_date'), 'desc' );
		}
		else
		{
			$data = $query->orderBy( \DB::raw('subcategories.id'), 'desc' );
		}


		$data = $query->select('subcategories.*','users.name as username')
			->paginate($pagination)->onEachSide(1);


	if( Auth::user()->role == 'admin') {
		$sort = Input::get('sort');
		$q = Input::get('q');

		if( $sort == 'date' )
			{
				$data = subcategories::where('categories_id', $id)->orderBy('last_updated', 'DESC')->paginate($pagination)->onEachSide(1);
			}
		else if( $sort == 'id' )
		{
			$data = subcategories::where('categories_id', $id)->orderBy('id', 'DESC')->paginate($pagination)->onEachSide(1);
		}

		else if( $sort == 'name' )
			{
				$data = subcategories::where('categories_id', $id)->orderBy('name', 'ASC')->paginate($pagination)->onEachSide(1);
			}


		else if( $sort == 'allinsta' )
			{
				$data = subcategories::where('categories_id', $id)->where('allinsta', 'yes')->orderBy('last_updated', 'DESC')->paginate($pagination)->onEachSide(1);
			}
		

		else if( $sort == 'instacronstatus' )
			{
				$data = subcategories::where('categories_id', $id)->where('instacronstatus', 'yes')->orderBy('last_updated', 'DESC')->paginate($pagination)->onEachSide(1);
			}

		else if( isset($q) && $q != "" )
			{
				$data = subcategories::where('name', 'LIKE', '%'.$q.'%')->paginate($pagination)->onEachSide(1);
			}
		

		else 
			{
				$data = subcategories::where('categories_id', $id)->orderBy('last_updated', 'DESC')->paginate($pagination)->onEachSide(1);
			}

		
	}

		
		$categories = Categories::find( $id );
		$catid = $categories->id;
		$subcategories = subcategories::find($catid);
		$maincatid = $categories->main_cat_id;
		$maincategory= DB::table('main_categorys')->find( $maincatid );
		$catname = $maincategory->name;

		return view('admin.viewsubcat',compact(['sort', 'q', 'data', 'id', 'catname', 'categories', 'subcategories']));
	}

	public function updateAllInsta(Request $request)
	{
		if( $request->id )
		{
			$subcategory = subcategories::find($request->id);

			if( Auth::user()->role != 'admin' && $subcategory->created_by != Auth::user()->id )
			{
				echo "0";
				die();
			}

			if( $request->allinsta && $request->allinsta != "" ){
				$subcategory->allinsta = $request->allinsta;
			}
			$response = $subcategory->save();
		}
		else
		{
			$response = 0;
		}
		echo $response;	
	}


	public function updatemode(Request $request)
	{
		if( $request->id )
		{
			$subcategory = subcategories::find($request->id);

			if( Auth::user()->role != 'admin' && $subcategory->created_by != Auth::user()->id )
			{
				echo "0";
				die();
			}

			if( $request->mode && $request->mode != "" ){
				$subcategory->mode = $request->mode;
			}
			$response = $subcategory->save();
		}
		else
		{
			$response = 0;
		}
		echo $response;	
	}

	public function showathome(Request $request)
	{
		if( $request->id )
		{
			$subcategory = subcategories::find($request->id);

			if( Auth::user()->role != 'admin' && $subcategory->created_by != Auth::user()->id )
			{
				echo "0";
				die();
			}

			if( $request->showathome && $request->showathome != "" ){
				$subcategory->showathome = $request->showathome;
			}
			$response = $subcategory->save();
		}
		else
		{
			$response = 0;
		}
		echo $response;	
	}

	public function updatesSpecialDate(Request $request)
	{
		$response = 0;
		if( $request->id ){
			$subcategory = subcategories::find($request->id);
			if( Auth::user()->role != 'admin' && $subcategory->created_by != Auth::user()->id ){
				echo "0";
				die();
			}
			$request->special_date = ($request->special_date == "") ? null : date("Y-m-d", strtotime($request->special_date));
			$subcategory->special_date = $request->special_date;
			$response = $subcategory->save();			
		} else {
			$response = 0;
		}
		echo $response;	
	}

	public function updateSubgroup(Request $request)
	{
		if( $request->id ){
			$subcategory = subcategories::find($request->id);
			if( Auth::user()->role != 'admin' && $subcategory->created_by != Auth::user()->id ){
				echo "0";
				die();
			}
			if( $request->selectSubgroup && $request->selectSubgroup != "" ){
				$subcategory->selectedgroup = $request->selectSubgroup;
			}
			$response = $subcategory->save();
		} else {
			$response = 0;
		}
		echo $response;	
	}

	public function updateSubcatImgTitle(Request $request)
	{
		if( $request->id )
		{
			$ids = explode(",", $request->id);
			if( count($ids) == 1 )
			{
				$subcategory = subcategories::find($request->id);
				if( $request->imgtitle && $request->imgtitle != "" ){
					$subcategory->imgtitle = $request->imgtitle;
				}
				$response = $subcategory->save();
			}
			else
			{
				foreach ($ids as $key => $subcategoryid) 
				{
					$subcategory = subcategories::find($subcategoryid);
					if( $request->imgtitle && $request->imgtitle != "" ){
						$subcategory->imgtitle = $request->imgtitle;
					}
					$response = $subcategory->save();		
				}
			}
		}
		else
		{
			$response = 0;
		}
		echo $response;
	}	

	public function updateSubcatTags(Request $request)
	{
		if( $request->id )
		{
			$ids = explode(",", $request->id);
			if( count($ids) == 1 )
			{
				$subcategory = subcategories::find($request->id);

				if( Auth::user()->role != 'admin' && $subcategory->created_by != Auth::user()->id )
				{
					echo "0";
					die();
				}

				if( $request->tags && $request->tags != "" ){
					$subcategory->keyword = $request->tags;
				}
				$response = $subcategory->save();
			}
			else
			{
				foreach ($ids as $key => $subcategoryid) 
				{
					$subcategory = subcategories::find($subcategoryid);

					if( Auth::user()->role != 'admin' && $subcategory->created_by != Auth::user()->id )
					{
						echo "0";
						die();
					}

					if( $request->tags && $request->tags != "" ){
						$subcategory->keyword = $request->tags;
					}
					$response = $subcategory->save();		
				}
			}
		}
		else
		{
			$response = 0;
		}
		echo $response;
	}

	public function addsubCategories($id)
	{
		$subcategories = subcategories::all();
		$data = Categories::find( $id );
		$catid = $data->id;
		$category = categories::find($catid);
		$catname = $category->name;
		$datamain = $data->main_cat_id;
		$maintype = DB::table('main_categorys')->find( $datamain );

		return view('admin.add-subcategories', compact('subcategories', 'data', 'id', 'catname', 'catid' ,'maintype', 'datamain'));
	}
	
	public function savesubCategories($id, Request $request)
	{
		$data 			 = $request->all();
		$temp            = 'public/temp/'; // Temp
	    $path            = config('path.img-subcategory'); 
	    $preview_path    = config('path.subcat_preview'); 

		Validator::extend('ascii_only', function($attribute, $value, $parameters){
    		return !preg_match('/[^x00-x7F\-]/i', $value);
		});

		$rules = array(
            'name'        => 'required',
	        'slug'        => 'required|ascii_only|unique:subcategories',
	        'keyword'  => 'required',
	        'spdescr'  => 'required',
        );

		$this->validate($request, $rules);
		if( $request->insta_username != "" )
		{
			$sub = subcategories::where('insta_username','=',$data['insta_username'])->count();
			if( $sub > 0 )
			{
				\Session::flash('info_message', trans('admin.insta_account_error'));
				$subcategories = subcategories::all();
				$data = Categories::find( $id );
				$catid = $data->id;
				$category = categories::find($catid);
				$catname = $category->name;
				$datamain = $data->main_cat_id;
				$maintype = DB::table('main_categorys')->find( $datamain );
				return view('admin.add-subcategories',compact('subcategories','data','id', 'catname', 'catid' ,'maintype', 'datamain'));
			}
		}

		if( $request->hasFile('thumbnail') )	
		{
			$extension        = $request->file('thumbnail')->getClientOriginalExtension();
			$type_mime_shot   = $request->file('thumbnail')->getMimeType();
			$sizeFile         = $request->file('thumbnail')->getSize();
			$thumbnail        = $request->slug.'-'.Str::random(6).'.webp';
			$preview          = $request->slug.'-'.Str::random(6).'.webp';

			if( $request->file('thumbnail')->move($temp, $thumbnail) ) 
			{
				$image = Image::make($temp.$thumbnail);
				if(  $image->width() == 457 && $image->height() == 359 ) 
				{
					\File::copy($temp.$thumbnail, $path.$thumbnail);
					\File::delete($temp.$thumbnail);
				} 
				else 
				{
					$image->fit(457, 359)->save($temp.$thumbnail);
					\File::copy($temp.$thumbnail, $path.$thumbnail);
					\File::delete($temp.$thumbnail);
				}

				\File::copy($path.$thumbnail, $preview_path.$preview);
				ImageOptimizer::optimize($path.$thumbnail);
				Storage::put($path.$thumbnail, $image, 'public');
				$url = Storage::url($path.$thumbnail);

				\File::delete($path.$thumbnail);

				$image = Image::make($preview_path.$preview)->encode("webp",90);
				$image->fit(100, 100)->save($preview_path.$preview);
				ImageOptimizer::optimize($preview_path.$preview);

				Storage::put($preview_path.$preview, $image, 'public');
				$url = Storage::url($preview_path.$preview);

				\File::delete($preview_path.$preview);
			}// End File
		} // HasFile
		else if( $request->instathumbnail != "" )	
		{
			$thumblocal 	= 'public/temp/';
			$filename 		= explode("?", pathinfo($request->instathumbnail, PATHINFO_FILENAME));
			$inst_file 		= "insta_".$filename[0];

			$insta_local 	= 'public/temp/'.$inst_file;
			copy($request->instathumbnail, $insta_local);
			$sizeFile = \File::size($insta_local);
			$p = new UploadedFile($insta_local, $inst_file, 'image/jpg', $sizeFile, null, TRUE);
			
			$extension        = $p->getClientOriginalExtension();
			$type_mime_shot   = $p->getMimeType();
			$sizeFile         = $p->getSize();
			$thumbnail        = $request->slug.'-'.Str::random(6).'.'.$extension;
			$preview          = $request->slug.'-'.Str::random(6).'.'.$extension;

			if( $p->move($temp, $thumbnail) ) 
			{
				$image = Image::make($temp.$thumbnail);
				if(  $image->width() == 457 && $image->height() == 359 ) 
				{
					\File::copy($temp.$thumbnail, $path.$thumbnail);
					\File::delete($temp.$thumbnail);
				} 
				else 
				{
					$image->fit(457, 359)->save($temp.$thumbnail);
					\File::copy($temp.$thumbnail, $path.$thumbnail);
					\File::delete($temp.$thumbnail);
				}

				\File::copy($path.$thumbnail, $preview_path.$preview);
				ImageOptimizer::optimize($path.$thumbnail);
				Storage::put($path.$thumbnail, $image, 'public');
				$url = Storage::url($path.$thumbnail);

				\File::delete($path.$thumbnail);

				$image = Image::make($preview_path.$preview)->encode("webp",90);
				$image->fit(100, 100)->save($preview_path.$preview);
				ImageOptimizer::optimize($preview_path.$preview);

				Storage::put($preview_path.$preview, $image, 'public');
				$url = Storage::url($preview_path.$preview);

				\File::delete($preview_path.$preview);
			}// End File
		} // HasFile
		else 
		{
			$thumbnail = '';
			$preview = '';
		}

		$userid = Auth::user()->id;
		if( $data['special_date'] != "" ){
			$data['special_date'] = date("Y-m-d", strtotime($data['special_date']));
		}
		$keywords = Helper::removespecialcharacters($request->keyword);
		DB::table('subcategories')->insert([ 
			'special_date' => $data['special_date'], 
			'created_by' => $userid, 
			'name'=> $data['name'], 
			'insta_username' => $data['insta_username'], 
			'cronstatus' => $data['cronstatus'], 
			'mode' => $data['mode'], 
			'showathome' => $data['showathome'],
			'pinthumb' => $data['pinthumb'],
			'watermark' => $data['watermark'], 
			'imagecount' => $data['imagecount'], 
			'allinsta' => $data['allinsta'],
			'imgtitle' => $data['imgtitle'],
			'slug'=>$data['slug'],
			'keyword'=> $keywords,
			'metakeywords'=>$data['metakeywords'],
			'instacronstatus'=>$data['instacronstatus'],
			'spdescr'=>$data['spdescr'],
			'tags'=>$data['tags'],
			'selectedgroup'=> $data['selectedgroup'],
			'sthumbnail' =>$thumbnail,
			'preview'=>$preview,
			'categories_id'=>$id]);
		\Session::flash('success_message', trans('admin.success_update'));
		return redirect('panel/admin/subcategories/view/'.$id);
	}

	public function editCategories($id, $pid) {

		$categories  = Categories::find( $id );

		if( Auth::user()->role != 'admin' && $categories->created_by != Auth::user()->id )
		{
			\Session::flash('info_message', trans('admin.recordaccessdenied'));
			return view('admin.pd');
		}

		$allsubcategories = array();
		$cats = subcategories::all();
		if( count($cats) > 0 )
		{
			$source = array();
			foreach ($cats as $key => $value) 
			{
				$itags = $value->slug;
			    $source[] = $itags;
			}
			$allsubcategories = array_unique($source);
		}

		$alltags = array();
		$tags = Images::where('categories_id', $id )
				->where('status', 'active' )->skip(0)->take(51000)->get();
		if( count($tags) > 0 )
		{
			$source = array();
			foreach ($tags as $key => $value) 
			{
				$itags = explode(",", $value->metakeywords);
			    foreach ($itags as $item) 
			    {
			        $source[] = trim($item);
			    }
			}
			$alltags = array_unique($source);
		}

		return view('admin.edit-categories',compact(['id','alltags','categories','allsubcategories']));

	}//<--- END METHOD

	public function updateCategories($id,$pid, Request $request ) 
	{
		$categories  = Categories::find( $request->id );

		if( Auth::user()->role != 'admin' || $categories->created_by != Auth::user()->id )
		{
			\Session::flash('info_message', trans('admin.recordaccessdenied'));
			return view('admin.pd');
		}

		$temp            = 'public/temp/'; // Temp
	    $path            = config('path.img-category'); // Path General

	    if( !isset($categories) ) {
			return redirect('panel/admin/categories');
		}

		Validator::extend('ascii_only', function($attribute, $value, $parameters){
			return !preg_match('/[^x00-x7F\-]/i', $value);
		});

		$rules = array(
	        'name'        => 'required',
	        'slug'        => 'required|ascii_only|unique:categories,slug,'.$request->id,
	        'keyword'  => 'required',
	        'cpdescr'  => 'required',

	     );

		$this->validate($request, $rules);

		if( $request->hasFile('thumbnail') )	{

			$extension              = $request->file('thumbnail')->getClientOriginalExtension();
			$type_mime_shot   = $request->file('thumbnail')->getMimeType();
			$sizeFile                 = $request->file('thumbnail')->getSize();
			$thumbnail              = $request->slug.'-'.Str::random(6).'.'.$extension;

			if( $request->file('thumbnail')->move($temp, $thumbnail) ) {

				$image = Image::make($temp.$thumbnail);
				if(  $image->width() == 457 && $image->height() == 359 ) {

					\File::copy($temp.$thumbnail, $path.$thumbnail);
					\File::delete($temp.$thumbnail);

				} else {
					$image->fit(457, 359)->save($temp.$thumbnail);

					\File::copy($temp.$thumbnail, $path.$thumbnail);
					\File::delete($temp.$thumbnail);
				}
				// Delete Old Image
				\File::delete($path.$categories->thumbnail);
				Storage::delete($path.$thumbnail);

				ImageOptimizer::optimize($path.$thumbnail);
				 Storage::put($path.$thumbnail, $image, 'public');

				 $url = Storage::url($path.$thumbnail);
				 \File::delete($path.$thumbnail);

			}// End File
		} // HasFile
		else {
			$thumbnail = $categories->thumbnail;
		}

		// UPDATE CATEGORY
		$categories->name        = $request->name;
		$categories->slug        = strtolower($request->slug);
		$categories->thumbnail  = $thumbnail;
		$categories->mode        = $request->mode;
		$categories->showathome    = $request->showathome;
		$categories->keyword        = $request->keyword;
		$categories->titleahead    = $request->titleahead;
		$categories->relatedtags        = $request->relatedtags;
		$categories->cpdescr        = $request->cpdescr;
		$categories->modified_by    = Auth::user()->id;

		$categories->save();

		\Session::flash('success_message', trans('misc.success_update'));

		return redirect('panel/admin/categories/'.$pid);

	}//<--- END METHOD

	public function deleteCategories($id, $pid)
	{
		$categories  = Categories::find( $id );

		if( Auth::user()->role != 'admin' && $categories->created_by != Auth::user()->id )
		{
			\Session::flash('info_message', trans('admin.recordaccessdenied'));
			return view('admin.pd');
		}

		$thumbnail   = config('path.img-category').$categories->thumbnail; // Path General

		if( !isset($categories) || $categories->id == 1 ) 
		{
			return redirect('panel/admin/categories/'.$pid);
		} 
		else 
		{
			$images_category   = Images::where('categories_id',$id)->get();
			// Delete Category
			$categories->delete();
			// Delete Thumbnail
			if ( \File::exists($thumbnail) ) 
			{
				\File::delete($thumbnail);
			}//<--- IF FILE EXISTS

			Storage::delete($thumbnail);

			//Update Categories Images
			if( isset( $images_category ) ) {
				foreach ($images_category as $key ) {
					$key->categories_id = 1;
					$key->save();
				}
			}

			return redirect('panel/admin/categories/'.$pid);
		}
	}//<--- END METHOD

	public function deletesubCategories($id,$pid)
	{
		$subcategories    = subcategories::find( $id );

		if( Auth::user()->role != 'admin' )
		{
			return redirect()->back()->with('alert_message', 'Not Permitted!'); 
		}

		$thumbnail        = config('path.img-subcategory').$subcategories->sthumbnail; // Path General
		$preview          = config('path.subcat_preview').$subcategories->preview; // Path General
		// Delete Thumbnail
		if ( \File::exists($thumbnail) ) 
		{
			\File::delete($thumbnail);
			\File::delete($preview);
		}//<--- IF FILE EXISTS

		Storage::delete($thumbnail);
		 Storage::delete($preview);

		subcategories::where('id',$id)->delete();
		return redirect('panel/admin/subcategories/view/'.$pid);
	}

	public function editsubCategories($id,$pid)
	{
		$data = subcategories::find($id);
		$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		$currenturl = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

		if( Auth::user()->role != 'admin' && $data->created_by != Auth::user()->id )
		{	
			return redirect()->back()->with('alert_message', 'Not Permitted!'); 
		}
		$data1 = $data->categories_id;
		$category = categories::find($data1);
		$catname = $category->name;
		$alltags = array();
		$tags = Images::where('subcategories_id', $id )
				->where('status', 'active' )->skip(0)->take(51000)->get();
		if( count($tags) > 0 )
		{
			$source = array();
			foreach ($tags as $key => $value) 
			{
				$itags = explode(",", $value->metakeywords);
			    foreach ($itags as $item) 
			    {
			        $source[] = trim($item);
			    }
			}
			$alltags = array_unique($source);
		}

		return view('admin.edit-subcategories',compact(['data','id','alltags', 'catname']));
	}

	public function updatesubCategories($id,$pid,Request $request)
	{	


		if( Auth::user()->role != 'admin' && $data->created_by != Auth::user()->id )
		{
			echo 'Sorry you are not permitted!';
		}

		$data 	= $request->all();
		$subcategories  = subcategories::find( $id );
		$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		$currenturl = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
		$temp   = 'public/temp/'; // Temp
	    $path   = config('path.img-subcategory');
	    $preview_path  = config('path.subcat_preview'); 

	    if( !isset($subcategories) ) {
			return redirect('panel/admin/subcategories/'.$id);
		}

		Validator::extend('ascii_only', function($attribute, $value, $parameters){
			return !preg_match('/[^x00-x7F\-]/i', $value);
		});

		$rules = array(
	        'name'        => 'required',
	        'slug'        => 'required|ascii_only|unique:subcategories,slug,'.$id,
	        // 'thumbnail'   => 'mimes:jpg,gif,png,jpe,jpeg|image_size:>=457,>=359',
	        'keyword'  => 'required',
	        'spdescr'  => 'required',
	     );

		$this->validate($request, $rules);

		if( $request->hasFile('thumbnail') )	
		{
			$extension        = $request->file('thumbnail')->getClientOriginalExtension();
			$type_mime_shot   = $request->file('thumbnail')->getMimeType();
			$sizeFile         = $request->file('thumbnail')->getSize();
			$thumbnail        = $request->slug.'-'.Str::random(5).'.webp';
			$preview          = $request->slug.'-'.Str::random(6).'.webp';

			if( $request->file('thumbnail')->move($temp, $thumbnail) ) 
			{
				$image = Image::make($temp.$thumbnail);
				if(  $image->width() == 457 && $image->height() == 359 ) {
					\File::copy($temp.$thumbnail, $path.$thumbnail);
					\File::delete($temp.$thumbnail);
				} else {
					$image->fit(457, 359)->save($temp.$thumbnail);
					\File::copy($temp.$thumbnail, $path.$thumbnail);
					\File::delete($temp.$thumbnail);
				}

				// Delete Old Image
				\File::delete($path.$subcategories->sthumbnail);
				\File::delete($path.$subcategories->preview);
				Storage::delete($path.$subcategories->sthumbnail);
				Storage::delete($path.$subcategories->preview);

				\File::copy($path.$thumbnail, $preview_path.$preview);
				ImageOptimizer::optimize($path.$thumbnail);
			 	Storage::put($path.$thumbnail, $image, 'public');
				 $url = Storage::url($path.$thumbnail);

				$image = Image::make($preview_path.$preview)->encode("webp",90);
				$image->fit(100, 100)->save($preview_path.$preview);
				ImageOptimizer::optimize($preview_path.$preview);
				 Storage::put($preview_path.$preview, $image, 'public');
				 $url = Storage::url($preview_path.$preview);

				 \File::delete($path.$thumbnail);
				\File::delete($preview_path.$preview);
				
			}// End File
		} // HasFile
		else if( $request->hasFile('thumbnail') )	
		{
			$thumblocal 	= 'public/temp/';
			$filename 		= explode("?", pathinfo($request->instathumbnail, PATHINFO_FILENAME));
			$inst_file 		= "insta_".$filename[0];

			$insta_local 	= 'public/temp/'.$inst_file;
			copy($request->instathumbnail, $insta_local);
			$sizeFile = \File::size($insta_local);
			$p = new UploadedFile($insta_local, $inst_file, 'image/jpg', $sizeFile, null, TRUE);

			$extension        = $p->getClientOriginalExtension();
			$type_mime_shot   = $p->getMimeType();
			$sizeFile         = $p->getSize();
			$thumbnail        = $request->slug.'-'.Str::random(5).'.webp';
			$preview          = $request->slug.'-'.Str::random(6).'.webp';

			if( $p->move($temp, $thumbnail) ) 
			{
				$image = Image::make($temp.$thumbnail)->encode("webp",90);
				if(  $image->width() == 457 && $image->height() == 359 ) {
					\File::copy($temp.$thumbnail, $path.$thumbnail);
					\File::delete($temp.$thumbnail);
				} else {
					$image->fit(457, 359)->save($temp.$thumbnail);
					\File::copy($temp.$thumbnail, $path.$thumbnail);
					\File::delete($temp.$thumbnail);
				}

				// Delete Old Image
				\File::delete($path.$subcategories->sthumbnail);
				\File::delete($path.$subcategories->preview);
				Storage::delete($path.$subcategories->sthumbnail);
				Storage::delete($path.$subcategories->preview);

				\File::copy($path.$thumbnail, $preview_path.$preview);
				ImageOptimizer::optimize($path.$thumbnail);
			 	Storage::put($path.$thumbnail, $image, 'public');
				$url = Storage::url($path.$thumbnail);

				$image = Image::make($preview_path.$preview)->encode("webp",90);
				$image->fit(100, 100)->save($preview_path.$preview);
				ImageOptimizer::optimize($preview_path.$preview);
				Storage::put($preview_path.$preview, $image, 'public');
				$url = Storage::url($preview_path.$preview);

				\File::delete($path.$thumbnail);
				\File::delete($preview_path.$preview);
			}// End File
		} // HasFile
		else 
		{
			$thumbnail = $subcategories->sthumbnail;
			$preview = $subcategories->preview;
		}
		$userid = Auth::user()->id;

		if( $data['special_date'] != "" )
		{
			$data['special_date'] = date("Y-m-d", strtotime($data['special_date']));
		}

		$keywords = Helper::removespecialcharacters($request->keyword);
		
		DB::table('subcategories')->where('id', $id)->update([ 
			'special_date' => $data['special_date'],
			'watermark' => $data['watermark'], 
			'showathome' => $data['showathome'], 
			'pinthumb' => $data['pinthumb'],
			'modified_by' => $userid,
			'name'=> $data['name'],
			'insta_username' => $data['insta_username'],
			'cronstatus' => $data['cronstatus'],
			'mode' => $data['mode'],
			'allinsta' => $data['allinsta'],
			'imgtitle' => $data['imgtitle'],
			'keyword'=> $keywords,
			'tags'=> $data['tags'],
			'selectedgroup'=> $data['selectedgroup'],
			'metakeywords'=> $data['metakeywords'],
			'instacronstatus'=>$data['instacronstatus'],
			'spdescr' => $data['spdescr'],
			'preview' => $preview,
			'sthumbnail' =>$thumbnail,
			'slug'=>$data['slug']
		]);



			if( $referer != '' ) {
				return redirect($referer)->with('success_message', trans('misc.success_update'));
			}
			else {
				return redirect($currenturl)->with('success_message', trans('misc.success_update'));
			}
	}
	
	public function settings() {

		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}

		return view('admin.settings');

	}//<--- END METHOD

	
	public function saveSettings(Request $request) 
	{
	
		$sql                      = AdminSettings::first();
		$sql->sitename            = $request->sitename;
		$sql->title               = $request->title;
		$sql->welcome_subtitle    = $request->welcome_subtitle;
		$sql->keywords            = $request->keywords;
		$sql->instacron_log  	  = $request->instacron_log;
		$sql->description         = $request->description;
		$sql->captcha             = $request->captcha;
		$sql->notification        = $request->notification;
		$sql->registration_active = $request->registration_active;
		$sql->email_verification  = $request->email_verification;
		$sql->hotsearch	          = $request->hotsearch;
		$sql->whatstoday          = $request->whatstoday;
		$sql->whatstoday1         = $request->whatstoday1;			
		$sql->whatstodaylink      = $request->whatstodaylink;
		$sql->whatstoday1link     = $request->whatstoday1link;		
		$sql->homefiles1          = $request->homefiles1;
		$sql->homefiles2          = $request->homefiles2;
		$sql->facebook            = $request->facebook;
		$sql->instagram           = $request->instagram;
		$sql->twitter             = $request->twitter;
		$sql->pinterest           = $request->pinterest;
		
		
		
		$sql->save();
		\Session::flash('success_message', trans('admin.success_update'));

    	return redirect('panel/admin/settings');

	}//<--- END METHOD



	public function settingsLimits() {

		return view('admin.limits');

	}//<--- END METHOD

	public function saveSettingsLimits(Request $request) {


		$sql                      = AdminSettings::first();

		$sql->downloadidto        = $request->downloadidto;
		$sql->downloadidfrom      = $request->downloadidfrom;
		$sql->result_request      = $request->result_request;
		$sql->limit_upload_user   = $request->limit_upload_user;
		$sql->auto_approve_images = $request->auto_approve_images;
		$sql->paginationlimit  = $request->paginationlimit;

		$sql->save();

		\Session::flash('success_message', trans('admin.success_update'));

    	return redirect('panel/admin/settings/limits');

	}//<--- END METHOD

	public function settingsModify() {

		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		return view('admin.modify');

	}//<--- END METHOD

	public function saveSettingsModify(Request $request)
	{

		$sql                      = AdminSettings::first();
		$sql->bannedkeywords	  = $request->bannedkeywords;
		$sql->responsiveads 	  = $request->responsiveads;
		$sql->deskads 	  		  = $request->deskads;
		$sql->mobileads 	  	  = $request->mobileads;
		$sql->stickyads  		  = $request->stickyads;
		$sql->stickyadsonoff  	  = $request->stickyadsonoff;
		$sql->adswithimage        = $request->adswithimage;
		$sql->google_ads_index    = $request->google_ads_index;
		$sql->google_analytics    = $request->google_analytics;
		$sql->save();

		\Session::flash('success_message', trans('admin.success_update'));

    	return redirect('panel/admin/modify');

	}//<--- END METHOD


	public function subcat_images($sid)
	{	
		$subcategories_id = $sid;
		$subcat = subcategories::find($sid);
		$catid = $subcat->categories_id;
		$cat = categories::find($catid);

		$catname = $cat->name;
		$query = Input::get('q');
		$sort = Input::get('sort');
		$settings = AdminSettings::first();
		$pagination = $settings->paginationlimit;
		$data = Images::where("subcategories_id", $subcategories_id)->orderBy('id','desc')->paginate($pagination);

		$sdata = DB::table('images')
				->where("subcategories_id", $subcategories_id)
                ->select('subgroup', DB::raw('count(*) as scount'))
                ->groupBy('subgroup')
                ->get();
        $sgdata = [];
        if( count($sdata) > 0 ) {
			foreach ($sdata as $key => $value) 
			{
				$sgdata[ $value->subgroup ] = $value->scount;
			}
		}

		// if( Auth::user()->role != 'admin' && $subcat->created_by != Auth::user()->id )
		// {
		// 	\Session::flash('info_message', trans('admin.recordaccessdenied'));
		// 	return view('admin.pd');
		// }

		if( isset( $query ) ) 
		{
		 	$data = Images::where("subcategories_id", $subcategories_id)->where('title', 'LIKE', '%'.$query.'%')
			->orWhere('metakeywords', 'LIKE', '%'.$query.'%')
		 	->orderBy('id','desc')->paginate($pagination);
		}
		// Sort
		if( $sort == 'title' ) {
			$data = Images::where("subcategories_id", $subcategories_id)->orderBy('title','asc')->paginate($pagination);
		}
		else if( $sort == 'featured' ) {
			$data = Images::where("subcategories_id", $subcategories_id)->orderBy('featured','asc')->paginate($pagination);
		}
		else if( $sort == 'pending' ) {
			$data = Images::where("subcategories_id", $subcategories_id)->where('status','pending')->paginate($pagination);
		}
		else if( $sort == 'nogroup' ) {
			$data = Images::where("subcategories_id", $subcategories_id)->where('subgroup', '=', null)->paginate($pagination);
		}
		else if($sort != '' ) {
			$data = Images::where("subcategories_id", $subcategories_id)->where('subgroup', 'LIKE', '%'.$sort.'%')->paginate($pagination);
		}else{
			//
		}
		return view('admin.subcatimages', ['data' => $data, 'catname' => $catname, 'subcat' => $subcat,'cat' => $cat, 'query' => $query, 'sort' => $sort, 'sgdata' => $sgdata ]);
	}

	public function images() 
	{
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		$query = Input::get('q');
		$sort = Input::get('sort');
		$settings = AdminSettings::first();
		$pagination = $settings->paginationlimit;
		$categories = Categories::all();
		$data = Images::orderBy('id','desc')->paginate($pagination);
		if( isset( $query ) ) {
		 	$data = Images::where('title', 'LIKE', '%'.$query.'%')
			->orWhere('metakeywords', 'LIKE', '%'.$query.'%')
			->orWhere('id', 'LIKE', '%'.$query.'%')
		 	->orderBy('id','desc')->paginate($pagination);
		 }

		// Sort
		if( isset( $sort ) && $sort == 'title' ) {
			$data = Images::orderBy('title','asc')->paginate($pagination);
		}

		// Sort
		if( isset( $sort ) && $sort == 'featured' ) {
			$data = Images::orderBy('featured','asc')->paginate($pagination);
		}

		if( isset( $sort ) && $sort == 'pending' ) {
			$data = Images::where('status','pending')->paginate($pagination);
		}

		return view('admin.images', ['data' => $data,'query' => $query, 'sort' => $sort, 'categories' => $categories ]);
	}//<--- End Method
	
	public function duplicateImages() {
        if (Auth::user()->role == 'editor') {
            \Session::flash('info_message', trans('admin.pd'));
            return view('admin.pd');
        }

        $query = Input::get('q');
        $sort = Input::get('sort');
        $settings = AdminSettings::first();
        $pagination = $settings->paginationlimit;
        $categories = Categories::all();

        $data = Images::whereIn('hash', function ( $query ) {
            $query->select('hash')->from('images')->groupBy('hash')->havingRaw('count(hash) > 1');
        })->whereNotNull('hash')->orderByDesc('hash');

        if (isset($query)) {
            $data = $data->where('title', 'LIKE', '%' . $query . '%')
                         ->orWhere('metakeywords', 'LIKE', '%' . $query . '%')
                         ->orWhere('id', 'LIKE', '%' . $query . '%');
        }

        // Sort
        if (isset($sort) && $sort == 'title') {
            $data = $data->orderBy('title', 'asc');
        }
        if (isset($sort) && $sort == 'featured') {
            $data = $data->orderBy('featured', 'asc');
        }
        if (isset($sort) && $sort == 'pending') {
            $data = $data->where('status', 'pending');
        }
        $data = $data->paginate($pagination);
        $dataTotal = $data->total();
        $countDuplicate = $dataTotal;

        return view('admin.duplicate-images', ['data' => $data, 'query' => $query, 'sort' => $sort, 'categories' => $categories, 'countDuplicate' => $countDuplicate]);
    }


	public function deletePending()
	{	
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		$pendingImages = Images::where('status', 'pending')->get();	
		if( count($pendingImages) > 0 )
		{
			foreach ($pendingImages as $key => $record) 
			{
				$image = Images::find($record->id);
				// Delete Notification
				$notifications = Notifications::where('destination',$record->id)
					->where('type', '2')
					->orWhere('destination',$record->id)
					->where('type', '3')
					->orWhere('destination',$record->id)
					->where('type', '6')
					->get();

				if(  isset( $notifications ) ){
					foreach($notifications as $notification){
						$notification->delete();
					}
				}

				//<---- ALL RESOLUTIONS IMAGES
				

				$preview_image = config('path.preview').$image->preview;
				Storage::delete(config('path.preview').$image->preview);
				$thumbnail     = config('path.thumbnail').$image->thumbnail;
				Storage::delete(config('path.thumbnail').$image->thumbnail);
				$simthumbnail     = config('path.simthumbnail').$image->simthumbnail;
				Storage::delete(config('path.simthumbnail').$image->simthumbnail);
				$pinthumbnail     = config('path.pinthumbnail').$image->pinthumbnail;
				Storage::delete(config('path.pinthumbnail').$image->pinthumbnail);

				if( $image->opt_file_source != "" )
				{
					$opt_file_source  = config('path.optfile').$image->opt_file_source;			
					if ( \File::exists($opt_file_source) ) {
						\File::delete($opt_file_source);
					}
					Storage::delete(config('path.optfile').$image->opt_file_source);
				}

				// Delete preview
				if ( \File::exists($preview_image) ) {
					\File::delete($preview_image);
				}//<--- IF FILE EXISTS

				// Delete thumbnail
				if ( \File::exists($thumbnail) ) {
					\File::delete($thumbnail);
				}//<--- IF FILE EXISTS
				
				
					// Delete simthumbnail
				if ( \File::exists($simthumbnail) ) {
					\File::delete($simthumbnail);
				}//<--- IF FILE EXISTS
				

				
					// Delete pinthumbnail
				if ( \File::exists($pinthumbnail) ) {
					\File::delete($pinthumbnail);
				}//<--- IF FILE EXISTS
				

				$image->delete();
				sleep(1);
			}
			echo "1";
		}
		else
		{
			echo "0";
		}
	}

	public function updateImage(Request $request)
	{	

		if( $request->id )
		{
			$ids = explode(",", $request->id);
			if( count($ids) == 1 )
			{
				$image = Images::find($request->id);
				if( $request->title && $request->title != "" ){
					$image->title = $request->title;
				}
				
				if( $request->metakeywords && $request->metakeywords != "" ){
					$image->metakeywords = $request->metakeywords;
				}
				if( ($request->categories_id && $request->categories_id != "") && ( $request->subcategories_id && $request->subcategories_id != "") )
				{
					$image->categories_id = $request->categories_id;
					$image->subcategories_id = $request->subcategories_id;
				}
				if( $request->status ){
					$image->status = $request->status;
				}
				if( $request->subgroup != '' ){
					$image->subgroup = $request->subgroup;
				}
				if( $request->featured )
				{
					$image->featured = $request->featured;

					if( $request->featured == 'yes' && $image->featured == 'no' ) {
						$image->featured_date = \Carbon\Carbon::now();
					} elseif( $request->featured == 'yes' && $image->featured == 'yes' ) {
						$image->featured_date = \Carbon\Carbon::now();
					}

					elseif( $request->featured == 'no' && $image->featured == 'yes' ) {
						$image->featured_date = null;
					}

					 else {
						$image->featured_date = null;
					}

				}
				if( $request->deleteall == 'yes' )
				{
					if( Auth::user()->role == 'editor' )
						{
							\Session::flash('info_message', trans('admin.pd'));
							return view('admin.pd');
						}
					
					$preview_image = config('path.preview').$image->preview;
					Storage::delete($preview_image);
					$thumbnail     = config('path.thumbnail').$image->thumbnail;
					Storage::delete($thumbnail);
					$simthumbnail     = config('path.simthumbnail').$image->simthumbnail;
					Storage::delete($simthumbnail);
					$pinthumbnail     = config('path.pinthumbnail').$image->pinthumbnail;
					Storage::delete($pinthumbnail);
					$large     = config('path.large').$image->large;
					Storage::delete($large);
					
					if( $image->opt_file_source != "" ){
						$opt_file_source  = config('path.optfile').$image->opt_file_source;			
						if ( \File::exists($opt_file_source) ) {
							\File::delete($opt_file_source);
						}
						Storage::delete(config('path.optfile').$image->opt_file_source);
					}
					if ( \File::exists($preview_image) ) {
						\File::delete($preview_image);
					}
					if ( \File::exists($thumbnail) ) {
						\File::delete($thumbnail);
					}

					if ( \File::exists($large) ) {
						\File::delete($large);
					}
					
					
					if ( \File::exists($simthumbnail) ) {
						\File::delete($simthumbnail);
					}
										
					if ( \File::exists($pinthumbnail) ) {
						\File::delete($pinthumbnail);
					}
					

					$imagedeletelog = "Image Id : ".$request->id.", Deleted By : (".Auth::user()->id.") ".Auth::user()->name.", Date : ".date("d-m-Y H:i:s").PHP_EOL;
					$logpath = config('path.imagedeletelog');
					file_put_contents($logpath, $imagedeletelog, FILE_APPEND);

					$response = $image->delete();
				}
				else
				{
					$response = $image->save();		
				}
			}
			else
			{
				foreach ($ids as $key => $imageid) 
				{
					$image = Images::find($imageid);
					if( $request->title && $request->title != "" ){
						$image->title = $request->title;
					}
					
					if( $request->metakeywords && $request->metakeywords != "" ){
						$image->metakeywords = $request->metakeywords;
					}
					if( ($request->categories_id && $request->categories_id != "") && ( $request->subcategories_id && $request->subcategories_id != "") )
					{
						$image->categories_id = $request->categories_id;
						$image->subcategories_id = $request->subcategories_id;
					}
					if( $request->status ){
						$image->status = $request->status;
					}
					if( $request->subgroup  != '') {
						$image->subgroup = $request->subgroup;
					}
					if( $request->featured ){
						$image->featured = $request->featured;
						if( $request->featured == 'yes' && $image->featured == 'no' ) {
							$image->featured_date = \Carbon\Carbon::now();
						} elseif( $request->featured == 'yes' && $image->featured == 'yes' ) {
							
						} else {
							$image->featured_date = null;
						}
					}
					if( $request->deleteall == 'yes' )
					{	
					if( Auth::user()->role == 'editor' )
						{
							\Session::flash('info_message', trans('admin.pd'));
							return view('admin.pd');
						}
						
						$preview_image = config('path.preview').$image->preview;
						Storage::delete($preview_image);
						$thumbnail     = config('path.thumbnail').$image->thumbnail;
						Storage::delete($thumbnail);
						
						$simthumbnail     = config('path.simthumbnail').$image->simthumbnail;
						Storage::delete($simthumbnail);

						$pinthumbnail     = config('path.pinthumbnail').$image->pinthumbnail;
						Storage::delete($pinthumbnail);

						$large     = config('path.large').$image->large;
						Storage::delete($large);
						

						if( $image->opt_file_source != "" ){
							$opt_file_source  = config('path.optfile').$image->opt_file_source;			
							if ( \File::exists($opt_file_source) ) {
								\File::delete($opt_file_source);
							}
							Storage::delete(config('path.optfile').$image->opt_file_source);
						}
						if ( \File::exists($preview_image) ) {
							\File::delete($preview_image);
						}
						if ( \File::exists($thumbnail) ) {
							\File::delete($thumbnail);
						}

						if ( \File::exists($large) ) {
							\File::delete($large);
						}
						
						if ( \File::exists($simthumbnail) ) {
							\File::delete($simthumbnail);
						}

						if ( \File::exists($pinthumbnail) ) {
							\File::delete($pinthumbnail);
						}
						
						
						$imagedeletelog = "Image Id : ".$imageid.", Deleted By : (".Auth::user()->id.") ".Auth::user()->name.", Date : ".date("d-m-Y H:i:s").PHP_EOL;
						$logpath = config('path.imagedeletelog');
						file_put_contents($logpath, $imagedeletelog, FILE_APPEND);

						$response = $image->delete();
					} else {
						$response = $image->save();		
					}
				}
			}
		}
		else
		{
			$response = 0;
		}
		echo $response;
	}

	public function updateImageTags(Request $request)
	{
		if( $request->id )
		{
			$ids = explode(",", $request->id);
			if( count($ids) == 1 )
			{
				$image = Images::find($request->id);
				if( $request->tags && $request->tags != "" ){
					$image->metakeywords = $request->tags;
				}
				$response = $image->save();
			}
			else
			{
				foreach ($ids as $key => $imageid) 
				{
					$image = Images::find($imageid);
					if( $request->tags && $request->tags != "" ){
						$image->tags = $request->tags;
					}
					$response = $image->save();		
				}
			}
		}
		else
		{
			$response = 0;
		}
		echo $response;
	}


	public function deleteAllPending()
	{
		$categories_id = $_POST['categories_id'];
		$subcategories_id = $_POST['subcategories_id'];
		$pendingImages = Images::where('subcategories_id', $subcategories_id)->where('categories_id', $categories_id)->where('status', 'pending')->get();
		if( Auth::user()->role == 'editor' )
		{
		\Session::flash('info_message', trans('admin.pd'));
		return view('admin.pd');
		}
		if( count($pendingImages) > 0 )
		{
			foreach ($pendingImages as $key => $record) 
			{
				$image = Images::find($record->id);
				// Delete Notification
				$notifications = Notifications::where('destination',$record->id)
					->where('type', '2')
					->orWhere('destination',$record->id)
					->where('type', '3')
					->orWhere('destination',$record->id)
					->where('type', '6')
					->get();

				if(  isset( $notifications ) ){
					foreach($notifications as $notification){
						$notification->delete();
					}
				}

				//<---- ALL RESOLUTIONS IMAGES
				

				$preview_image = config('path.preview').$image->preview;
				Storage::delete(config('path.preview').$image->preview);
				$thumbnail     = config('path.thumbnail').$image->thumbnail;
				Storage::delete(config('path.thumbnail').$image->thumbnail);
				
				$simthumbnail     = config('path.simthumbnail').$image->simthumbnail;
				Storage::delete(config('path.simthumbnail').$image->simthumbnail);

				
				$pinthumbnail     = config('path.pinthumbnail').$image->pinthumbnail;
				Storage::delete(config('path.pinthumbnail').$image->pinthumbnail);


				if( $image->opt_file_source != "" )
				{
					$opt_file_source  = config('path.optfile').$image->opt_file_source;			
					if ( \File::exists($opt_file_source) ) {
						\File::delete($opt_file_source);
					}
					Storage::delete(config('path.optfile').$image->opt_file_source);
				}

				// Delete preview
				if ( \File::exists($preview_image) ) {
					\File::delete($preview_image);
				}//<--- IF FILE EXISTS

				// Delete thumbnail
				if ( \File::exists($thumbnail) ) {
					\File::delete($thumbnail);
				}//<--- IF FILE EXISTS
				
				
					// Delete simthumbnail
				if ( \File::exists($simthumbnail) ) {
					\File::delete($simthumbnail);
				}//<--- IF FILE EXISTS

				
					// Delete pinthumbnail
				if ( \File::exists($pinthumbnail) ) {
					\File::delete($pinthumbnail);
				}//<--- IF FILE EXISTS

				$image->delete();
				sleep(1);
			}
			echo "1";
		}
		else
		{
			echo "0";
		}
	}

	public function subcat_delete_image(Request $request)
	{
		$image = Images::find($request->id);
		// Delete Notification
			if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		//<---- ALL RESOLUTIONS IMAGES
		$preview_image = config('path.preview').$image->preview;
		Storage::delete(config('path.preview').$image->preview);
		$thumbnail     = config('path.thumbnail').$image->thumbnail;
		Storage::delete(config('path.thumbnail').$image->thumbnail);
		$simthumbnail     = config('path.simthumbnail').$image->simthumbnail;
		Storage::delete(config('path.simthumbnail').$image->simthumbnail);
		$pinthumbnail     = config('path.pinthumbnail').$image->pinthumbnail;
		Storage::delete(config('path.pinthumbnail').$image->pinthumbnail);

		if( $image->opt_file_source != "" )
		{
			$opt_file_source  = config('path.optfile').$image->opt_file_source;			
			if ( \File::exists($opt_file_source) ) {
				\File::delete($opt_file_source);
			}
			Storage::delete(config('path.optfile').$image->opt_file_source);
		}

		// Delete preview
		if ( \File::exists($preview_image) ) {
			\File::delete($preview_image);
		}//<--- IF FILE EXISTS

		// Delete thumbnail
		if ( \File::exists($thumbnail) ) {
			\File::delete($thumbnail);
		}//<--- IF FILE EXISTS
		
			// Delete thumbnail
		if ( \File::exists($simthumbnail) ) {
			\File::delete($simthumbnail);
		}//<--- IF FILE EXISTS
		

		
			// Delete pinthumbnail
		if ( \File::exists($pinthumbnail) ) {
			\File::delete($pinthumbnail);
		}//<--- IF FILE EXISTS
				

		$image->delete();

		$imagedeletelog = "Image Id : ".$request->id.", Deleted By : (".Auth::user()->id.") ".Auth::user()->name.", Date : ".date("d-m-Y H:i:s").PHP_EOL;
		$logpath = config('path.imagedeletelog');
		file_put_contents($logpath, $imagedeletelog, FILE_APPEND);
		
		return redirect('panel/admin/images');
	}

	public function delete_image(Request $request) 
	{
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}

		$imagedeletelog = "Image Id : ".$request->id.", Deleted By : (".Auth::user()->id.") ".Auth::user()->name.", Date : ".date("d-m-Y H:i:s").PHP_EOL;
		$logpath = config('path.imagedeletelog');
		file_put_contents($logpath, $imagedeletelog, FILE_APPEND);

		$image = Images::find($request->id);
		// Delete Notification
		$notifications = Notifications::where('destination',$request->id)
			->where('type', '2')
			->orWhere('destination',$request->id)
			->where('type', '3')
			->orWhere('destination',$request->id)
			->where('type', '6')
			->get();

		if(  isset( $notifications ) ){
			foreach($notifications as $notification){
				$notification->delete();
			}
		}

		//<---- ALL RESOLUTIONS IMAGES
		
		$pathLarge      = config('path.large');
		$pathPreview    = config('path.preview');
		$pathThumbnail  = config('path.thumbnail');
		$pathsimThumbnail  = config('path.simthumbnail');
		$pathpinThumbnail  = config('path.pinthumbnail');
		
	
		$preview_image = config('path.preview').$image->preview;
		//echo "URL".Storage::url($preview_image).PHP_EOL;
		$res = Storage::delete($preview_image);
		//echo "Storage Delete : ".$preview_image." : ".$res.PHP_EOL;
		
		
		$thumbnail  = config('path.thumbnail').$image->thumbnail;
		//echo "URL".Storage::url($thumbnail).PHP_EOL;
		$res = Storage::delete($thumbnail);
		//echo "Storage Delete : ".$thumbnail." : ".$res.PHP_EOL;


		$pinthumbnail  = config('path.pinthumbnail').$image->pinthumbnail;
		//echo "URL".Storage::url($simthumbnail).PHP_EOL;
		$res = Storage::delete($pinthumbnail);
		//echo "Storage Delete : ".$simthumbnail." : ".$res.PHP_EOL;


		$simthumbnail  = config('path.simthumbnail').$image->simthumbnail;
		//echo "URL".Storage::url($simthumbnail).PHP_EOL;
		$res = Storage::delete($simthumbnail);
		//echo "Storage Delete : ".$simthumbnail." : ".$res.PHP_EOL;
		

		$large  = config('path.large').$image->large;
		//echo "URL".Storage::url($thumbnail).PHP_EOL;
		$res = Storage::delete($large);
		//echo "Storage Delete : ".$thumbnail." : ".$res.PHP_EOL;
		

		

		
		if( $image->opt_file_source != "" )
		{
			$opt_file_source  = config('path.optfile').$image->opt_file_source;			
			if ( \File::exists($opt_file_source) ) {
				\File::delete($opt_file_source);
			}
			Storage::delete(config('path.optfile').$image->opt_file_source);
		}

		// Delete preview
		if ( \File::exists($preview_image) ) {
			\File::delete($preview_image);
		}//<--- IF FILE EXISTS

		// Delete thumbnail
		if ( \File::exists($thumbnail) ) {
			\File::delete($thumbnail);
		}//<--- IF FILE EXISTS

		
		if ( \File::exists($large) ) {
			\File::delete($large);
		}

	// Delete simthumbnail
		if ( \File::exists($simthumbnail) ) {
			\File::delete($simthumbnail);
		}


	// Delete pinthumbnail
		if ( \File::exists($pinthumbnail) ) {
			\File::delete($pinthumbnail);
		}


		$image->delete();
		return redirect('panel/admin/images');

	}

	public function edit_image($id) {

		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}

		$data = Images::findOrFail($id);
		$images = Images::where('id', '=', $id)->get();
		foreach($images as $image)
		{
			$stock_path = Storage::url(config('path.large').$image->large);
			$file = $image->large;
		}
		$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		$url = $stock_path;
		copy( $url, 'public/temp/'.$file );
		$data->imagetoedit = url('public/temp/'.$file);

		return view('admin.single-edit-image', [ 'referer' => $referer, 'data' => $data ]);

	}

	public function testedit_saveimage() 
	{
		$imageData = $_POST['imagedata'];
		list($type, $imageData) = explode(';', $imageData);
	    list(,$extension) = explode('/',$type);
	    list(,$imageData)      = explode(',', $imageData);
	    $fileName = uniqid().'.'.$extension;
	    $imageData = base64_decode($imageData);
	    file_put_contents('public/temp/'.$fileName, $imageData);
		echo url('public/temp/'.$fileName);
	}//<--- End Method

	public function old_edit_image($id) 
	{
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}

		$data = Images::findOrFail($id);

		return view('admin.edit-image', ['data' => $data ]);

	}//<--- End Method

	public function update_image(Request $request) {

		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}

		$sql = Images::find($request->id);

		$referer = isset($request->referer) ? $request->referer : '';

		$rules = array(
            'title'       => 'required',
	        'metakeywords'        => 'required',
        );

		if( $request->featured == 'yes' && $sql->featured == 'no' ) {
			$featuredDate = \Carbon\Carbon::now();
		} elseif( $request->featured == 'yes' && $sql->featured == 'yes' ) {
			$featuredDate = $sql->featured_date;
		} else {
			$featuredDate = null;
		}

		$this->validate($request, $rules);
		$thumbnail = "";
		$simthumbnail = "";
		$pinthumbnail = "";
		$preview = "";
		$large = "";
		$resolution = "";

		if( $request->croppedimage != "" )
		{
			$croppedimage = $request->croppedimage;
			$baseurl = url('')."/";
			$tempfile = str_replace($baseurl, "", $croppedimage);
			$sizeFile = \File::size($tempfile);
			$originalName = pathinfo($croppedimage, PATHINFO_BASENAME);

			// PATHS
			$temp            = 'public/temp/';
		    $path_preview    = 'public/uploads/preview/';
			$path_thumbnail  = 'public/uploads/thumbnail/';
			$path_simthumbnail  = 'public/uploads/simthumbnail/';
			$path_pinthumbnail  = 'public/uploads/pinthumbnail/';
			$path_large      = 'public/uploads/large/';
			$optFileSource 	 = 'uploads/opt_file/';
			$optFilePath   = config('path.optfile');
			
			$p = new UploadedFile($tempfile, $originalName, 'image/jpeg', $sizeFile, null, TRUE);
			if( $p )
			{
				// Delete Old images
				$notifications = Notifications::where('destination',$request->id)
				->where('type', '2')
				->orWhere('destination',$request->id)
				->where('type', '3')
				->orWhere('destination',$request->id)
				->where('type', '6')
				->get();
				if(  isset( $notifications ) ){
					foreach($notifications as $notification){
						$notification->delete();
					}
				}
				//<---- ALL RESOLUTIONS IMAGES
				
		$image = Images::find($request->id);
		
		$preview_image = config('path.preview').$image->preview;
		Storage::delete(config('path.preview').$image->preview);
		
		$thumbnail     = config('path.thumbnail').$image->thumbnail;
		Storage::delete(config('path.thumbnail').$image->thumbnail);
		
		$simthumbnail     = config('path.simthumbnail').$image->simthumbnail;
		Storage::delete(config('path.simthumbnail').$image->simthumbnail);

		$pinthumbnail     = config('path.pinthumbnail').$image->pinthumbnail;
		Storage::delete(config('path.pinthumbnail').$image->pinthumbnail);

		$large    = config('path.large').$image->large;
		Storage::delete(config('path.large').$image->large);


				if( $image->opt_file_source != "" )
				{
					$opt_file_source  = config('path.optfile').$image->opt_file_source;			
					if ( \File::exists($opt_file_source) ) {
						\File::delete($opt_file_source);
					}
					Storage::delete(config('path.optfile').$image->opt_file_source);
				}
				// Delete preview
				if ( \File::exists($preview_image) ) {
					\File::delete($preview_image);
				}//<--- IF FILE EXISTS
				// Delete thumbnail
				if ( \File::exists($thumbnail) ) {
					\File::delete($thumbnail);
				}//<--- IF FILE EXISTS
				
				if ( \File::exists($simthumbnail) ) {
					\File::delete($simthumbnail);
				}//<--- IF FILE EXISTS

				if ( \File::exists($pinthumbnail) ) {
					\File::delete($pinthumbnail);
				}//<--- IF FILE EXISTS


				if ( \File::exists($large) ) {
					\File::delete($large);
				}//<--- IF FILE EXISTS
				
				// Delete Old images -- END
				$extension       = $p->getClientOriginalExtension();
	    		if( $extension != 'gif' )
	    		{
					$originalName    = Helper::fileNameOriginal($p->getClientOriginalName());
					$type_mime_img   = $p->getMimeType();
					$sizeFile        = $p->getSize();
					$large           = strtolower( Auth::user()->id.time().Str::random(3).'.'.$extension );
					$oname 			 = substr($originalName, 0, 10);
					$preview         = strtolower( Str::slug( $oname, '-').Str::random(3).'.webp');
					$thumbnail       = strtolower( Str::slug( $oname, '-').Str::random(3).'.webp');
					
					$simthumbnail       = strtolower( Str::slug( $oname, '-').Str::random(3).'.webp');

					$pinthumbnail       = strtolower( Str::slug( $oname, '-').Str::random(3).'.webp');


					if( $p->move($temp, $large) ) 
					{
						set_time_limit(0);
						$original = $temp.$large;
						$width    = Helper::getWidth( $original );
						$height   = Helper::getHeight( $original );

						if ( $width > $height ) {

							if( $width > 1280) : $_scale = 1280; else: $_scale = 900; endif;

							// PREVIEW
							$scale    = 550 / $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$preview, $request->rotation );

						
							// Thumbnail
							$uploaded = Helper::resizeImageFixed( $original, 45, 45, $temp.$thumbnail);
							
							// SIMTHUMBNAIL
							$scale    = 310 / $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$simthumbnail, $request->rotation );

							// pinthumbnail
							$scale    = 310 / $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$pinthumbnail, $request->rotation );


						} else {

							if( $width > 1280) : $_scale = 960; else: $_scale = 800; endif;

							// PREVIEW
							$scale    = 480 / $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$preview, $request->rotation );


					
							$uploaded = Helper::resizeImageFixed( $original, 45, 45, $temp.$thumbnail);
							
							$scale    = 200 / $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$simthumbnail, $request->rotation );
							
							$scale    = 200 / $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$pinthumbnail, $request->rotation );

							
						}

					}// End File
					
					
					$lResolution = list($w, $h) = getimagesize($temp.$large);
					$lSize     = Helper::formatBytes(filesize($temp.$large), 1);
					$resolution = $w.'x'.$h;

					$pathLarge      = config('path.large');
					$pathPreview    = config('path.preview');
					$pathThumbnail  = config('path.thumbnail');
					$pathsimThumbnail  = config('path.simthumbnail');
					$pathpinThumbnail  = config('path.pinthumbnail');
					
					\File::copy($temp.$preview, $path_preview.$preview);
					\File::delete($temp.$preview);
					ImageOptimizer::optimize($path_preview.$preview);
					$imgPreview = Image::make($path_preview.$preview)->encode("webp",70);
					Storage::put($pathPreview.$preview, $imgPreview, [
				              'visibility' => 'public',
				              'contentEncoding' => 'gzip'
				        ]);
					$url = Storage::url($pathPreview.$preview);
					\File::delete($path_preview.$preview);


					\File::copy($temp.$thumbnail, $path_thumbnail.$thumbnail);
					\File::delete($temp.$thumbnail);
					ImageOptimizer::optimize($path_thumbnail.$thumbnail);
					$imgThumbnail = Image::make($path_thumbnail.$thumbnail)->encode("webp",70);
					Storage::put($pathThumbnail.$thumbnail, $imgThumbnail,[
				              'visibility' => 'public',
				              'contentEncoding' => 'gzip'
				        ]);
					$url = Storage::url($pathThumbnail.$thumbnail);
					\File::delete($path_thumbnail.$thumbnail);
					

					
					\File::copy($temp.$pinthumbnail, $path_pinthumbnail.$pinthumbnail);
					\File::delete($temp.$pinthumbnail);
					ImageOptimizer::optimize($path_pinthumbnail.$pinthumbnail);
					$imgpinThumbnail = Image::make($path_pinthumbnail.$pinthumbnail)->encode("webp",70);
					Storage::put($pathpinThumbnail.$pinthumbnail, $imgpinThumbnail,[
				              'visibility' => 'public',
				              'contentEncoding' => 'gzip'
				        ]);
					$url = Storage::url($pathpinThumbnail.$pinthumbnail);
					\File::delete($path_pinthumbnail.$pinthumbnail);
				

					

					\File::copy($temp.$large, $path_large.$large);
					\File::delete($temp.$large);
					$imgLarge = Image::make($path_large.$large)->encode($extension);
					Storage::put($pathLarge.$large, $imgLarge, 'public');
					$url = Storage::url($pathLarge.$large);				
					\File::delete($path_large.$large);
					
				}
			}
		}

	    $sql->title         = $request->title;
	    if( $thumbnail != "" )
	    {
	    	$sql->thumbnail         = $thumbnail;	
	    }
	    if( $simthumbnail != "" )
	    {
	    	$sql->simthumbnail         = $simthumbnail;	
	    }

	    if( $pinthumbnail != "" )
	    {
	    	$sql->pinthumbnail         = $pinthumbnail;	
	    }

	    if( $preview != "" )
	    {
	    	$sql->preview         = $preview;	
	    }

	    if( $large != "" )
	    {
	    	$sql->large         = $large;	
	    }

	    if( $resolution != "" )
	    {
	    	$sql->resolution         = $resolution;	
	    }
		
		$sql->metakeywords          = strtolower($request->metakeywords);
		$sql->categories_id = $request->categories_id;
		$sql->status        = $request->status;
		$sql->featured      = $request->featured;
		$sql->featured_date = $featuredDate;
		$sql->save();

	    \Session::flash('success_message', trans('admin.success_update'));

	    if( $referer != '' )
	    {
	    	return redirect($referer);
	    }

	    return back();
	}//<--- End Method

	public function contact()
	{
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		$pagination = 5;
		$contacts = DB::table('subscribers')
                    ->where('status', '=', 'contact')
                    ->orderBy('created_at', 'DESC')
                    ->paginate($pagination);

		return view('admin.contact' , compact('contacts'));
	}

		public function dmca()
	{
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		$pagination = 5;
		$dmca = DB::table('dmca')
                    ->orderBy('created_at', 'DESC')
                    ->paginate($pagination);

		return view('admin.dmca' , compact('dmca'));
	}

	public function deletecontact($id)
	{
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		DB::table('subscribers')
            ->where('id', $id)->delete();
		
		\Session::flash('success_message', trans('misc.successfully_removed'));

		return redirect('panel/admin/contact');
	}

		public function deletedmca($id)
	{
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		DB::table('dmca')
            ->where('id', $id)->delete();
		
		\Session::flash('success_message', trans('misc.successfully_removed'));

		return redirect('panel/admin/dmca');
	}

	public function deleteallcontact()
	{
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		if( isset($_POST['ids']) )
		{
			$ids = $_POST['ids'];
			$records = explode(",", $ids);
			foreach ($records as $key => $id) 
			{
				DB::table('subscribers')->where('id', $id)->delete();
			}

			\Session::flash('success_message', trans('misc.successfully_removed'));
		}
		
		return redirect('panel/admin/contact');
	}

		public function deletealldmca()
	{
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		if( isset($_POST['ids']) )
		{
			$ids = $_POST['ids'];
			$records = explode(",", $ids);
			foreach ($records as $key => $id) 
			{
				DB::table('dmca')->where('id', $id)->delete();
			}

			\Session::flash('success_message', trans('misc.successfully_removed'));
		}
		
		return redirect('panel/admin/dmca');
	}

	public function emptysearch()
	{	
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		$pagination = 15;
		$emptysearchs = DB::table('emptysearches')
                    ->orderBy('created', 'DESC')
                    ->paginate($pagination);
                    
		return view('admin.emptysearch' , compact('emptysearchs'));
	}

	public function deleteemptysearch($id)
	{	
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		DB::table('emptysearches')
            ->where('id', $id)->delete();
		
		\Session::flash('success_message', trans('misc.successfully_removed'));

		return redirect('panel/admin/emptysearch');
	}

	public function deletemultipleEmptysearch(Request $request)
	{
		$response = 1;
		if( $request->id )
		{
			$ids = explode(",", $request->id);
			if( count($ids) == 1 )
			{
				DB::table('emptysearches')->where('id', $request->id)->delete();
			}
			else
			{
				foreach ($ids as $key => $recordid) 
				{
					DB::table('emptysearches')->where('id', $recordid)->delete();
				}
			}
		}
		else
		{
			$response = 0;
		}
		echo $response;
	}

	public function deleteallemptysearch()
	{
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		DB::table('emptysearches')->delete();
		
		\Session::flash('success_message', trans('admin.truncated'));
		
		return redirect('panel/admin/emptysearch');
	}

	public function topsearch()
	{	
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		$settings = AdminSettings::first();
		$pagination = $settings->paginationlimit;
		$topsearches = DB::table('searchkeywords')
						->selectRaw('query,id,created,count(*) as count')
						->havingRaw('count(*) > 5')
						->orderBy('created', 'DESC')
						->groupBy('query')
						->paginate($pagination);
						        
		$query = Input::get('q');
		
		if( isset( $query ) ) {
		 	$topsearches = DB::table('searchkeywords')->where('query', 'LIKE', '%'.$query.'%')
			->orWhere('id', 'LIKE', '%'.$query.'%')
		 	->orderBy('id','desc')->paginate($pagination);
		 }


		return view('admin.topsearch' , compact('topsearches','query'));
	}

	public function deletetopsearch($id)
	{	
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		DB::table('searchkeywords')
            ->where('id', $id)->delete();
		
		\Session::flash('success_message', trans('misc.successfully_removed'));

		return redirect('panel/admin/topsearch');
	}

	public function deletemultipletopsearch(Request $request)
	{
		$response = 1;
		if( $request->id )
		{
			$ids = explode(",", $request->id);
			if( count($ids) == 1 )
			{
				DB::table('searchkeywords')->where('id', $request->id)->delete();
			}
			else
			{
				foreach ($ids as $key => $recordid) 
				{
					DB::table('searchkeywords')->where('id', $recordid)->delete();
				}
			}
		}
		else
		{
			$response = 0;
		}
		echo $response;
	}

	public function deletealltopsearch()
	{
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		DB::table('searchkeywords')->delete();
		
		\Session::flash('success_message', trans('admin.truncated'));
		
		return redirect('panel/admin/topsearch');
	}



	public function subscribers()
	{
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		$subscribers = DB::table('subscribers')
                    ->where('status', '=', 'subscriber')
                    ->orderBy('created_at', 'DESC')
                    ->get();
		return view('admin.subscriber' , compact('subscribers'));
	}

	public function users()
	{
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		$user = DB::table('users')
                    ->orderBy('name', 'DESC')
                    ->get();
		return view('admin.user' , compact('user'));
	}
	
	
   	public function maincategoriesedit($value)
    {
    	if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
       	$main = DB::table('main_categorys')->where('id', $value)->first();

        return view('admin.edit-main_category', compact('main'));
    }

    public function mainupdate(Request $request, $value)
    {
    	if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		$name = $_POST['main_category'];
		$slug = $_POST['slug'];
        $titleahead = isset($_POST['titleahead'])? $_POST['titleahead']: '';

        if ($request->hasFile('thumbnail')) {
            $temp = 'public/temp/';
            $path = config('path.img-category');
            $extension = $request->file('thumbnail')->getClientOriginalExtension();
            $thumbnail = $request->slug . '-' . Str::random(6) . '.' . $extension;

            $main_cat = DB::table('main_categorys')
                ->where('id', $value)->whereNotNull('thumbnail')->first();

            if(!empty($main_cat)){
                \File::delete($temp . $main_cat->thumbnail);
                if ($request->file('thumbnail')->move($temp, $thumbnail)) {
                    $image = Image::make($temp . $thumbnail);
                    if ($image->width() == 457 && $image->height() == 359) {
                        \File::copy($temp . $thumbnail, $path . $thumbnail);
                    } else {
                        $image->fit(457, 359)->save($temp . $thumbnail);
                        \File::copy($temp . $thumbnail, $path . $thumbnail);
                    }
                    ImageOptimizer::optimize($path . $thumbnail);
                    Storage::put($path . $thumbnail, $image, 'public');
                    $url = Storage::url($path . $thumbnail);
                    \File::delete($path . $thumbnail);
                }// End File
            }

        } // HasFile

        else {
            $thumbnail = '';
        }

        $update_categories = DB::table('main_categorys')
        ->where('id', $value)
        ->update(['name' => $name , 'slug' => $slug, 'titleahead' => $titleahead,'thumbnail' => $thumbnail ]);

        $main_categorys = DB::table('main_categorys')->get();

        return view('admin.main_category' , compact('main_categorys'));
    }
    public function maindestroy()
    {
    	if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
    	$value = $_POST['id_main'];
    	DB::table('main_categorys')
            ->where('id', $value)->delete();
            return redirect()->back();
    }

   public function maincatadd(Request $request)
    {
        $mainCategorys = $_POST['main_category'];
        $mainSlug = $_POST['slug'];
        $pro_name = $mainCategorys;
        if ($request->hasFile('thumbnail')) {
            $temp = 'public/temp/';
            $path = config('path.img-category');
            $extension = $request->file('thumbnail')->getClientOriginalExtension();
            $thumbnail = $request->slug . '-' . Str::random(6) . '.' . $extension;

            if ($request->file('thumbnail')->move($temp, $thumbnail)) {
                $image = Image::make($temp . $thumbnail);
                if ($image->width() == 457 && $image->height() == 359) {
                    \File::copy($temp . $thumbnail, $path . $thumbnail);
                } else {
                    $image->fit(457, 359)->save($temp . $thumbnail);
                    \File::copy($temp . $thumbnail, $path . $thumbnail);
                }
                ImageOptimizer::optimize($path . $thumbnail);
                Storage::put($path . $thumbnail, $image, 'public');
                $url = Storage::url($path . $thumbnail);
                \File::delete($path . $thumbnail);
            }// End File
        } // HasFile

        else {
            $thumbnail = '';
        }
        $created_at = \Carbon\Carbon::now()->toDateTimeString();
        $mainCategorys = DB::table('main_categorys')->insert([
            'name' => $pro_name,
            'slug' => $mainSlug,
            'thumbnail' => $thumbnail,
            'created_at' => $created_at,
            'updated_at' => $created_at
        ]);
        if ($mainCategorys) {
            $main_categorys = DB::table('main_categorys')->get();
            return redirect()->back()->with('main_categorys');
        } else {
            echo "Error";
        }
    }

 

	public function theme()
	{
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		return view('admin.theme');
	}//<--- End method

	public function themeStore(Request $request) {

		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		$temp  = 'public/temp/'; // Temp
	  	$path  = 'public/img/'; // Path

		$rules = array(
          'logo'   => 'mimes:png',
					'favicon'   => 'mimes:ico',
					'index_image_top'   => 'mimes:jpg,jpeg',
					'index_image_bottom'   => 'mimes:jpg,jpeg',
        );

		$this->validate($request, $rules);

		//======= LOGO
		if( $request->hasFile('logo') )	{

		$extension = $request->file('logo')->getClientOriginalExtension();
		$file      = 'logo.'.$extension;

		if($request->file('logo')->move($temp, $file) ) {
			\File::copy($temp.$file, $path.$file);
			\File::delete($temp.$file);
			}// End File
		} // HasFile

		//======== FAVICON
		if($request->hasFile('favicon') )	{

		$extension  = $request->file('favicon')->getClientOriginalExtension();
		$file       = 'favicon.'.$extension;

		if( $request->file('favicon')->move($temp, $file) ) {
			\File::copy($temp.$file, $path.$file);
			\File::delete($temp.$file);
			}// End File
		} // HasFile


		\Artisan::call('cache:clear');

		return redirect('panel/admin/theme')
			 ->with('success_message', trans('misc.success_update'));

	}
	public function instacronlog()
	{
		if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
		$data = DB::table('instacronlog')->orderBy('created', 'DESC')->get();
		return view('admin.instacronlog' , compact('data'));
	}

	public function deletelog($id)
    {
    	if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
    	DB::table('instacronlog')->where('id', $id)->delete();
    	\Session::flash('success_message', trans('admin.success_delete_log'));
    	return redirect('panel/admin/instacronlog');
    }
    public function deletealllog()
    {
    	if( Auth::user()->role == 'editor' )
		{
			\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
		}
    	DB::table('instacronlog')->delete();
    	\Session::flash('success_message', trans('admin.success_delete_log'));
    	return redirect('panel/admin/instacronlog');
    }


    public function removesessions() {
    // defined in route/console.php
    \Artisan::call('allsessions:clear');
    	dd("All Sessions cleared Successfully!");
	}

    public function keygenearate() {
 
    \Artisan::call('key:generate');
    	dd("Key Generated Successfully!");
	}

    public function alllogClear() {
    // defined in route/console.php
    \Artisan::call('alllogs:clear');
    	dd("All Logs cleared Successfully!");
	}

    public function logClear() {
    
    \Artisan::call('log:clear');
    	dd("All Logs cleared Successfully!");
	}


    public function optimizeClear() {
    
    \Artisan::call('optimize:clear');
    	dd("All Cache cleared Successfully!");
	}

	public function PageCacheClear() {
    
    \Artisan::call('pages:clear');
    	dd("All Pages Cache cleared Successfully!");
	}


	public function pagecacheclearphoto() {
    
    \Artisan::call('pages:clear --slug=photo');
    	dd("All Photos Pages Cache cleared Successfully!");
	}

	public function pagecacheclearc() {
    
    \Artisan::call('pages:clear --slug=categoy');
    	dd("All Categories Pages Cache cleared Successfully!");
	}


	public function pagecacheclears() {
    
    \Artisan::call('pages:clear --slug=subcategory');
    	dd("All Subcategories Pages Cache cleared Successfully!");
	}


	public function pagecacheclearlatest() {
    
    \Artisan::call('pages:clear --slug=latest');
    	dd("Latest Page Cache cleared Successfully!");
	}


	public function pagecacheclearfeatured() {
    
    \Artisan::call('pages:clear --slug=featured');
    	dd("Featured Page Cache cleared Successfully!");
	}

	public function pagecacheclearhome() {
    
    \Artisan::call('pages:clear --slug=home');
    	dd("Home Page Cache cleared Successfully!");
	}

	public function pagecacheclearsubgroup() {
    
    \Artisan::call('pages:clear --slug=subgroup');
    	dd("Subgroup Page Cache cleared Successfully!");
	}


}
