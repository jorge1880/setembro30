<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\User;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Turma;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $this->authorize('viewAny', Professor::class);
        // Buscar apenas usuários com nível professor
        $professores = Professor::whereHas('user', function ($query) {
            $query->where('nivel', User::NIVEL_PROFESSOR);
        })->with('user')->get();
        return view('admin.professores', compact('professores'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Professor::class);
        return view('admin.professores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Professor::class);

        // Validação dos dados
        $request->validate([
            'nome' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'morada' => ['required'],
            'telefone' => ['required'],
            'naturalidade' => ['required'],
            'num_agente' => ['required', 'unique:professores,num_agente'],
            'n_bilhete' => ['required', 'unique:professores,n_bilhete'],
            'imagem' => ['nullable', 'mimes:jpg,jpeg,png,gif,webp,bmp,svg,avif', 'max:5120'], // 5MB
        ]);

        // Usar transação para garantir integridade dos dados
        DB::transaction(function () use ($request) {
            $imagePath = null;

            if ($request->hasFile('imagem')) {
                try {
                    $imagePath = ImageHelper::uploadImage($request->file('imagem'));
                } catch (\Exception $e) {
                    throw new \Exception('Erro ao fazer upload da imagem: ' . $e->getMessage());
                }
            }

            // Criar usuário com nível professor
            $user = User::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'nivel' => User::NIVEL_PROFESSOR, // Forçar nível professor
                'password' => bcrypt($request->password),
                'imagem' =>  $imagePath,
            ]);

            // Criar professor associado ao usuário
            Professor::create([
                'morada' => $request->morada,
                'telefone' => $request->telefone,
                'naturalidade' => $request->naturalidade,
                'num_agente' => $request->num_agente,
                'n_bilhete' => $request->n_bilhete,
                'id_user' => $user->id,
            ]);
        });

        return redirect()->route('admin.professores')->with('sucesso', 'Professor cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $professor = Professor::findOrFail($id);
        $this->authorize('view', $professor);
        return view('admin.professores.show', compact('professor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $professor = Professor::findOrFail($id);
        $turmas = Turma::all();
        $turmasProfessor = $professor->turmas->pluck('id')->toArray();
        $this->authorize('update', $professor);
        return view('admin.professores.edit', compact('professor', 'turmas', 'turmasProfessor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $professor = Professor::findOrFail($id);
        $this->authorize('update', $professor);

        $request->validate([
            'nome' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $professor->user->id],
            'morada' => ['required'],
            'telefone' => ['required'],
            'naturalidade' => ['required'],
            'num_agente' => ['required', 'unique:professores,num_agente,' . $professor->id],
            'n_bilhete' => ['required', 'unique:professores,n_bilhete,' . $professor->id],
            'imagem' => ['nullable', 'mimes:jpg,jpeg,png,gif,webp,bmp,svg,avif', 'max:5120'], // 5MB
            'turmas' => ['nullable', 'array'],
            'turmas.*' => ['exists:turmas,id']
        ]);

        DB::transaction(function () use ($request, $professor) {
            // Atualizar usuário
            $professor->user->update([
                'nome' => $request->nome,
                'email' => $request->email,
            ]);

            // Atualizar imagem se fornecida
            if ($request->hasFile('imagem')) {
                try {
                    // Deletar imagem antiga se existir
                    if ($professor->user->imagem) {
                        ImageHelper::deleteImage($professor->user->imagem);
                    }

                    $professor->user->imagem = ImageHelper::uploadImage($request->file('imagem'));
                    $professor->user->save();
                } catch (\Exception $e) {
                    throw new \Exception('Erro ao fazer upload da imagem: ' . $e->getMessage());
                }
            }

            // Atualizar professor
            $professor->update([
                'morada' => $request->morada,
                'telefone' => $request->telefone,
                'naturalidade' => $request->naturalidade,
                'num_agente' => $request->num_agente,
                'n_bilhete' => $request->n_bilhete,
            ]);

            // Sincronizar as turmas
            if ($request->has('turmas')) {
                $professor->turmas()->sync($request->turmas);
            } else {
                $professor->turmas()->detach();
            }
        });

        return redirect()->route('admin.professores')->with('sucesso', 'Professor atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Professor  $professor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $professor = Professor::find($id);
        $this->authorize('delete', $professor);

        if (!$professor) {
            return redirect()->back()->with('error', '❌ Professor não encontrado no sistema.');
        }

        // Verificar se há turmas associadas
        $turmasCount = $professor->turmas()->count();
        if ($turmasCount > 0) {
            return redirect()->back()->with('error', '⚠️ **Não é possível excluir este professor!**<br><br>📚 **Motivo:** Existem <strong>' . $turmasCount . ' turma(s)</strong> associada(s) a este professor.<br><br>🔧 **Solução:** Primeiro remova as associações com as turmas.');
        }

        // Verificar se há disciplinas associadas
        $disciplinasCount = $professor->disciplinas()->count();
        if ($disciplinasCount > 0) {
            return redirect()->back()->with('error', '⚠️ **Não é possível excluir este professor!**<br><br>📚 **Motivo:** Existem <strong>' . $disciplinasCount . ' disciplina(s)</strong> associada(s) a este professor.<br><br>🔧 **Solução:** Primeiro remova as associações com as disciplinas.');
        }

        // Verificar se há materiais de apoio associados
        $materiaisCount = $professor->materiaisApoio()->count();
        if ($materiaisCount > 0) {
            return redirect()->back()->with('error', '⚠️ **Não é possível excluir este professor!**<br><br>📚 **Motivo:** Existem <strong>' . $materiaisCount . ' material(is) de apoio</strong> associado(s) a este professor.<br><br>🔧 **Solução:** Primeiro remova os materiais de apoio ou transfira-os para outro professor.');
        }

        try {
            // Deletar imagem se existir
            if ($professor->imagem) {
                ImageHelper::deleteImage($professor->imagem);
            }

            // Deletar usuário associado
            if ($professor->user) {
                if ($professor->user->imagem) {
                    ImageHelper::deleteImage($professor->user->imagem);
                }
                $professor->user->delete();
            }

            $professor->delete();
            return redirect()->route('admin.professores')->with('sucesso', '✅ Professor excluído com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao deletar professor: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }
}
