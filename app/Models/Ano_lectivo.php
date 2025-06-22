<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ano_lectivo extends Model
{
    use HasFactory;

    protected $table = 'ano_lectivos';
    protected $fillable = [
        'ano',
    ];
    

    public function matricuas(){
        return $this->hasMany(Matricula::class,'id_ano', 'id');
    }
    
}
