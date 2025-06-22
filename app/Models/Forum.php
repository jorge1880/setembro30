<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 'descricao', 'user_id', 'data_inicio', 'data_fim', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function turmas()
    {
        return $this->belongsToMany(Turma::class, 'forum_turma');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
}
