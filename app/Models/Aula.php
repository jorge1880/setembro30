<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;
    protected $fillable =[
        'descricao',
        'conteudo',
        'id_curso',
        'id_disciplina',
        'id_turma',
        'id_user',
    ];

    public function professor(){
       return  $this->belongsTo(User::class,'id_user')->withDefault([
           'nome' => 'Professor não encontrado'
       ]);
    }

      public function curso(){
       return  $this->belongsTo(Curso::class,'id_curso')->withDefault([
           'designacao' => 'Curso não encontrado'
       ]);
    }

      public function disciplina(){
       return  $this->belongsTo(Disciplina::class,'id_disciplina')->withDefault([
           'nome_disciplina' => 'Disciplina não encontrada'
       ]);
    }

      public function turma (){
       return  $this->belongsTo(Turma::class,'id_turma')->withDefault([
           'designacao' => 'Turma não encontrada'
       ]);
    }

    public function materiaisApoio()
    {
        return $this->hasMany(MaterialApoio::class, 'aula_id');
    }

    public function cursos()
    {
        return $this->belongsToMany(\App\Models\Curso::class, 'aula_has_cursos', 'id_aula', 'id_curso');
    }
}
