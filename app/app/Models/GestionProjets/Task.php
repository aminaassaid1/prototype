<?php

namespace App\Models\GestionProjets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    
    protected $fillable = [
            'id'  ,
            'nom'  ,
            'description'  ,
            'project_id'  ,
            'created_at'  ,
            'updated_at'  ,
        ];

    public function ayah()
    {
        return $this->belongsTo(Ayah::class,'ayah_id');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class,'topic_id');
    }
}