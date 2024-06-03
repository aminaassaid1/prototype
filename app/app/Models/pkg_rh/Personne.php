<?php

namespace App\Models\pkg_rh;

use App\Models\pkg_notifications\Notification;
use App\Models\pkg_projets\Tache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MorphType; 

class Personne extends Model
{
    use HasFactory,MorphType;


    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public $table = 'personnes';
    protected $fillable = ['nom','prenom','type' , 'groupe_id'];
    public function notification()
    {
        return $this->hasMany(Notification::class, 'apprenant_id');
    }

    public function Tache(){
        return $this->hasMany(Tache::class);
    }

}