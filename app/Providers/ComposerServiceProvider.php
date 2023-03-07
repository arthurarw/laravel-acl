<?php

namespace App\Providers;

use App\Http\Views\Composers\ChannelComposer;
use App\Http\Views\Composers\MenuComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
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
        View::composer(['layouts.app', 'threads.create', 'threads.edit'], ChannelComposer::class);
        View::composer('layouts.manager', MenuComposer::class);
    }
}
