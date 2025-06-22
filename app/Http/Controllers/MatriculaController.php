<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Curso;
use App\Models\Turma;
use App\Models\Classe;
use App\Models\Matricula;
use App\Models\Ano_lectivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $this->authorize('viewAny', Matricula::class);
        $matriculas = Matricula::with(['user', 'turma', 'curso', 'classe', 'anolect'])
            ->whereNotNull('id_user')
            ->paginate(10);
        return view('admin.alunos', compact('matriculas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Matricula::class);
        $cursos = Curso::all();
        $classes = Classe::all();
        $turmas = Turma::all();
        $ano = Ano_lectivo::latest()->first();
        return view('admin.alunos.create', compact('cursos', 'classes', 'turmas', 'ano'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $this->authorize('create', Matricula::class);
        // Validação dos dados
        $request->validate([
            'nome' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'nivel' => ['required'],
            'password' => ['required'],
            'morada' => ['required'],
            'nascimento' => ['required'],
            'nome_mae' => ['required'],
            'nome_pai' => ['required'],
            'telefone' => ['required'],
            'naturalidade' => ['required'],
            'area_formacao' => ['required'],
            'n_bilhete' => ['required', 'unique:matriculas,n_bilhete'],

            // outros campos do usuário
            'id_ano' => ['required', 'integer', 'exists:ano_lectivos,id'],
            'id_turma' => ['required', 'integer', 'exists:turmas,id'],
            'id_classe' => ['required', 'integer', 'exists:classes,id'],
            'id_curso' => ['required', 'integer', 'exists:cursos,id'],

        ]);

        // Usar transação para garantir integridade dos dados
        DB::transaction(function () use ($request) {
            // Criar usuário

            $imagePath = null;

            if ($request->hasFile('imagem')) {
                $imagePath = $request->file('imagem')->store('imagens', 'public');
            }


            $user = User::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'nivel' => $request->nivel,
                'password' => bcrypt($request->password),
                'imagem' =>  $imagePath,
            ]);

            // Criar matrícula associada ao usuário
            Matricula::create([
                'morada' => $request->morada,
                'nascimento' => $request->nascimento,
                'nome_mae' => $request->nome_mae,
                'nome_pai' => $request->nome_pai,
                'telefone' => $request->telefone,
                'naturalidade' => $request->naturalidade,
                'area_formacao' => $request->area_formacao,
                'n_bilhete' => $request->n_bilhete,
                'id_ano' => $request->id_ano,
                'id_turma' => $request->id_turma,
                'id_classe' => $request->id_classe,
                'id_curso' => $request->id_curso,
                'id_user' => $user->id,
            ]);
        });

        return redirect()->route('admin.alunos')->with('sucesso', 'Matrícula cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $matricula = Matricula::with(['user', 'turma', 'curso', 'classe', 'anolect'])->where('id_user', $id)->first();

        if (!$matricula) {
            return redirect()->route('admin.alunos')->with('erro', 'Aluno não encontrado.');
        }

        $this->authorize('view', $matricula);

        return view('admin.alunos.show', compact('matricula'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $matricula = Matricula::with(['user', 'turma', 'curso', 'classe', 'anolect'])->findOrFail($id);

        // Verificar se a matrícula tem um usuário válido
        if (!$matricula->user) {
            return redirect()->route('admin.alunos')->with('erro', 'Matrícula inválida: usuário não encontrado.');
        }

        $this->authorize('update', $matricula);
        $cursos = Curso::all();
        $classes = Classe::all();
        $turmas = Turma::all();
        $ano = Ano_lectivo::latest()->first();

        return view('admin.alunos.edit', compact('matricula', 'cursos', 'classes', 'turmas', 'ano'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $matricula = Matricula::where('id_user', $id)->first();
        $this->authorize('update', $matricula);
        $request->validate([
            'nome' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $id],
            'nivel' => ['required'],
            'morada' => ['required'],
            'nascimento' => ['required'],
            'nome_mae' => ['required'],
            'nome_pai' => ['required'],
            'telefone' => ['required'],
            'naturalidade' => ['required'],
            'area_formacao' => ['required'],
            'n_bilhete' => ['required', 'unique:matriculas,n_bilhete,' . $matricula->id],
            'id_ano' => ['required', 'integer', 'exists:ano_lectivos,id'],
            'id_turma' => ['required', 'integer', 'exists:turmas,id'],
            'id_classe' => ['required', 'integer', 'exists:classes,id'],
            'id_curso' => ['required', 'integer', 'exists:cursos,id'],
        ]);

        DB::transaction(function () use ($request, $id) {
            // Buscar o usuário
            $user = User::findOrFail($id);

            // Atualizar imagem se houver nova
            if ($request->hasFile('imagem')) {
                $imagePath = $request->file('imagem')->store('imagens', 'public');
                $user->imagem = $imagePath;
            }

            // Atualizar campos do usuário
            $user->nome = $request->nome;
            $user->email = $request->email;
            $user->nivel = $request->nivel;

            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            $user->save();

            // Atualizar matrícula associada
            $matricula = Matricula::where('id_user', $user->id)->first();

            if ($matricula) {
                $matricula->update([
                    'morada' => $request->morada,
                    'nascimento' => $request->nascimento,
                    'nome_mae' => $request->nome_mae,
                    'nome_pai' => $request->nome_pai,
                    'telefone' => $request->telefone,
                    'naturalidade' => $request->naturalidade,
                    'area_formacao' => $request->area_formacao,
                    'n_bilhete' => $request->n_bilhete,
                    'id_ano' => $request->id_ano,
                    'id_turma' => $request->id_turma,
                    'id_classe' => $request->id_classe,
                    'id_curso' => $request->id_curso,
                ]);
            }
        });

        return redirect()->route('admin.alunos')->with('sucesso', 'Dados do Aluno atualizados com sucesso!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $matricula = Matricula::find($id);
        $this->authorize('delete', $matricula);

        if (!$matricula) {
            return redirect()->back()->with('error', '❌ Matrícula não encontrada no sistema.');
        }

        try {
            // Verificar se há materiais de apoio associados
            $materiaisCount = $matricula->materiaisApoio()->count();
            if ($materiaisCount > 0) {
                return redirect()->back()->with('error', '⚠️ **Não é possível excluir esta matrícula!**<br><br>📚 **Motivo:** Existem <strong>' . $materiaisCount . ' material(is) de apoio</strong> associado(s) a esta matrícula.<br><br>🔧 **Solução:** Primeiro remova os materiais de apoio ou transfira-os para outra matrícula.');
            }

            $matricula->delete();
            return redirect()->route('admin.matriculas')->with('sucesso', '✅ Matrícula excluída com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao deletar matrícula: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }
}
