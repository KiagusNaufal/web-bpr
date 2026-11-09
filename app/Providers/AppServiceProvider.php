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
        // Profil BPR dipakai navbar, footer, meta, dan panel admin.
        View::composer(['components.layouts.*', 'partials.*', 'pages.*', 'admin.*', 'errors.*'], function ($view) {
            if (! array_key_exists('profile', $view->getData())) {
                $view->with('profile', once(fn () => CompanyProfile::current()));
            }
        });
    }
}
