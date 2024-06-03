<?php

namespace App\Models\pkg_rh;
use App\Models\pkg_rh\Personne;
use App\Traits\MorphType; 
use Illuminate\Database\Eloquent\Model;
use App\Models\pkg_notifications\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Apprenant extends  Personne
{
    use HasFactory, MorphType; 

    public function users(){
        return $this->belongsTo(User::class);
    }
}