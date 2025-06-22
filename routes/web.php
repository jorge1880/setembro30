<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\AnoLectivoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\MaterialApoioController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [SiteController::class, 'index'])->name('site.home');

Route::get('/sobre-nos', [SiteController::class, 'sobre'])->name('site.sobre');

// Rotas de autenticação (sem middleware auth)
Route::post('/auth', [LoginController::class, 'auth'])->name('login.auth');
Route::get('/login', [LoginController::class, 'loginForm'])->name('login.form');
Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');

// Rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    //ROUTAS DE CURSOS
    Route::get('admin/cursos', [CursoController::class, 'index'])->name('admin.cursos');
    Route::post('admin/curso/store', [CursoController::class, 'store'])->name('admin.curso.store');
    Route::delete('admin/curso/delete/{id}', [CursoController::class, 'destroy'])->name('admin.curso.delete');
    Route::post('admin/curso/update/{id}', [CursoController::class, 'update'])->name('admin.curso.update');
    Route::get('admin/curso/edit/{id}', [CursoController::class, 'edit'])->name('admin.curso.edit');
    Route::get('admin/curso/create', [CursoController::class, 'create'])->name('admin.curso.create');

    //ROUTAS DE TURMAS
    Route::get('admin/turmas', [TurmaController::class, 'index'])->name('admin.turmas');
    Route::post('admin/turma/store', [TurmaController::class, 'store'])->name('admin.turma.store');
    Route::delete('admin/turma/delete/{id}', [TurmaController::class, 'destroy'])->name('admin.turma.delete');
    Route::post('admin/turma/update/{id}', [TurmaController::class, 'update'])->name('admin.turma.update');
    Route::get('admin/turma/edit/{id}', [TurmaController::class, 'edit'])->name('admin.turma.edit');
    Route::get('admin/turma/create', [TurmaController::class, 'create'])->name('admin.turma.create');

    //ROUTAS DE USUARIOS
    Route::get('admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('admin/users/search', [DashboardController::class, 'searchUsers'])->name('admin.users.search');
    Route::get('admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('admin/users/{id}', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('admin/users/{id}/change-password', [UserController::class, 'changePassword'])->name('admin.users.change-password');
    Route::get('admin/admins', [UserController::class, 'admins'])->name('admin.admins');

    // Perfil pessoal do usuário logado
    Route::get('admin/profile', [UserController::class, 'profile'])->name('admin.profile');
    Route::post('admin/profile/update', [UserController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('admin/profile/change-password', [UserController::class, 'changePasswordProfile'])->name('admin.profile.change-password');

    //ROUTAS DE PROFESSORES
    Route::get('admin/professores', [ProfessorController::class, 'index'])->name('admin.professores');
    Route::get('admin/professor/create', [ProfessorController::class, 'create'])->name('admin.professor.create');
    Route::post('admin/professor/store', [ProfessorController::class, 'store'])->name('admin.professor.store');
    Route::get('admin/professor/{id}', [ProfessorController::class, 'show'])->name('admin.professor.show');
    Route::get('admin/professor/{id}/edit', [ProfessorController::class, 'edit'])->name('admin.professor.edit');
    Route::put('admin/professor/{id}', [ProfessorController::class, 'update'])->name('admin.professor.update');
    Route::delete('admin/professor/{id}', [ProfessorController::class, 'destroy'])->name('admin.professor.destroy');

    //ROUTAS DE ALUNOS
    Route::get('admin/alunos', [MatriculaController::class, 'index'])->name('admin.alunos');
    Route::get('admin/aluno/create', [MatriculaController::class, 'create'])->name('admin.aluno.create');
    Route::post('admin/aluno/store', [MatriculaController::class, 'store'])->name('admin.aluno.store');
    Route::get('admin/aluno/{id}', [MatriculaController::class, 'show'])->name('admin.aluno.show');
    Route::get('admin/aluno/edit/{id}', [MatriculaController::class, 'edit'])->name('admin.aluno.edit');
    Route::post('admin/aluno/update/{id}', [MatriculaController::class, 'update'])->name('admin.aluno.update');
    Route::delete('admin/aluno/delete/{id}', [MatriculaController::class, 'destroy'])->name('admin.aluno.delete');

    //ESSAS  ROUTAS SÃO PARA CLASSES
    Route::get('admin/classes', [ClasseController::class, 'index'])->name('admin.classes');
    Route::post('admin/classe/store', [ClasseController::class, 'store'])->name('admin.classe.store');
    Route::delete('admin/classe/delete/{id}', [ClasseController::class, 'destroy'])->name('admin.classe.delete');
    Route::post('admin/classe/update/{id}', [ClasseController::class, 'update'])->name('admin.classe.update');
    Route::get('admin/classe/edit/{id}', [ClasseController::class, 'edit'])->name('admin.classe.edit');
    Route::get('admin/classe/create', [ClasseController::class, 'create'])->name('admin.classe.create');

    //ROUTAS PARA ANO LECTIVOS
    Route::get('admin/anos', [AnoLectivoController::class, 'index'])->name('admin.anos');
    Route::post('admin/ano/store', [AnoLectivoController::class, 'store'])->name('admin.ano.store');
    Route::post('admin/ano/update/{id}', [AnoLectivoController::class, 'update'])->name('admin.ano.update');
    Route::delete('admin/ano/delete/{id}', [AnoLectivoController::class, 'destroy'])->name('admin.ano.delete');
    Route::get('admin/ano/edit/{id}', [AnoLectivoController::class, 'edit'])->name('admin.ano.edit');
    Route::get('admin/ano/create', [AnoLectivoController::class, 'create'])->name('admin.ano.create');

    //DISCIPLINAS
    Route::get('admin/disciplinas', [DisciplinaController::class, 'index'])->name('admin.disciplinas');
    Route::get('admin/disciplina/create', [DisciplinaController::class, 'create'])->name('admin.disciplina.create');
    Route::post('admin/disciplina/store', [DisciplinaController::class, 'store'])->name('admin.disciplina.store');
    Route::delete('admin/disciplina/delete/{id}', [DisciplinaController::class, 'destroy'])->name('admin.disciplina.delete');
    Route::get('admin/disciplina/edit/{id}', [DisciplinaController::class, 'edit'])->name('admin.disciplina.edit');
    Route::post('admin/disciplina/update/{id}', [DisciplinaController::class, 'update'])->name('admin.disciplina.update');

    //AULAS
    Route::get('admin/aulas', [AulaController::class, 'index'])->name('admin.aulas');
    Route::get('admin/aula/create', [AulaController::class, 'create'])->name('admin.aula.create');
    Route::post('admin/aula/store', [AulaController::class, 'store'])->name('admin.aula.store');
    Route::get('admin/aula/unica/{id}', [AulaController::class, 'show'])->name('admin.aula.unica');
    Route::get('admin/aula/edit/{id}', [AulaController::class, 'edit'])->name('admin.aula.edit');
    Route::put('admin/aula/update/{id}', [AulaController::class, 'update'])->name('admin.aula.update');
    Route::delete('admin/aula/delete/{id}', [AulaController::class, 'destroy'])->name('admin.aula.delete');
    Route::post('admin/aula/{aula}/material', [App\Http\Controllers\AulaController::class, 'adicionarMaterial'])->name('admin.aula.material.adicionar');
    Route::delete('admin/aula/{aula}/material/{material}', [App\Http\Controllers\AulaController::class, 'removerMaterial'])->name('admin.aula.material.remover');
    Route::post('admin/aula/{aula}/material/{material}/editar', [App\Http\Controllers\AulaController::class, 'editarMaterial'])->name('admin.aula.material.editar');

    //POSTS
    Route::get('admin/post/create', [PostController::class, 'create'])->name('admin.post.create');
    Route::post('admin/post/store', [PostController::class, 'store'])->name('admin.post.store');
    Route::get('admin/posts', [PostController::class, 'index'])->name('admin.posts');
    Route::get('admin/post/edit/{id}', [PostController::class, 'edit'])->name('admin.post.edit');
    Route::post('admin/post/update/{id}', [PostController::class, 'update'])->name('admin.post.update');
    Route::delete('admin/post/delete/{id}', [PostController::class, 'destroy'])->name('admin.post.delete');

    //FORUMS
    Route::get('admin/forum/create', [ForumController::class, 'create'])->name('admin.forum.create');
    Route::get('admin/forums', [ForumController::class, 'index'])->name('admin.forums');
    Route::post('admin/forum/store', [ForumController::class, 'store'])->name('admin.forum.store');
    Route::post('forums/{id}/responder', [App\Http\Controllers\ForumController::class, 'responder'])->name('forums.responder');
    Route::post('/forums/{forum}/comentario/{comentario}/destacar', [ForumController::class, 'destacarComentario'])->name('forums.comentario.destacar');
    Route::post('/forums/{forum}/comentario/{comentario}/silenciar', [ForumController::class, 'silenciarComentario'])->name('forums.comentario.silenciar');
    Route::post('/forums/{forum}/fechar', [ForumController::class, 'fecharForum'])->name('forums.fechar');
    Route::get('forums/{id}', [App\Http\Controllers\ForumController::class, 'show'])->name('forums.show');

    // GESTÃO DE MATERIAIS DO PROFESSOR
    Route::get('professores/materiais', [MaterialApoioController::class, 'index'])->name('professores.materiais.index');
    Route::get('professores/materiais/create', [MaterialApoioController::class, 'create'])->name('professores.materiais.create');
    Route::post('professores/materiais', [MaterialApoioController::class, 'store'])->name('professores.materiais.store');
    Route::get('professores/materiais/{material}/edit', [MaterialApoioController::class, 'edit'])->name('professores.materiais.edit');
    Route::put('professores/materiais/{material}', [MaterialApoioController::class, 'update'])->name('professores.materiais.update');
    Route::delete('professores/materiais/{material}', [MaterialApoioController::class, 'destroy'])->name('professores.materiais.destroy');

    // GALERIA DE IMAGENS
    Route::get('admin/images/gallery', [App\Http\Controllers\AdminController::class, 'imageGallery'])->name('admin.images.gallery');
});

// Rota pública para visualizar posts
Route::get('post/single-post/{id}', [SiteController::class, 'show'])->name('single.post');

// Recuperação de senha
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'resetPassword'])->name('password.email');

// ROTA TEMPORÁRIA PARA LOGIN RÁPIDO - REMOVER ANTES DE IMPLANTAR
Route::get('/login-diretor', function () {
    $diretor = \App\Models\User::where('nivel', \App\Models\User::NIVEL_DIRETOR_GERAL)->first();
    if ($diretor) {
        Auth::login($diretor);
        return redirect('admin/dashboard')->with('sucesso', 'Login como Diretor Geral efetuado com sucesso!');
    }
    return 'Nenhum usuário com o nível de Diretor Geral foi encontrado.';
});
