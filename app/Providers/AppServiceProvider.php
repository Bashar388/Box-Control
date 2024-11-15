<?php

namespace App\Providers;

use App\Listeners\CreateWalletForNewUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
//       Event::listen(
//        Registered::class,
//        [CreateWalletForNewUser::class, 'handle']
//    );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
