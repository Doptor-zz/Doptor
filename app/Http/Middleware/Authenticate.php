<?php namespace App\Http\Middleware;

use Closure;
use Redirect;
use Request;

use Sentry;

class Authenticate {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!Sentry::check()) {
		    return Redirect::guest('login/' . Request::segment(1));
		}

		return $next($request);
	}

}
