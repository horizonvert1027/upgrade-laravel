<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\User;
use App\Models\Images;
use App\Models\AdminSettings;
use App\Models\Downloads;
use App\Models\ResizeLogThumb;
use App\Models\ResizeLogsimThumb;
use ImageOptimizer;
use App\Helper;
use App\Models\DeviceToken;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use App\subcategories;
use App\Models\Categories;
use Image;
use DB;
use Illuminate\Support\Facades\Storage;
use Psr\SimpleCache\CacheInterface;
use \Illuminate\Support\Str;

class Extra extends Controller {
	 public function __construct( AdminSettings $settings, Request $request) {
		$this->settings = $settings::first();
		$this->request = $request;
	}

	 protected function validator(array $data, $id = null) {

    	Validator::extend('ascii_only', function($attribute, $value, $parameters){
    		return !preg_match('/[^x00-x7F\-]/i', $value);
		});

		$sizeAllowed = $this->settings->file_size_allowed * 1024;
		$dimensions = explode('x',$this->settings->min_width_height_image);

		if($this->settings->currency_position == 'right') {
			$currencyPosition =  2;
		} else {
			$currencyPosition =  null;
		}
		$messages = array (
			'photo.required' => trans('misc.please_select_image'),
	    	"photo.max"   => trans('misc.max_size').' '.Helper::formatBytes( $sizeAllowed, 1 ),
		);

		// Create Rules
		if( $id == null ) {
			return Validator::make($data, [
				 'photo' => 'required'
	        ], $messages);
		// Update Rules
		} else {
			return Validator::make($data, [
	        	'title'       => 'required|min:3|max:100',
		        'metakeywords'        => 'required'
	        ], $messages);
		}

    }

	public function index() {
	 	$data = Images::all();
    	return view('admin.images')->withData($data);
	}

	  public function upload()
	  {
 		if( Auth::check() && Auth::user()->authorized_to_upload == 'yes' && Auth::user()->status == 'active'  )
 			{
    		return view('images.upload');
    		}
    	else {
    		return view('images.notauthUpload');
    		}
      }

	public function getcategories($id)
	{
	 	$data = Categories::where('main_cat_id',$id)->orderBy('name','ASC')->get();
		foreach ($data as $key => $value) {
			echo "<option value=$value->id> $value->name</option>";
		}
	}

	public function getsubcat($id)
	{
	 	$data = subcategories::where('categories_id',$id)->orderBy('name','ASC')->get();
		foreach ($data as $key => $value) {
			echo "<option value=$value->id> $value->name</option>";
		}
	}



	public function getsubkeywords($id)
	{
	 	$data = subcategories::where('id', $id)->orderBy('name','ASC')->get();
		foreach ($data as $key => $value) 
		{
			$keyword = $value->keyword;
		}
		$keywords = explode(",", $keyword);
		foreach ($keywords as $key => $value) 
		{
			echo "<option value='$value'>$value</option>";
		}
	}

	public function instalog()
	{
		echo "<html><head><script>
     var time = new Date().getTime();
     
     function refresh(){
     	var t = 60000 - (new Date().getTime() - time);
     	t = t / 1000;
     	document.getElementById('refresh').innerHTML = 'Refreshing in '+t+' seconds';
         if(new Date().getTime() - time >= 60000) 
             window.location.reload(true);
         else 
             setTimeout(refresh, 5000);
     }
     setTimeout(refresh, 10000);</script></head><body><pre>";
		$filename = 'public/logs/instacron.log';
		echo "Log File : ".$filename;
		echo "<br>";
		$modified = date("Y-m-d H:i:s.", filemtime($filename));
		$dateInUTC = $modified;
		$time = strtotime($dateInUTC.' UTC');
		date_default_timezone_set("Asia/Kolkata");
		$dateInLocal = date("Y-m-d h:i:s a", $time);
		echo "Last changed: ".$dateInLocal.PHP_EOL;
		echo "<br>";
		echo "<span style='width:100%;padding:10px;display:block;' id='refresh'></span>";
		
		$data = array_slice(file($filename), -200);

		foreach ($data as $line) {
		    echo $line;
		}
		echo "</body></html>";
	}

	public function CronCheck()
	{
		$logfile = 'public/logs/cron.log';
		file_put_contents($logfile, "Cron Running".date("d-m-Y H:i:s"));	
	}

	public function clearTempImages()
	{
		$tempPath = 'public/temp/';
		$files = ( glob( $tempPath."*" ) ? glob( $tempPath."*" ) : array() );
		array_map('unlink',  $files);
		echo "public/temp/ ".count($files)." Files deleted.".PHP_EOL;
	}

	public function clearCronLogs()
	{
		$logfile = 'public/logs/instacron.log';
		file_put_contents($logfile, '');
		$logfile = 'public/logs/instacron1.log';
		file_put_contents($logfile, '');
		$logfile = 'public/logs/webscrappercron.log';
		file_put_contents($logfile, '');
	}

	public function WebScrapper()
	{
		$webscrappers = DB::table('webscrapper')->where('autocron', 'yes')->get();
		$data = false;
		foreach ($webscrappers as $key => $row) 
		{
			if( $row->cron_status == '' || $row->cron_status == 'running' )
			{
				$data = $row;
				$response = DB::table('webscrapper')
			        ->where('id', $row->id)
			        ->update(['cron_status' => 'running' ]);
			    break;
			}
		}

		if( $data )
		{
			$images = Helper::webScrapper($data->url, $data->element, $data->class);
			if( !is_array($images) )
			{
				echo "Error : ". $images;
				$response = DB::table('webscrapper')
			        ->where('id', $row->id)
			        ->update(['cron_status' => 'failed', 'message' => $images ]);
			    die();    
			}

			if( count($images) == 0 )
			{
				echo "No images found.";
				$response = DB::table('webscrapper')
			        ->where('id', $row->id)
			        ->update(['cron_status' => 'failed', 'message' => 'No Images found.' ]);	
			    die();
			}

			$response = DB::table('webscrapper')
			        ->where('id', $row->id)
			        ->update(['cron_status' => 'Success', 'message' => '' ]);

			$subcategories = DB::table('subcategories')->where('id','=', $data->subcategory_id)->where('categories_id','=', $data->category_id)->get();

			$subcategory = false;
			foreach ($subcategories as $k => $sub) 
			{
				$subcategory = $sub;
			}

			if( $subcategory == false )
			{
				$response = DB::table('webscrapper')
			        ->where('id', $row->id)
			        ->update(['cron_status' => 'Failed', 'message' => 'subcategory not found.']);
			    die();
			}

			echo "Processing ".count($images)." images ".PHP_EOL;

			foreach ($images as $key => $image) 
			{
				$inst_file = pathinfo($image, PATHINFO_FILENAME);
				$extension = pathinfo($image, PATHINFO_EXTENSION);
				$inst_file = "image".$inst_file.".".$extension;
				$url = $image;
				$title = $data->title;
				$metakeywords = rtrim($data->metakeywords, ", ").','.$subcategory->metakeywords;
				$credits = $data->credits;
				$subgroup = $data->subgroup;
				$subcategories_id = $data->subcategory_id;
				$categories_id = $data->category_id;
				$set_status = $data->image_status;

				$ig = Images::where('categories_id', $categories_id)->where('subcategories_id', $subcategories_id)->where('original_name', '=', $inst_file)->get();
				if( $ig->count() == 0 )
				{
					$insert = 1;
				}
				if( $insert == 1 )
				{
					echo "Inserting Image : ";
					$res = $this->insertImage($inst_file, $url, $title, $metakeywords, $credits, $subgroup, $subcategories_id, $categories_id, $set_status);
					echo $inst_file." Insert : ". $res.PHP_EOL;
				}
				else
				{
					echo "Image ".$inst_file." alredy exists.";
				}

			}

		}
		else {
			echo "Nothing to do.";
		}
		die();
		
	}


