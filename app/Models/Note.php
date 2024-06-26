<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{

    use HasFactory;
    protected $fillable = [
        'etudiant_id',
        'matiere_id',
        'classe_id',
        'note',
        'unique_note'
        
    ];
    protected $guarded=['id','created_ad'];

    public function classe(){
        return $this->belongsTo(classe::class,'classe_id');
    }

    public function matiere(){
        return $this->belongsTo(matiere::class,'matiere_id');
    }

    public function etudiant(){
        return $this->belongsTo(Etudiant::class,'etudiant_id');
    }

   
    
}
