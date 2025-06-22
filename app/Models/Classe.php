<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;
    protected $fillable = [

        'designacao',
    ];


    public function classes(){
        return $this->hasMany(Matricula::class,'id_classe', 'id');
    }
}
