<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Comment;


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
        //
        Paginator::useBootstrap();


        View::composer('admin.layout', function ($view) {
            $allcomment = Comment::count(); // أو بدون شرط حسب المطلوب
            $view->with('allcomment', $allcomment);
        });

    }
}
