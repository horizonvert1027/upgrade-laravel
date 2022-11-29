<?php

namespace App;
use Image;
use App\Models\AdminSettings;
use App\Models\Images;
use App\subcategories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
class Helper
{
	public static function spacesUrlFiles($string) {
	  return ( preg_replace('/(\s+)/u','_',$string ) );
	}

	public static function spacesUrl($string) {
	  return ( preg_replace('/(\s+)/u','+',trim( $string ) ) );
	}

	public static function spacetoplus($string) {
	  return (preg_replace('/(\s+)/u','-',strtolower($string)));
	}

	public static function removeLineBreak( $string )  {
		return str_replace(array("\r\n", "\r"), "", $string);
	}

	public static function getFristImageSearch($slug)
	{
		$slug = str_replace("-", " ", $slug);
		$image = Images::where( 'subgroup', 'LIKE', '%'.$slug.'%' )
		->where('status', 'active' )
		->orderBy('date', 'DESC' )
		->first();
		if( isset( $image ) ) {
			return $image->thumbnail;
		}
		else
		{
			return "";
		}
	}
	public static function numberformat($n, $precision = 1) {
        if ($n < 900) {
        // Default
         $n_format = number_format($n);
        } else if ($n < 900000) {
        // Thausand
        $n_format = number_format($n / 1000, $precision). 'K';
        } else if ($n < 900000000) {
        // Million
        $n_format = number_format($n / 1000000, $precision). 'M';
        } else if ($n < 900000000000) {
        // Billion
        $n_format = number_format($n / 1000000000, $precision). 'B';
        } else {
        // Trillion
        $n_format = number_format($n / 1000000000000, $precision). 'T';
    }
    return $n_format;
    }
	public static function removedash( $string )  {
		return (preg_replace('/(\s-)/u',' ',strtolower($string)));
	}

	public static function first3words($s, $limit=3) {
    	return preg_replace('/((\w+\W*){'.($limit-1).'}(\w+))(.*)/', '${1}', $s);   
	}

	public static function specialmatchedword($source, $replacestring) {
		$stringToReplace = $replacestring;
		$stringToReplace = explode(' ',$stringToReplace);
		$stringFrom = $source;
		$truncatedsubgroup = str_replace($stringToReplace, '',$stringFrom);
		return $truncatedsubgroup;
	}

