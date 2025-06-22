<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Matricula extends Model
{
    use HasFactory;

    protected $fillable = [
        'morada',
        'nascimento',
        'nome_mae',
        'nome_pai',
        'telefone',
        'naturalidade',
        'area_formacao',
        'n_bilhete',
        'id_ano',
        'id_turma',
        'id_classe',
        'id_curso',
        'id_user'

    ];

    public function user()
    {
        return $this->belongsTo(User::class,'id_user');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class,'id_curso');
    }
    
    public function classe()
    {
        return $this->belongsTo(Classe::class,'id_classe');
    }
    
    public function turma()
    {
        return $this->belongsTo(Turma::class,'id_turma');
    }
    public function anolect()
    {
        return $this->belongsTo(Ano_lectivo::class,'id_ano');
    }
}
