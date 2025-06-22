@extends('admin.layout')

@section('title', "Visualizar Professor")
@section('conteudo')

<div class="row container">
    <div class="col s12">
        <div class="card z-depth-4">
            <div class="card-content">
                <span class="card-title">
                    <a href="{{ route('admin.professores') }}" class="btn-floating waves-effect waves-light blue">
                        <i class="material-icons">arrow_back</i>
                    </a>
                    <a href="#" class="btn-floating"><i class="material-icons">visibility</i></a> 
                    <span style="font-size: 20pt">Perfil do Professor: <span class="red-text">{{$professor->user->nome}}</span></span>
                </span>

                <div class="row">
                    <div class="col s12 m4 center">
                        @if($professor->user->imagem && \App\Helpers\ImageHelper::imageExists($professor->user->imagem))
                            <img src="{{ \App\Helpers\ImageHelper::getImageUrl($professor->user->imagem, 'img/profileestude.webp') }}" 
                                 alt="Foto do professor" 
                                 style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: 3px solid #26a69a; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        @else
                            <i class="material-icons" style="font-size: 200px; color: #ccc;">account_circle</i>
                        @endif
                    </div>
                    
                    <div class="col s12 m8">
                        <div class="row">
                            <div class="col s12 m6">
                                <h6><strong>Nome Completo:</strong></h6>
                                <p>{{ $professor->user->nome }}</p>
                            </div>
                            
                            <div class="col s12 m6">
                                <h6><strong>E-mail:</strong></h6>
                                <p>{{ $professor->user->email }}</p>
                            </div>
                            
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
                            
                            <div class="col s12 m6">
                                <h6><strong>Data de Registro:</strong></h6>
                                <p>{{ $professor->user->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 center">
                        @can('update', $professor)
                        <a href="{{ route('admin.professor.edit', $professor->id) }}" class="btn waves-effect waves-light orange">
                            <i class="material-icons left">edit</i>
                            Editar Professor
                        </a>
                        @endcan
                        <a href="{{ route('admin.professores') }}" class="btn waves-effect waves-light blue">
                            <i class="material-icons left">arrow_back</i>
                            Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card para Alterar Senha -->
        <div class="card z-depth-4">
            <div class="card-content">
                <span class="card-title">Alterar Senha</span>
                <form action="{{ route('admin.users.change-password', $professor->user->id) }}" method="POST">
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

@endsection 