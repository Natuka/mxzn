<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $request = app('request');
        $authorization = $request->header('Authorization');
        if (!$authorization) {
            $authorization = $request->get('token');
        }

        if (!empty($authorization)) {
            $request->headers->set('Authorization', $authorization);
        }
    }
}
