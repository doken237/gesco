<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelle',
        'classe_id',
        'unique_matiere'
        
    ];
    protected $guarded=['id','created_ad'];
    
    public function classe(){
        return $this->belongsTo(classe::class,'classe_id');
    }

}
