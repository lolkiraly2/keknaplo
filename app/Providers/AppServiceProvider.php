<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
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

        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()], false));
            return (new MailMessage)
                ->subject('Jelszó visszaállítása')
                ->greeting('Üdvözlöm!')
                ->line('Kattintson az alábbi gombra a jelszava visszaállításához.')
                ->action('Jelszó visszaállítása', $url)
                ->line('Ez a link 60 percig érvényes.')
                ->line('Ha nem ön kérte a jelszó visszaállítását, akkor figyelmen kívül hagyhatja ezt az üzenetet.');
        });
    }
}
