<?php

namespace App\Providers;

use App\Models\AccessToken;
use App\Models\DepositReceipt;
use App\Models\Report;
use App\Models\User;
use App\Observers\AccessTokenObserver;
use App\Observers\DepositReceiptObserver;
use App\Observers\ReportObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Http;
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
        Report::observe(ReportObserver::class);
        User::observe(UserObserver::class);
        AccessToken::observe(AccessTokenObserver::class);
        DepositReceipt::observe(DepositReceiptObserver::class);

        Http::macro('textapi', function(){
            return Http::acceptJson()->baseUrl(config('textapi.url'));
        });
    }
}
