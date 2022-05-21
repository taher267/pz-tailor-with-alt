<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Validator::extend('departure_date_check', function ($attribute, $value, $parameters, $validator) {
        //     $inputs = $validator->getData();
        //     $arrivalDate = $inputs['arrival_date'];
        //     $departureDate = $inputs['departure_date'];
        //     $result = true;
        //     if ($arrivalDate > $departureDate) {
        //         $result = false;
        //     }
        //     return $result;
        // });
    }
}
