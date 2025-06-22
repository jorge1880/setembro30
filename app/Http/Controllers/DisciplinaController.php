<?php

namespace App\Http\Controllers;

use App\Models\Disciplina;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class DisciplinaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    
     */

        public function __construct(){
        $this->middleware('auth');
         
       }

    public function index()
    {
        $this->authorize('viewAny', Disciplina::class);
        $disciplinas = Disciplina::paginate(10);
        return view('admin.disciplinas', compact('disciplinas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Disciplina::class);
        return view('admin.disciplinas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->authorize('create', Disciplina::class);
      $disciplina = $request->validate([
            'nome_disciplina'=>['required'],
        ],
         [
            'nome_disciplina.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite o nome da disciplina.',
         ],
    );

    try {
        Disciplina::create($disciplina);
        return redirect()->route('admin.disciplinas')->with('sucesso', '✅ **Disciplina cadastrada com sucesso!**<br><br>📚 A disciplina foi adicionada ao sistema.');
    } catch (QueryException $e) {

        if ($e->getCode() == 23000) {
            return redirect()->back()->withErrors(['nome_disciplina' => '⚠️ **Disciplina já existe!**<br><br>📚 **Problema:** Já existe uma disciplina com este nome.<br><br>🔧 **Solução:** Use um nome diferente para a disciplina.']);
        }
        return redirect()->back()->withErrors(['error' => '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.']);
       
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disciplina  $disciplina
     * @return \Illuminate\Http\Response
     */
    public function show(Disciplina $disciplina)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Disciplina  $disciplina
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $disciplina = Disciplina::find($id);
        $this->authorize('update', $disciplina);
        return view('admin.disciplinas.edit', compact('disciplina'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Disciplina  $disciplina
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $disciplinaDB = Disciplina::find($id);
        
        if (!$disciplinaDB) {
            return redirect()->back()->with('error', '❌ **Disciplina não encontrada!**<br><br>🔧 **Solução:** A disciplina pode ter sido removida por outro usuário.');
        }
        
        $this->authorize('update', $disciplinaDB);
         $disciplina = $request->validate([
            'nome_disciplina'=>['required'],
        ],
         [
            'nome_disciplina.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite o nome da disciplina.',
         ],
       );
 

    try {
        $disciplinaDB->update($disciplina);
        return redirect()->route('admin.disciplinas')->with('sucesso', '✅ **Disciplina atualizada com sucesso!**<br><br>📚 As informações da disciplina foram modificadas.');
    } catch (QueryException $e) {

        if ($e->getCode() == 23000) {
            return redirect()->back()->withErrors(['nome_disciplina' => '⚠️ **Disciplina já existe!**<br><br>📚 **Problema:** Já existe uma disciplina com este nome.<br><br>🔧 **Solução:** Use um nome diferente para a disciplina.']);
        }
        return redirect()->back()->withErrors(['error' => '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.']);
       
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disciplina  $disciplina
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $disciplina = Disciplina::find($id);
        $this->authorize('delete', $disciplina);

        if (!$disciplina) {
            return redirect()->back()->with('error', '❌ Disciplina não encontrada no sistema.');
        }

        // Verificar se existem aulas associadas
        $aulasCount = $disciplina->aulas()->count();
        
        if ($aulasCount > 0) {
            return redirect()->back()->with('error', '⚠️ **Não é possível excluir esta disciplina!**<br><br>📚 **Motivo:** Existem <strong>' . $aulasCount . ' aula(s)</strong> associada(s) a esta disciplina.<br><br>🔧 **Solução:** Primeiro remova as aulas ou transfira-as para outra disciplina.');
        }

        // Verificar se há cursos associados
        $cursosCount = $disciplina->cursos()->count();
        if ($cursosCount > 0) {
            return redirect()->back()->with('error', '⚠️ **Não é possível excluir esta disciplina!**<br><br>📚 **Motivo:** Esta disciplina está associada a <strong>' . $cursosCount . ' curso(s)</strong>.<br><br>🔧 **Solução:** Primeiro remova as associações com os cursos.');
        }

        try {
            $disciplina->delete();
            return redirect()->route('admin.disciplinas')->with('sucesso', '✅ Disciplina excluída com sucesso!');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->back()->with('error', '⚠️ **Erro de integridade do banco de dados!**<br><br>📚 **Motivo:** Esta disciplina possui registros relacionados que impedem sua exclusão.<br><br>🔧 **Solução:** Entre em contato com o administrador do sistema.');
            }
            return redirect()->back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }
}
