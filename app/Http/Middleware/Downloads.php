<?php namespace App\Http\Middleware;

use Closure;
use App\Models\AdminSettings;
use Illuminate\Contracts\Auth\Guard;

class Downloads {

	protected $auth;


	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}


	public function handle($request, Closure $next)
	{
		$settings = AdminSettings::first();
		$loginUrl = url('login');
		$registerUrl = url('register');
		
		if ( $this->auth->guest() && $settings->downloads == 'users' ) {
			
				return redirect()->guest('register')
					->with(array('login_required' => trans('auth.register_download')));
			
		} elseif ( $this->auth->check() && url()->previous() == $registerUrl  ) {
			
				return redirect('/');
		}
		
		return $next($request);

	}

}
