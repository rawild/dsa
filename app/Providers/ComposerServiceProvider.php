<?php

namespace dsa\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
     public function boot()
    {
       # Make the variable "user" available to all views
       \View::composer('*', function($view) {
           $view->with('user', \Auth::user());
       });

       view()->composer(
        'home','dsa\Http\ViewComposers\HomeComposer'
        );

       view()->composer(
       'adminhome', 'dsa\Http\ViewComposers\AdminHomeComposer'
       );

    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
