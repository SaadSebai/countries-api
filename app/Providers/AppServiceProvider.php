<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
        RateLimiter::for('api', function (Request $request) {
            return $request->user()
                ? [
                    Limit::perSecond(10)->by($request->user()->id),
                    Limit::perMinute(1000)->by($request->user()->id),
                ]
                : Limit::perMinute(20)->by($request->ip());
        });
    }
}
