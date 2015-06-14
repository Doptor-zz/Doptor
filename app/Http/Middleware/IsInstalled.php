<?php namespace App\Http\Middleware;

use Closure;
use Redirect;
use Schema;

class IsInstalled {

	/**
	 * Handle an incoming request.
	 * Check whether or not the app is installed
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (Schema::hasTable('settings')) {
		    return Redirect::to('/');
		}

		return $next($request);
	}

}
