@extends('admin.layout')
@section('title', 'Perfil')
@section('conteudo')

<div class="section">
    <div class="container">
        <div class="row">
            <a href="{{ route('admin.dashboard') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px;">
                <i class="material-icons">arrow_back</i>
            </a>
            <h4 class="left"> <i class="material-icons btn-floating center" style="font-size:25pt">person</i>Perfil do Usuário</h4>
        </div>

        @include('admin.mensagem.mensagem')

        <div class="row">
            <div class="col s12 m4" style="margin-bottom: 20px">
                <div class="card-panel">
                    <div class="center">
                        @if($user)
                            <img src="{{ \App\Helpers\ViewHelper::getUserImageUrl($user) }}" 
                                 style="max-width: 250px; height:250px; border-radius:100%; object-fit: cover; border: 3px solid #26a69a;" 
                                 alt="Foto do usuário">
                            <h5>{{$user->nome}}</h5>
                            <p class="grey-text">{{$user->email}}</p>
                            
                            <div style="margin-top: 20px">
                                @can('update', $user)
                                <a href="{{route('admin.users.edit', $user->id)}}" class="btn orange waves-effect waves-light">
                                    <i class="material-icons left">edit</i>Editar Perfil
                                </a>
                                @endcan
                                
                                @can('delete', $user)
                                <a href="#delete-user" class="btn red modal-trigger waves-effect waves-light">
                                    <i class="material-icons left">delete</i>Eliminar
                                </a>
                                @endcan
                            </div>
                        @else
                            <p class="red-text">Usuário não encontrado!</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col s12 m8">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Informações do Usuário</span>
                        <table class="striped">
                            <tr>
                                <th>Nome Completo</th>
                                <td>{{$user->nome}}</td>
                            </tr>
                            <tr>
                                <th>E-mail</th>
                                <td>{{$user->email}}</td>
                            </tr>
                            <tr>
                                <th>Nível de Acesso</th>
                                <td>
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
                                            <span class="chip grey white-text">Aluno</span>
                                            @break
                                        @default
                                            <span class="chip">{{$user->nivel}}</span>
                                    @endswitch
                                </td>
                            </tr>
                            
                            @if($user->nivel === \App\Models\User::NIVEL_ALUNO && $user->matricula)
                            <tr>
                                <th>Turma</th>
                                <td>{{$user->matricula->turma->designacao ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <th>Ano Lectivo</th>
                                <td>{{$user->matricula->anolect->ano ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <th>Classe</th>
                                <td>{{$user->matricula->classe->designacao ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <th>Curso</th>
                                <td>{{$user->matricula->curso->nome ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <th>Telefone</th>
                                <td>{{$user->matricula->telefone ?? 'N/A'}}</td>
                            </tr>
                            @endif

                            @if($user->nivel === \App\Models\User::NIVEL_PROFESSOR && $user->professor)
                            <tr>
                                <th>Número de Agente</th>
                                <td>{{$user->professor->num_agente ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <th>Telefone</th>
                                <td>{{$user->professor->telefone ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <th>Morada</th>
                                <td>{{$user->professor->morada ?? 'N/A'}}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <!-- Card para Alterar Senha -->
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Alterar Senha</span>
                        <form action="{{ route('admin.users.change-password', $user->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="current_password" name="current_password" type="password" required>
                                    <label for="current_password">Senha Atual</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="new_password" name="new_password" type="password" required>
                                    <label for="new_password">Nova Senha</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="confirm_password" name="confirm_password" type="password" required>
                                    <label for="confirm_password">Confirmar Nova Senha</label>
                                </div>
                                <div class="col s12">
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
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
@can('delete', $user)
<div id="delete-user" class="modal">
    <div class="modal-content">
        <h4>Confirmar Exclusão</h4>
        <p>Tem certeza que deseja excluir o usuário <strong>{{$user->nome}}</strong>?</p>
        <p class="red-text">Esta ação não pode ser desfeita!</p>
    </div>
    <div class="modal-footer">
        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="modal-close waves-effect waves-red btn-flat">Sim, Excluir</button>
        </form>
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
    </div>
</div>
@endcan

@endsection

