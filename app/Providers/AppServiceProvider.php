<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

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
       /* if(env('APP_ENV') === 'production'){
            URL::forceScheme('https');
        }else{
            URL::forceScheme('http');
        }*/

        if (env('APP_ENV') !== 'local') { 
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            $userNotifications = [];

            if (Auth::check()) {
                $user_id = Auth::user()->id;
 
                $userNotifications = Notification::where('user_id', $user_id)->latest()->get();
            }
 
            $view->with('userNotifications', $userNotifications);
        });

    }
}