	public function getsubgroup($id)
	{
	 	$data = subcategories::where('id',$id)->first();
	 	$keywords = explode(",", $data->keyword);
	 	$html = '';
	 	$select_subgroup = '';
		foreach ($keywords as $key => $value)
		{
		    if ($key == 0){
                $select_subgroup = $value;
            }
			$value = trim($value);
            $html .= "<option value='$value'> $value</option>";
		}
		return response()->json(['select_subgroup' => $select_subgroup , 'data' => $html]);
	}


	public function getsubgroupupload($id)
	{
	 	$data = subcategories::where('id',$id)->first();
	 	$keywords = explode(",", $data->keyword);
		foreach ($keywords as $key => $value) 
		{
			$value = trim($value);
			echo "<option value='$value'> $value</option>";
		}
	}

	// Run instagram for only allinsta = no
	public function InstaAllCron()
	{
		echo "<pre>";
		set_time_limit(0);
		$logfile = 'public/logs/instacron.log';

		$log = " Allinsta Cron Started : ".date('d-m-Y H:i:s').PHP_EOL;
		echo $log;
		file_put_contents($logfile, $log, FILE_APPEND); 
		$subcategories = DB::table('subcategories')->where('allinsta','=','yes')->where('insta_username','!=','')->get();
		foreach ($subcategories as $key => $subcategory)
		{
			$username = $subcategory->insta_username;
			$subgroup = $subcategory->selectedgroup;
			$metakeywords = $subcategory->metakeywords;
			$allinsta = $subcategory->allinsta;
			$imagecount = $subcategory->imagecount;
			$images_limit = 0;
			$set_status = ($subcategory->cronstatus == 'yes') ? 'pending' : 'active';
			$subcategories_id = $subcategory->id;
			$categories_id = $subcategory->categories_id;
			$log = "Allinsta Instagram Username : ".$username.PHP_EOL;
			echo $log;
			file_put_contents($logfile, $log, FILE_APPEND); 
			$lastimagedate = "";
			$images = Images::where('subcategories_id', $subcategories_id)->where('original_name', 'LIKE', 'insta_%')->where('categories_id', $categories_id)->orderBy('date','DESC')->get();
			if( $images->count() != 0)
			{
				$lastimagedate = date("d-m-Y H:i:s", strtotime($images->get(0)->date));
			}
			$images_limit = $images->count();
			$log = "Images in db : ".$images->count().PHP_EOL;
			$log .= "Allinsta Insta User : ".$username." fetching images ".PHP_EOL;
			echo $log;
			file_put_contents($logfile, $log, FILE_APPEND);

			if( $images_limit >= $imagecount )
			{
				$log = "No insert. Limit exceded : ".$images_limit.PHP_EOL;
				echo $log;
				file_put_contents($logfile, $log, FILE_APPEND);
				continue;
			}

			$run = 0;
			$instagram = new \InstagramScraper\Instagram();
			$insta_userid = $username;
			echo "Instagram user id: ".$insta_userid.PHP_EOL;
			if( $insta_userid == 0)
			{
				$log = "Instagram issue with account : ".$username." -> Account Id cannot be fetched. ".PHP_EOL;
				echo $log;
				file_put_contents($logfile, $log, FILE_APPEND);
				continue;
			}
			else
			{
				$log = "Instagram Account Id ".$insta_userid." .".PHP_EOL;
				echo $log;
				file_put_contents($logfile, $log, FILE_APPEND);
			}
			$instaid = explode(",", $insta_userid);
			$stopProcessing = 0;
			foreach ($instaid as $kkey => $insta_userid)
			{
				$response['maxId'] = '';
				$response['hasNextPage'] = 1;
				while( $response['hasNextPage'] )
				{
					$response = $instagram->getPaginateMediasByUserId($insta_userid, 30, $response['maxId']);
					if( isset($response['error']) )
					{
						$log = "Instagram issue with account : ".$insta_userid." -> ".$response['error']." ".PHP_EOL;
						echo $log;
						file_put_contents($logfile, $log, FILE_APPEND);
						break;
					}
					if( $stopProcessing == 1 )
					{
						break;
					}
					foreach ($response['medias'] as $media) 
					{				
						$title = $subcategory->imgtitle;
						$type = $media->getType();
						if( $type != 'image' && $type != 'sidecar' )
						{
							echo "Not image media.".PHP_EOL;
							continue;
						}
						if( $stopProcessing == 1 )
						{
							break;
						}
						$imageArray = array();
						if( $type == 'image' )
						{
							$imageArray[] = $media;
						}
						else
						{
							$imageArray = $media->getSidecarMedias();
						}
						foreach($imageArray as $ikey => $value) 
						{
							$url = $value->getImageHighResolutionUrl();
							$filename = explode("?", pathinfo($url, PATHINFO_FILENAME));
							$inst_file = "insta_".$filename[0];
							$tt = explode(".", $inst_file);
							$insta_original_name = $tt[0];
							$insert = 0;
							// Fetch all images 
							$ig = Images::where('categories_id', $categories_id)->where('subcategories_id',$subcategories_id)->where('original_name', '=', $insta_original_name)->get();
							if( $ig->count() == 0 )
							{
								$insert = 1;
							}
							
							if( $insert == 0 ) {
								$log = "Media exists : ".$inst_file.PHP_EOL;
								echo $log;
								file_put_contents($logfile, $log, FILE_APPEND);
								continue;
							}

							if( $imagecount != 0 && $images_limit > $imagecount )
							{
								$stopProcessing = 1;
								$log = "No insert. Limit exceded : ".$images_limit.PHP_EOL;
								echo $log;
								file_put_contents($logfile, $log, FILE_APPEND);
								break;
							}

							$log = " Inserting Media : ".$inst_file.PHP_EOL;
							echo $log;
							file_put_contents($logfile, $log, FILE_APPEND);
							$res = $this->insertImage($inst_file, $url, $title, $metakeywords, $subgroup, $subcategories_id, $categories_id, $set_status);
							$images_limit++;
							$log = " Insert : ".$res.PHP_EOL;
							echo $log;
							file_put_contents($logfile, $log, FILE_APPEND);
							$run++;
						}
					}
				}
			}
			$log = "Allinsta Insta: ".$run." images processed ".PHP_EOL;
			echo $log;
			file_put_contents($logfile, $log, FILE_APPEND);
		}
		die();
	}


