<?php namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

use Request;
use Redirect;
use Schema;

use Carbon\Carbon;
use Sentry;

class RouteServiceProvider extends ServiceProvider {

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = '';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
		parent::boot($router);
		// Check whether or not the app is installed
		$router->filter('isInstalled', function() {
		    if (Schema::hasTable('settings')) {
		        return Redirect::to('/');
		    }
		});

		$router->filter('auth', function()
		{
		    if (!Sentry::check()) {
		        return Redirect::guest('login/' . Request::segment(1));
		    }
		});

		$router->filter('auth.pw_6_months', function()
		{
		    // Check if the users password was changed within last 6 months or not
		    // If not ask him to change his password, before he can log in
		    $last_pw_changed = new Carbon(current_user()->last_pw_changed);

		    if (Carbon::now()->diffInDays($last_pw_changed) > 180) {
		        return Redirect::to(Request::segment(1) . '/users/change-password')
		                        ->with('error_message', 'It has been more than 6 months since you last changed your password. You need to change it before you can log in.');
		    }
		});

		$router->filter('auth.backend', function()
		{
		    // Check whether the user has backend access or not
		    if (!current_user()->hasAccess('backend')) {
		        return Redirect::to('admin');
		    }
		});

		$router->filter('auth.permissions', function() use ($router)
		{
		    // Authorize all admin/backend routes/paths
		    $route = $router->currentRouteName() ?: $router->current()->getPath();
		    $route = preg_replace('/(admin(\.|\/)?|backend(\.|\/)?)?/', '', $route);
		    $route = str_replace('.store', '.create', $route);
		    $route = str_replace('.update', '.edit', $route);

		    if(!current_user()->hasAccess($route)) {
		        return App::abort(401);
		    }
		});

		/*
		|--------------------------------------------------------------------------
		| Guest Filter
		|--------------------------------------------------------------------------
		|
		| The "guest" filter is the counterpart of the authentication filters as
		| it simply checks that the current user is not logged in. A redirect
		| response will be issued if they are, which you may freely change.
		|
		*/

		$router->filter('guest', function()
		{
		    if (Auth::check()) return Redirect::to('/');
		});
	}

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function map(Router $router)
	{
		include app_path('Http/routes.php');
	}

}
