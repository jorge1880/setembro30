<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Curso;
use App\Models\Turma;
use App\Models\Classe;
use App\Models\Ano_lectivo;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Matricula;
use App\Models\Professor;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('viewAny', User::class);
        // Incluir todos os usuários na lista
        $users = User::all();
        return view('admin.usuarios.index', compact('users'));
    }

    public function admins()
    {
        $this->authorize('viewAny', User::class);
        $users = User::whereIn('nivel', [
            User::NIVEL_DIRETOR_GERAL,
            User::NIVEL_DIRETOR_PEDAGOGICO
        ])->get();
        return view('admin.admins', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nivel' => 'required|string',
            'imagem' => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,avif|max:5120'
        ], [
            'nome.required' => '📝 <b>Campo obrigatório!</b><br><br>🔧 <b>Solução:</b> Digite o nome completo do usuário.',
            'nome.max' => '⚠️ <b>Nome muito longo!</b><br><br>📚 <b>Problema:</b> O nome não pode ter mais de 255 caracteres.<br><br>🔧 <b>Solução:</b> Use um nome mais curto.',
            'email.required' => '📝 <b>Campo obrigatório!</b><br><br>🔧 <b>Solução:</b> Digite o email do usuário.',
            'email.email' => '⚠️ <b>Email inválido!</b><br><br>📚 <b>Problema:</b> O formato do email não é válido.<br><br>🔧 <b>Solução:</b> Digite um email válido (exemplo: usuario@email.com).',
            'email.unique' => '⚠️ <b>Email já cadastrado!</b><br><br>📚 <b>Problema:</b> Este email já está sendo usado por outro usuário.<br><br>🔧 <b>Solução:</b> Use um email diferente ou verifique se o usuário já existe.',
            'password.required' => '📝 <b>Campo obrigatório!</b><br><br>🔧 <b>Solução:</b> Digite uma senha para o usuário.',
            'password.min' => '⚠️ <b>Senha muito curta!</b><br><br>📚 <b>Problema:</b> A senha deve ter pelo menos 8 caracteres.<br><br>🔧 <b>Solução:</b> Use uma senha mais longa com letras, números e símbolos.',
            'nivel.required' => '📝 <b>Campo obrigatório!</b><br><br>🔧 <b>Solução:</b> Selecione o nível de acesso do usuário.',
            'imagem.mimes' => '⚠️ <b>Arquivo inválido!</b><br><br>📚 <b>Problema:</b> O arquivo deve ser uma imagem (JPG, PNG, GIF).<br><br>🔧 <b>Solução:</b> Selecione um arquivo de imagem válido.',
            'imagem.max' => '⚠️ <b>Arquivo muito grande!</b><br><br>📚 <b>Problema:</b> A imagem não pode ter mais de 5MB.<br><br>🔧 <b>Solução:</b> Use uma imagem menor ou comprima o arquivo.',
        ]);

        try {
            $user = new User();
            $user->nome = $validatedData['nome'];
            $user->email = $validatedData['email'];
            $user->password = bcrypt($validatedData['password']);
            $user->nivel = $validatedData['nivel'];

            if ($request->hasFile('imagem')) {
                try {
                    $user->imagem = ImageHelper::uploadImage($request->file('imagem'));
                } catch (\Exception $e) {
                    return redirect()->back()->with(
                        'error',
                        '❌ <b>Erro ao processar imagem!</b><br><br>' .
                            '📚 <b>Problema:</b> ' . $e->getMessage() . '<br><br>' .
                            '🔧 <b>Solução:</b> Tente usar uma imagem diferente ou entre em contato com o suporte.'
                    )->withInput();
                }
            }

            $user->save();

            return redirect()->route('admin.users')->with(
                'sucesso',
                '✅ <b>Usuário criado com sucesso!</b><br><br>' .
                    '📚 <b>O que aconteceu:</b> O usuário "' . $user->nome . '" foi adicionado ao sistema.<br><br>' .
                    '📧 <b>Email:</b> ' . $user->email . '<br>' .
                    '🔐 <b>Próximos passos:</b> O usuário pode fazer login com o email e senha cadastrados.'
            );
        } catch (\Exception $e) {
            \Log::error('Erro ao criar usuário: ' . $e->getMessage());
            return redirect()->back()->with(
                'error',
                '❌ <b>Erro inesperado!</b><br><br>' .
                    '📚 <b>Problema:</b> Ocorreu um erro técnico ao tentar criar o usuário.<br><br>' .
                    '🔧 <b>Solução:</b> Tente novamente em alguns segundos. Se o problema persistir, entre em contato com o suporte técnico.'
            )->withInput();
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('view', $user);
        return view('admin.usuarios.perfil', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        return view('admin.usuarios.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'nivel' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
            'imagem' => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,avif|max:5120'
        ], [
            'nome.required' => '📝 <b>Campo obrigatório!</b><br><br>🔧 <b>Solução:</b> Digite o nome completo do usuário.',
            'nome.max' => '⚠️ <b>Nome muito longo!</b><br><br>📚 <b>Problema:</b> O nome não pode ter mais de 255 caracteres.<br><br>🔧 <b>Solução:</b> Use um nome mais curto.',
            'email.required' => '📝 <b>Campo obrigatório!</b><br><br>🔧 <b>Solução:</b> Digite o email do usuário.',
            'email.email' => '⚠️ <b>Email inválido!</b><br><br>📚 <b>Problema:</b> O formato do email não é válido.<br><br>🔧 <b>Solução:</b> Digite um email válido (exemplo: usuario@email.com).',
            'email.unique' => '⚠️ <b>Email já cadastrado!</b><br><br>📚 <b>Problema:</b> Este email já está sendo usado por outro usuário.<br><br>🔧 <b>Solução:</b> Use um email diferente.',
            'nivel.required' => '📝 <b>Campo obrigatório!</b><br><br>🔧 <b>Solução:</b> Selecione o nível de acesso do usuário.',
            'password.min' => '⚠️ <b>Senha muito curta!</b><br><br>📚 <b>Problema:</b> A senha deve ter pelo menos 8 caracteres.<br><br>🔧 <b>Solução:</b> Use uma senha mais longa com letras, números e símbolos.',
            'password.confirmed' => '⚠️ <b>Senhas não conferem!</b><br><br>📚 <b>Problema:</b> A confirmação da senha não é igual à nova senha.<br><br>🔧 <b>Solução:</b> Verifique se digitou a mesma senha nos dois campos.',
            'imagem.mimes' => '⚠️ <b>Arquivo inválido!</b><br><br>📚 <b>Problema:</b> O arquivo deve ser uma imagem (JPG, PNG, GIF).<br><br>🔧 <b>Solução:</b> Selecione um arquivo de imagem válido.',
            'imagem.max' => '⚠️ <b>Arquivo muito grande!</b><br><br>📚 <b>Problema:</b> A imagem não pode ter mais de 5MB.<br><br>🔧 <b>Solução:</b> Use uma imagem menor ou comprima o arquivo.',
        ]);

        try {
            $user->nome = $validatedData['nome'];
            $user->email = $validatedData['email'];
            $user->nivel = $validatedData['nivel'];

            if (!empty($validatedData['password'])) {
                $user->password = bcrypt($validatedData['password']);
            }

            if ($request->hasFile('imagem')) {
                try {
                    // Deletar imagem antiga se existir
                    if ($user->imagem) {
                        ImageHelper::deleteImage($user->imagem);
                    }

                    $user->imagem = ImageHelper::uploadImage($request->file('imagem'));
                } catch (\Exception $e) {
                    return redirect()->back()->with(
                        'error',
                        '❌ <b>Erro ao processar imagem!</b><br><br>' .
                            '📚 <b>Problema:</b> ' . $e->getMessage() . '<br><br>' .
                            '🔧 <b>Solução:</b> Tente usar uma imagem diferente ou entre em contato com o suporte.'
                    )->withInput();
                }
            }

            $user->save();

            return redirect()->route('admin.users')->with(
                'sucesso',
                '✅ <b>Usuário atualizado com sucesso!</b><br><br>' .
                    '📚 <b>O que aconteceu:</b> As informações do usuário "' . $user->nome . '" foram atualizadas.<br><br>' .
                    '📧 <b>Email atualizado:</b> ' . $user->email
            );
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar usuário: ' . $e->getMessage());
            return redirect()->back()->with(
                'error',
                '❌ <b>Erro inesperado!</b><br><br>' .
                    '📚 <b>Problema:</b> Ocorreu um erro técnico ao tentar atualizar o usuário.<br><br>' .
                    '🔧 <b>Solução:</b> Tente novamente em alguns segundos. Se o problema persistir, entre em contato com o suporte técnico.'
            )->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $this->authorize('delete', $user);

            // Não permitir que um usuário delete a si mesmo
            if (Auth::id() === $user->id) {
                return redirect()->back()->with(
                    'error',
                    '⚠️ <b>Operação não permitida!</b><br><br>' .
                        '📚 <b>Problema:</b> Você não pode excluir sua própria conta de usuário.<br><br>' .
                        '🔧 <b>Solução:</b> Peça a outro administrador para fazer esta operação ou entre em contato com o suporte.'
                );
            }

            // Verificar se há dependências (matrículas, professores, etc.)
            $matriculas = \App\Models\Matricula::where('id_user', $user->id)->count();
            if ($matriculas > 0) {
                return redirect()->back()->with(
                    'error',
                    '⚠️ <b>Não é possível excluir este usuário!</b><br><br>' .
                        '📚 <b>Problema:</b> Este usuário possui <b>' . $matriculas . ' matrícula(s)</b> associada(s). ' .
                        'O sistema não permite excluir um usuário que ainda possui matrículas ativas.<br><br>' .
                        '🔧 <b>Solução:</b> Primeiro você deve:<br>' .
                        '• Remover todas as matrículas deste usuário<br>' .
                        '• Ou transferir as matrículas para outro usuário<br>' .
                        '• Depois tente excluir o usuário novamente.'
                );
            }

            $professores = \App\Models\Professor::where('id_user', $user->id)->count();
            if ($professores > 0) {
                return redirect()->back()->with(
                    'error',
                    '⚠️ <b>Não é possível excluir este usuário!</b><br><br>' .
                        '📚 <b>Problema:</b> Este usuário está associado a <b>' . $professores . ' perfil(is) de professor</b>. ' .
                        'O sistema não permite excluir um usuário que ainda possui perfis de professor ativos.<br><br>' .
                        '🔧 <b>Solução:</b> Primeiro você deve:<br>' .
                        '• Remover o perfil de professor deste usuário<br>' .
                        '• Ou transferir o perfil para outro usuário<br>' .
                        '• Depois tente excluir o usuário novamente.'
                );
            }

            // Deletar imagem se existir
            if ($user->imagem) {
                try {
                    ImageHelper::deleteImage($user->imagem);
                } catch (\Exception $e) {
                    \Log::warning('Erro ao deletar imagem do usuário: ' . $e->getMessage());
                }
            }

            $nomeUsuario = $user->nome;
            $user->delete();

            return redirect()->route('admin.users')->with(
                'sucesso',
                '✅ <b>Usuário excluído com sucesso!</b><br><br>' .
                    '📚 <b>O que aconteceu:</b> O usuário "' . $nomeUsuario . '" foi removido permanentemente do sistema.'
            );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with(
                'error',
                '❌ <b>Usuário não encontrado!</b><br><br>' .
                    '📚 <b>Problema:</b> O usuário que você está tentando excluir não existe no sistema.<br><br>' .
                    '🔧 <b>Solução:</b> Atualize a página e tente novamente.'
            );
        } catch (\Exception $e) {
            \Log::error('Erro ao deletar usuário: ' . $e->getMessage());
            return redirect()->back()->with(
                'error',
                '❌ <b>Erro inesperado!</b><br><br>' .
                    '📚 <b>Problema:</b> Ocorreu um erro técnico ao tentar excluir o usuário.<br><br>' .
                    '🔧 <b>Solução:</b> Tente novamente em alguns segundos. Se o problema persistir, entre em contato com o suporte técnico.'
            );
        }
    }

    public function changePassword(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $this->authorize('changePassword', $user);

            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|string|min:8',
                'confirm_password' => 'required|same:new_password',
            ], [
                'current_password.required' => '📝 <b>Campo obrigatório!</b><br><br>🔧 <b>Solução:</b> Digite sua senha atual para confirmar sua identidade.',
                'new_password.required' => '📝 <b>Campo obrigatório!</b><br><br>🔧 <b>Solução:</b> Digite a nova senha que deseja usar.',
                'new_password.min' => '⚠️ <b>Senha muito curta!</b><br><br>📚 <b>Motivo:</b> A nova senha deve ter pelo menos 8 caracteres.<br><br>🔧 <b>Solução:</b> Use uma senha mais longa com letras, números e símbolos.',
                'confirm_password.required' => '📝 <b>Campo obrigatório!</b><br><br>🔧 <b>Solução:</b> Confirme a nova senha digitando-a novamente.',
                'confirm_password.same' => '⚠️ <b>Senhas não conferem!</b><br><br>📚 <b>Motivo:</b> A confirmação da senha não é igual à nova senha.<br><br>🔧 <b>Solução:</b> Verifique se digitou a mesma senha nos dois campos.',
            ]);

            // Verificar se a senha atual está correta
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors([
                    'current_password' =>
                    '❌ <b>Senha atual incorreta!</b><br><br>' .
                        '📚 <b>Motivo:</b> A senha atual que você digitou não está correta.<br><br>' .
                        '🔍 <b>Possíveis causas:</b><br>' .
                        '• Você digitou a senha errada<br>' .
                        '• A tecla Caps Lock está ativada<br>' .
                        '• Você esqueceu a senha atual<br><br>' .
                        '🔧 <b>Solução:</b><br>' .
                        '1. Verifique se digitou a senha corretamente<br>' .
                        '2. Verifique se a tecla Caps Lock está desativada<br>' .
                        '3. Se esqueceu a senha, use "Esqueci minha senha"<br>' .
                        '4. Ou peça ao administrador para redefinir sua senha'
                ]);
            }

            // Atualizar a senha
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->back()->with(
                'success',
                '✅ <b>Senha alterada com sucesso!</b><br><br>' .
                    '📚 <b>O que aconteceu:</b> Sua senha foi atualizada no sistema.<br><br>' .
                    '🔍 <b>Detalhes:</b><br>' .
                    '• Usuário: ' . $user->nome . '<br>' .
                    '• Email: ' . $user->email . '<br>' .
                    '• Data: ' . now()->format('d/m/Y H:i') . '<br><br>' .
                    '🔐 <b>Próximos passos:</b><br>' .
                    '1. Use sua nova senha para fazer login<br>' .
                    '2. Mantenha sua senha segura<br>' .
                    '3. Não compartilhe sua senha com ninguém'
            );
        } catch (\Exception $e) {
            \Log::error('Erro ao alterar senha: ' . $e->getMessage());
            return redirect()->back()->with(
                'error',
                '❌ <b>Erro ao alterar senha!</b><br><br>' .
                    '📚 <b>Motivo:</b> ' . $e->getMessage() . '<br><br>' .
                    '🔧 <b>Solução:</b> Tente novamente ou entre em contato com o suporte.'
            );
        }
    }

    /**
     * Mostra o perfil pessoal do usuário logado
     */
    public function profile()
    {
        $user = auth()->user();

        // Se for aluno, buscar a matrícula
        if ($user->nivel === User::NIVEL_ALUNO) {
            $matricula = Matricula::with(['turma', 'curso', 'classe', 'anolect'])->where('id_user', $user->id)->first();
            return view('admin.profile', compact('user', 'matricula'));
        }

        // Se for professor, buscar o professor
        if ($user->nivel === User::NIVEL_PROFESSOR) {
            $professor = Professor::where('id_user', $user->id)->first();
            return view('admin.profile', compact('user', 'professor'));
        }

        // Para outros tipos de usuário
        return view('admin.profile', compact('user'));
    }

    /**
     * Atualiza o perfil pessoal do usuário logado
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $this->authorize('updateProfile', $user);

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'imagem' => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,avif|max:5120'
        ]);

        $user->nome = $request->nome;
        $user->email = $request->email;

        if ($request->hasFile('imagem')) {
            try {
                // Deletar imagem antiga se existir
                if ($user->imagem) {
                    ImageHelper::deleteImage($user->imagem);
                }

                $user->imagem = ImageHelper::uploadImage($request->file('imagem'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage())->withInput();
            }
        }

        $user->save();

        return redirect()->back()->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Altera a senha do usuário logado
     */
    public function changePasswordProfile(Request $request)
    {
        try {
            $user = auth()->user();
            $this->authorize('changePassword', $user);

            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|string|min:8',
                'confirm_password' => 'required|same:new_password',
            ], [
                'current_password.required' => '🔑 A senha atual é obrigatória.',
                'new_password.required' => '🔑 A nova senha é obrigatória.',
                'new_password.min' => '🔑 A nova senha deve ter pelo menos 8 caracteres.',
                'confirm_password.required' => '🔑 A confirmação da senha é obrigatória.',
                'confirm_password.same' => '🔑 A confirmação da senha não confere.',
            ]);

            // Verificar se a senha atual está correta
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => '❌ **Senha atual incorreta!**<br><br>🔧 **Solução:** Verifique se digitou a senha corretamente.']);
            }

            // Atualizar a senha
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->back()->with('success', '✅ **Senha alterada com sucesso!**<br><br>🔐 Sua nova senha já está ativa.');
        } catch (\Exception $e) {
            \Log::error('Erro ao alterar senha do perfil: ' . $e->getMessage());
            return redirect()->back()->with('error', '❌ **Erro inesperado!**<br><br>🔧 **Solução:** Tente novamente ou entre em contato com o suporte técnico.');
        }
    }
}