	public static function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos   = array_keys($words);
        $text  = substr($text, 0, $pos[$limit]);
    }
    return $text;
	}

	public static function removeDuplicateWords( $string )
	{
		$string = str_replace(",", " ", $string);
		$arr = explode(' ', $string);
		$result = array();
		foreach($arr as $value)
		{
		    $result[ strtolower($value) ] = $value;
		}
		$str = implode(' ', $result);
		$str = str_replace("  ", " ", $str);
		return $str;
	}

	public static function likecheck( $title, $description=null ) {
		$settings = AdminSettings::first();
		$matchin = $title . $description;
		$values = $settings->bannedkeywords;
		$regex = implode(' | ', explode(',', $values));
		if(preg_match("/$regex/i", $matchin) === 1) {
			return true; 
		}
	}

	public static function subgroupneat( $subgroup ) {
		$subgroup = str_ireplace(' and','with',$subgroup);
		$values = 'Photos,Wallpapers,Pics,Images,Files';
		$regex = implode(' | ', explode(',', $values));
		$subgroup = preg_replace(array('/\bWallpapers\b/','/\bPictures\b/','/\bPics\b/','/\bImage\b/','/\bImages\b/','/\bPhotos\b/','/\bFull\b/','/\HD\b/','/\bWallpaper\b/','/\bPhoto\b/'), '', $subgroup);
		return $subgroup;
	}


		public static function titleahead( $titleahead )
	{
		if(isset($titleahead) && $titleahead == 0)
		{$aageka  = 'Full HD Backgrounds';} 
		elseif(isset( $titleahead) && $titleahead == 1)
		{$aageka  = 'Full HD Transparent Images';}
		elseif(isset( $titleahead) && $titleahead == 2)
		{$aageka  = 'Full HD Wallpapers | Photos | Images | Pictures';}
		elseif(isset( $titleahead) && $titleahead == 3)
		{$aageka  = 'Presets & Brushes';}
		elseif(isset( $titleahead) && $titleahead == 4)
		{$aageka  = 'Graphics Templates';}
		else {$aageka = 'HD Images | Photo';};

		return $aageka;
	}

	public static function combinAllTitles($images){
		$alltitles = '';
		foreach($images as $img) {
			$alltitles .= $img->title." ";
			$imgstitle = rtrim($alltitles, ' ');
		}
		if (isset($imgstitle) && $imgstitle!= '') {
			return $imgstitle;
		}
		else {
			return ('');
		}
	}

	public static function getNextImage($imageid, $categories_id, $subcategories_id)
	{
		$images = Images::where('id','>', $imageid)->where('categories_id', $categories_id )->where('subcategories_id', $subcategories_id )->orderBy('id', 'asc')->where('status', 'active' )->limit(1)->get();
		if( $images->count() == 1 )
		{
			$image = '';
			foreach ($images as $key => $value) 
			{
				$image = $value;
			}
			return $image;
		}
		else{
			return false;
		}
	}

	public static function getPreviousImage($imageid, $categories_id, $subcategories_id)
	{
		$images = Images::where('id','<', $imageid)->where('categories_id', $categories_id )->where('subcategories_id', $subcategories_id )->orderBy('id', 'desc' )->where('status', 'active' )->limit(1)->get();
		if( $images->count() == 1 )
		{
			$image = '';
			foreach ($images as $key => $value) 
			{
				$image = $value;
			}
			return $image;
		}
		else{
			return false;
		}
	}

	public static function getFristImage($slug)
	{
		$slug = str_replace("-", " ", $slug);
		$image = Images::select('preview')->where( 'metakeywords','LIKE', '%'.$slug.'%' )
		->where('status', 'active' )
		->groupBy('id')
		->orderBy('id', 'desc' )
		->first();

		if( isset( $image ) ) {
			return $image->preview;
		}
		else
		{
			return "";
		}
	}

	public static function getFristImageSubGroup($slug)
	{
		$slug = str_replace("-", " ", $slug);
		$image = Images::select('thumbnail')->where( 'subgroup', 'LIKE', '%'.$slug.'%' )
		->where('status', 'active' )
		->groupBy('id')
		->orderBy('date', 'desc' )
		->first();
		if( isset($image) ) 
		{
			return $image->thumbnail;
		}
		else
		{
			return "";
		}
	}


	public static function checktaghasimg($tags)
	{
	    // if ( isset($tags[10]) ) {
	    //      $sthumbnailcheck = Helper::getFristImageSubGroup($tags[10]);
	    //   }
	    //   elseif (isset($tags[6])) {
	    //      $sthumbnailcheck = Helper::getFristImageSubGroup($tags[6]);
	    //   }
	    //   	      elseif (isset($tags[5])) {
	    //      $sthumbnailcheck = Helper::getFristImageSubGroup($tags[5]);
	    //   }
	    //   	      elseif (isset($tags[4])) {
	    //      $sthumbnailcheck = Helper::getFristImageSubGroup($tags[4]);
	    //   }
	    //   	      elseif (isset($tags[3])) {
	    //      $sthumbnailcheck = Helper::getFristImageSubGroup($tags[3]);
	    //   }
	    //   	      elseif (isset($tags[2])) {
	    //      $sthumbnailcheck = Helper::getFristImageSubGroup($tags[2]);
	    //   }
	    //   	      elseif (isset($tags[1])) {
	    //      $sthumbnailcheck = Helper::getFristImageSubGroup($tags[1]);
	    //   }
	    //   else {
	         $sthumbnailcheck = Helper::getFristImageSubGroup($tags[0]);
	      // }
	      return $sthumbnailcheck;
	}

	public static function getFristImageSubCategory($subcategory_id)
	{
		$image = Images::select('preview')->where('subcategories_id', $subcategory_id)
		->where('status', 'active' )
		->groupBy('id')
		->orderBy('date', 'desc' )
		->first();

		if( isset( $image ) ) {
			return $image->preview;
		}
		else
		{
			return "";
		}
	}

	public static function getFristImageDesc($slug)
	{
		$slug = str_replace("-", " ", $slug);
		$image = Images::where( 'metakeywords','LIKE', '%'.$slug.'%' )
		->where('status', 'active' )
		->groupBy('id')
		->orderBy('id', 'desc' )
		->first();
		
		if( isset( $image ) ) 
		{
			return $image->desc;
		}
		else
		{
			return "";
		}
	}

	public static function getSubCategoryThumbnail($subcategory)
	{
		$subcategory = subcategories::where( 'slug','=', ''.$subcategory.'' )->first();
		if( isset( $subcategory ) ) {
			return $subcategory->sthumbnail;
		}
		else
		{
			return "";
		}
	}

	public static function getSubCategoryName($subcatslug)
	{
		$subcategorySlug = subcategories::where( 'slug','=', ''.$subcatslug.'' )->first();
		if( isset( $subcategorySlug ) ) {
			return $subcategorySlug->name;
		}
		else
		{
			return "";
		}
	}


	public static function getusername($id)
	{
		$user = DB::table('users')->where( 'id','=', ''.$id.'' )->first();
		if( isset( $user ) ) {
			return $user->name;
		}
		else {
			return "Unknown";
		}
	}


	public static function getSubCategoryDob($subcategory)
	{
		$subcategory = subcategories::where( 'slug','=', ''.$subcategory.'' )->first();
		if( isset( $subcategory ) ) {
			return $subcategory->special_date;
		}
		else
		{
			return "";
		}
	}

		public static function getSubCategoryTagged($subcategory)
	{
		$subcategory = subcategories::where( 'slug','=', ''.$subcategory.'' )->first();
		if( isset( $subcategory ) ) {
			return $subcategory->tags;
		}
		else
		{
			return "";
		}
	}
			public static function getSubCategorySlug($subcategory)
	{
		$subcategory = subcategories::where( 'slug','=', ''.$subcategory.'' )->first();
		if( isset( $subcategory ) ) {
			return $subcategory->slug;
		}
		else
		{
			return "";
		}
	}

	public static function getSubCategoryTotalImages($subcategory)
	{
		$subcategory = subcategories::where( 'slug','=', ''.$subcategory.'' )->first();
		
		if( isset( $subcategory ) ) {
			$subcatid = $subcategory->id;
		$images = Images::where( 'subcategories_id','=', ''.$subcatid.'' )->get();
			return count($images);
		}
		else
		{
			return "";
		}
	}


	public static function getCategoryTotalImages($subcategory)
	{
		$category = categories::where( 'slug','=', ''.$subcategory.'' )->first();
		
		if( isset( $category ) ) {
			$subcatid = $category->id;
		$images = Images::where( 'categories_id','=', ''.$subcatid.'' )->get();
			return count($images);
		}
		else
		{
			return "";
		}
	}


	public static function getSubCategoryExt($subcategory)
	{
		$subcategory = subcategories::where( 'slug','=', ''.$subcategory.'' )->first();
		
		if( isset( $subcategory ) ) {
			$subcatid = $subcategory->id;
			$lastimage = Images::where( 'subcategories_id','=', ''.$subcatid.'' )->first();
			if( isset( $lastimage ) ) {
				$limg = $lastimage->extension;
			return $limg;
			} 
		}
		else
		{
			return "";
		}
	}
		public static function getSubCategoryOptfile($subcategory)
	{
		$subcategory = subcategories::where( 'slug','=', ''.$subcategory.'' )->first();
		
		if( isset( $subcategory ) ) {
			$subcatid = $subcategory->id;
			if( isset( $lastimage ) ) {
			$lastimage = Images::where( 'subcategories_id','=', ''.$subcatid.'' )->first();
			$opt_file_source = $lastimage->opt_file_source;
			return $opt_file_source;
			} 
		}
		else
		{
			return "";
		}
	}
	

    public static function hyphenated($url)
    {
        $url = strtolower($url);
        //Rememplazamos caracteres especiales latinos
        $find = array('á','é','í','ó','ú','ñ');
        $repl = array('a','e','i','o','u','n');
        $url = str_replace($find,$repl,$url);
        // Añaadimos los guiones
        $find = array(' ', '&', '\r\n', '\n', '+');
                $url = str_replace ($find, '-', $url);
        // Eliminamos y Reemplazamos demás caracteres especiales
        $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
        $repl = array('', '-', '');
        $url = preg_replace ($find, $repl, $url);
        //$palabra=trim($palabra);
        //$palabra=str_replace(" ","-",$palabra);
        return $url;
        }

	// Text With (2) line break
	public static function checkTextDb( $str ) {

		//$str = trim( self::spaces( $str ) );
		if( mb_strlen( $str, 'utf8' ) < 1 ) {
			return false;
		}
		$str = preg_replace('/(?:(?:\r\n|\r|\n)\s*){3}/s', "\r\n\r\n", $str);
		$str = trim($str,"\r\n");

		return $str;
	}

	public static function removesymbols($string)
	{
		$string = preg_replace('/[\'^£$%&*()}{@#~><>,:;"|=_¬-]/', ' ', $string);
		return $string;
	}