	// Run instagram for only allinsta = no
	public function InstaCron()
	{
		echo "<pre>";
		set_time_limit(0);
		$logfile = 'public/logs/instacron.log';
		$log = " Cron Started : ".date('d-m-Y H:i:s').PHP_EOL;
		echo $log;
		file_put_contents($logfile, $log, FILE_APPEND); 
		$subcategories = DB::table('subcategories')->where('instacronstatus','=','on')->where('allinsta','!=','yes')->where('insta_username','!=','')->get();
		foreach ($subcategories as $key => $subcategory)
		{
			$username = $subcategory->insta_username;
			$metakeywords = $subcategory->metakeywords;
			$subgroup = $subcategory->selectedgroup;
			$allinsta = $subcategory->allinsta;
			$set_status = ($subcategory->cronstatus == 'yes') ? 'pending' : 'active';
			$subcategories_id = $subcategory->id;
			$categories_id = $subcategory->categories_id;
			$log = " Instagram Userid : ".$username.PHP_EOL;
			echo $log;
			file_put_contents($logfile, $log, FILE_APPEND);

			$lastimagedate = "";
			$images = Images::where('subcategories_id', $subcategories_id)->where('original_name', 'LIKE', 'insta_%')->where('categories_id', $categories_id)->orderBy('date','DESC')->get();
			if( $images->count() != 0)
			{
				$lastimagedate = date("d-m-Y H:i:s", strtotime($images->get(0)->date));
			}
			$number = 5;
			$log = "Insta User : ".$username." media fetching ".$number.PHP_EOL;
			echo $log;
			file_put_contents($logfile, $log, FILE_APPEND);
			$instagram = new \InstagramScraper\Instagram();
			$insta_userid = $username;
			if( $insta_userid == 0)
			{
				$log = "Instagram issue with account : ".$username." -> Account Id cannot be fetched. ".PHP_EOL;
				echo $log;
				file_put_contents($logfile, $log, FILE_APPEND);
				continue;
			}
			else
			{
				$log = "Instagram account : ".$username." -> Account Id ".$insta_userid." .".PHP_EOL;
				echo $log;
				file_put_contents($logfile, $log, FILE_APPEND);
			}
			$instaid = explode(",", $insta_userid);
			foreach($instaid as $key => $insta_userid) 
			{
				if( $this->settings->instacron_log == 'yes' )
				{
					$runstatus = DB::table('instacronlog')->where('insta_username','=', $insta_userid)->get();
					if( count($runstatus) > 0 )
					{
						$log = "Already Run for Account Id : ".$insta_userid." - Skip".PHP_EOL;
						echo $log;
						file_put_contents($logfile, $log, FILE_APPEND);
						continue;
					}
				}

				$nonPrivateAccountMedias = $instagram->getMediasByUserId($insta_userid, $number, '');
				if( isset($nonPrivateAccountMedias['error']) )
				{
					$log = "Instagram issue with account : ".$insta_userid." -> ".$nonPrivateAccountMedias['error'].PHP_EOL;
					echo $log;
					file_put_contents($logfile, $log, FILE_APPEND);
					continue;
				}
				if( count($nonPrivateAccountMedias) != 0 )
				{
					foreach ($nonPrivateAccountMedias as $key => $media) 
					{
						$title = $subcategory->imgtitle;
						$type = $media->getType();
						$log = "Media : ".$type.PHP_EOL;
						echo $log;
						file_put_contents($logfile, $log, FILE_APPEND);

						if( $type != 'image' && $type != 'sidecar' )
						{
							echo "Not image media.".PHP_EOL;
							continue;
						}
						$imageArray = array();
						if( $type == 'image' )
						{
							$imageArray[] = $media;
						}
						else
						{
							$imageArray = $media->getSidecarMedias();
						}
						foreach($imageArray as $ikey => $value) 
						{
							$url = $value->getImageHighResolutionUrl();
							$filename = explode("?", pathinfo($url, PATHINFO_FILENAME));
							$inst_file = "insta_".$filename[0];
							$tt = explode(".", $inst_file);
							$insta_original_name = $tt[0];
							$insert = 0;
							// Fetch all images 
							$ig = Images::where('original_name', '=', $insta_original_name)->get();
							if( $ig->count() == 0 ) {
								$insert = 1;
							}
							
						
							if( $insert == 0 ){
								$log = "Media exists : ".$inst_file.PHP_EOL;
								echo $log;
								file_put_contents($logfile, $log, FILE_APPEND);
								continue;
							}

							$log = " Inserting Media : ".$inst_file.PHP_EOL;
							echo $log;
							file_put_contents($logfile, $log, FILE_APPEND);
							$this->insertImage($inst_file, $url, $title, $metakeywords, $subgroup, $subcategories_id, $categories_id, $set_status);
						}
					}

					if( $this->settings->instacron_log == 'yes' )
					{
						// Insert run log to table
						DB::table('instacronlog')->insert(
						    ['insta_username' => $insta_userid]
						);
					}
				}
				else
				{
					$log = "Insta User : ".$insta_userid." media not found.";
					echo $log;
					file_put_contents($logfile, $log, FILE_APPEND);
				}
			}
		}
		die();
	}

