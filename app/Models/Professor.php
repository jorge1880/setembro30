<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Professor extends Model
{
    use HasFactory;

    protected $table = 'professores';

    protected $fillable = [
        'morada',
        'n_bilhete',
        'num_agente',
        'telefone',
        'naturalidade',
        'id_user',
       
    ];


  public function user()
    {
        return $this->belongsTo(User::class,'id_user');
    }

     public function aulas(){
        return $this->hasMany(Aula::class,'id_aula', 'id');
    }

    public function materiais()
    {
        return $this->hasMany(MaterialApoio::class, 'professor_id');
    }

    public function turmas()
    {
        return $this->belongsToMany(\App\Models\Turma::class, 'professor_turma', 'professor_id', 'turma_id');
    }
}
