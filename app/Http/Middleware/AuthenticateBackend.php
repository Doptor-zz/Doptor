<?php namespace App\Http\Middleware;

use Closure;
use Redirect;

class AuthenticateBackend {

    /**
     * Handle an incoming request.
     * Check whether the user has backend access or not
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!current_user()->hasAccess('backend')) {
            return Redirect::to('admin');
        }

        return $next($request);
    }

}
