<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Disciplina;

class DisciplinaPolicy
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

    public function view(User $user, Disciplina $disciplina)
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
            'admin'
        ]);
    }

    public function update(User $user, Disciplina $disciplina)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            'admin'
        ]);
    }

    public function delete(User $user, Disciplina $disciplina)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            'admin'
        ]);
    }
} 