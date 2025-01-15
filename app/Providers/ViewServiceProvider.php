<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\View\Factory;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('layouts.dashboard', function ($view) {
            $user = auth()->user();
            
            $view->with([
                'user' => $user,
            ]);
        });
    }
} 