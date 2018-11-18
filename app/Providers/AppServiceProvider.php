<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Use GuzzleHttp for web scraping
use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://finviz.com/screener.ashx?v=111');
        $cadHTML = $res->getBody();
        
        return $cadHTML;
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
