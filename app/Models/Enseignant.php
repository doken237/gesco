<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'telephone',
        'unique_enseignant'  
    ];
    protected $guarded=['id','created_ad'];

}
