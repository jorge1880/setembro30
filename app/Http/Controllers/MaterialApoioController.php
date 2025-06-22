<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\MaterialApoio;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Services\MaterialApoioService;
use Illuminate\Support\Facades\Gate;

class MaterialApoioController extends Controller
{
    protected $materialApoioService;

    public function __construct(MaterialApoioService $materialApoioService)
    {
        $this->middleware('auth');
        // A autorização será feita manualmente nos métodos que precisam
        $this->materialApoioService = $materialApoioService;
    }

    // Exibe a página de gerenciamento de materiais para o professor
    public function index()
    {
        $user = auth()->user();
        
        // Verificar se o usuário é um professor
        if ($user->nivel !== 'professor') {
            return redirect()->route('admin.dashboard')->with('error', '❌ **Acesso negado!**<br><br>📚 **Problema:** Apenas professores podem acessar esta página.<br><br>🔧 **Solução:** Entre em contato com o administrador se você deveria ter acesso.');
        }
        
        // Verificar se existe um registro de professor para este usuário
        $professor = $user->professor;
        if (!$professor) {
            return redirect()->route('admin.dashboard')->with('error', '❌ **Perfil não encontrado!**<br><br>📚 **Problema:** Seu perfil de professor não foi encontrado no sistema.<br><br>🔧 **Solução:** Entre em contato com o administrador para resolver este problema.');
        }
        
        $materiais = $professor->materiais()
            ->with('aula.disciplina')
            ->latest()
            ->paginate(12);

        return view('admin.professores.materiais.index', compact('materiais'));
    }

    // Exibe o formulário para criar um novo material
    public function create()
    {
        $this->authorize('create', MaterialApoio::class);

        // Buscar todas as aulas do sistema, agrupadas por curso e turma
        $aulas = \App\Models\Aula::with('disciplina.curso', 'turma')->get();
        $aulasAgrupadas = $aulas->groupBy(function($aula) {
            $curso = $aula->disciplina->curso->nome_curso ?? 'Outros Cursos';
            $turma = $aula->turma->designacao ?? 'Turma Desconhecida';
            return $curso . ' - ' . $turma;
        });

        return view('admin.professores.materiais.create', compact('aulasAgrupadas'));
    }

    // Armazena um novo material
    public function store(StoreMaterialRequest $request)
    {
        $user = auth()->user();
        
        // Verificar se o usuário é um professor
        if ($user->nivel !== 'professor') {
            return redirect()->route('admin.dashboard')->with('error', '❌ **Acesso negado!**<br><br>📚 **Problema:** Apenas professores podem acessar esta página.<br><br>🔧 **Solução:** Entre em contato com o administrador se você deveria ter acesso.');
        }
        
        // Verificar se existe um registro de professor para este usuário
        $professor = $user->professor;
        if (!$professor) {
            return redirect()->route('admin.dashboard')->with('error', '❌ **Perfil não encontrado!**<br><br>📚 **Problema:** Seu perfil de professor não foi encontrado no sistema.<br><br>🔧 **Solução:** Entre em contato com o administrador para resolver este problema.');
        }
        
        try {
            $this->materialApoioService->store($request->validated(), $professor->id);
            return redirect()->route('professores.materiais.index')->with('success', '✅ **Material adicionado com sucesso!**<br><br>📚 O material foi salvo no sistema.');
        } catch (\Exception $e) {
            \Log::error('Erro ao adicionar material: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }

    // Exibe o formulário para editar um material
    public function edit(MaterialApoio $material)
    {
        $this->authorize('update', $material);

        // Buscar todas as aulas do sistema, agrupadas por curso e turma
        $aulas = \App\Models\Aula::with('disciplina.curso', 'turma')->get();
        $aulasAgrupadas = $aulas->groupBy(function($aula) {
            $curso = $aula->disciplina->curso->nome_curso ?? 'Outros Cursos';
            $turma = $aula->turma->designacao ?? 'Turma Desconhecida';
            return $curso . ' - ' . $turma;
        });

        return view('admin.professores.materiais.create', compact('material', 'aulasAgrupadas'));
    }

    // Atualiza um material
    public function update(UpdateMaterialRequest $request, MaterialApoio $material)
    {
        try {
            $this->materialApoioService->update($request->validated(), $material);
            return redirect()->route('professores.materiais.index')->with('success', '✅ **Material atualizado com sucesso!**<br><br>📚 As informações do material foram modificadas.');
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar material: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }

    // Remove um material
    public function destroy(MaterialApoio $material)
    {
        $this->authorize('delete', $material);

        try {
            $this->materialApoioService->destroy($material);
            return back()->with('success', '✅ **Material removido com sucesso!**<br><br>📚 O material foi excluído do sistema.');
        } catch (\Exception $e) {
            \Log::error('Erro ao remover material: ' . $e->getMessage());
            return back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }
}
