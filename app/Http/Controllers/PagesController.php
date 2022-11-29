<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\User;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller {
	
	
	 protected function validator(array $data, $id = null) {
	 	
    	Validator::extend('ascii_only', function($attribute, $value, $parameters){
    		return !preg_match('/[^x00-x7F\-]/i', $value);
		});
				
		// Create Rules
		if( $id == null ) {
			return Validator::make($data, [
        	'title'      =>      'required',
			'slug'       =>      'required|ascii_only|alpha_dash|unique:pages',
			'content'    =>      'required',
        ]);
		
		// Update Rules		
		} else {
			return Validator::make($data, [
	        	'title'      =>      'required',
				'slug'       =>      'required|ascii_only|alpha_dash|unique:pages,slug,'.$id,
				'content'    =>      'required',
	        ]);
		}
		
    }
	 
	 /**
   * Display a listing of the resource.
   *
   * @return Response
   */
	 public function index() {
	 	
	 	$data = Pages::all();
		
    	return view('admin.pages')->withData($data);
	 }
	 
	 /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
	 public function create() {
    	return view('admin.add-page');
	 }
	 
	 /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
	 public function store( Request $request ) {
		
		 $input = $request->all();
		
	     $validator = $this->validator($input);
	
	    if ($validator->fails()) {
	        $this->throwValidationException(
	            $request, $validator
	        );
	    }
		
		Pages::create($input);
		
		\Session::flash('success_message',trans('admin.success_add'));
		
		return redirect('panel/admin/pages');
		
	}//<--- End Method
	
	/**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */	
	public function show($page) {

		$response = Pages::where( 'slug','=', $page )->firstOrFail();
		$title = $response->title;
        $description = $response->description;
        $keywords = $response->keywords;
        $thumbimage = url('/').'/public/img/apple/android-chrome-512x512.png';
        $sitemap = '';
        $contenturl = url('/');
        $rssfeed = url('/').'/rssfeeds';
		return view('default.page',compact(['response','title', 'description', 'keywords','thumbimage','rssfeed','contenturl','sitemap']));
		
	}//<--- End Method
	
	/**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
	public function edit($id) {
		
		$data = Pages::findOrFail($id);

    	return view('admin.edit-page')->withData($data);
	
	}//<--- End Method
	
	/**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
	public function update($id, Request $request) {
    	
    $lang = Pages::findOrFail($id);
		
	$input = $request->all();
		
	     $validator = $this->validator($input,$id);
	
	    if ($validator->fails()) {
	        $this->throwValidationException(
	            $request, $validator
	        );
	    }
		
    $lang->fill($input)->save();

    \Session::flash('success_message', trans('admin.success_update'));

    return redirect('panel/admin/pages');
	
	}//<--- End Method
	
	
	/**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
	public function destroy($id){
	  
	  $lang = Pages::findOrFail($id);

      $lang->delete();

      return redirect('panel/admin/pages');
	  
	}//<--- End Method


}
