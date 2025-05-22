<?php

namespace App\Providers;

use App\Services\CurrencyConverter;
use Illuminate\Support\Facades\App;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('currency.converter', function(){
            return new CurrencyConverter(config('services.currency_converter.api_key'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        Validator::extend('filter', function($attribute, $value, $params)
            {
                return !in_array(strtolower($value), $params);
            }, 'the value is prophed!!');
            
        Paginator::useBootstrapFour();
        // Paginator::defaultView('pagination.custom');
    }
}
