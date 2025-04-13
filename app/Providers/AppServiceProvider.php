<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

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
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Email cím megerősítése')
                ->greeting('Üdvözlöm!')
                ->line('Kattintson az alábbi gombra az email címének megerősítéséhez.')
                ->action('Email-cím megerősítése', $url)
                ->line('Ha nem ön regisztrált, akkor figyelmen kívül hagyhatja ezt az üzenetet.');
        });
    }
}
