<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Turma;
use App\Models\Classe;
use App\Models\Ano_lectivo;
use App\Models\User;
use App\Models\Aula;
use App\Models\Disciplina;
use App\Models\Post;
use App\Models\Forum;
use App\Models\Professor;

class DashboardController extends Controller
{

  
    public function __construct(){
        $this->middleware('auth');
        }

    //CONTROLLER FOR DASBOARD
    public function index(){
        // Contagem de usuários por nível usando constantes
        $totalUsers = User::count();
        $totalAlunos = User::where('nivel', User::NIVEL_ALUNO)->count();
        
        // Contar apenas professores que têm registro na tabela professores
        $totalProfs = Professor::whereHas('user', function($query) {
            $query->where('nivel', User::NIVEL_PROFESSOR);
        })->count();
        
        $totalAdmins = User::whereIn('nivel', [
            'admin', 
            User::NIVEL_DIRETOR_GERAL, 
            User::NIVEL_DIRETOR_PEDAGOGICO
        ])->count();
        
        // Contagem de outras entidades
        $totalCuros = Curso::count();
        $totalturmas = Turma::count();
        $totalClasses = Classe::count();
        $totalAnos = Ano_lectivo::count();
        $totalAulas = Aula::count();
        $totalDisciplinas = Disciplina::count();
        $totalPosts = Post::count();
        $totalForums = Forum::count();

        // Dados para o Gráfico de Usuários (Chart.js)
        $userChartData = [
            'labels' => ['Alunos', 'Professores', 'Admins'],
            'datasets' => [[
                'label' => 'Distribuição de Usuários',
                'data' => [$totalAlunos, $totalProfs, $totalAdmins],
                'backgroundColor' => [
                    'rgba(54, 162, 235, 0.5)', // Blue for Alunos
                    'rgba(255, 159, 64, 0.5)', // Orange for Professores
                    'rgba(75, 192, 192, 0.5)'  // Green for Admins
                ],
                'borderColor' => [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                'borderWidth' => 1
            ]]
        ];

        // Dados para o Gráfico de Conteúdo (Chart.js)
        $contentChartData = [
            'labels' => ['Cursos', 'Turmas', 'Aulas', 'Disciplinas'],
            'datasets' => [[
                'label' => 'Total de Conteúdo Acadêmico',
                'data' => [$totalCuros, $totalturmas, $totalAulas, $totalDisciplinas],
                'backgroundColor' => [
                    'rgba(153, 102, 255, 0.5)', // Purple for Cursos
                    'rgba(255, 99, 132, 0.5)',  // Red for Turmas
                    'rgba(255, 205, 86, 0.5)',  // Yellow for Aulas
                    'rgba(201, 203, 207, 0.5)'  // Grey for Disciplinas
                ],
                'borderColor' => [
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(201, 203, 207, 1)'
                ],
                'borderWidth' => 1
            ]]
        ];

        // Log para debug (apenas em desenvolvimento)
        if (config('app.debug')) {
            \Log::info('Dashboard Stats', [
                'totalUsers' => $totalUsers,
                'totalAlunos' => $totalAlunos,
                'totalProfs' => $totalProfs,
                'totalAdmins' => $totalAdmins,
                'totalCursos' => $totalCuros,
                'totalTurmas' => $totalturmas,
                'totalClasses' => $totalClasses,
                'totalAnos' => $totalAnos,
                'totalAulas' => $totalAulas,
                'totalDisciplinas' => $totalDisciplinas,
                'totalPosts' => $totalPosts,
                'totalForums' => $totalForums,
            ]);
        }

        return view('admin.dashboard', compact(
            'totalCuros', 
            'totalturmas',
            'totalClasses',
            'totalAnos',
            'totalAlunos',
            'totalAdmins',
            'totalProfs',
            'totalUsers',
            'totalAulas',
            'totalDisciplinas',
            'totalPosts',
            'totalForums',
            'userChartData',
            'contentChartData'
        ));
    }

    // Função para pesquisa de usuários
    public function searchUsers(Request $request)
    {
        $this->authorize('viewAny', User::class);
        
        $query = $request->get('search');
        
        if ($query) {
            $users = User::whereNotIn('nivel', [User::NIVEL_PROFESSOR])
                ->where(function($q) use ($query) {
                    $q->where('nome', 'LIKE', "%{$query}%")
                      ->orWhere('id', 'LIKE', "%{$query}%")
                      ->orWhere('email', 'LIKE', "%{$query}%");
                })
                ->get();
        } else {
            $users = User::whereNotIn('nivel', [User::NIVEL_PROFESSOR])->get();
        }
        
        return view('admin.usuarios.index', compact('users', 'query'));
    }

    // Função para verificar consistência dos dados
    public function verificarConsistencia()
    {
        $this->authorize('viewAny', User::class);
        
        $stats = [
            'usuarios' => [
                'total' => User::count(),
                'alunos' => User::where('nivel', User::NIVEL_ALUNO)->count(),
                'professores' => User::where('nivel', User::NIVEL_PROFESSOR)->count(),
                'admins' => User::whereIn('nivel', ['admin', User::NIVEL_DIRETOR_GERAL, User::NIVEL_DIRETOR_PEDAGOGICO])->count(),
            ],
            'entidades' => [
                'cursos' => Curso::count(),
                'turmas' => Turma::count(),
                'classes' => Classe::count(),
                'anos' => Ano_lectivo::count(),
                'aulas' => Aula::count(),
                'disciplinas' => Disciplina::count(),
                'posts' => Post::count(),
                'forums' => Forum::count(),
            ]
        ];
        
        // Verificar inconsistências
        $inconsistencias = [];
        
        // Verificar se a soma dos tipos de usuário bate com o total
        $somaUsuarios = $stats['usuarios']['alunos'] + $stats['usuarios']['professores'] + $stats['usuarios']['admins'];
        if ($somaUsuarios != $stats['usuarios']['total']) {
            $inconsistencias[] = "Soma de tipos de usuário ($somaUsuarios) não bate com total ({$stats['usuarios']['total']})";
        }
        
        // Verificar usuários órfãos
        $usuariosOrfaos = User::whereNotIn('nivel', [
            User::NIVEL_ALUNO, 
            User::NIVEL_PROFESSOR, 
            'admin', 
            User::NIVEL_DIRETOR_GERAL, 
            User::NIVEL_DIRETOR_PEDAGOGICO
        ])->count();
        
        if ($usuariosOrfaos > 0) {
            $inconsistencias[] = "Existem $usuariosOrfaos usuários com nível não reconhecido";
        }
        
        return response()->json([
            'stats' => $stats,
            'inconsistencias' => $inconsistencias,
            'consistente' => empty($inconsistencias)
        ]);
    }
}
