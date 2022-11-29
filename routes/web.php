<?php
use Illuminate\Support\Facades\Route;
Route::post('/save-token', 'AdminController@saveToken')->name('save.token');
	Route::group(['middleware'=>['HtmlMinifier','cache']], function(){
	Route::get('/downloadAll', 'Extra@downloadall');
	Route::get('/convertHash', 'Extra@convertHash');
	Route::get('/testconvsim', 'Extra@test1');
	Route::get('WebScrapper', 'Extra@WebScrapper');
	Route::get('/', 'HomeController@index');
	Route::redirect('/home', '/');
	Route::get('type/{slug}', "HomeController@typeslug");
	Route::get('contact-us','ContactController@index');
	Route::post('contact','ContactController@sendmail');
	Route::get('dmca','DmcaController@dmca');
	Route::post('dmcago','DmcaController@senddmca');
	Route::post('subscribers','ContactController@sendmailsubscribers');
	Route::post('validate','HomeController@usernameValidate');
	Route::get('instalog', 'Extra@instalog');
	Route::get('CronCheck', 'Extra@CronCheck');
	Route::get('ClearCronLogs', 'Extra@clearCronLogs');
	Route::get('clearTempImages', 'Extra@clearTempImages');
	Route::get('InstaCron', 'Extra@InstaCron');
	Route::get('InstaAllCron', 'Extra@InstaAllCron');
	Route::get('latest', 'HomeController@latest');
	Route::get('featured', 'HomeController@featured');
	Route::get('rssfeeds', 'HomeController@latestFeed');
	Route::get('rssfeeds/featured', 'HomeController@featuredFeed');
	Route::get('rssfeeds/c/{slug}', 'HomeController@categoryrss');
	Route::get('rssfeeds/s/{slug}', 'HomeController@subcategories');
	Route::get('rssfeeds/g/{slug}', 'HomeController@subgrouprss');
	Route::auth();
	Route::group(['middleware' => 'guest'], function() {
		Route::get('oauth/{provider}', 'SocialAuthController@redirect')->where('provider', '(facebook|google|twitter)$');
		Route::get('oauth/{provider}/callback', 'SocialAuthController@callback')->where('provider', '(facebook|google|twitter)$');
	});
	Route::get('members', 'HomeController@members');
	Route::get('tags/{slug}','HomeController@tags' );
	Route::get('c/{slug}','HomeController@category');
	Route::get('s/{slug}','HomeController@subcategory');
	Route::get('g/{subgroup}','HomeController@subgroup' );
	Route::get('search', 'HomeController@getSearch');
	Route::get('searcher', 'HomeController@getSearcher');
	Route::get('file/{id}/{slug?}','ImagesController@show');
	Route::get('photo/{id}/{slug?}','ImagesController@show');
	Route::get('/logout', 'Auth\LoginController@logout');
	Route::get('verify/account/{confirmation_code}', 'HomeController@getVerifyAccount')->where('confirmation_code','[A-Za-z0-9]+');
	Route::get('page/{page}','PagesController@show')->where('page','[^/]*' );
	// SITEMAPS
	Route::get('sg/allsitemap', 'HomeController@sitemaps');
	Route::get('sg/frequent', 'HomeController@frequentsitemaps');
	Route::get('sg/maincat', 'HomeController@maincat');
	Route::get('sg/categories', 'HomeController@catxml');
	Route::get('sg/pages', 'HomeController@pagesitemaps');
	Route::get('sg/users', 'HomeController@userssitemap');
	// Route::get('sg/search', 'HomeController@searchkeywords');
	Route::get('sg/subcategorieslists', 'HomeController@allsubcatxml');
	Route::get('sg/{slug}/subcategories', 'HomeController@cat_subcats');
	Route::get('sg/{slug}/subcategories-{page}', 'HomeController@cat_subcats');
	Route::get('sg/subgroupslists', 'HomeController@sgsitemapslist');
	Route::get('sg/subgroup', 'HomeController@subgroupxml');
	Route::get('sg/subgroup-{page}', 'HomeController@subgrouppagexml');
	Route::get('sg/subgroupsof/{slug}', 'HomeController@instantsubgroup');
	Route::get('sg/imageslists', 'HomeController@imglistxml');
	Route::get('sg/images', 'HomeController@imgxml');
	Route::get('sg/images-{page}', 'HomeController@imgpagexml');
	Route::get('ajax/users', 'AjaxController@users');
	Route::get('ajax/search', 'AjaxController@search');
	Route::get('ajax/latest', 'AjaxController@latest');
	Route::get('ajax/featured', 'AjaxController@featured');
	Route::get('ajax/category', 'AjaxController@category');
	Route::get('ajax/subcategory', 'AjaxController@subcategories');
	Route::get('ajax/subcategories', 'AjaxController@moresubcategories');
	Route::get('ajax/subgroup', 'AjaxController@subgroup');
	Route::get('ajax/searchtags', 'AjaxController@searchtags');
	Route::get('ajax/user/images', 'AjaxController@userImages');
	Route::get('ajax/getSubcatlinks', 'AjaxController@getSubcatlinks');
	Route::group(['middleware' => ['auth','cache']], function() {
	Route::get('panel/admin/send-notification', 'AdminController@sendNotification')->name('sendNotification');
    Route::post('panel/admin/send-notification-process', 'AdminController@sendNotificationProcess')->name('sendNotificationProcess');
	Route::get('upload', 'Extra@upload');
	Route::get('getcategories/{id}','Extra@getcategories');
	Route::get('getsubcat/{id}','Extra@getsubcat');
	Route::get('getsubgroup/{id}','Extra@getsubgroup');
	Route::get('getsubgroupupload/{id}','Extra@getsubgroupupload');
	Route::get('getsubkeywords/{id}','Extra@getsubkeywords');
	// Edit Photo
	Route::get('edit/photo/{id}','Extra@edit');
	Route::post('update/photo','Extra@update');
	// Delete Photo 6
	Route::get('delete/photo/{id}','Extra@destroy');
	// Account Settings
	Route::get('account','UserController@account');
	Route::post('account','UserController@update_account');
	// Password
	Route::get('account/password','UserController@password');
	Route::post('account/password','UserController@update_password');
	// Delete Account
	Route::get('account/delete','UserController@delete');
	Route::post('account/delete','UserController@delete_account');
	// Upload Avatar
	Route::post('upload/avatar','UserController@upload_avatar');
	// Upload Cover
	Route::post('upload/cover','UserController@upload_cover');
	// Photos Pending
	Route::get('photos/pending','UserController@photosPending');
	Route::post('upload','Extra@create');
	//======= DASHBOARD ================//
	// Dashboard
	Route::get('user/dashboard','DashboardController@dashboard');
	// Photos
	Route::get('user/dashboard/photos','DashboardController@photos');
	});//<------ End User Views LOGGED
	// Downloads Images
	Route::group(['middleware' => 'downloads'], function() {
	Route::get('fetch/{token_id}/{type}','Extra@download');
	});
	// Downloads Images
	Route::group(['middleware' => 'downloads','cache'], function() {
	Route::get('ifetch/{token_id}/{type}','Extra@idownload');
	});
	Route::group(['middleware' => 'downloads','cache'], function() {
	Route::get('otherfetch/{token_id}/{type}','Extra@otherdownload');
	});
	/*
	|
	|-----------------------------------
	| Profile User
	|-----------------------------------
	*/
	Route::get('user/{slug}', 'UserController@profile')->where('slug','[A-Za-z0-9@. \_-]+');
	/*
	|
	|-----------------------------------
	| Admin Panel
	|--------- -------------------------
	*/
	Route::group(['middleware' => ['role','cache']], function() {
	// Upgrades
	Route::get('update/{version}','UpgradeController@update');
	//Route::get('panel/admin/instacronduplicate','AdminController@instacronduplicate');
	// Dashboard
https://oyebesmartest.com/panel/admin/pagecacheclearhome
	// Artisan Commands
	Route::get('panel/admin/pagecacheclearfeatured', 'AdminController@pagecacheclearfeatured');
	Route::get('panel/admin/pagecacheclearlatest', 'AdminController@pagecacheclearlatest');
	Route::get('panel/admin/pagecacheclearimages', 'AdminController@pagecacheclearphoto');
	Route::get('panel/admin/pagecacheclearcat', 'AdminController@pagecacheclearc');
	Route::get('panel/admin/pagecacheclearsubcat', 'AdminController@pagecacheclears');
	Route::get('panel/admin/pagecacheclearsubgroup', 'AdminController@pagecacheclearsubgroup');
	Route::get('panel/admin/pagecacheclearhome', 'AdminController@pagecacheclearhome');
	Route::get('panel/admin/removesessions', 'AdminController@removesessions');
	Route::get('panel/admin/keygenearate', 'AdminController@keygenearate');
	Route::get('panel/admin/alllogclear', 'AdminController@alllogClear');
	Route::get('panel/admin/logclear', 'AdminController@logClear');
	Route::get('panel/admin/optimizecache', 'AdminController@optimizeClear');
	Route::get('panel/admin/pagecacheclear', 'AdminController@PageCacheClear');
	Route::get('panel/admin','AdminController@admin');
	//Instacron log
	Route::get('panel/admin/instacronlog','AdminController@instacronlog');
	Route::get('panel/admin/deletelog/{id}','AdminController@deletelog');
	Route::get('panel/admin/deletealllog','AdminController@deletealllog');
	//webscapper
	Route::post('panel/admin/webscrapper','AdminController@webscrapper');
	Route::post('panel/admin/checkwebscrapperurl','AdminController@checkwebscrapperurl');
	Route::post('panel/admin/updatewebscrapper','AdminController@updatewebscrapper');
	Route::post('panel/admin/updatewebscrappertitle','AdminController@updatewebscrappertitle');
	Route::get('panel/admin/webscrapper/delete/{id}','AdminController@webscrapperdelete');
	// Main Categories
	Route::post('/panel/admin/main-category/add','AdminController@maincatadd');
	Route::get('panel/admin/main_category','AdminController@main_category');
	Route::get('panel/admin/updateCatImages','AdminController@updateCatImages');
	// Categories
	Route::get('panel/admin/categories','AdminController@categories');
	Route::get('panel/admin/recentsubcategories','AdminController@recentsubcategories');
	Route::get('panel/admin/categories/{id}','AdminController@categories');

	Route::get('panel/admin/categories/add/{id}','AdminController@addCategories');
	Route::post('panel/admin/categories/add/{id}','AdminController@storeCategories');
	Route::post('panel/admin/categories/updateTags','AdminController@updateCatTags');
	Route::post('panel/admin/categories/updateTitleahead','AdminController@updateCatTitleahead');
	Route::get('panel/admin/subcategories/view/{id}','AdminController@subCategories');
	Route::post('panel/admin/maincategories/add','AdminController@mainCategories');
	Route::post('panel/admin/maincategories/updateTitleahead','AdminController@updateMainCatTitleahead');
	Route::get('panel/admin/main_category/{main_category}/maincategoriesedit', 'AdminController@maincategoriesedit');
	Route::patch('panel/admin/main-category/mainupdate/{main_category}', 'AdminController@mainupdate');
	Route::post('/panel/admin/main-category/destroy', 'AdminController@maindestroy');
	Route::get('panel/admin/subcategories/add/{id}','AdminController@addsubCategories');
	Route::post('panel/admin/subcategories/add/{id}','AdminController@savesubCategories');
	Route::post('panel/admin/subcategories/updateTags','AdminController@updateSubcatTags');
	Route::post('panel/admin/subcategories/updateImageTitle','AdminController@updateSubcatImgTitle');
	Route::post('panel/admin/subcategories/updateAllInsta', 'AdminController@updateAllInsta');
	Route::post('panel/admin/subcategories/updateshowathome', 'AdminController@showathome');
	Route::post('panel/admin/subcategories/updatemode', 'AdminController@updatemode');
	Route::post('panel/admin/subcategories/updatesSpecialDate', 'AdminController@updatesSpecialDate');
	Route::post('panel/admin/subcategories/updateSubgroup', 'AdminController@updateSubgroup');
	Route::get('panel/admin/categories/edit/{id}/{pid}','AdminController@editCategories')->where(array( 'id' => '[0-9]+'));
	Route::post('panel/admin/categories/edit/{id}/{pid}','AdminController@updateCategories');
	Route::get('panel/admin/categories/delete/{id}/{pid}','AdminController@deleteCategories')->where(array( 'id' => '[0-9]+'));
	Route::get('panel/admin/subcategories/delete/{id}/{pid}','AdminController@deletesubCategories')->where(array( 'id' => '[0-9]+', 'pid' => '[0-9]+'));
	Route::get('panel/admin/subcategories/edit/{id}/{pid}','AdminController@editsubCategories')->where(array( 'id' => '[0-9]+', 'pid' => '[0-9]+'));
	Route::post('panel/admin/subcategories/edit/{id}/{pid}','AdminController@updatesubCategories')->where(array( 'id' => '[0-9]+', 'pid' => '[0-9]+'));
	// Settings
	Route::get('panel/admin/settings','AdminController@settings');
	Route::post('panel/admin/settings','AdminController@saveSettings');
	// Images
	Route::get('panel/admin/images','AdminController@images');
	Route::get('panel/admin/duplicate-images','AdminController@duplicateImages');
	Route::post('panel/admin/images/delete','AdminController@delete_image');
	Route::post('panel/admin/images/deletePending','AdminController@deletePending');
	Route::post('panel/admin/images/updateImage','AdminController@updateImage');
	Route::post('panel/admin/images/updateImageTags','AdminController@updateImageTags');
	Route::get('panel/admin/images/{id}','AdminController@edit_image');
	Route::get('panel/admin/testimages/{id}','AdminController@testedit_image');
	Route::post('panel/admin/testedit_saveimage','AdminController@testedit_saveimage');
	Route::post('panel/admin/images/update','AdminController@update_image');
	// Subcat Images
	Route::get('panel/admin/subcatimages/{sid}','AdminController@subcat_images');
	Route::post('panel/admin/subcatimages/{sid}/delete','AdminController@subcat_delete_image');
	Route::post('panel/admin/subcatimages/deleteAllPending','AdminController@deleteAllPending');
	// Limits
	Route::get('panel/admin/settings/limits','AdminController@settingsLimits');
	Route::post('panel/admin/settings/limits','AdminController@saveSettingsLimits');
	// Members
	Route::resource('panel/admin/members', 'AdminUserController',
	['names' => [
	'edit'    => 'user.edit',
	'destroy' => 'user.destroy'
	]]
	);
	Route::get('panel/admin/members/subcategories/{mid}', 'AdminController@membersSubcategories');


	//***** Languages
	Route::get('panel/admin/languages','LangController@index');

	// ADD NEW
	Route::get('panel/admin/languages/create','LangController@create');

	// ADD NEW POST
	Route::post('panel/admin/languages/create','LangController@store');

	// EDIT LANG
	Route::get('panel/admin/languages/edit/{id}','LangController@edit')->where( array( 'id' => '[0-9]+'));

	// EDIT LANG POST
	Route::post('panel/admin/languages/edit/{id}', 'LangController@update')->where(array( 'id' => '[0-9]+'));

	// DELETE LANG
	Route::resource('panel/admin/languages', 'LangController',
		['names' => [
		    'destroy' => 'languages.destroy'
		 ]]
	);

	// Members Reported
	Route::get('panel/admin/webscrapper','AdminController@webscrapper');
	Route::post('panel/admin/webscrapper','AdminController@webscrapper');
	Route::get('panel/admin/members-reported','AdminController@members_reported');
	Route::post('panel/admin/members-reported','AdminController@delete_members_reported');
	Route::get('panel/admin/modify','AdminController@settingsModify');
	Route::post('panel/admin/modify','AdminController@saveSettingsModify');
	// Pages
	Route::resource('panel/admin/pages', 'PagesController',
	['names' => [
	'edit'    => 'pages.edit',
	'destroy' => 'pages.destroy'
	]]
	);

	Route::get('lang/{id}', function($id){

	$lang = App\Models\Languages::where('abbreviation', $id)->firstOrFail();

	Session::put('locale', $lang->abbreviation);

   return back();

})->where(array( 'id' => '[a-z]+'));
	
	Route::get('panel/admin/theme','AdminController@theme');
	Route::post('panel/admin/theme','AdminController@themeStore');
	Route::get('panel/admin/contact','AdminController@contact');
	Route::get('panel/admin/contact/delete/{id}','AdminController@deletecontact');
	Route::post('panel/admin/contact/deleteallcontact','AdminController@deleteallcontact');
	Route::get('panel/admin/dmca','AdminController@dmca');
	Route::get('panel/admin/dmca/delete/{id}','AdminController@deletedmca');
	Route::post('panel/admin/dmca/deletealldmca','AdminController@deletealldmca');
	Route::get('panel/admin/emptysearch','AdminController@emptysearch');
	Route::get('panel/admin/emptysearch/delete/{id}','AdminController@deleteemptysearch');
	Route::get('panel/admin/emptysearch/deleteall','AdminController@deleteallemptysearch');
	Route::post('panel/admin/emptysearch/deletemultiple','AdminController@deletemultipleEmptysearch');
	Route::get('panel/admin/topsearch','AdminController@topsearch');
	Route::get('panel/admin/topsearch/delete/{id}','AdminController@deletetopsearch');
	Route::get('panel/admin/topsearch/deleteall','AdminController@deletealltopsearch');
	Route::post('panel/admin/topsearch/deletemultiple','AdminController@deletemultipletopsearch');
	Route::get('panel/admin/subscribers ','AdminController@subscribers');
	Route::get('panel/admin/users ','AdminController@users');
});
});
