<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;

class AulaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Aula::class);
        $user = auth()->user();
        
        $aulasQuery = Aula::with(['turma', 'disciplina', 'professor']);

        if ($user->nivel === 'aluno') {
            // Aluno: vê apenas aulas da sua turma
            $matricula = $user->matricula;
            if ($matricula && $matricula->id_turma) {
                $aulasQuery->where('id_turma', $matricula->id_turma);
            } else {
                // Aluno sem turma não vê nenhuma aula
                $aulasQuery->whereRaw('1 = 0'); 
            }
        } elseif ($user->nivel === 'professor') {
            // Professor: vê apenas as aulas que ele criou
            $aulasQuery->where('id_user', $user->id);
        }
        // Diretores e Admins: Nenhuma restrição adicional, eles veem tudo.

        $aulas = $aulasQuery->latest()->paginate(10);
        
        return view('admin.aulas', compact('aulas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Aula::class);
        $cursos = Curso::all();  
        $disciplinas = Disciplina::all();  
        $turmas = Turma::all();  
        return view('admin.aulas.create', compact('cursos','disciplinas','turmas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Aula::class);
        $aula = $request->validate([
            'titulo'=>['required'],
            'descricao'=>['required'],
            'data'=>['required'],
            'hora_inicio'=>['required'],
            'hora_fim'=>['required'],
            'id_disciplina'=>['required'],
            'id_user'=>['required'],
        ],
        [
            'titulo.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite o título da aula.',
            'descricao.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite a descrição da aula.',
            'data.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Selecione a data da aula.',
            'hora_inicio.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Selecione a hora de início.',
            'hora_fim.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Selecione a hora de fim.',
            'id_disciplina.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Selecione a disciplina.',
            'id_user.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Selecione o professor.',
        ],
    );

    try {
        Aula::create($aula);
        return redirect()->route('admin.aulas')->with('sucesso', '✅ **Aula cadastrada com sucesso!**<br><br>📚 A aula foi adicionada ao sistema.');
    } catch (QueryException $e) {
        if ($e->getCode() == 23000) {
            return redirect()->back()->withErrors(['error' => '⚠️ **Aula já existe!**<br><br>📚 **Problema:** Já existe uma aula com estas informações.<br><br>🔧 **Solução:** Verifique os dados e tente novamente.']);
        }
        return redirect()->back()->withErrors(['error' => '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.']);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aula  $aula
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aula = Aula::findOrFail($id);
        $materiais = $aula->materiaisApoio()->latest()->get();
        return view('admin.aulas.unica-aula', compact('aula', 'materiais'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aula  $aula
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aula = Aula::findOrFail($id);
        $this->authorize('update', $aula);
        
        $cursos = Curso::all();  
        $disciplinas = Disciplina::all();  
        $turmas = Turma::all();  

        return view('admin.aulas.edit', compact('aula', 'cursos', 'disciplinas', 'turmas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aula  $aula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $aula = Aula::findOrFail($id);
        $this->authorize('update', $aula);
        
        $request->validate([
            'descricao' => ['required'],
            'conteudo' => ['required'],
            'id_curso' => ['required', 'exists:cursos,id'],
            'id_disciplina' => ['required', 'exists:disciplinas,id'],
            'id_turma' => ['required', 'exists:turmas,id'],
        ], [
            'descricao.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite a descrição da aula.',
            'conteudo.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite o conteúdo da aula.',
            'id_curso.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Selecione o curso.',
            'id_curso.exists' => '⚠️ **Curso inválido!**<br><br>🔧 **Solução:** Selecione um curso válido.',
            'id_disciplina.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Selecione a disciplina.',
            'id_disciplina.exists' => '⚠️ **Disciplina inválida!**<br><br>🔧 **Solução:** Selecione uma disciplina válida.',
            'id_turma.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Selecione a turma.',
            'id_turma.exists' => '⚠️ **Turma inválida!**<br><br>🔧 **Solução:** Selecione uma turma válida.',
        ]);

        try {
            $aula->update([
                'descricao' => $request->descricao,
                'conteudo' => $request->conteudo,
                'id_curso' => $request->id_curso,
                'id_disciplina' => $request->id_disciplina,
                'id_turma' => $request->id_turma,
            ]);
            
            return redirect()->route('admin.aulas')->with('sucesso', '✅ **Aula atualizada com sucesso!**<br><br>📚 As informações da aula foram modificadas.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aula  $aula
     * @return \Illuminate\Http\Response
     */
   public function destroy($id){
    
    $aula = Aula::find($id);
    $this->authorize('delete', $aula);

    if (!$aula) {
        return redirect()->back()->with('error', '❌ Aula não encontrada no sistema.');
    }

    // Verificar se existem materiais de apoio associados
    $materiaisCount = $aula->materiaisApoio()->count();
    
    if ($materiaisCount > 0) {
        return redirect()->back()->with('error', '⚠️ **Não é possível excluir esta aula!**<br><br>📚 **Motivo:** Existem <strong>' . $materiaisCount . ' material(is) de apoio</strong> associado(s) a esta aula.<br><br>🔧 **Solução:** Primeiro remova os materiais de apoio ou transfira-os para outra aula.');
    }

    try {
        $aula->delete();
        return redirect()->route('admin.aulas')->with('sucesso', '✅ Aula excluída com sucesso!');
    } catch (QueryException $e) {
        if ($e->getCode() == 23000) {
            return redirect()->back()->with('error', '⚠️ **Erro de integridade do banco de dados!**<br><br>📚 **Motivo:** Esta aula possui registros relacionados que impedem sua exclusão.<br><br>🔧 **Solução:** Entre em contato com o administrador do sistema.');
        }
        return redirect()->back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
    }
}

    public function adicionarMaterial(Request $request, $aulaId)
    {
        $aula = Aula::findOrFail($aulaId);
        $user = auth()->user();
        // Apenas professores da turma podem adicionar
        if ($user->nivel !== 'professor' || $aula->id_user != $user->id) {
            abort(403, 'Apenas o professor responsável pode adicionar materiais.');
        }
        $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|in:arquivo,link',
            'arquivo' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip',
            'link' => 'nullable|url',
            'descricao' => 'nullable|string|max:500',
        ]);
        $material = new \App\Models\MaterialApoio();
        $material->aula_id = $aula->id;
        $material->professor_id = $user->professor->id ?? null;
        $material->titulo = $request->titulo;
        $material->tipo = $request->tipo;
        $material->descricao = $request->descricao;
        if ($request->tipo === 'arquivo' && $request->hasFile('arquivo')) {
            $material->arquivo = $request->file('arquivo')->store('materiais', 'public');
        }
        if ($request->tipo === 'link') {
            $material->link = $request->link;
        }
        $material->save();
        return back()->with('success', 'Material de apoio adicionado!');
    }

    public function removerMaterial($aulaId, $materialId)
    {
        $aula = \App\Models\Aula::findOrFail($aulaId);
        $user = auth()->user();
        $material = $aula->materiaisApoio()->findOrFail($materialId);
        if ($user->nivel !== 'professor' || $aula->id_user != $user->id) {
            abort(403, 'Apenas o professor responsável pode remover materiais.');
        }
        // Remove arquivo do storage se for arquivo
        if ($material->tipo === 'arquivo' && $material->arquivo) {
            \Storage::disk('public')->delete($material->arquivo);
        }
        $material->delete();
        return back()->with('success', 'Material removido com sucesso!');
    }

    public function editarMaterial(Request $request, $aulaId, $materialId)
    {
        $aula = \App\Models\Aula::findOrFail($aulaId);
        $user = auth()->user();
        $material = $aula->materiaisApoio()->findOrFail($materialId);
        if ($user->nivel !== 'professor' || $aula->id_user != $user->id) {
            abort(403, 'Apenas o professor responsável pode editar materiais.');
        }
        $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|in:arquivo,link',
            'arquivo' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip',
            'link' => 'nullable|url',
            'descricao' => 'nullable|string|max:500',
        ]);
        $material->titulo = $request->titulo;
        $material->tipo = $request->tipo;
        $material->descricao = $request->descricao;
        if ($request->tipo === 'arquivo' && $request->hasFile('arquivo')) {
            // Remove arquivo antigo
            if ($material->arquivo) {
                \Storage::disk('public')->delete($material->arquivo);
            }
            $material->arquivo = $request->file('arquivo')->store('materiais', 'public');
            $material->link = null;
        }
        if ($request->tipo === 'link') {
            $material->link = $request->link;
            if ($material->arquivo) {
                \Storage::disk('public')->delete($material->arquivo);
            }
            $material->arquivo = null;
        }
        $material->save();
        return back()->with('success', 'Material editado com sucesso!');
    }

}
