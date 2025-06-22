<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ClasseController extends Controller
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
        $this->authorize('viewAny', Classe::class);
        $classes = Classe::paginate(10);
        return view('admin.classes', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Classe::class);
        return view('admin.classes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Classe::class);
        $classe = $request->validate([
            'designacao'=>['required'],
        ],
        [
            'designacao.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite a designação da classe.',
        ],
    );

    try {
        Classe::create($classe);
        return redirect()->route('admin.classes')->with('sucesso', '✅ **Classe cadastrada com sucesso!**<br><br>📚 A classe foi adicionada ao sistema.');
    } catch (QueryException $e) {
        if ($e->getCode() == 23000) {
            return redirect()->back()->withErrors(['designacao' => '⚠️ **Classe já existe!**<br><br>📚 **Problema:** Já existe uma classe com esta designação.<br><br>🔧 **Solução:** Use uma designação diferente para a classe.']);
        }
        return redirect()->back()->withErrors(['error' => '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.']);
    }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function show(Classe $classe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $classe = Classe::find($id);
        $this->authorize('update', $classe);
        return view('admin.classes.edit', compact('classe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $classeDB = Classe::find($id);
        
        if (!$classeDB) {
            return redirect()->back()->with('error', '❌ **Classe não encontrada!**<br><br>🔧 **Solução:** A classe pode ter sido removida por outro usuário.');
        }
        
        $this->authorize('update', $classeDB);
        $classe = $request->validate([
            'designacao'=>['required'],
        ],
        [
            'designacao.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite a designação da classe.',
        ],
    );

    try {
        $classeDB->update($classe);
        return redirect()->route('admin.classes')->with('sucesso', '✅ **Classe atualizada com sucesso!**<br><br>📚 As informações da classe foram modificadas.');
    } catch (QueryException $e) {
        if ($e->getCode() == 23000) {
            return redirect()->back()->withErrors(['designacao' => '⚠️ **Classe já existe!**<br><br>📚 **Problema:** Já existe uma classe com esta designação.<br><br>🔧 **Solução:** Use uma designação diferente para a classe.']);
        }
        return redirect()->back()->withErrors(['error' => '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.']);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response 
     */
    public function destroy($id)
    {
        $classe = Classe::find($id);
        $this->authorize('delete', $classe);

        if (!$classe) {
            return redirect()->back()->with('error', '❌ Classe não encontrada no sistema.');
        }

        // Verificar se existem matrículas associadas
        $matriculasCount = $classe->classes()->count();
        
        if ($matriculasCount > 0) {
            return redirect()->back()->with('error', '⚠️ **Não é possível excluir esta classe!**<br><br>📚 **Motivo:** Existem <strong>' . $matriculasCount . ' aluno(s)</strong> matriculado(s) nesta classe.<br><br>🔧 **Solução:** Primeiro remova as matrículas dos alunos ou transfira-os para outra classe.');
        }

        try {
            $classe->delete();
            return redirect()->route('admin.classes')->with('sucesso', '✅ Classe excluída com sucesso!');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->back()->with('error', '⚠️ **Erro de integridade do banco de dados!**<br><br>📚 **Motivo:** Esta classe possui registros relacionados que impedem sua exclusão.<br><br>🔧 **Solução:** Entre em contato com o administrador do sistema.');
            }
            return redirect()->back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }
}
