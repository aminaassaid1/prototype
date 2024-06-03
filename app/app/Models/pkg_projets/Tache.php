<?php

namespace App\Models\pkg_projets;

use App\Models\pkg_rh\Personne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_at',
        'updated_at',
        'nom',
        'description',  
        'priorité',
        'dateDebut',
        'dateEchéance',
        'personne_id',
        'status_tache_id',
        'projets_id',
    ];

    public function Personne(){
        return $this->belongsTo(Personne::class, 'personne_id');
    }

    public function Projet(){
        return $this->belongsTo(Projet::class, 'projets_id');
    }

    public function StatutTache(){
        return $this->belongsTo(StatutTache::class, 'status_tache_id');
    }
}
