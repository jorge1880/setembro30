<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modela\Matricula;

class Curso extends Model
{
    use HasFactory;

   // protected $table = "cursos";
    
    protected $fillable = [
      'nome',
      'descricao',
    ];

    

    public function cursos(){
      return $this->hasMany(Matricula::class,'id_curso', 'id');
  }

   public function aulas(){
        return $this->hasMany(Aula::class,'id_aula', 'id');
    }
  
    public function disciplinas()
    {
        return $this->belongsToMany(\App\Models\Disciplina::class, 'disciplina_has_cursos', 'id_curso', 'id_disciplina');
    }
}
