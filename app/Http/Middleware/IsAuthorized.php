<?php namespace App\Http\Middleware;

use Closure;

class IsAuthorized {

    /**
     * Authorize all admin/backend routes/paths
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $router = app()->make('router');
        $route = $router->currentRouteName() ?: $router->current()->getPath();
        $route = preg_replace('/(admin(\.|\/)?|backend(\.|\/)?)?/', '', $route);
        $route = str_replace('.store', '.create', $route);
        $route = str_replace('.update', '.edit', $route);

        if(current_user()->permissions != [] && !current_user()->hasAccess($route)) {
            return abort(401);
        }

        return $next($request);
    }

}
