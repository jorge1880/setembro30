<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class TurmaController extends Controller
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
        //
      
        $turmas = Turma::paginate(4);
        $this->authorize('viewAny',Turma::class);
        return view('admin.turmas', compact('turmas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $this->authorize('create',Turma::class);
        return view('admin.turmas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $turma = $request->validate([
            'designacao'=>['required'],
        ],
        [ 
            'designacao.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite a designação da turma.',
        ],
    );


     
      try {
        $this->authorize('create',Turma::class);
        Turma::create($turma);
        return redirect()->route('admin.turmas')->with('sucesso', '✅ **Turma cadastrada com sucesso!**<br><br>📚 A turma foi adicionada ao sistema.');
      } catch (QueryException $e) {
        if ($e->getCode() == 23000) {
            return redirect()->back()->withErrors(['designacao'=>'⚠️ **Turma já existe!**<br><br>📚 **Problema:** Já existe uma turma com esta designação.<br><br>🔧 **Solução:** Use uma designação diferente para a turma.']);
        }
        return redirect()->back()->withErrors(['error'=>'❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.']);
       }
   
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function show(Turma $turma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $turma = Turma::find($id);
        $this->authorize('edit',$turma);
        return view('admin.turmas.edit', compact('turma'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $turmaData = $request->validate([
            'designacao'=>['required'],
        ],
        [ 
            'designacao.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite a designação da turma.',
        ],
    );
  
      try {
        $turma = Turma::find($id);
        
        if (!$turma) {
            return redirect()->back()->with('error', '❌ **Turma não encontrada!**<br><br>🔧 **Solução:** A turma pode ter sido removida por outro usuário.');
        }
        
        $this->authorize('update',$turma);
        $turma->update($turmaData);
        return redirect()->route('admin.turmas')->with('sucesso', '✅ **Turma atualizada com sucesso!**<br><br>📚 As informações da turma foram modificadas.');
      } catch (QueryException $e) {
        if ($e->getCode() == 23000) {
            return redirect()->back()->withErrors(['designacao'=>'⚠️ **Turma já existe!**<br><br>📚 **Problema:** Já existe uma turma com esta designação.<br><br>🔧 **Solução:** Use uma designação diferente para a turma.']);
         }
         return redirect()->back()->withErrors(['error'=>'❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.']);
   
     }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Turma  $turma
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $turma = Turma::find($id);
        $this->authorize('delete',$turma);
        
        try {
            // Verificar se há matrículas associadas a esta turma
            $matriculas = \App\Models\Matricula::where('id_turma', $turma->id)->count();
            if ($matriculas > 0) {
                return redirect()->route('admin.turmas')->with('error', '⚠️ **Não é possível excluir esta turma!**<br><br>📚 **Motivo:** Existem <strong>' . $matriculas . ' aluno(s)</strong> matriculado(s) nesta turma.<br><br>🔧 **Solução:** Primeiro remova as matrículas ou transfira os alunos para outra turma.');
            }
            
            // Verificar se há professores associados a esta turma
            $professores = $turma->professores()->count();
            if ($professores > 0) {
                return redirect()->route('admin.turmas')->with('error', '⚠️ **Não é possível excluir esta turma!**<br><br>📚 **Motivo:** Existem <strong>' . $professores . ' professor(es)</strong> associado(s) a esta turma.<br><br>🔧 **Solução:** Primeiro remova as associações com os professores.');
            }
            
            // Verificar se há fóruns associados a esta turma
            $forums = \App\Models\Forum::whereHas('turmas', function($query) use ($turma) {
                $query->where('turma_id', $turma->id);
            })->count();
            if ($forums > 0) {
                return redirect()->route('admin.turmas')->with('error', '⚠️ **Não é possível excluir esta turma!**<br><br>📚 **Motivo:** Existem <strong>' . $forums . ' fórum(s)</strong> associado(s) a esta turma.<br><br>🔧 **Solução:** Primeiro remova os fóruns ou transfira-os para outra turma.');
            }
            
            $turma->delete();
            return redirect()->route('admin.turmas')->with('sucesso', '✅ Turma excluída com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao deletar turma: ' . $e->getMessage());
            return redirect()->route('admin.turmas')->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }
}