// removes all special characters except space comma
	public static function removespecialcharacters($string)
	{
		$string = preg_replace('/[^A-Za-z0-9\s,]/', '', $string);
		return $string;
	}
	
// Remove all tags from Tags

	public static function oldremovetags( $str)
	{
		$res = str_replace("&nbsp;", " ", htmlspecialchars(strip_tags(substr($str,0,1000)), ENT_QUOTES));
		$res = preg_replace('/(?:(?:\r\n|\r|\n)\s*){2}/s', " ", $res);
		$res = str_replace("&#039;", "′", $res);
		$res = str_replace(["&amp;","amp;"], "", $res);
		$res = str_replace("nbsp;", " ", $res);
		return $res;

	}

	public static function removetags( $str)
	{
		$res = strip_tags(preg_replace('/<[^>]*>/',' ',str_replace(array("&nbsp;","\n","\r"),"",html_entity_decode($str,ENT_QUOTES,'UTF-8'))));
		// more than one space
		$res = preg_replace('/(\s+)/u',' ',$res );
		 // initial space
		$res = preg_replace("/^\s+/",'', $res); 
		return $res;
	}

	public static function counts( $totaling)
	{
		$count= number_format((ceil($totaling/100 )*100)+400);
		return $count;
	}

	public static function checkText( $str ) {

		
		if( mb_strlen( $str, 'utf8' ) < 1 ) {
			return false;
		}

		$str = nl2br( e( $str ) );
		$str = str_replace( array( chr( 10 ), chr( 13 ) ), '' , $str );

		$str = stripslashes( $str );

		return $str;
	}

	public static function formatNumber( $number ) {
    if( $number >= 1000 &&  $number < 1000000 ) {

       return number_format( $number/1000, 1 ). "k";
    } else if( $number >= 1000000 ) {
		return number_format( $number/1000000, 1 ). "M";
	} else {
        return $number;
    }
   }//<<<<--- End Function

   public static function formatNumbersStats( $number ) {

    if( $number >= 100000000 ) {
		return '<span class=".numbers-with-commas counter">'.number_format( $number/1000000, 0 ). "</span>M";
	} else {
        return '<span class=".numbers-with-commas counter">'.number_format( $number ).'</span>';
    }
   }//<<<<--- End Function

   	public static function spaces($string) {
	  return ( preg_replace('/(\s+)/u',' ',$string ) );

	}

	public static function convertTojpeg($image)
	{
		$extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
		$dir = strtolower(pathinfo($image, PATHINFO_DIRNAME));
		$base = strtolower(pathinfo($image, PATHINFO_BASENAME)); 
		$f = explode(".", $base);
		$newImage = $dir."/".$f[0].".png";

		imagepng(imagecreatefromstring(file_get_contents($image)), $newImage, -1);
		chmod($newImage, 0777);
		return $newImage;
	}

	public static function resizeImage( $image, $width, $height, $scale, $imageNew = null ) 
	{
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$imageType = image_type_to_mime_type($imageType);
		$newImageWidth = ceil($width * $scale);
		$newImageHeight = ceil($height * $scale);
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		switch($imageType) {
			case "image/gif":
				$source=imagecreatefromgif($image);
				imagefill( $newImage, 0, 0, imagecolorallocate( $newImage, 255, 255, 255 ) );
				imagealphablending( $newImage, TRUE );
				break;
		    case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				$source=imagecreatefromjpeg($image);
				break;
			case "image/webp":
				$source=imagecreatefromwebp($image);
				break;
		    case "image/png":
			case "image/x-png":
				$source=imagecreatefrompng($image);
				imagealphablending( $newImage, false );
				imagesavealpha( $newImage, true );

				//imagefill( $newImage, 0, 0, imagecolorallocate( $newImage, 255, 255, 255 ) );
				//imagealphablending( $newImage, TRUE );
				break;
	  	}
		imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);

		switch($imageType) {
			case "image/gif":
		  		imagegif( $newImage, $imageNew );
				break;
	      	case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
		  		imagejpeg( $newImage, $imageNew ,90 );
				break;
			case "image/png":
			case "image/x-png":
				imagepng( $newImage, $imageNew );
				break;
			case "image/webp":
				imagewebp($newImage,$imageNew);
				break;
	    }

		chmod($image, 0777);
		return $image;
	}

	public static function resizeImageFixed( $image, $width, $height, $imageNew = null ) {

		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$imageType = image_type_to_mime_type($imageType);
		$newImage = imagecreatetruecolor($width,$height);
		//dd($imageType);

		switch($imageType) {
			case "image/gif":
				$source=imagecreatefromgif($image);
				imagefill( $newImage, 0, 0, imagecolorallocate( $newImage, 255, 255, 255 ) );
				imagealphablending( $newImage, TRUE );
				break;
		    case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				$source=imagecreatefromjpeg($image);
				break;
			case "image/webp":
				$source=imagecreatefromwebp($image);
				break;
		    case "image/png":
			case "image/x-png":
				$source=imagecreatefrompng($image);
				imagealphablending( $newImage, false );
				imagesavealpha( $newImage, true );

				/*imagefill( $newImage, 0, 0, imagecolorallocate( $newImage, 255, 255, 255 ) );
				imagealphablending( $newImage, TRUE );*/
				break;
	  	}
		if( $width/$imagewidth > $height/$imageheight ){
	        $nw = $width;
	        $nh = ($imageheight * $nw) / $imagewidth;
	        $px = 0;
	        $py = ($height - $nh) / 2;
	    } else {
	        $nh = $height;
	        $nw = ($imagewidth * $nh) / $imageheight;
	        $py = 0;
	        $px = ($width - $nw) / 2;
	    }
	    
	    //dd($source);

		imagecopyresampled($newImage,$source,$px, $py, 0, 0, $nw, $nh, $imagewidth, $imageheight);

		switch($imageType) {
			case "image/gif":
		  		imagegif($newImage,$imageNew);
				break;
	      	case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
		  		imagejpeg($newImage,$imageNew,90);
				break;
			case "image/png":
			case "image/x-png":
				imagepng($newImage,$imageNew);
				break;
			case "image/webp":
				imagewebp($newImage,$imageNew);
				break;
	    }

		chmod($image, 0777);
		return $image;
	}

	public static function getResolution( $image ) 
	{
		$size   = getimagesize( $image );
		return $size[0]."x".$size[1];
	}

	public static function getHeight( $image ) {
		$size   = getimagesize( $image );
		$height = $size[1];
		return $height;
	}

	public static function getWidth( $image ) {
		$size  = getimagesize($image);
		$width = $size[0];
		return $width;
	}
	public static function formatBytes($size, $precision = 2) {
    $base = log($size, 1024);
    $suffixes = array('', 'kB', 'MB', 'GB', 'TB');

    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
  }

	public static function removeHTPP($string){
		$string = preg_replace('#^https?://#', '', $string);
		return $string;
	}

	public static function Array2Str( $kvsep, $entrysep, $a ){
		$str = "";
			foreach ( $a as $k => $v ){
				$str .= "{$k}{$kvsep}{$v}{$entrysep}";
				}
		return $str;
	}

	public static function removeBR($string) {
		$html    = preg_replace( '[^(<br( \/)?>)*|(<br( \/)?>)*$]', '', $string );
		$output = preg_replace('~(?:<br\b[^>]*>|\R){3,}~i', '<br /><br />', $html);
		return $output;
	}

	public static function removeTagScript( $html ){

			  	//parsing begins here:
				$doc = new \DOMDocument();
				@$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
				$nodes = $doc->getElementsByTagName('script');

				$remove = [];

				foreach ($nodes as $item) {
					$remove[] = $item;
				}

				foreach ($remove as $item) {
					$item->parentNode->removeChild($item);
				}

				return preg_replace(
					'/^<!DOCTYPE.+?>/', '',
					str_replace(
					array('<html>', '</html>', '<body>', '</body>', '<head>', '</head>', '<p>', '</p>', '&nbsp;' ),
					array('','','','','',' '),
					$doc->saveHtml() ));
	}// End Method

	public static function removeTagIframe( $html ){

			  	//parsing begins here:
				$doc = new \DOMDocument();
				@$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
				$nodes = $doc->getElementsByTagName('iframe');

				$remove = [];

				foreach ($nodes as $item) {
					$remove[] = $item;
				}

				foreach ($remove as $item) {
					$item->parentNode->removeChild($item);
				}

				return preg_replace(
					'/^<!DOCTYPE.+?>/', '',
					str_replace(
					array('<html>', '</html>', '<body>', '</body>', '<head>', '</head>', '<p>', '</p>', '&nbsp;' ),
					array('','','','','',' '),
					$doc->saveHtml() ));
	}// End Method

	public static function fileNameOriginal($string)
	{
		return pathinfo($string, PATHINFO_FILENAME);
	}

	public static function formatDate( $date ){

		$day    = date('d', strtotime($date));
		$_month = date('m', strtotime($date));
		$month  = trans("months.$_month");
		$year   = date('Y', strtotime($date));

		$dateFormat = $month.' '.$day.', '.$year;

		return $dateFormat;
	}

