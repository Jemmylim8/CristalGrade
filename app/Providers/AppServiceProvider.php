<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Announcement;
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
    public function boot()
    {
        // Share the latest 5 announcements with every view that includes the sidebar
        View::composer('announcements._sidebar', function ($view) {
            $view->with('sidebarAnnouncements', Announcement::with('user')->latest()->take(5)->get());
        });
    }
}
