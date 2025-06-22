<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->nivel === 'admin') {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            'admin'
        ]);
    }

    public function view(User $user, User $model)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            'admin'
        ]);
    }

    public function create(User $user)
    {
        // Apenas diretor geral pode criar diretor pedagógico
        if (request()->has('nivel') && request('nivel') === User::NIVEL_DIRETOR_PEDAGOGICO) {
            return in_array($user->nivel, [User::NIVEL_DIRETOR_GERAL, 'admin']);
        }
        
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            'admin'
        ]);
    }

    public function update(User $user, User $model)
    {
        // Diretor geral pode editar qualquer usuário
        if (in_array($user->nivel, [User::NIVEL_DIRETOR_GERAL, 'admin'])) {
            return true;
        }

        // Diretor pedagógico pode editar todos exceto o diretor geral e outros diretores pedagógicos
        if ($user->nivel === User::NIVEL_DIRETOR_PEDAGOGICO) {
            return !in_array($model->nivel, [User::NIVEL_DIRETOR_GERAL, User::NIVEL_DIRETOR_PEDAGOGICO, 'admin']);
        }

        return false;
    }

    public function delete(User $user, User $model)
    {
        // Diretor geral pode deletar qualquer usuário
        if (in_array($user->nivel, [User::NIVEL_DIRETOR_GERAL, 'admin'])) {
            return true;
        }

        // Diretor pedagógico pode deletar todos exceto o diretor geral e outros diretores pedagógicos
        if ($user->nivel === User::NIVEL_DIRETOR_PEDAGOGICO) {
            return !in_array($model->nivel, [User::NIVEL_DIRETOR_GERAL, User::NIVEL_DIRETOR_PEDAGOGICO, 'admin']);
        }

        return false;
    }

    /**
     * Permite que qualquer usuário altere seu próprio perfil
     */
    public function updateProfile(User $user, User $model)
    {
        // Qualquer usuário pode alterar seu próprio perfil
        return $user->id === $model->id;
    }

    /**
     * Permite que qualquer usuário altere sua própria senha
     */
    public function changePassword(User $user, User $model)
    {
        // Qualquer usuário pode alterar sua própria senha
        return $user->id === $model->id;
    }
}