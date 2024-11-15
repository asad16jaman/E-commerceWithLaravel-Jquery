<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Helpers\GetFix;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();
        View::share('getFix', function(string $txt,int $num){
            $words = explode(' ', $txt); // Split the text by spaces
            $words = array_slice($words, 0, $num); // Get the first 20 words
            return implode(' ', $words); // Join them back into a string
            
        });
        
    }
}
