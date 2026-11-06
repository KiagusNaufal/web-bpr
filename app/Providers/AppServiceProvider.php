<?php

namespace App\Providers;

use App\Models\CompanyProfile;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Profil BPR dipakai navbar, footer, dan meta; dimuat sekali per request.
        View::composer(['components.layouts.*', 'partials.*', 'pages.*'], function ($view) {
            static $profile = null;
            $view->with('profile', $profile ??= CompanyProfile::current());
        });
    }
}
