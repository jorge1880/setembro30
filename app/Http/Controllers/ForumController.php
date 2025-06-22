<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use App\Models\Forum;
use App\Models\Comentario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Filtros: turma, status
        $turmaId = $request->input('turma_id');
        $status = $request->input('status');
        $query = Forum::query();
        if ($turmaId) {
            $query->whereHas('turmas', function($q) use ($turmaId) {
                $q->where('turma_id', $turmaId);
            });
        }
        if ($status) {
            $query->where('status', $status);
        }
        // Aluno só vê fóruns das suas turmas
        if (Auth::user()->nivel === User::NIVEL_ALUNO) {
            $turmasAluno = Auth::user()->matricula ? [Auth::user()->matricula->id_turma] : [];
            $query->whereHas('turmas', function($q) use ($turmasAluno) {
                $q->whereIn('turma_id', $turmasAluno);
            });
        }
        $forums = $query->with('turmas')->orderByDesc('created_at')->paginate(10);
        $turmas = Turma::all();
        return view('forums.index', compact('forums', 'turmas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Forum::class);
        $turmas = Turma::all();
        return view('forums.create', compact('turmas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Forum::class);
        $request->validate([
            'titulo' => 'required',
            'descricao' => 'required',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'turmas' => 'required|array',
        ], [
            'titulo.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite o título do fórum.',
            'descricao.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite a descrição do fórum.',
            'data_inicio.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Selecione a data de início.',
            'data_inicio.date' => '⚠️ **Data inválida!**<br><br>🔧 **Solução:** Selecione uma data válida.',
            'data_fim.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Selecione a data de fim.',
            'data_fim.date' => '⚠️ **Data inválida!**<br><br>🔧 **Solução:** Selecione uma data válida.',
            'data_fim.after_or_equal' => '⚠️ **Data de fim inválida!**<br><br>🔧 **Solução:** A data de fim deve ser igual ou posterior à data de início.',
            'turmas.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Selecione pelo menos uma turma.',
            'turmas.array' => '⚠️ **Seleção inválida!**<br><br>🔧 **Solução:** Selecione as turmas corretamente.',
        ]);
        
        try {
            $forum = Forum::create([
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'user_id' => Auth::id(),
                'data_inicio' => $request->data_inicio,
                'data_fim' => $request->data_fim,
                'status' => 'novo',
            ]);
            $forum->turmas()->sync($request->turmas);
            // Notificar alunos das turmas (implementação futura)
            return redirect()->route('admin.forums')->with('success', '✅ **Fórum criado com sucesso!**<br><br>📚 O fórum foi adicionado ao sistema.');
        } catch (\Exception $e) {
            \Log::error('Erro ao criar fórum: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $forum = Forum::with(['turmas', 'comentarios.user'])->findOrFail($id);
        // Aluno só pode ver se for da turma
        if (Auth::user()->nivel === User::NIVEL_ALUNO) {
            $turmasAluno = Auth::user()->matricula ? [Auth::user()->matricula->id_turma] : [];
            if (!$forum->turmas->pluck('id')->intersect($turmasAluno)->count()) {
                abort(403, 'Acesso não autorizado');
            }
        }
        return view('forums.show', compact('forum'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $forum = Forum::findOrFail($id);
            $this->authorize('update', $forum);
            
            $turmas = Turma::all();
            return view('forums.edit', compact('forum', 'turmas'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Fórum não encontrado.');
        } catch (\Exception $e) {
            \Log::error('Erro ao editar fórum: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao carregar o fórum para edição.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $forum = Forum::findOrFail($id);
            $this->authorize('update', $forum);
            
            $request->validate([
                'titulo' => 'required',
                'descricao' => 'required',
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date|after_or_equal:data_inicio',
                'turmas' => 'required|array',
            ], [
                'titulo.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite o título do fórum.',
                'descricao.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite a descrição do fórum.',
                'data_inicio.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Selecione a data de início.',
                'data_inicio.date' => '⚠️ **Data inválida!**<br><br>🔧 **Solução:** Selecione uma data válida.',
                'data_fim.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Selecione a data de fim.',
                'data_fim.date' => '⚠️ **Data inválida!**<br><br>🔧 **Solução:** Selecione uma data válida.',
                'data_fim.after_or_equal' => '⚠️ **Data de fim inválida!**<br><br>🔧 **Solução:** A data de fim deve ser igual ou posterior à data de início.',
                'turmas.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Selecione pelo menos uma turma.',
                'turmas.array' => '⚠️ **Seleção inválida!**<br><br>🔧 **Solução:** Selecione as turmas corretamente.',
            ]);
            
            $forum->update([
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'data_inicio' => $request->data_inicio,
                'data_fim' => $request->data_fim,
            ]);
            
            $forum->turmas()->sync($request->turmas);
            
            return redirect()->route('admin.forums')->with('success', '✅ **Fórum atualizado com sucesso!**<br><br>📚 As informações do fórum foram modificadas.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', '❌ **Fórum não encontrado!**<br><br>🔧 **Solução:** O fórum pode ter sido removido por outro usuário.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar fórum: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $forum = Forum::find($id);
        $this->authorize('delete', $forum);

        if (!$forum) {
            return redirect()->back()->with('error', '❌ Fórum não encontrado no sistema.');
        }

        // Verificar se existem comentários associados
        $comentariosCount = $forum->comentarios()->count();
        
        if ($comentariosCount > 0) {
            return redirect()->back()->with('error', '⚠️ **Não é possível excluir este fórum!**<br><br>📚 **Motivo:** Existem <strong>' . $comentariosCount . ' comentário(s)</strong> associado(s) a este fórum.<br><br>🔧 **Solução:** Primeiro remova os comentários ou transfira-os para outro fórum.');
        }

        try {
            // Remover associações com turmas
            $forum->turmas()->detach();
            
            $forum->delete();
            return redirect()->route('admin.forums')->with('success', '✅ Fórum excluído com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao deletar fórum: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }

    public function responder(Request $request, $id)
    {
        $forum = Forum::findOrFail($id);
        $user = auth()->user();

        $isAluno = $user->nivel === \App\Models\User::NIVEL_ALUNO && $forum->turmas->pluck('id')->contains(optional($user->matricula)->id_turma);
        $isProfessor = $user->nivel === \App\Models\User::NIVEL_PROFESSOR && $user->professor && $forum->turmas->pluck('id')->intersect($user->professor->turmas->pluck('id'))->count() > 0;
        $isDiretor = in_array($user->nivel, [User::NIVEL_DIRETOR_GERAL, User::NIVEL_DIRETOR_PEDAGOGICO]);

        if (!$isAluno && !$isProfessor && !$isDiretor) {
            abort(403, '❌ **Acesso não autorizado!**<br><br>🔧 **Solução:** Você não tem permissão para responder neste fórum.');
        }

        $request->validate([
            'texto' => 'required',
            'anexo' => 'nullable|file|max:5120',
        ], [
            'texto.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite sua resposta.',
            'anexo.file' => '⚠️ **Arquivo inválido!**<br><br>🔧 **Solução:** Selecione um arquivo válido.',
            'anexo.max' => '⚠️ **Arquivo muito grande!**<br><br>🔧 **Solução:** O arquivo deve ter no máximo 5MB.',
        ]);
        
        try {
            $anexo = null;
            if ($request->hasFile('anexo')) {
                $anexo = $request->file('anexo')->store('anexos', 'public');
            }
            $forum->comentarios()->create([
                'user_id' => $user->id,
                'texto' => $request->texto,
                'anexo' => $anexo,
            ]);
            return redirect()->route('forums.show', $forum->id)->with('success', '✅ **Comentário enviado com sucesso!**<br><br>📚 Sua resposta foi publicada no fórum.');
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar comentário: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }

    public function destacarComentario($forumId, $comentarioId)
    {
        try {
            $forum = Forum::findOrFail($forumId);
            $comentario = $forum->comentarios()->findOrFail($comentarioId);
            $this->authorize('moderar', $forum);
            $comentario->destaque = !$comentario->destaque;
            $comentario->save();
            return back()->with('success', '✅ **Comentário destacado/normalizado!**<br><br>📚 O status do comentário foi alterado.');
        } catch (\Exception $e) {
            \Log::error('Erro ao destacar comentário: ' . $e->getMessage());
            return back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }

    public function silenciarComentario($forumId, $comentarioId)
    {
        try {
            $forum = Forum::findOrFail($forumId);
            $comentario = $forum->comentarios()->findOrFail($comentarioId);
            $this->authorize('moderar', $forum);
            $comentario->silenciado = !$comentario->silenciado;
            $comentario->save();
            return back()->with('success', '✅ **Comentário silenciado/ativado!**<br><br>📚 O status do comentário foi alterado.');
        } catch (\Exception $e) {
            \Log::error('Erro ao silenciar comentário: ' . $e->getMessage());
            return back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }

    public function fecharForum($forumId)
    {
        try {
            $forum = Forum::findOrFail($forumId);
            $this->authorize('moderar', $forum);
            $forum->status = 'encerrado';
            $forum->save();
            return back()->with('success', '✅ **Fórum encerrado!**<br><br>📚 O fórum foi fechado para novas respostas.');
        } catch (\Exception $e) {
            \Log::error('Erro ao fechar fórum: ' . $e->getMessage());
            return back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }
}
