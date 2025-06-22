<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Matricula;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = [
        'designacao',
    ];

    public function turmas(){
        return $this->hasMany(Matricula::class,'id_turma', 'id');
    }

    public function aulas(){
        return $this->hasMany(Aula::class,'id_aula', 'id');
    }

     public function forums()
    {
        return $this->belongsToMany(\App\Models\Forum::class, 'forum_turma');
    }

    public function professores()
    {
        return $this->belongsToMany(\App\Models\Professor::class, 'professor_turma', 'turma_id', 'professor_id');
    }

}
