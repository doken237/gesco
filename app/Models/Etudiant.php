<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;
    protected $fillable = [
        'matricule',
        'name',
        'email',
        'classe_id',
        'telephone',
    ];
    protected $guarded=['id','created_ad'];
    public function classe(){
        return $this->belongsTo(classe::class,'classe_id');
    }

   
}