	public function insertImage($inst_file, $url, $title, $metakeywords, $credits, $subgroup, $subcategories_id, $categories_id, $set_status)
	{
		$logfile = 'public/logs/instacron.log';
		$descr = "";
		$userid = 1;
		$status = $set_status;
		$insta_local = 'public/temp/'.$inst_file;
		copy($url, $insta_local);
		$sizeFile = \File::size($insta_local);
		$p = new UploadedFile($insta_local, $inst_file, 'image/jpg', $sizeFile, null, TRUE);

		// PATHS
		$temp            = 'public/temp/';
	    $path_preview    = 'public/uploads/preview/';
		$path_thumbnail  = 'public/uploads/thumbnail/';
		$path_simthumbnail  = 'public/uploads/simthumbnail/';
		$path_pinthumbnail  = 'public/uploads/pinthumbnail/';
		$path_medium     = 'public/uploads/medium/';
		$path_large      = 'public/uploads/large/';
		$optFileSource 	 = 'public/uploads/opt_file/';
		$optFilePath   = config('path.optfile');
        $original = "";  
	    
		$isgif = 0;
    	if( $p )	
    	{
    		$extension       = $p->getClientOriginalExtension();


    		if( $extension != 'gif' )
    		{
				$originalName    = Helper::fileNameOriginal($p->getClientOriginalName());
				$type_mime_img   = $p->getMimeType();
				$sizeFile        = $p->getSize();
				$oname 			 = substr($title, 0, 25);
				$large           = strtolower( Str::slug( $oname, '-').Str::random(5).'.'.$extension );
				$preview         = strtolower( Str::slug( $oname, '-').Str::random(5).'.webp' );
				$thumbnail       = strtolower( Str::slug( $oname, '-').Str::random(5).'.webp' );
				$simthumbnail       = strtolower( Str::slug( $oname, '-').Str::random(5).'.webp' );
				$pinthumbnail       = strtolower( Str::slug( $oname, '-').Str::random(5).'.webp' );

				if( $p->move($temp, $large) ) 
				{
					set_time_limit(0);
					$original = $temp.$large;
					$hash            = md5_file($original);
					info("large path ".json_encode($original));
					$width    = Helper::getWidth( $original );
					$height   = Helper::getHeight( $original );

					if ( $width > $height ) {

							if( $width > 1280) : $_scale = 1280; else: $_scale = 900; endif;

							// PREVIEW
							$scale    = 350 / $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$preview, null );



							// Thumbnail
							$uploaded = Helper::resizeImageFixed( $original, 45, 45, $temp.$thumbnail);

							// SIMTHUMBNAIL
							$scale    = 270 / $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$simthumbnail, null );

							//PINTHUMBNAIL
							$scale    = 1280 / $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$pinthumbnail, null );

						} else {

							if( $width > 1280) : $_scale = 960; else: $_scale = 800; endif;

							// PREVIEW
							$scale    = 300 / $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$preview, null );

							// Thumbnail
							$uploaded = Helper::resizeImageFixed( $original, 45, 45, $temp.$thumbnail);

							// SIMTHUMBNAIL
							$scale    = 200 / $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$simthumbnail, null );

