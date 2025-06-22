<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Forum;

class ForumPolicy
{
    public function before(User $user, $ability)
    {
        if (in_array($user->nivel, [User::NIVEL_DIRETOR_GERAL, User::NIVEL_DIRETOR_PEDAGOGICO, 'admin'])) {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            User::NIVEL_PROFESSOR,
            User::NIVEL_ALUNO,
            'admin'
        ]);
    }
 
    public function create(User $user)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            User::NIVEL_PROFESSOR,
            'admin'
        ]);
    }

    public function update(User $user, Forum $forum)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            User::NIVEL_PROFESSOR,
            'admin'
        ]);
    }

    public function edit(User $user, Forum $forum)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            User::NIVEL_PROFESSOR,
            'admin'
        ]);
    }

    public function delete(User $user, Forum $forum)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            'admin'
        ]);
    }

    public function moderar(User $user, Forum $forum)
    {
        // Diretores e admin já são liberados pelo before
        // Professor só pode moderar se for o criador do fórum
        return $user->nivel === User::NIVEL_PROFESSOR && $forum->user_id === $user->id;
    }
}