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
        \Validator::extend('phone', function ($attribute, $value, $parameters) {
            //return preg_match("/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/", $value);
            // 支持台灣手機號
            // return preg_match("/^(0|86|17951)?1[0-9]{10}$/", $value) || preg_match("/^(886)?0[1-9][0-9]{8}$/", $value);
            return is_mobile($value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