							// PINTHUMBNAIL
							$scale    = 950 / $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$pinthumbnail, null );

						}

						
					$watercheck = subcategories::where('id', $subcategories_id)->get();
					$watermarktype = $watercheck[0]->watermark;

					if( $watermarktype  == 'light'){
						Helper::watermarkLight($temp.$large);
					}
					else if( $watermarktype  == 'both'){
						Helper::watermarkLight($temp.$large);
						Helper::watermarkBottom($temp.$large);
					}
					else if( $watermarktype  == 'bottom'){
						Helper::watermarkBottom($temp.$large);
					}
					
					Helper::watermarkPinterest($temp.$pinthumbnail);


				}// End File
			}
			else
			{
				$isgif = 1;
				// GIF file
				$originalName    = Helper::fileNameOriginal($p->getClientOriginalName());
				$type_mime_img   = $p->getMimeType();
				$sizeFile        = $p->getSize();
				$oname 			 = substr($originalName, 0, 25);
				$large           = strtolower( Str::slug( $oname, '-').Str::random(5).'.'.$extension );
				$preview         = strtolower( Str::slug( $oname, '-').Str::random(3).'.webp' );
				$thumbnail       = strtolower( Str::slug( $oname, '-').Str::random(3).'.webp' );
				$simthumbnail       = strtolower( Str::slug( $oname, '-').Str::random(3).'.webp' );
				$pinthumbnail       = strtolower( Str::slug( $oname, '-').Str::random(3).'.webp' );

				if( $p->move($temp, $large) ) 
				{
					set_time_limit(0);
					$original = $temp.$large;
					$hash            = md5_file($original);
					info("large path ".json_encode($original));
					$width    = Helper::getWidth( $original );
					$height   = Helper::getHeight( $original );
				}// End File
			}
		} 

		if( isset($title) && $title != "" ) {
			$title = trim($title);
		} else {
			$title = trim($originalName);
		}

		$subcat = subcategories::find($subcategories_id);
		if( trim($descr) == "" )
		{
			if( trim($metakeywords) != "" )
			{
				$request_tags = explode(",", trim($metakeywords));
				$request_tag = $request_tags[0];
				$first_image_desc = Helper::getFristImageDesc($request_tag);
				if( $first_image_desc != "" )
				{
					$descr = $first_image_desc;
				}
				else
				{
					$descr = $subcat->spdescr;		
				}
			}	
			else
			{
				$descr = $subcat->spdescr;
			}
		}

		if( trim($metakeywords) == "" )
		{
			$metakeywords = $subcat->metakeywords;
		}
		
		$categories = DB::table('categories')->where('id','=',$categories_id)->get();
		$main_cat_id = $categories[0]->main_cat_id;			

		$randomText = Helper::randomImageContent2($metakeywords, $main_cat_id, $categories_id);			
		if( $randomText != "" ){
			$title = $title." ".$randomText;
			$title = Helper::removeDuplicateWords($title);
		}

		$subcat = subcategories::find($subcategories_id);
		if( $subcat ) {
			$subcat->last_updated = now();
			$subcat->save();
		}

		$thiscat = Categories::find($categories_id);
		if( $thiscat ) {
			$thiscat->last_updated = now();
			$thiscat->save();
		}

		$lResolution = list($w, $h) = getimagesize($temp.$large);
		$lSize     = Helper::formatBytes(filesize($temp.$large), 1);
		$resolution = $w.'x'.$h;

		$log = " Inserting Media Title : ".$title.PHP_EOL;
		echo $log;
		file_put_contents($logfile, $log, FILE_APPEND);

		$sql = new Images;
		$sql->large = $large;
		$sql->resolution = $resolution;
		$sql->thumbnail            = $thumbnail;
		$sql->simthumbnail         = $simthumbnail;
		$sql->pinthumbnail         = $pinthumbnail;
		$sql->preview              = $preview;
		$sql->title                = $title;
		$sql->categories_id        = $categories_id;
		$sql->subcategories_id     = $subcategories_id;
		$sql->subgroup			   = $subgroup;
		$sql->user_id              = $userid;
		$sql->status               = $status;
		$sql->metakeywords         = strtolower($metakeywords);
		$sql->credits              = $credits;
		$sql->extension            = strtolower($extension);
		$sql->original_name        = $originalName;
		$sql->hash 				   = $hash ?? null;
		$sql->save();

		// ID INSERT
		$imageID = $sql->id; 
		

		$pathLarge      = config('path.large');
		$pathPreview    = config('path.preview');
		$pathThumbnail  = config('path.thumbnail');
		$pathLarge      = config('path.large');
		$pathsimThumbnail  = config('path.simthumbnail');
		$pathpinThumbnail  = config('path.pinthumbnail');

		if( $isgif == 0 ) {
		 	\File::copy($temp.$preview, $path_preview.$preview);
				\File::delete($temp.$preview);
				ImageOptimizer::optimize($path_preview.$preview);

				$imgPreview = Image::make($path_preview.$preview)->encode("webp",86);
				Storage::put($pathPreview.$preview, $imgPreview, [
			              'visibility' => 'public'
			        ]);
				$url = Storage::url($pathPreview.$preview);
				\File::delete($path_preview.$preview);

				\File::copy($temp.$thumbnail, $path_thumbnail.$thumbnail);
				\File::delete($temp.$thumbnail);
				ImageOptimizer::optimize($path_thumbnail.$thumbnail);
				$imgThumbnail = Image::make($path_thumbnail.$thumbnail)->encode("webp",86);
				Storage::put($pathThumbnail.$thumbnail, $imgThumbnail,[
			              'visibility' => 'public'
			        ]);
				$url = Storage::url($pathThumbnail.$thumbnail);
				\File::delete($path_thumbnail.$thumbnail);



				\File::copy($temp.$simthumbnail, $path_simthumbnail.$simthumbnail);
				\File::delete($temp.$simthumbnail);
				ImageOptimizer::optimize($path_simthumbnail.$simthumbnail);
				$imgsimThumbnail = Image::make($path_simthumbnail.$simthumbnail)->encode("webp",86);
				Storage::put($pathsimThumbnail.$simthumbnail, $imgsimThumbnail,[
			              'visibility' => 'public'
			        ]);
				$url = Storage::url($pathsimThumbnail.$simthumbnail);
				\File::delete($path_simthumbnail.$simthumbnail);


				\File::copy($temp.$pinthumbnail, $path_pinthumbnail.$pinthumbnail);
				\File::delete($temp.$pinthumbnail);
				ImageOptimizer::optimize($path_pinthumbnail.$pinthumbnail);
				$imgpinThumbnail = Image::make($path_pinthumbnail.$pinthumbnail)->encode("webp",92);
				Storage::put($pathpinThumbnail.$pinthumbnail, $imgpinThumbnail,[
			              'visibility' => 'public'
			        ]);
				$url = Storage::url($pathpinThumbnail.$pinthumbnail);
				\File::delete($path_pinthumbnail.$pinthumbnail);

				
				\File::copy($temp.$large, $path_large.$large);
				\File::delete($temp.$large);
				$imgLarge = Image::make($path_large.$large)->encode($extension);
				Storage::put($pathLarge.$large, $imgLarge, 'public');
				$url = Storage::url($pathLarge.$large);				
				\File::delete($path_large.$large);
		} else {
			\File::copy($temp.$large, $path_preview.$preview);
			\File::copy($temp.$large, $path_thumbnail.$thumbnail);		
			\File::copy($temp.$large, $path_simthumbnail.$simthumbnail);
			\File::copy($temp.$large, $path_pinthumbnail.$pinthumbnail);
			\File::copy($temp.$large, $path_large.$large);
			\File::delete($temp.$large);
		
			$imgPreview = file_get_contents($path_preview.$preview);
			Storage::put($pathPreview.$preview, $imgPreview, [
			              'visibility' => 'public'
			        ]);
			$url = Storage::url($pathPreview.$preview);
			\File::delete($path_preview.$preview);

			
			$imgThumbnail = file_get_contents($path_thumbnail.$thumbnail);
			Storage::put($pathThumbnail.$thumbnail, $imgThumbnail, [
			              'visibility' => 'public'
			        ]);
			$url = Storage::url($pathThumbnail.$thumbnail);
			\File::delete($path_thumbnail.$thumbnail);
			


			$imgsimThumbnail = file_get_contents($path_simthumbnail.$simthumbnail);
			Storage::put($pathsimThumbnail.$simthumbnail, $imgsimThumbnail, [
			              'visibility' => 'public'
			        ]);
			$url = Storage::url($pathsimThumbnail.$simthumbnail);
			\File::delete($path_simthumbnail.$simthumbnail);
			

			$imgpinThumbnail = file_get_contents($path_pinthumbnail.$pinthumbnail);
			Storage::put($pathpinThumbnail.$pinthumbnail, $imgpinThumbnail, [
			              'visibility' => 'public'
			        ]);
			$url = Storage::url($pathpinThumbnail.$pinthumbnail);
			\File::delete($path_pinthumbnail.$pinthumbnail);
			

			$imgLarge = file_get_contents($path_large.$large);
			Storage::put($pathLarge.$large, $imgLarge, 'public');
			$url = Storage::url($pathLarge.$large);
			\File::delete($path_large.$large);
		}
		return 1;
	}

	public function create( Request $request ) 
	{
		if( Auth::guest() ) {
		 	return response()->json([
		        'session_null' => true,
		        'success' => false,
		    ]);
		}

		$temp            = 'public/temp/';
	    $path_preview    = 'public/uploads/preview/';
		$path_thumbnail  = 'public/uploads/thumbnail/';
		$path_simthumbnail  = 'public/uploads/simthumbnail/';
		$path_pinthumbnail  = 'public/uploads/pinthumbnail/';
		$path_large      = 'public/uploads/large/';
		$optFileSource 	 = 'public/uploads/opt_file/';

		$optFilePath   = config('path.optfile');
        // OPTIONAL FILE UPLOAD other files extensions
		$otpGetExe = '';
		if($request->hasFile('opt-file'))
		{
			$otpRawFile = $request->file('opt-file');
			$otpGetExe = $otpRawFile->getClientOriginalExtension();
			$otpGetExeOriginalName = Helper::fileNameOriginal($otpRawFile->getClientOriginalName());
			$opt_file = strtolower(Str::slug($request->title, '-') . time() . Str::random(3) . '.' . $otpGetExe);
			$otpRawFile->move($optFileSource, $opt_file);
			$otherfile  = file_get_contents($optFileSource.$opt_file);
				Storage::put($optFilePath.$opt_file, $otherfile, [
			              'visibility' => 'private',
			              'ContentType' => ''
			        ]);
		}		
		
		
	    $original = "";  
	    foreach($request->file('photo') as $p)
		{
			$isgif = 0;
	    	if( $p )	
	    	{
	    		$extension       = $p->getClientOriginalExtension();


	    		if( $extension != 'gif' )
	    		{
					$originalName    = Helper::fileNameOriginal($p->getClientOriginalName());
					$type_mime_img   = $p->getMimeType();
					$sizeFile        = $p->getSize();
					$oname 			 = substr($request->title, 0, 25);
					$large           = strtolower( Str::slug( $oname, '-').Str::random(5).'.'.$extension );

					$preview         = strtolower( Str::slug( $oname, '-').Str::random(5).'.webp' );
					$thumbnail       = strtolower( Str::slug( $oname, '-').Str::random(5).'.webp' );
					$simthumbnail       = strtolower( Str::slug( $oname, '-').Str::random(5).'.webp' );
					$pinthumbnail       = strtolower( Str::slug( $oname, '-').Str::random(5).'.webp' );

					if( $p->move($temp, $large) ) 
					{
						set_time_limit(0);
						$original = $temp.$large;
						$hash            = md5_file($original);
						info("large path ".json_encode($original));
						$width    = Helper::getWidth( $original );
						$height   = Helper::getHeight( $original );

						if ( $width > $height ) {

							if( $width > 1280) : $_scale = 1280; else: $_scale = 900; endif;

							// PREVIEW
							$scale    = 350 / $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$preview, $request->rotation );

							// Thumbnail
							$uploaded = Helper::resizeImageFixed( $original, 45, 45, $temp.$thumbnail);

							// SIMTHUMBNAIL
							$scale    = 270 / $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$simthumbnail, $request->rotation );

							// PINTHUMBNAIL
							$scale    = 1280/ $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$pinthumbnail, $request->rotation );

						} else {

							if( $width > 1280) : $_scale = 960; else: $_scale = 800; endif;

							// PREVIEW
							$scale    = 300/ $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$preview, $request->rotation );

							// Thumbnail
							$uploaded = Helper::resizeImageFixed( $original, 45, 45, $temp.$thumbnail);

							// SIMTHUMBNAIL
							$scale    = 200 / $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$simthumbnail, $request->rotation );


							// PINTHUMBNAIL
							$scale    = 950 / $width;
							$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $temp.$pinthumbnail, $request->rotation );
						}

					$subcategories_id = $request->subcategories_id;
					$watercheck = subcategories::where('id', $subcategories_id)->get();
					$watermarktype = $watercheck[0]->watermark;

					if( $watermarktype  == 'light'){
						Helper::watermarkLight($temp.$large);
					}
					else if( $watermarktype  == 'both'){
						Helper::watermarkLight($temp.$large);
						Helper::watermarkBottom($temp.$large);
					}
					else if( $watermarktype  == 'bottom'){
						Helper::watermarkBottom($temp.$large);
					}
					
					Helper::watermarkPinterest($temp.$pinthumbnail);

					}// End File
				}
				else
				{
					$isgif = 1;
					// GIF file
					$originalName    = Helper::fileNameOriginal($p->getClientOriginalName());
					$type_mime_img   = $p->getMimeType();
					$sizeFile        = $p->getSize();
					$oname 			 = substr($originalName, 0, 25);
					$large           = strtolower( Str::slug( $oname, '-').Str::random(5).'.'.$extension );
					$preview         = $thumbnail = $simthumbnail = $pinthumbnail = strtolower( Str::slug( $oname, '-').Str::random(3).'.'.$extension );

					if( $p->move($temp, $large) ) 
					{
						set_time_limit(0);
						$original = $temp.$large;
						$width    = Helper::getWidth( $original );
						$height   = Helper::getHeight( $original );
					}// End File
				}
			} 

			
			if( $this->settings->auto_approve_images == 'on' ) {
				$status = 'active';
			} else {
				$status = 'pending';
			}
			$title = "";
			if( isset($request->title) && $request->title != "" )
			{
				$title = trim($request->title);
			}
			
			else {
				$title = trim($originalName);
			}

			$credits = "";
			if( isset($request->credits) && $request->credits != "" )
			{
				$credits = trim($request->credits);
			}
			
			else {
				$credits = '';
			}


			$subcat = subcategories::find($request->subcategories_id);

			if( trim($request->metakeywords) == "" )
			{
				$request->metakeywords = $subcat->metakeywords;
			}
	
			$categories = DB::table('categories')->where('id','=',$request->categories_id)->get();
			$main_cat_id = $categories[0]->main_cat_id;			

			$randomText = Helper::randomImageContent2($request->metakeywords, $main_cat_id, $request->categories_id);			
			if( $randomText != "" ){
				$title = $title." ".$randomText;
				$title = Helper::removeDuplicateWords($title);
			}

			$subcat = subcategories::find($request->subcategories_id);
			if( $subcat )
			{
				$subcat->last_updated = now();
				$subcat->save();
			}

			$thiscat = Categories::find($request->categories_id);
			if( $thiscat )
			{
				$thiscat->last_updated = now();
				$thiscat->save();
			}

			$subgroup = '';
			if( $request->subgroup )
			{
				$subgroup = $request->subgroup;
			}

			$lResolution = list($w, $h) = getimagesize($temp.$large);
			$lSize     = Helper::formatBytes(filesize($temp.$large), 1);

			$resolution = $w.'x'.$h;

			$sql = new Images;

			$sql->large = $large;
			$sql->resolution = $resolution;
			$sql->thumbnail            = $thumbnail;
			$sql->simthumbnail            = $simthumbnail;
			$sql->pinthumbnail            = $pinthumbnail;
			$sql->preview              = $preview;
			$sql->large             = $large;
			$sql->title                = $title;
			$sql->credits                = $credits;
			$sql->metakeywords         = $request->metakeywords;
			$sql->categories_id        = $request->categories_id;
			$sql->subgroup			   = $subgroup;
			$sql->subcategories_id     = $request->subcategories_id;
			if($request->hasFile('opt-file'))
			{
				$sql->opt_file_source 		= $opt_file;	
			}
			$sql->user_id              = Auth::user()->id;
			$sql->status               = $status;
			$sql->extension            = ( $otpGetExe == '' ) ? strtolower($extension) : $otpGetExe;
			$sql->original_name        = $originalName;
			$sql->hash 				   = $hash ?? null;
			$sql->save();

			// ID INSERT
			$imageID = $sql->id;
			
			$pathLarge      = config('path.large');
			$pathPreview    = config('path.preview');
			$pathLarge     = config('path.large');
			$pathThumbnail  = config('path.thumbnail');
			$pathsimThumbnail  = config('path.simthumbnail');
			$pathpinThumbnail  = config('path.pinthumbnail');
			
			
			if( $isgif == 0 )
			{
			 	\File::copy($temp.$preview, $path_preview.$preview);
				\File::delete($temp.$preview);
				ImageOptimizer::optimize($path_preview.$preview);

				$imgPreview = Image::make($path_preview.$preview)->encode("webp",86);
				Storage::put($pathPreview.$preview, $imgPreview, [
			              'visibility' => 'public'
			        ]);
				$url = Storage::url($pathPreview.$preview);
				\File::delete($path_preview.$preview);

				\File::copy($temp.$thumbnail, $path_thumbnail.$thumbnail);
				\File::delete($temp.$thumbnail);
				ImageOptimizer::optimize($path_thumbnail.$thumbnail);
				$imgThumbnail = Image::make($path_thumbnail.$thumbnail)->encode("webp",86);
				Storage::put($pathThumbnail.$thumbnail, $imgThumbnail,[
			              'visibility' => 'public'
			        ]);
				$url = Storage::url($pathThumbnail.$thumbnail);
				\File::delete($path_thumbnail.$thumbnail);



				\File::copy($temp.$simthumbnail, $path_simthumbnail.$simthumbnail);
				\File::delete($temp.$simthumbnail);
				ImageOptimizer::optimize($path_simthumbnail.$simthumbnail);
				$imgsimThumbnail = Image::make($path_simthumbnail.$simthumbnail)->encode("webp",86);
				Storage::put($pathsimThumbnail.$simthumbnail, $imgsimThumbnail,[
			              'visibility' => 'public'
			        ]);
				$url = Storage::url($pathsimThumbnail.$simthumbnail);
				\File::delete($path_simthumbnail.$simthumbnail);



				\File::copy($temp.$pinthumbnail, $path_pinthumbnail.$pinthumbnail);
				\File::delete($temp.$pinthumbnail);
				ImageOptimizer::optimize($path_pinthumbnail.$pinthumbnail);
				$imgpinThumbnail = Image::make($path_pinthumbnail.$pinthumbnail)->encode("webp",92);
				Storage::put($pathpinThumbnail.$pinthumbnail, $imgpinThumbnail,[
			              'visibility' => 'public'
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
			else
			{
				\File::copy($temp.$large, $path_thumbnail.$thumbnail);
				\File::copy($temp.$large, $path_large.$large);
				\File::delete($temp.$large);
				
				$imgThumbnail = file_get_contents($path_thumbnail.$thumbnail);
				Storage::put($pathThumbnail.$thumbnail, $imgThumbnail,[
			              'visibility' => 'public'
			        ]);

				$imgLarge = file_get_contents($path_large.$large);
				Storage::put($pathLarge.$large, $imgLarge, 'public');
				$url = Storage::url($pathLarge.$large);
				\File::delete($path_large.$large);
			}
		}

		//<--- End Method
		return response()->json([
					'success' => true,
					'target' => url('photo', $imageID),
			]);
	}

	public function edit($id) {

		$data = Images::findOrFail($id);

		if( $data->user_id != Auth::user()->id ) {
			abort('404');
		}

    	return view('images.edit')->withData($data);
	}

	public function update(Request $request) 
	{

	    $image = Images::findOrFail($request->id);

		if( $image->user_id != Auth::user()->id ) {
			return redirect('/');
		}
		$input = $request->all();
		$validator = $this->validator($input,$request->id);

	    if ($validator->fails()) {
	        $this->throwValidationException(
	            $request, $validator
	        );
	    }
	    $image->fill($input);
	    $image->featured = $input['featured'];
	    $image->descr = $input['descr'];
	    $image->save();

	    \Session::flash('success_message', trans('admin.success_update'));

	    return redirect('edit/photo/'.$image->id);
	}


	public function destroy(Request $request){
	  $image = Images::find($request->id);

	  if( $image->user_id != Auth::user()->id ) {
		return redirect('/');
	}


		$preview_image = 'public/uploads/preview/'.$image->preview;
		$thumbnail     = 'public/uploads/thumbnail/'.$image->thumbnail;
		$simthumbnail     = 'public/uploads/simthumbnail/'.$image->simthumbnail;
		$pinthumbnail     = 'public/uploads/pinthumbnail/'.$image->pinthumbnail;
		$large   = 'public/uploads/large/'.$image->large;

		// Delete preview
		Storage::delete(config('path.preview').$image->preview);

		// Delete thumbnail
		Storage::delete(config('path.thumbnail').$image->thumbnail);


		// Delete simthumbnail
		Storage::delete(config('path.simthumbnail').$image->simthumbnail);


		// Delete pinthumbnail
		Storage::delete(config('path.pinthumbnail').$image->pinthumbnail);


		Storage::delete(config('path.large').$image->large);

		$image->delete();

      return redirect(Auth::user()->username);

	}//<--- End Method


	public function download($token_id) 
	{
		
		$token_id = $this->request->token_id;
		$response = Images::where('large', $token_id)->firstOrFail();
		$cat_id = $response['categories_id'];

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
		
		if(isset($img->opt_file_source) && $img->opt_file_source != "") {$part  = '/file';} else {$part  = '/photo';};
		$slug = $response->category->slug;


		$multilangLink = config('app.topsiteurl').($part).("/$response->id").'/'.Str::slug($response->title);
		

		$contenturl=url('/').($part).("/$response->id").'/'.Str::slug($response->title);
		$categories = DB::table('categories')->where('slug','=',$slug)->get();
		$title= 'Downloading... '.($response->title);
		$description= 'Downloading...' . Helper::removetags($subcat->spdescr);
		$thumbimage=config('app.filesurl').('uploads/preview').'/'.($response->preview);

		$main_cat_id = $categories[0]->main_cat_id;
		$main_categories = DB::table('main_categorys')->where('id','=',$main_cat_id)->get();
		$aageka  = 'image free dowwnload';
		$imgtitle= '🔥 '.($response->title).' | '.($aageka);
		$imgdescr= Helper::removetags($response->descr);
		$imgdescrtrue= ($response->descr);
		$filesurl=config('app.filesurl');
		$imgpreview = $filesurl.('uploads/preview').'/'.($response->preview);
		$imgsimthumbnail = $filesurl.('uploads/simthumbnail').'/'.($response->simthumbnail);
		$imgthumbnail= config('app.filesurl').('uploads/thumbnail').'/'.($response->thumbnail);
		$imglarge = $filesurl.(config('path.uploads').'large/'.$response->large);
		$imgtitletrue=($response->title);
		$imgalt = Str::limit($imgtitletrue, 28, '');
		$catname= ($response->category->name);
		$subcatname= ($response->subcat->name);
		$subcatlink=url('s').'/'.($subcat->slug);
		$subgroups= ($response->subcat->keyword);
		$keywords=$response->metakeywords;
		$rssfeed=$subcatlink.'/rssfeeds';
		$maincategoryID = $main_cat_id;
		DeviceToken::updateToken($maincategoryID);
		$catlink=($response->title);
		$arrayTags=explode(",",$response->category->relatedtags);
		$arrayTags=explode(",",$response->metakeywords);
		$countTags=count($arrayTags);
		$latestsubimages = Images::where('subcategories_id',$response->subcategories_id)->whereStatus('active')->where('id','<>',$response->id)->where('date','>',date("Y-m-d", strtotime("-1 days")))->orderBy('date','DESC')->take(1)->get();
		$similarimages=Images::where('subcategories_id',$response->subcategories_id)->whereStatus('active')->where('id','<>',$response->id)->orderBy('date','DESC')->take(6)->get();
		$images=Images::where('subcategories_id',$response->subcategories_id)
		->whereStatus('active')
		->where(function($query)use($arrayTags,$countTags){for($k=0;$k<$countTags;++$k){$query
		->orWhere('metakeywords','LIKE','%'.$arrayTags[$k].'%');}})
		->where('images.id','<>',$response->id)
		->orderByRaw('RAND()')
		->take(60)
		->get();
		$loader = $filesurl.'/'.(config('path.svg').'loader.svg');
		$catlink=url('c').'/'.($response->category->slug);

		$subcatlinks = array();
		        
    	return view('images.download', compact('imgthumbnail','contenturl','keywords', 'thumbimage','title', 'description','rssfeed','token_id','main_categories','imgtitle', 'imgdescr', 'imgpreview', 'imgsimthumbnail', 'part', 'catname', 'subcatname', 'imgtitletrue', 'subcatlink', 'catlink', 'arrayTags', 'countTags', 'latestsubimages', 'similarimages', 'images', 'loader', 'imgalt', 'subgroups', 'imgdescrtrue', 'imglarge','main_cat_id','subcatlinks','maincategoryID','multilangLink'))->withResponse($response);
	}//<--- End Method

	public function idownload($token_id) 
	{	$settings = AdminSettings::first();
		$image = Images::where('large',$token_id)->firstOrFail();
		if( isset( $image ) ) 
		{
			{
				$pathFile = config('path.uploads').'/large/'.$image->large;
				$headers = [
					'Content-Type:' => ' image/'.$image->extension,
					'Cache-Control' => 'no-cache, no-store, must-revalidate',
					'Pragma' => 'no-cache',
					'Expires' => '0'
				];
				return Storage::download($pathFile, 'Downloaded from '.$settings->sitename.' '.$image->large.'.'.$image->extension, $headers);
			}
		}
	}

	public function otherdownload($token_id) 
	{
		$image = Images::where('large',$token_id)->firstOrFail();
		$other = $image->opt_file_source;

		if( $other != 'NULL' )  
		{
				$pathFile = config('path.uploads').'opt_file/'.$image->opt_file_source;
				return Storage::download($pathFile, 'Downloaded from  '.$image->opt_file_source);
		}
	}
	
	public function test2(){
	    $array = [157888, 157889, 157890, 157891];
	    $responses = Images::whereIn("id", $array)->get();
	    
	    foreach($responses as $response)
	    {   
    	    $filesurl=config('app.filesurl');
    		$imgthumb= $filesurl.('uploads/thumbnail').'/'.($response->thumbnail);
    		$ext = pathinfo($imgthumb, PATHINFO_EXTENSION);
    		$file = file_get_contents($imgthumb);
    		file_put_contents(public_path($response->thumbnail), $file);
    	    $uploaded = Helper::resizeImageFixed( public_path($response->thumbnail), 45, 45, public_path($response->thumbnail));
    	    $pathThumbnail  = config('path.thumbnail');
    	    $imgThumbnail = Image::make(public_path($response->thumbnail))->encode($ext);
    	    $x = Storage::put($pathThumbnail.$response->thumbnail, $imgThumbnail, ['visibility' => 'public']);
	    }
	    echo "Converted Successfully";
	}
	
	public function imageConvert($image, $type)
    {
        $filesurl='https://obs.sgp1.digitaloceanspaces.com/';
        $imgthumb= $filesurl.('uploads/').$type.'/'.$image;
        $ext = pathinfo($imgthumb, PATHINFO_EXTENSION);

        $file = file_get_contents($imgthumb);
        $image_path = public_path('uploads/'.$type.'/'.$image);
        file_put_contents($image_path, $file);

        Helper::resizeImageFixed( $image_path, 45, 45, $image_path);
        $imgThumbnail = Image::make($image_path)->encode($ext);
        Storage::put($image_path, $imgThumbnail, ['visibility' => 'public']);
	}

	public function imageDownload($image, $type)
    {
        $filesurl='https://obs.sgp1.digitaloceanspaces.com/';
        $imgthumb= $filesurl.('uploads/').$type.'/'.$image;

        $file = file_get_contents($imgthumb);
        $image_path = public_path('downloaded/uploads/'.$type.'/'.$image);

		if(!\File::exists(public_path('downloaded/uploads/'.$type))) {
			\File::makeDirectory(public_path('downloaded/uploads/'.$type),0777,true);
		}


        file_put_contents($image_path, $file);
	}


	public function downloadall(){
		$settings = AdminSettings::first();
		$imageidfrom = $settings->downloadidfrom;
		$imageidto = $settings->downloadidto;
	    $array = [$imageidfrom, $imageidto];
	    $responses = Images::whereBetween("id", $array)->get();
	    foreach($responses as $response)
	    {
	        if ($response->is_downloaded == 0){
                if (!empty($response->thumbnail)){
                    $this->imageDownload($response->thumbnail, 'thumbnail');
                }
                if (!empty($response->simthumbnail)){
                    $this->imageDownload($response->simthumbnail,'simthumbnail');
                }
                if (!empty($response->preview)){
                    $this->imageDownload($response->preview, 'preview');
                }
                if (!empty($response->large)){
                    $this->imageDownload($response->large, 'large');
                }
                echo 'Downloaded for '.$response->id. '<br>';
             $response = DB::table('images')
			        ->where('id', $response->id)
			        ->update(['is_downloaded' => '1']);

            }
            else if ($response->is_downloaded == 1){
            	echo 'Already downloaded for '.$response->id. ', <br>';
            }
        }
	    echo "Downloaded Successfully!";
	}



    public function convertHash() {
    	$array = [55000, 65000];
    	$responses = Images::whereBetween("id", $array)->whereNull('hash')->whereNotNull('large')->get();
	    foreach($responses as $response)

    	{
    	    $filesurl='https://obs.sgp1.digitaloceanspaces.com/';
    		$imgsimthumb= $filesurl.('uploads/large').'/'.($response->large);
    		$hash = md5_file($imgsimthumb);
    		$response->update(['hash' => $hash]);

	   }
	   echo "Converted Successfully";
	}

    
    public function test1() {
    	$array = [101984, 130000];
    	$responses = Images::whereBetween("id", $array)->get();
	    foreach($responses as $response)

    	{
    	    $filesurl='https://obs.sgp1.digitaloceanspaces.com/';
    		$imgsimthumb= $filesurl.('uploads/simthumbnail').'/'.($response->simthumbnail);
    		$ext = pathinfo($imgsimthumb, PATHINFO_EXTENSION);
    		
    		$file = file_get_contents($imgsimthumb);
    		file_put_contents(public_path($response->simthumbnail), $file);
    		
    		$original = public_path($response->simthumbnail);
			$width    = Helper::getWidth( $original );
			$height   = Helper::getHeight( $original );
					
        		
        // 		LINE NO. 629
        		if ( $width > $height ) 
        			{
        				if( $width > 1280) : $_scale = 1280; else: $_scale = 900; endif;
        				// SIMTHUMBNAIL
        				$scale    = 310 / $width;
        				$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $original );
        			}
        		else 
        			{
        				if( $width > 1280) : $_scale = 960; else: $_scale = 800; endif;
        				// SIMTHUMBNAIL
        				$scale    = 200 / $width;
        				$uploaded = Helper::resizeImage( $original, $width, $height, $scale, $original );
        			}

    	    $pathsimThumbnail  = config('path.simthumbnail');
    	    $imgsimThumbnail = Image::make(public_path($response->simthumbnail))->encode($ext);
    	    $x = Storage::put($pathsimThumbnail.$response->simthumbnail, $imgsimThumbnail, ['visibility' => 'public']);	

    	    ResizeLogsimThumb::create(['ID'=>$response->id, "done"=>"true"]); 
	   }
	   echo "Converted Successfully";
	}
}
