<?php

namespace App\Providers;

// use App\View\Composers\ProfileComposer;
// use Illuminate\Support\Facades\View;

use Illuminate\Support\ServiceProvider;
use Statamic\Statamic;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Statamic::script('app', 'cp-custom-hooks.js');
        Statamic::style('app', 'cp-custom.css');
        Statamic::style('app', 'cp-custom-website-form.css');

        // DOESN'T WORK
        // .. https://statamic.dev/extending/lifecycle
        // .. https://laravel.com/docs/9.x/views
        
        // View::composer('statamic::layout', function ( $view ) {
        //     Statamic::provideToScript( [ 'test' => print_r( $view, false ) ] );
        // });
    }
}
