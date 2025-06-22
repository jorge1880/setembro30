<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Helpers\ImageHelper;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Post::class);
        $posts = Post::paginate(3);
        return view('admin.posts', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        $request->validate([
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required|string',
            'imagem' => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,avif|max:5120',
        ], [
            'titulo.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite o título do post.',
            'titulo.max' => '⚠️ **Título muito longo!**<br><br>🔧 **Solução:** O título deve ter no máximo 255 caracteres.',
            'conteudo.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite o conteúdo do post.',
            'imagem.image' => '⚠️ **Arquivo inválido!**<br><br>🔧 **Solução:** Selecione apenas arquivos de imagem (JPG, PNG, GIF).',
            'imagem.max' => '⚠️ **Arquivo muito grande!**<br><br>🔧 **Solução:** A imagem deve ter no máximo 5MB.',
        ]);

        try {
            $post = new Post();
            $post->titulo = $request->titulo;
            $post->conteudo = $request->conteudo;
            $post->user_id = auth()->id();

            if ($request->hasFile('imagem')) {
                $post->imagem = ImageHelper::uploadImage($request->file('imagem'));
            }

            $post->save();

            return redirect()->route('admin.posts')->with('sucesso', '✅ **Post criado com sucesso!**<br><br>📚 O post foi publicado no sistema.');
        } catch (\Exception $e) {
            \Log::error('Erro ao criar post: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('update', $post);
        return view('admin.posts.edit', compact('post'));
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
        $post = Post::findOrFail($id);
        $this->authorize('update', $post);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required|string',
            'imagem' => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,avif|max:5120',
        ], [
            'titulo.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite o título do post.',
            'titulo.max' => '⚠️ **Título muito longo!**<br><br>🔧 **Solução:** O título deve ter no máximo 255 caracteres.',
            'conteudo.required' => '📝 **Campo obrigatório!**<br><br>🔧 **Solução:** Digite o conteúdo do post.',
            'imagem.image' => '⚠️ **Arquivo inválido!**<br><br>🔧 **Solução:** Selecione apenas arquivos de imagem (JPG, PNG, GIF).',
            'imagem.max' => '⚠️ **Arquivo muito grande!**<br><br>🔧 **Solução:** A imagem deve ter no máximo 5MB.',
        ]);

        try {
            $post->titulo = $request->titulo;
            $post->conteudo = $request->conteudo;

            if ($request->hasFile('imagem')) {
                // Deletar imagem antiga se existir
                if ($post->imagem) {
                    ImageHelper::deleteImage($post->imagem);
                }
                $post->imagem = ImageHelper::uploadImage($request->file('imagem'));
            }

            $post->save();

            return redirect()->route('admin.posts')->with('sucesso', '✅ **Post atualizado com sucesso!**<br><br>📚 As informações do post foram modificadas.');
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar post: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $this->authorize('delete', $post);

        if (!$post) {
            return redirect()->back()->with('error', '❌ Post não encontrado no sistema.');
        }

        try {
            // Verificar se há comentários associados
            $comentariosCount = $post->comentarios()->count();
            if ($comentariosCount > 0) {
                return redirect()->back()->with('error', '⚠️ **Não é possível excluir este post!**<br><br>📚 **Motivo:** Existem <strong>' . $comentariosCount . ' comentário(s)</strong> associado(s) a este post.<br><br>🔧 **Solução:** Primeiro remova os comentários ou transfira-os para outro post.');
            }

            // Deletar imagem se existir
            if ($post->imagem) {
                ImageHelper::deleteImage($post->imagem);
            }

            $post->delete();
            return redirect()->route('admin.posts')->with('sucesso', '✅ Post excluído com sucesso!');
        } catch (\Exception $e) {
            \Log::error('Erro ao deletar post: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }
}
