<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
   

    public function __construct(){
        $this->middleware('auth');
         
    }

    public function index()
    {
        //
       // $cursos = Curso::all();
        $cursos = Curso::paginate(5);
        $this->authorize('viewAny', Curso::class);
        return view("admin.cursos", compact('cursos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $this->authorize('create', Curso::class);
        return view('admin.cursos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $curso = $request->validate([
            'nome'=>['required'],
            'descricao'=>['required'],
        ],
        [
            'nome.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite o nome do curso.',
            'descricao.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite a descrição do curso.',
        ]);

       $this->authorize('create',Curso::class);
       try {
            Curso::create($curso);
            return redirect()->route('admin.cursos')->with('sucesso', '✅ **Curso cadastrado com sucesso!**<br><br>📚 O curso foi adicionado ao sistema.');

       } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->back()->withErrors(['nome'=>'⚠️ **Curso já existe!**<br><br>📚 **Problema:** Já existe um curso com este nome.<br><br>🔧 **Solução:** Use um nome diferente para o curso.']);
            }
            return redirect()->back()->withErrors(['error'=>'❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.']);
       }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        $curso = Curso::find($id);
        $this->authorize('edit', $curso);
        return view('admin.cursos.edit',compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dataCurso = $request->validate([
            'nome'=>['required'],
            'descricao'=>['required']
        ],[
            'nome.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite o nome do curso.',
            'descricao.required'=>'📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite a descrição do curso.',
        ],
    );


        $curso = Curso::find($id);

        if (!$curso) {
            return redirect()->back()->with('error', '❌ **Curso não encontrado!**<br><br>🔧 **Solução:** O curso pode ter sido removido por outro usuário.');
        }

        $this->authorize('update',$curso);
        try {
            $curso->update($dataCurso);
           return redirect()->route('admin.cursos')->with('sucesso', '✅ **Curso atualizado com sucesso!**<br><br>📚 As informações do curso foram modificadas.');
    
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->back()->withErrors(['nome'=> '⚠️ **Curso já existe!**<br><br>📚 **Problema:** Já existe um curso com este nome.<br><br>🔧 **Solução:** Use um nome diferente para o curso.']);
            }
            return redirect()->back()->withErrors(['error'=> '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.']);
        }
    }
        

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $curso = Curso::findOrFail($id);
            $this->authorize('delete', $curso);
            
            // Verificar dependências diretas apenas
            $dependencias = [];
            
            // 1. Verificar matrículas
            $matriculas = \App\Models\Matricula::where('id_curso', $curso->id)->count();
            if ($matriculas > 0) {
                $dependencias[] = $matriculas . ' matrícula(s)';
            }
            
            // 2. Verificar aulas diretas
            $aulasDiretas = \App\Models\Aula::where('id_curso', $curso->id)->count();
            if ($aulasDiretas > 0) {
                $dependencias[] = $aulasDiretas . ' aula(s)';
            }
            
            // Se há dependências, mostrar erro
            if (!empty($dependencias)) {
                $mensagem = '⚠️ <b>Não é possível excluir este curso!</b><br><br>';
                $mensagem .= '📚 <b>Dependências encontradas:</b><br>';
                $mensagem .= '• ' . implode('<br>• ', $dependencias) . '<br><br>';
                $mensagem .= '🔧 <b>Para resolver:</b> Remova todas as dependências primeiro.';
                
                return redirect()->back()->with('error', $mensagem);
            }
            
            // Se não há dependências, excluir
            $nomeCurso = $curso->nome;
            $curso->delete();
            
            return redirect()->route('admin.cursos')->with('sucesso', 
                '✅ <b>Curso excluído com sucesso!</b><br><br>' .
                '📚 O curso "' . $nomeCurso . '" foi removido do sistema.'
            );
            
        } catch (\Exception $e) {
            \Log::error('Erro ao deletar curso: ' . $e->getMessage());
            return redirect()->back()->with('error', 
                '❌ <b>Erro ao excluir curso!</b><br><br>' .
                '📚 <b>Erro:</b> ' . $e->getMessage() . '<br><br>' .
                '🔧 <b>Solução:</b> Entre em contato com o suporte técnico.'
            );
        }
    }
}
