<?php

namespace App\Providers;
use App\Models\Curso;
use App\Models\Turma;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\MaterialApoio;
use App\Policies\MaterialApoioPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        \App\Models\Curso::class => \App\Policies\CursoPolicy::class,
        \App\Models\Turma::class => \App\Policies\TurmaPolicy::class,
        \App\Models\Disciplina::class => \App\Policies\DisciplinaPolicy::class,
        \App\Models\Classe::class => \App\Policies\ClassePolicy::class,
        \App\Models\Professor::class => \App\Policies\ProfessorPolicy::class,
        \App\Models\Matricula::class => \App\Policies\MatriculaPolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\Forum::class => \App\Policies\ForumPolicy::class,
        \App\Models\Aula::class => \App\Policies\AulaPolicy::class,
        \App\Models\Post::class => \App\Policies\PostPolicy::class,
        \App\Models\Ano_lectivo::class => \App\Policies\AnoLectivoPolicy::class,
        \App\Models\MaterialApoio::class => \App\Policies\MaterialApoioPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
