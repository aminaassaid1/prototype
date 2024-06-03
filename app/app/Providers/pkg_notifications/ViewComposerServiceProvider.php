<?php

namespace App\Providers\pkg_notifications;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composers\pkg_notifications\NotificationComposer;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Enregistrer le NotificationComposer pour être utilisé avec toutes les vues
        View::composer('*', NotificationComposer::class);
    }

    public function register()
    {
        //
    }
}

