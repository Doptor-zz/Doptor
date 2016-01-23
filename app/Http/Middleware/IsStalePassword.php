<?php namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Redirect;
use Request;

class IsStalePassword {

    /**
     * Check if the users password was changed within last 6 months or not
     * If not ask to change the password, before the user can log in
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $last_pw_changed = new Carbon(current_user()->last_pw_changed);

        if (
            // has it been 180 days since this account is created
            Carbon::now()->diffInDays(current_user()->created_at) >= 180 &&
            // has it been 180 days since last password change
            Carbon::now()->diffInDays($last_pw_changed) > 180
        ) {
            return Redirect::to(Request::segment(1) . '/users/change-password')
                            ->with('error_message', trans('users.pw_change_6_months'));
        }
        return $next($request);
    }

}
