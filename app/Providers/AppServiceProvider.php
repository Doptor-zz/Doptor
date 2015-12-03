<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\ClassLoader;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
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
        $this->app->bind(
            'Illuminate\Contracts\Auth\Registrar',
            'App\Services\Registrar'
        );

        if ($this->app->environment() == 'local') {
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
        }

        ClassLoader::addDirectories(array(

            app_path().'/commands',
            app_path().'/controllers',
            app_path().'/models',
            app_path().'/services',
            app_path().'/services/Validation',
            app_path().'/database/seeds',

        ));

        // Autoload all components
        $components = array('posts', 'MediaManager', 'theme_manager');
        foreach ($components as $component) {
            ClassLoader::addDirectories(array(
                app_path().'/Components/'.$component,
                app_path().'/Components/'.$component.'/controllers',
                app_path().'/Components/'.$component.'/controllers/backend',
                app_path().'/Components/'.$component.'/database/migrations',
                app_path().'/Components/'.$component.'/database/seeds',
                app_path().'/Components/'.$component.'/models',
                app_path().'/Components/'.$component.'/presenters',
                app_path().'/Components/'.$component.'/services',
                app_path().'/Components/'.$component.'/validation',
                app_path().'/Components/'.$component.'/views',
            ));
        }
    }

}
