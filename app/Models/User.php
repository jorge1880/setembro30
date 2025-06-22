<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const NIVEL_DIRETOR_GERAL = 'diretor_geral';
    const NIVEL_DIRETOR_PEDAGOGICO = 'diretor_pedagogico';
    const NIVEL_PROFESSOR = 'professor';
    const NIVEL_ALUNO = 'aluno';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'email',
        'nivel',
        'password',
        'imagem',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function matricula()
    {
        return $this->hasOne(Matricula::class, 'id_user');
    }

    public function professor()
    {
        return $this->hasOne(Professor::class, 'id_user');
    }

    
    public function post()
    {
        return $this->hasMany(Post::class);
    }

    public function forums()
    {
        return $this->hasMany(\App\Models\Forum::class);
    }

    public function comentarios()
    {
        return $this->hasMany(\App\Models\Comentario::class);
    }

}
