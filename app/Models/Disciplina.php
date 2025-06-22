<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;

    protected $fillable  = ['nome_disciplina',];


     public function aulas(){
        return $this->hasMany(Aula::class,'id_aula', 'id');
    }

    public function curso()
    {
        return $this->belongsTo(\App\Models\Curso::class, 'id_curso');
    }

    public function cursos()
    {
        return $this->belongsToMany(\App\Models\Curso::class, 'disciplina_has_cursos', 'id_disciplina', 'id_curso');
    }
}
