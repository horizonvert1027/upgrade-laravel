<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request as Input;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\User;
use App\Models\Images;
use App\Models\Notifications;
use App\Models\Downloads;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller {
	
	use Traits\userTraits;
	
	 protected function validator(array $data, $id = null) {
	 	
    	Validator::extend('ascii_only', function($attribute, $value, $parameters){
    		return !preg_match('/[^x00-x7F\-]/i', $value);
		});

			return Validator::make($data, [
	        	
	        ]);
		
    }
	 
	 /**
   * Display a listing of the resource.
   *
   * @return Response
   */
	 public function index() 
	 {
	 	if( Auth::user()->role != 'admin' )
	 	{
	 		\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
	 	}

	 	$sort = Input::get('sort');

		$query = Input::get('q');	
		if( $query != '' && strlen( $query ) > 2 ) 
		{
		 	$data = User::where('name', 'LIKE', '%'.$query.'%')
			->orWhere('username', 'LIKE', '%'.$query.'%');

			if( $sort == "" )
			{
				$data = $data->orderBy('id','desc')->paginate(20);	
			}
			else if( $sort == 'editor' )
			{
				$data->where('role', 'editor');
				$data = $data->orderBy('id','desc')->paginate(20);		
			}		 	
		} 
		else 
		{
			if( $sort == "" ){
				$data = User::orderBy('id','desc')->paginate(20);	
			}
			else if( $sort == 'editor' )
			{
				$user = User::where('role', 'editor');
				$data = $user->orderBy('id','desc')->paginate(20);					
			}
		}
		
    	return view('admin.members', ['data' => $data, 'sort' => $sort, 'query' => $query]);
	 }
	
	/**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
	public function edit($id) 
	{
		if( Auth::user()->role != 'admin' )
	 	{
	 		\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
	 	}
		
		$data = User::findOrFail($id);
		
		if( $data->id == 1 || $data->id == Auth::user()->id ) {
			\Session::flash('info_message', trans('admin.user_no_edit'));
			return redirect('panel/admin/members');
		}
    	return view('admin.edit-member')->withData($data);
	
	}//<--- End Method
	
	/**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
	public function update($id, Request $request) {
    	
    	if( Auth::user()->role != 'admin' )
	 	{
	 		\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
	 	}

	    $user = User::findOrFail($id);		
		$input = $request->all();
		$validator = $this->validator($input,$id);
		
	    if ($validator->fails()) {
	        $this->throwValidationException(
	            $request, $validator
	        );
	    }
		
	    $user->fill($input)->save();
	    \Session::flash('success_message', trans('admin.success_update'));
	    return redirect('panel/admin/members');
	}//<--- End Method
	
	
	/**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
      
	public function destroy($id)
	{
		if( Auth::user()->role != 'admin' )
	 	{
	 		\Session::flash('info_message', trans('admin.pd'));
			return view('admin.pd');
	 	}

		$user = User::findOrFail($id); 
		if( $user->id == 1 || $user->id == Auth::user()->id ) {
		 	return redirect('panel/admin/members');
			exit;
		}
	 
	 	$this->deleteUser($id);
      	return redirect('panel/admin/members');
	}//<--- End Method


}