public static function DynamicgetAverageColor($image, $x, $y){
	    $image_path = public_path($image->dirname.'/'.$image->basename);
	    info("image ".json_encode($image));
	    if ($image->extension == 'png'){
            $full_image = imagecreatefrompng($image_path);
        }
        elseif ($image->extension == 'jpeg'){
            $full_image = imagecreatefromjpeg($image_path);
        }

        elseif ($image->extension == 'jpg'){
            $full_image = imagecreatefromjpeg($image_path);
        }

        elseif ($image->extension == 'gif'){
            $full_image = imagecreatefromgif($image_path);
        }
        elseif ($image->extension == 'webp'){
            $full_image = imagecreatefromwebp($image_path);
        }
        $scaled = imagescale($full_image, $x, $y, IMG_BICUBIC);
        $index = imagecolorat($scaled, $x-50, $y-50);
        $rgb = imagecolorsforindex($scaled, $index);
        $red = round(round(($rgb['red'] / 0x33)) * 0x33);
        $green = round(round(($rgb['green'] / 0x33)) * 0x33);
        $blue = round(round(($rgb['blue'] / 0x33)) * 0x33);
        $total_rgb = $red + $green + $blue;
        info("total : $total_rgb");
        if ($total_rgb < 182){
            $color = '#ffffff';
        }else{
            $color = '#ffffff';
        }
        return $color;
    }

    public static function Dynamicwatermarklight( $name ) {
        $thumbnail = Image::make($name);
        $water_mark_position = env("WATERMARK_PLACE",'top-right');
        $width = $thumbnail->width();
        $height = $thumbnail->height();

        if ($water_mark_position == 'top-left'){
            $x = 200;
            $y = 50;
        }elseif ($water_mark_position == 'top-right'){
            $x = $width - 200;
            $y = 50;
        }elseif ($water_mark_position == 'bottom-left'){
            $x = 200;
            $y = $height - 50;
        }elseif ($water_mark_position == 'bottom-right'){
            $x = $width - 200;
            $y = $height - 50;
        }else{
            $x = 200;
            $y = 50;
        }

        $thumbnail->text('https://oyebesmartest.com/', $x, $y, function ($font) use ($thumbnail, $x, $y) {
            $font->file(public_path('Roboto_Mono/RobotoMono-VariableFont_wght.ttf'));
            $font->size(40);
            $font->color(Helper::color_inverse(Helper::getAverageColor($thumbnail, $x, $y)));
            $font->align('center');
            $font->valign('bottom');
        });
        $thumbnail->save($name)->destroy();
    }

   public static function getAverageColor($image){
	    $image_path = $image->dirname.'/'.$image->basename;
	    $imageWidth = $image->width();
	    info("image ".json_encode($image));
	    if ($image->extension == 'png'){
            $full_image = imagecreatefrompng($image_path);
        }
        elseif ($image->extension == 'jpeg'){
            $full_image = imagecreatefromjpeg($image_path);
        }
         elseif ($image->extension == 'jpg'){
            $full_image = imagecreatefromjpeg($image_path);
        }
        elseif ($image->extension == 'gif'){
            $full_image = imagecreatefromgif($image_path);
        }elseif ($image->extension == 'webp'){
            $full_image = imagecreatefromwebp($image_path);
        }
                $imageSc = round(15 * $imageWidth / 90);
        $imageScH = $imageSc / 4;
        $scaled = imagescale($full_image, $imageScH, $imageSc); 
        //it takes avg color only from bottom right 90 90
        $index = imagecolorat($scaled, $imageScH - 1, $imageSc - 1 );
        $rgb = imagecolorsforindex($scaled, $index);
        $red = round(round(($rgb['red'] / 0x33)) * 0x33);
        $green = round(round(($rgb['green'] / 0x33)) * 0x33);
        $blue = round(round(($rgb['blue'] / 0x33)) * 0x33);
        $total_rgb = $red + $green + $blue;
        info("total : $total_rgb");
        if ($total_rgb < 350){
            $color = 'DarkImage';
        }else{
            $color = 'LightImage';
        }
        return $color;
    }

	public static function watermarkLight( $name ) {
		$thumbnail = Image::make($name);
		$color = Helper::getAverageColor($thumbnail);
	    $imageWidth = $thumbnail->width();
	    $watermarkSourceDark =  Image::make('public/img/watermark/dark.png');
	    $watermarkSourceLight =  Image::make('public/img/watermark/light.png');

		if ($color == 'LightImage') {
			if ( $thumbnail->width() <= 1500 ) {
				$watermarkSize = round(15 * $imageWidth / 90);
				$watermarkSourceDark->resize($watermarkSize, null, function ($constraint){
				$constraint->aspectRatio();});
				$thumbnail->insert($watermarkSourceDark, 'bottom-right', 0, 0);
			}
			else if ( $thumbnail->width() >= 1501 ) {
				$watermarkSize = round(10 * $imageWidth / 95);
				$watermarkSourceDark->resize($watermarkSize, null, function ($constraint){
				$constraint->aspectRatio();});
				$thumbnail->insert($watermarkSourceDark, 'bottom-right', 0, 0);
			}
		}
		else if ($color == 'DarkImage') {
			if ( $thumbnail->width() <= 1500 ) {
				$watermarkSize = round(17 * $imageWidth / 85);
				$watermarkSourceLight->resize($watermarkSize, null, function ($constraint){
				$constraint->aspectRatio();});
				$thumbnail->insert($watermarkSourceLight, 'bottom-right', 0, 0);
			}
			else if ( $thumbnail->width() >= 1501 ) {
				$watermarkSize = round(10 * $imageWidth / 95);
				$watermarkSourceLight->resize($watermarkSize, null, function ($constraint){
				$constraint->aspectRatio();});
				$thumbnail->insert($watermarkSourceLight, 'bottom-right', 0, 0);
			}
		}
	    $thumbnail->save($name)->destroy();
	}

	public static function watermarkBottom( $name ) {
		$thumbnail = Image::make($name);
		$blackStrip = round(14 * $thumbnail->height() / 300);

		$watermarkLogo = Image::make('public/img/watermark/logo.png');
		$watermarkLogoSize = round(14 * $thumbnail->height() / 300);
		$watermarkLogo->resize(null, $watermarkLogoSize, function ($constraint){
		$constraint->aspectRatio();});

		$watermarkSocial = Image::make('public/img/watermark/social.png');
		$watermarkSocialSize = round(14 * $thumbnail->height() / 300);
		$watermarkSocial->resize(null, $watermarkSocialSize, function ($constraint){
				$constraint->aspectRatio();});

		$thumbnail->resizeCanvas(null, $thumbnail->height() + $blackStrip, 'top', false, '000000');
		$thumbnail->insert($watermarkLogo, 'bottom-left', 2, 0);
		$thumbnail->insert($watermarkSocial, 'bottom-right', 0, 0);
		$thumbnail->save($name)->destroy();
	}


	public static function watermarkPinterest( $name ) {
		$thumbnail = Image::make($name);
		$heightFromBottom = round(14 * $thumbnail->height() / 75);
		$watermarkLogo = Image::make('public/img/watermark/pinterest.png');
		$watermarkLogoSize = round(14 * $thumbnail->width() / 28);
		$watermarkLogo->resize($watermarkLogoSize, null, function ($constraint){
		$constraint->aspectRatio();});
		$thumbnail->insert($watermarkLogo, 'bottom-left', 0, $heightFromBottom);
		$thumbnail->save($name)->destroy();
	}



	public static function strRandom() {
		return substr( strtolower( md5( time() . mt_rand( 1000, 9999 ) ) ), 0, 8 );
	}

	public static function validateImageUploaded($image) {

		$finfo = new \finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($image),
        array(
					'jpg' => 'image/jpeg',
					'webp' => 'image/webp',
					'png' => 'image/png',
					'gif' => 'image/gif'
        ),
        true
    )) {
        throw new \Exception('Invalid file format.');
    }

	}// End method




	public static function getSlugforSubName($name)
	{
	 	$subcategories = DB::table('subcategories')->where('name', '=', $name)->get();
	    if( $subcategories && count($subcategories) > 0 )
	    {
	    	return $subcategories[0]->slug;
	    }
	    return "";
	}


