<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Turma;
use Illuminate\Auth\Access\HandlesAuthorization;

class TurmaPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
  

    public function before(User $user, $ability)
    {
        if (in_array($user->nivel, [User::NIVEL_DIRETOR_GERAL, User::NIVEL_DIRETOR_PEDAGOGICO, 'admin'])) {
            return true; // Admin e diretores têm acesso total
        }
    }

    /**
     * Quem pode visualizar a lista de turmas.
     * Diretores, Professores e Admins podem visualizar.
     */
    public function viewAny(User $user)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            User::NIVEL_PROFESSOR,
            'admin'
        ]);
    }
 
    /**
     * Quem pode criar uma turma.
     * Apenas Diretores e Admin (mas já coberto pelo before).
     */
    public function create(User $user)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            'admin'
        ]);
    }

    /**
     * Quem pode atualizar uma turma.
     */
    public function update(User $user, Turma $turma)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            'admin'
        ]);
    }

    public function edit(User $user, Turma $turma)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            'admin'
        ]);
    }

    /**
     * Quem pode deletar uma turma.
     */
    public function delete(User $user, Turma $turma)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            'admin'
        ]);
    }
}
