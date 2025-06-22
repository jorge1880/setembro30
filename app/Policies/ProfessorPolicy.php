<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Professor;

class ProfessorPolicy
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
            'admin'
        ]);
    }

    public function view(User $user, Professor $professor)
    {
        // O método 'before' já trata de administradores e diretores.
        // Esta verificação garante que um professor só pode ver o seu próprio perfil.
        if ($user->nivel === User::NIVEL_PROFESSOR) {
            return $user->id === $professor->id_user;
        }

        // Outros perfis (como alunos) não podem ver o perfil de um professor.
        return false;
    }

    public function create(User $user)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            'admin'
        ]);
    }

    public function update(User $user, Professor $professor)
    {
        // Professores só podem editar seu próprio perfil
        if ($user->nivel === User::NIVEL_PROFESSOR) {
            return $user->id === $professor->id_user;
        }
        
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            'admin'
        ]);
    }

    public function delete(User $user, Professor $professor)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            'admin'
        ]);
    }
} 