public static function getSlugforSubInsta($name)
	{
	 	$subcategories = DB::table('subcategories')->where('cronstatus', 'yes')->get();
	    if( $subcategories && count($subcategories) > 0 )
	    {
	    	return $subcategories[0]->slug;
	    }
	    return "";
	}

	public static function resolutionPreview($image)
	{
		$resolution = explode('x', $image);
		$lWidth = $resolution[0];
		$lHeight = $resolution[1];

		if ($lWidth > $lHeight) {
			if ($lWidth > 1280) : $_scale = 1280; else: $_scale = 900; endif;
			$previewWidth = 850 / $lWidth;
		} else {
			if ($lWidth > 1280) : $_scale = 960; else: $_scale = 800; endif;
			$previewWidth = 480 / $lWidth;
		}

		$newWidth = ceil($lWidth * $previewWidth);
		$newHeight = ceil($lHeight * $previewWidth);

		return $newWidth.'x'.$newHeight;
	}

	public static function cleanStr($str)
	{
		$reservedSymbols = [
			'!','”','"',"'",'-','+','<','>','@','(',')','~','*',
			'/','\/','{','}','[',']','#','$','%','&','.','_',':',
			';','=','?','^','`','|', '//', '\\'
		];
		return trim(stripslashes(str_replace($reservedSymbols, '', $str)), ',');
	}

	public static function isMobile() 
	{ 
	$userAgent=""; 
		if(isset($_SERVER["HTTP_USER_AGENT"]))
			{ 
				$userAgent=preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]); 
			} 
	return $userAgent; 
	}



	public static function randomImageContent($metakeywords, $cat_id)
	{
		$alltag = array_filter(explode(",", $metakeywords));
		$rindex = array_rand($alltag);
		$randomTag = $alltag[ $rindex ];
		$tt = explode(" ", trim($randomTag));
		$randomTagText = ucfirst($tt[0]);

		$category_tags = [];
		$category_tags[0] = ["Background HD","HD Image","Full HD Photo","HD Pics","HD Pictures","HD Photos","Images","Free Image","New Image","Latest Pic","New Photo","Download Free Image"];
		$category_tags[1] = ["Transparent Image","PNG Download","PNG File download","Vector Download","Transparent Photo","Download PNG File","Download PNG Image","Dowwnload PNG Photo","Transarent Image download","free PNG Download","Download free transparent Image","PNG Picture","PNG Pics","PNG Photo"];
		$category_tags[2] = ["Wallpaper","Backgrounds","HD Wallpaper","Ultra HD wallpaper","4k Background","Full HD Wallpaper","Free HD Wallpapers","Free wallpaper","Download Wallpaper","Download HD Wallpaper","Download HD Background","Download Background","Wallpaper Images","Wallpaper Photo","Wallpaper for Mobiles and Desktop","Beautiful Wallpaper","Latest Wallpaper","New Wallpaper"];
		$category_tags[3] = ["Download Wish Images","Wish Images","Wish Pics","Wishes Pics","Wishes Pictures","Wishing Images","Greetings Wishes","Greet Pictures","Best Wishes Images"];

		if( !array_key_exists($cat_id, $category_tags))
		{
			$cat_id = 0;
		}
		$ctags = $category_tags[$cat_id];
		$cindex = array_rand($ctags);
		$randomCatTag = $ctags[ $cindex ];
		$randomTagText .= " ";
		$randomTagText .= $randomCatTag;
		return $randomTagText;
	}


	public static function randomImageContent1($metakeywords, $cat_id, $subcategory)
	{
		$alltag = array_filter(explode(",", $metakeywords));
		$rindex = array_rand($alltag);
		$randomTag = $alltag[ $rindex ];
		$tt = explode(" ", trim($randomTag));
		$randomTagText = ucfirst($tt[0]);

		$category_tags = [];
		$category_tags[0] = ["Background HD","HD Image","Full HD Photo","HD Pics","HD Pictures","HD Photos","Images","Free Image","New Image","Latest Pic","New Photo","Download Free Image"];
		$category_tags[1] = ["Transparent Image","PNG Download","PNG File download","Vector Download","Transparent Photo","Download PNG File","Download PNG Image","Dowwnload PNG Photo","Transarent Image download","free PNG Download","Download free transparent Image","PNG Picture","PNG Pics","PNG Photo"];
		$category_tags[2] = ["Wallpaper","Backgrounds","HD Wallpaper","Ultra HD wallpaper","4k Background","Full HD Wallpaper","Free HD Wallpapers","Free wallpaper","Download Wallpaper","Download HD Wallpaper","Download HD Background","Download Background","Wallpaper Images","Wallpaper Photo","Wallpaper for Mobiles and Desktop","Beautiful Wallpaper","Latest Wallpaper","New Wallpaper"];
		$category_tags[3] = ["Download Wish Images","Wish Images","Wish Pics","Wishes Pics","Wishes Pictures","Wishing Images","Greetings Wishes","Greet Pictures","Best Wishes Images"];


		$category[31] = ["Celebrity Wallpaper","Wallpaper of Celebrity","4k Wallpaper","celebrity 4k wallpaper", "Full HD Celebrity Wallpaper","Ultra HD Celebrity Wallpaper","Celebrity WhatsApp DP","Profile Picture HD", "Celebrity Pics HD", "Celebrity Background", "Celebrity Wallpapers"];
		$category[207] = ["Amoled Wallpapers","Ultra HD Dark Wallpapers","Super Amoled Wallpapers","4k Amoled Black Wallpapers","Full HD Amoled Wallpapers", "Amoled 4k Wallpaper", "Dark Amoled Wallpaper", "Black 4k Wallpaper","Black Dark Super Amoled Wallpaper"];
		$category[24] = ["Game Wallpapers","Ultra HD Game Wallpapers","Game Full HD Wallpapers","4k Gaming Wallpapers","Full HD Gaming Wallpapers", "Game 4k Wallpaper", "Amoled Game Wallpaper", "Games 4k Wallpaper","Black Super Amoled Gaming Wallpaper"];


		if( !array_key_exists($cat_id, $category_tags))
		{
			$cat_id = 0;
		}
		$ctags = $category_tags[$cat_id];

		if( $subcategory == 71 )
		{
			$ctags = ["Vector file of FLags", "Flag PNG"];			
		}
		
		$cindex = array_rand($ctags);
		$randomCatTag = $ctags[ $cindex ];
		$randomTagText .= " ";
		$randomTagText .= $randomCatTag;
		return $randomTagText;
	}

	public static function randomImageContent2($metakeywords, $main_cat_id, $cat_id)
	{
		$alltag = array_filter(explode(",", $metakeywords));
		if( count($alltag) == 0 )
		{
			return "";
		}
		$rindex = array_rand($alltag);
		$randomTag = $alltag[ $rindex ];
		$tt = explode(" ", trim($randomTag));
		$randomTagText = ucfirst($tt[0]);

		$main_category_tags = [];
		$maincats = DB::table('main_categorys')->where('titleahead', '!=', '')->get();
		foreach ($maincats as $key => $value) 
		{
			$metakeywords = explode(",", $value->titleahead);
			$main_category_tags[ $value->id ] = $metakeywords;
		}

		$category = [];
		$cats = DB::table('categories')->where('titleahead', '!=', '')->get();
		foreach ($cats as $key => $value) 
		{
			$metakeywords = explode(",", $value->titleahead);
			$category[ $value->id ] = $metakeywords;
		}

		if( !array_key_exists($cat_id, $category))
		{
			if( !array_key_exists($main_cat_id, $main_category_tags) )
			{
				return "";
			}
			else
			{
				$ctags = $main_category_tags[$main_cat_id];
			}
		}
		else
		{
			$ctags = $category[$cat_id];	
		}
		
		$cindex = array_rand($ctags);
		$randomCatTag = $ctags[ $cindex ];
		$randomTagText .= " ";
		$randomTagText .= $randomCatTag;
		return $randomTagText;
	}

	public static function getPendingImages()
	{
		$image = Images::where('status','pending')->count();
		return $image;
	}

	public static function getSubInsta()
	{
		$subcategories = subcategories::where('cronstatus','yes')->count();
		return $subcategories;
	}
	
	public static function getSubPendingImages($subcategories_id)
	{
		$image = Images::where('subcategories_id',$subcategories_id)->where('status','pending')->count();
		return $image;
	}
	
	public static function getSubTotalImages($subcategories_id)
	{
		$image = Images::where('subcategories_id',$subcategories_id)->count();
		return $image;
	}
	
	public static function getCatPendingImages($categories_id)
	{
		$image = Images::where('categories_id',$categories_id)->where('status','pending')->count();
		return $image;
	}

	// Webscrapper
	public static function webScrapper($url, $parent, $class)
	{
		if( $url == "" || $parent == "" || $class == "" )
		{
			return "Invalid data.";
		}
		
		$element = $parent; //"div"; 
		$arr = array();
		try{
			$html = file_get_contents($url);	
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
		
	    libxml_use_internal_errors(true);
	    $dom = new \DOMDocument();
	    $dom->loadHTML($html);
	    if( !$dom )
	    {
	    	return "Error loading DOM";
	    }
	    else
	    {
	    	$u = explode("/", $url);
            $baseurl = $u[0].'/'.$u[1].'/'.$u[2];
            
	    	$xpath = new \DOMXPath($dom);
		    foreach ($xpath->query('//'.$element.'[@class="'.$class.'"]') as $item) 
		    {
		    	$all = $item->getElementsByTagName("img");
		    	if( count($all) == 0 )
		    	{
		    		return 'Document : //'.$element.'[@class="'.$class.'"] - returned no items.';
		    	}
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
			    		$arr[] = $src;
			    	}
			    }
		    }
		    $response = array_filter($arr);
		}
		return $response;
	}

	//get client ip
    public static function getIp() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
	}
}//<--- End Class
