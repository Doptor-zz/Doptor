<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['validator']->extend('alpha_spaces', function($attribute, $value, $parameters) {
            return preg_match('/^[\pL\s]+$/u', $value);
        });

        $this->app['validator']->extend('alpha_num_spaces', function($attribute, $value, $parameters) {
            return preg_match('/^[\pL\d\s]+$/u', $value);
        });

        $this->app['validator']->extend('unique_vendor_modulename', function($attribute, $value, $parameters) {
            // The combination of vendor and module name must be unique
            $result_count = \DB::table($parameters[0])
                                        ->where('name', $value)
                                        ->where('vendor', $parameters[2]);

            if (isset($parameters[3])) {
                // the result is not the current entry
                $result_count = $result_count->where('id', '<>', $parameters[3]);
            }

            $result_count = $result_count->count();

            return (!$result_count);
        });
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
