<?php

namespace App\Models\pkg_notifications;

use App\Models\pkg_rh\Personne;
use App\Models\pkg_rh\Apprenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'message',
        'isVue',
        'apprenant_id',
    ];

    public function personne()
    {
        return $this->belongsTo(Personne::class);
    }

}