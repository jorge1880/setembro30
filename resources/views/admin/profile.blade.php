@extends('admin.layout')

@section('title', "Meu Perfil")
@section('conteudo')

<div class="row container">
    <div class="col s12">
        <div class="card z-depth-4">
            <div class="card-content">
                <span class="card-title">
                    <a href="{{ route('admin.dashboard') }}" class="btn-floating waves-effect waves-light blue">
                        <i class="material-icons">arrow_back</i>
                    </a>
                    <a href="#" class="btn-floating"><i class="material-icons">account_circle</i></a> 
                    <span style="font-size: 20pt">Meu Perfil: <span class="red-text">{{$user->nome}}</span></span>
                </span>

                <div class="row">
                    <div class="col s12 m4 center">
                        @if($user->imagem && \App\Helpers\ImageHelper::imageExists($user->imagem))
                            <img src="{{ \App\Helpers\ImageHelper::getImageUrl($user->imagem, 'img/profileestude.webp') }}" 
                                 alt="Minha foto" 
                                 style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: 3px solid #26a69a; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        @else
                            <i class="material-icons" style="font-size: 200px; color: #ccc;">account_circle</i>
                        @endif
                    </div>
                    
                    <div class="col s12 m8">
                        <div class="row">
                            <div class="col s12 m6">
                                <h6><strong>Nome Completo:</strong></h6>
                                <p>{{ $user->nome }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>E-mail:</strong></h6>
                                <p>{{ $user->email }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>Tipo de Usuário:</strong></h6>
                                <p>
                                    @switch($user->nivel)
                                        @case(\App\Models\User::NIVEL_DIRETOR_GERAL)
                                            <span class="chip blue white-text">Diretor Geral</span>
                                            @break
                                        @case(\App\Models\User::NIVEL_DIRETOR_PEDAGOGICO)
                                            <span class="chip green white-text">Diretor Pedagógico</span>
                                            @break
                                        @case(\App\Models\User::NIVEL_PROFESSOR)
                                            <span class="chip orange white-text">Professor</span>
                                            @break
                                        @case(\App\Models\User::NIVEL_ALUNO)
                                            <span class="chip purple white-text">Aluno</span>
                                            @break
                                        @default
                                            <span class="chip">{{$user->nivel}}</span>
                                    @endswitch
                                </p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>Data de Registro:</strong></h6>
                                <p>{{ $user->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            @if(isset($matricula))
                            <!-- Informações específicas do aluno -->
                            <div class="col s12 m6">
                                <h6><strong>Número do Bilhete:</strong></h6>
                                <p>{{ $matricula->n_bilhete }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>Data de Nascimento:</strong></h6>
                                <p>{{ \Carbon\Carbon::parse($matricula->nascimento)->format('d/m/Y') }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>Morada:</strong></h6>
                                <p>{{ $matricula->morada }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>Telefone:</strong></h6>
                                <p>{{ $matricula->telefone }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>Naturalidade:</strong></h6>
                                <p>{{ $matricula->naturalidade }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>Área de Formação:</strong></h6>
                                <p>{{ $matricula->area_formacao }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>Nome da Mãe:</strong></h6>
                                <p>{{ $matricula->nome_mae }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>Nome do Pai:</strong></h6>
                                <p>{{ $matricula->nome_pai }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>Curso:</strong></h6>
                                <p>{{ $matricula->curso->nome ?? 'N/A' }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>Turma:</strong></h6>
                                <p>{{ $matricula->turma->nome ?? 'N/A' }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>Classe:</strong></h6>
                                <p>{{ $matricula->classe->nome ?? 'N/A' }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>Ano Lectivo:</strong></h6>
                                <p>{{ $matricula->anolect->ano ?? 'N/A' }}</p>
                            </div>
                            @endif

                            @if(isset($professor))
                            <!-- Informações específicas do professor -->
                            <div class="col s12 m6">
                                <h6><strong>Número de Agente:</strong></h6>
                                <p>{{ $professor->num_agente }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>Número do Bilhete:</strong></h6>
                                <p>{{ $professor->n_bilhete }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>Morada:</strong></h6>
                                <p>{{ $professor->morada }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>Telefone:</strong></h6>
                                <p>{{ $professor->telefone }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>Naturalidade:</strong></h6>
                                <p>{{ $professor->naturalidade }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 center">
                        <a href="{{ route('admin.dashboard') }}" class="btn waves-effect waves-light blue">
                            <i class="material-icons left">arrow_back</i>
                            Voltar ao Dashboard
                        </a>
                        <button class="btn waves-effect waves-light green" onclick="toggleEditForm()">
                            <i class="material-icons left">edit</i>
                            Editar Perfil
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card para Editar Perfil (inicialmente oculto) -->
        <div class="card z-depth-4" id="editProfileCard" style="display: none;">
            <div class="card-content">
                <span class="card-title">Editar Meu Perfil</span>
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input id="edit_nome" name="nome" type="text" value="{{ $user->nome }}" required>
                            <label for="edit_nome">Nome Completo</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="edit_email" name="email" type="email" value="{{ $user->email }}" required>
                            <label for="edit_email">E-mail</label>
                        </div>
                        <div class="input-field col s12">
                            <div class="file-field input-field">
                                <div class="btn blue">
                                    <span>Foto</span>
                                    <input type="file" name="imagem" accept="image/*">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Escolha uma nova foto (opcional)">
                                </div>
                            </div>
                        </div>
                        <div class="col s12 center">
                            <button type="submit" class="btn waves-effect waves-light green">
                                <i class="material-icons left">save</i>Salvar Alterações
                            </button>
                            <button type="button" class="btn waves-effect waves-light red" onclick="toggleEditForm()">
                                <i class="material-icons left">close</i>Cancelar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card para Alterar Senha -->
        <div class="card z-depth-4">
            <div class="card-content">
                <span class="card-title">Alterar Minha Senha</span>
                <form action="{{ route('admin.profile.change-password') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <input id="current_password" name="current_password" type="password" required>
                            <label for="current_password">Senha Atual</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input id="new_password" name="new_password" type="password" required>
                            <label for="new_password">Nova Senha</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input id="confirm_password" name="confirm_password" type="password" required>
                            <label for="confirm_password">Confirmar Nova Senha</label>
                        </div>
                        <div class="col s12 center">
                            <button type="submit" class="btn waves-effect waves-light blue">
                                <i class="material-icons left">lock</i>Alterar Senha
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleEditForm() {
    const editCard = document.getElementById('editProfileCard');
    if (editCard.style.display === 'none') {
        editCard.style.display = 'block';
    } else {
        editCard.style.display = 'none';
    }
}
</script>

@endsection 