<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Curso;

class CursoPolicy
{
    /**
     * O método 'before' é chamado antes dos outros métodos.
     * Se o usuário for admin ou diretor, ele pode tudo.
     */
    public function before(User $user, $ability)
    {
        if (in_array($user->nivel, [User::NIVEL_DIRETOR_GERAL, User::NIVEL_DIRETOR_PEDAGOGICO, 'admin'])) {
            return true; // Admin e diretores têm acesso total
        }
    }

    /**
     * Quem pode visualizar a lista de cursos.
     * Diretores, Professores, Alunos e Admins podem visualizar.
     */
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

    /**
     * Quem pode visualizar um curso específico.
     */
    public function view(User $user, Curso $curso)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            User::NIVEL_PROFESSOR,
            User::NIVEL_ALUNO,
            'admin'
        ]);
    }

    /**
     * Quem pode criar um curso.
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
     * Quem pode atualizar um curso.
     */
    public function update(User $user, Curso $curso)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            'admin'
        ]);
    }

    public function edit(User $user, Curso $curso)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            'admin'
        ]);
    }

    /**
     * Quem pode deletar um curso.
     */
    public function delete(User $user, Curso $curso)
    {
        return in_array($user->nivel, [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO,
            'admin'
        ]);
    }
}
