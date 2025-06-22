<?php

namespace App\Http\Controllers;

use App\Models\Ano_lectivo;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class AnoLectivoController extends Controller
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
        $this->authorize('viewAny', Ano_lectivo::class);
        $anos = Ano_lectivo::paginate(4);
        return view('admin.anos_lectivos', compact('anos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Ano_lectivo::class);
        return view('admin.anoslectivos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Ano_lectivo::class);
        //
        $ano = $request->validate([
            'ano'=>['required'],
        ],[
            'ano.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite o ano lectivo.',
        ]);

        try {
            Ano_lectivo::create($ano);
           return redirect()->route('admin.anos')->with('sucesso','✅ **Ano Lectivo cadastrado com sucesso!**<br><br>📚 O ano lectivo foi adicionado ao sistema.');
        } catch (QueryException $e) {
            if ($e->getCode()==23000) {
                return redirect()->back()->withErrors(['ano'=>'⚠️ **Ano lectivo já existe!**<br><br>📚 **Problema:** Este ano lectivo já está cadastrado no sistema.<br><br>🔧 **Solução:** Use um ano diferente ou verifique se já não foi cadastrado.']); 
             
            }
            return redirect()->back()->withErrors(['error'=>'❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.']); 

        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ano_lectivo  $ano_lectivo
     * @return \Illuminate\Http\Response
     */
    public function show(Ano_lectivo $ano_lectivo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ano_lectivo  $ano_lectivo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ano = Ano_lectivo::find($id);
        $this->authorize('update', $ano);
        return view('admin.anoslectivos.edit', compact('ano'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ano_lectivo  $ano_lectivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $anoDB = Ano_lectivo::find($id);
        
        if (!$anoDB) {
            return redirect()->back()->with('error', '❌ **Ano lectivo não encontrado!**<br><br>🔧 **Solução:** O ano lectivo pode ter sido removido por outro usuário.');
        }
        
        $this->authorize('update', $anoDB);
        //
        $ano = $request->validate([
            'ano'=>['required'],
        ],[
            'ano.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite o ano lectivo.',
        ]);

        try {
            $anoDB->update($ano);
           return redirect()->route('admin.anos')->with('sucesso','✅ **Ano Lectivo atualizado com sucesso!**<br><br>📚 As informações do ano lectivo foram modificadas.');
        } catch (QueryException $e) {
            if ($e->getCode()==23000) {
                return redirect()->back()->withErrors(['ano'=>'⚠️ **Ano lectivo já existe!**<br><br>📚 **Problema:** Este ano lectivo já está cadastrado no sistema.<br><br>🔧 **Solução:** Use um ano diferente ou verifique se já não foi cadastrado.']); 
             
            }
            return redirect()->back()->withErrors(['error'=>'❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.']); 

        }
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ano_lectivo  $ano_lectivo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ano = Ano_lectivo::find($id);
        $this->authorize('delete', $ano);

        if (!$ano) {
            return redirect()->back()->with('error', '❌ Ano lectivo não encontrado no sistema.');
        }

        // Verificar se existem matrículas associadas
        $matriculasCount = $ano->matricuas()->count();
        
        if ($matriculasCount > 0) {
            return redirect()->back()->with('error', '⚠️ **Não é possível excluir este ano lectivo!**<br><br>📚 **Motivo:** Existem <strong>' . $matriculasCount . ' matrícula(s)</strong> associada(s) a este ano lectivo.<br><br>🔧 **Solução:** Primeiro remova as matrículas ou transfira-as para outro ano lectivo.');
        }

        try {
            $ano->delete();
            return redirect()->route('admin.anos')->with('sucesso', '✅ Ano lectivo excluído com sucesso!');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->back()->with('error', '⚠️ **Erro de integridade do banco de dados!**<br><br>📚 **Motivo:** Este ano lectivo possui registros relacionados que impedem sua exclusão.<br><br>🔧 **Solução:** Entre em contato com o administrador do sistema.');
            }
            return redirect()->back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }
}
