<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Categories;
use App\Models\User;
use App\Models\AdminSettings;
use App\Models\Images;
use App\Models\Collections;

class UpgradeController extends Controller {

	public function __construct( AdminSettings $settings, Images $images, Collections $collections, User $user, Categories $categories) {
	 $this->user         = $user::first();
	 $this->settings     = $settings::first();
	 $this->images       = $images::first();
	 $this->collections  = $collections::first();
	 $this->categories   = $categories::first();
 }

	public function update($version) {

		$upgradeDone = '<h2 style="text-align:center; margin-top: 30px; font-family: Arial, san-serif;color: #4BBA0B;">'.trans('admin.upgrade_done').' <a style="text-decoration: none; color: #F50;" href="'.url('/').'">'.trans('error.go_home').'</a></h2>';

		//<<---- Version 1.3 ----->>
		if( $version == '1.3' ) {

			if( isset($this->settings->google_adsense_index) ) {
				return redirect('/');
			} else {

				Schema::table('admin_settings', function($table){
					$table->text('google_adsense_index')->after('min_width_height_image');
				 });

				return $upgradeDone;
			}
		}//<<---- Version 1.3 ----->>

		//<<---- Version 1.6 ----->>
		if( $version == '1.6' ) {

			// Create Table languages
				if (!Schema::hasTable('languages')) {
					Schema::create('languages', function($table)
							 {
									 $table->increments('id');
									 $table->string('name', 100);
									 $table->string('abbreviation', 32);
							 });

				 if( Schema::hasTable('languages') ) {
					 DB::table('languages')->insert(
							 array('name' => 'English', 'abbreviation' => 'en')
					 );
				 }
			 }// <<--- End Create Table languages

			 // Add Instagram
			 if( !Schema::hasColumn('users', 'instagram') ) {
				 Schema::table('users', function($table){
 					$table->string('instagram', 200)->after('authorized_to_upload');
 				 });
			 }// <<--- End Add Instagram

			 // Add Link to Pages Terms and Privacy
			 if( !Schema::hasColumn('admin_settings', 'link_terms', 'link_privacy' ) ) {
				 Schema::table('admin_settings', function($table){
 					$table->string('link_terms', 200)->after('google_adsense_index');
					$table->string('link_privacy', 200)->after('google_adsense_index');
 				 });
			 }// <<--- End Add Link to Pages Terms and Privacy


					return $upgradeDone;

		}//<<---- Version 1.6 ----->>

		//<<---- Version 2.0 ----->>
		if( $version == '2.0' ) {

			// Add Fields in Users Table
			if( !Schema::hasColumn('users', 'funds', 'balance', 'payment_gateway', 'bank') ) {
				Schema::table('users', function($table){
					$table->unsignedInteger('funds');
					$table->decimal('balance', 10, 2);
					$table->string('payment_gateway', 50);
					$table->text('bank');
				});
			}// <<-- Add Fields in Users Table

			// Add Fields in Images Table
			if( !Schema::hasColumn('images', 'price', 'item_for_sale', 'funds') ) {
				Schema::table('images', function($table){
					$table->unsignedInteger('price');
					$table->enum('item_for_sale', ['free', 'sale'])->default('free');
				});
			}// <<--- End Add Fields in Images Table

			 // Add Fields in AdminSettings
			 if( ! Schema::hasColumn('admin_settings',
			 		'paypal_sandbox',
					'paypal_account',
					'fee_commission',
					'stripe_secret_key',
					'stripe_public_key',
					'max_deposits_amount',
					'min_deposits_amount',
					'min_sale_amount',
					'max_sale_amount',
					'amount_min_withdrawal',
					'enable_paypal',
					'enable_stripe',
					'currency_position',
					'currency_symbol',
					'currency_code',
					'handling_fee'

					) ) {

				 Schema::table('admin_settings', function($table){
 					$table->enum('paypal_sandbox', ['true', 'false'])->default('true');
					$table->string('paypal_account', 200);
					$table->unsignedInteger('fee_commission');

					$table->string('stripe_secret_key', 200);
					$table->string('stripe_public_key', 200);

					$table->unsignedInteger('max_deposits_amount');
					$table->unsignedInteger('min_deposits_amount');
					$table->unsignedInteger('min_sale_amount');
					$table->unsignedInteger('max_sale_amount');
					$table->unsignedInteger('amount_min_withdrawal');

					$table->enum('enable_paypal', ['0', '1'])->default('0');
					$table->enum('enable_stripe', ['0', '1'])->default('0');

					$table->enum('currency_position', ['left', 'right'])->default('left');
					$table->string('currency_symbol', 200);
					$table->string('currency_code', 200);
					$table->unsignedInteger('handling_fee');

 				 });
			 }// <<--- End Add Fields in AdminSettings

			 // Create table Deposits
			 if( ! Schema::hasTable('deposits')) {

					 Schema::create('deposits', function ($table) {

					 $table->engine = 'InnoDB';
					 $table->increments('id');
					 $table->unsignedInteger('user_id');
					 $table->string('txn_id', 200);
					 $table->unsignedInteger('amount');
					 $table->string('payment_gateway', 100);
					 $table->timestamp('date');
			 });

		 }// <<< --- Create table Deposits

		 // Create table Purchases
		 if( ! Schema::hasTable('purchases')) {

				 Schema::create('purchases', function ($table) {

				 $table->engine = 'InnoDB';
				 $table->increments('id');
				 $table->unsignedInteger('images_id');
				 $table->unsignedInteger('user_id');
				 $table->unsignedInteger('price');
				 $table->timestamp('date');
				 $table->enum('approved', ['0', '1'])->default('1');
				 $table->decimal('earning_net_seller', 10, 2);
				 $table->decimal('earning_net_admin', 10, 2);
		 });

	 }// <<< --- Create table Purchases

	 // Create table Purchases
	 if( ! Schema::hasTable('withdrawals')) {

			 Schema::create('withdrawals', function ($table) {

			 $table->engine = 'InnoDB';
			 $table->increments('id');
			 $table->unsignedInteger('user_id');
			 $table->enum('status', ['pending', 'paid'])->default('pending');
			 $table->string('amount', 50);
			 $table->timestamp('date');
			 $table->string('gateway', 100);
			 $table->text('account');
			 $table->timestamp('date_paid')->default('0000-00-00 00:00:00');
	 });

 }// <<< --- Create table Purchases

 return $upgradeDone;

}//<<---- Version 2.0 ----->>

//<<---- Version 2.3 ----->>
if( $version == '2.3' ) {

	// AdminSettings
	if( ! Schema::hasColumn('admin_settings',
		 'sell_option',
		 'ip'
		 ) ) {

			 Schema::table('admin_settings', function($table){
				$table->enum('sell_option', ['on', 'off'])->default('on');
				});
		 } // Schema hasColumn AdminSettings

		 // User
	 	if( ! Schema::hasColumn('users','ip') ) {

	 			 Schema::table('users', function($table) {
					 $table->string('ip', 30);
	 				});
	 		 } // Schema hasColumn User
	return $upgradeDone;

}//<<---- Version 2.3 ----->>

//<------------------------ Version 2.5
if( $version == '2.5' ) {

	// Create table payment_gateways
if( ! Schema::hasTable('payment_gateways') ) {

		 Schema::create('payment_gateways', function ($table) {

			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->string('name', 50);
			$table->string('type');
			$table->enum('enabled', ['1', '0'])->default('1');
			$table->enum('sandbox', ['true', 'false'])->default('true');
			$table->decimal('fee', 3, 1);
			$table->decimal('fee_cents', 2, 2);
			$table->string('email', 80);
			$table->string('token', 200);
			$table->string('key', 255);
			$table->string('key_secret', 255);
			$table->text('bank_info');
		});

		\DB::table('payment_gateways')->insert([
			[
				'name' => 'PayPal',
				'type' => 'normal',
				'enabled' => $this->settings->enable_paypal,
				'fee' => 5.4,
				'fee_cents' => 0.30,
				'email' => $this->settings->paypal_account,
				'key' => '',
				'key_secret' => '',
				'bank_info' => '',
				'token' => '02bGGfD9bHevK3eJN06CdDvFSTXsTrTG44yGdAONeN1R37jqnLY1PuNF0mJRoFnsEygyf28yePSCA1eR0alQk4BX89kGG9Rlha2D2KX55TpDFNR5o774OshrkHSZLOFo2fAhHzcWKnwsYDFKgwuaRg',
		],
		[
			'name' => 'Stripe',
			'type' => 'card',
			'enabled' => $this->settings->enable_stripe,
			'fee' => 2.9,
			'fee_cents' => 0.30,
			'email' => '',
			'key' => $this->settings->stripe_public_key,
			'key_secret' => $this->settings->stripe_secret_key,
			'bank_info' => '',
			'token' => 'asfQSGRvYzS1P0X745krAAyHeU7ZbTpHbYKnxI2abQsBUi48EpeAu5lFAU2iBmsUWO5tpgAn9zzussI4Cce5ZcANIAmfBz0bNR9g3UfR4cserhkJwZwPsETiXiZuCixXVDHhCItuXTPXXSA6KITEoT',
	]
		]);

	}// End create table payment_gateways

	return $upgradeDone;
}//<---------------------- Version 2.5



	}// <<--- method update

}
