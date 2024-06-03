<?php
 
namespace App\View\Composers\pkg_notifications;

use App\Models\pkg_notifications\Notification;
use App\Models\pkg_rh\Apprenant;
use App\Models\pkg_rh\Personne;
use App\Models\User;
use App\Repositories\pkg_notifications\notificationRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
 
class NotificationComposer
{
    public function compose(View $view): void
    {
        $userId = Auth::id();
        if ($userId AND Auth::user()->name == 'apprenant') {
            $apprenant_id = Apprenant::where('user_id', $userId)->first()->id;
            $notifications = Notification::where('apprenant_id', $apprenant_id)->where('isVue', 0)->get()->sortDesc()->take(7);
            $view->with('notifications', $notifications);
        }
    }
}