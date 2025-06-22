@extends('admin.layout')

@section('title', "Editar Usuário")
@section('conteudo')

<div class="row container">
    <div class="col s12">
        <div class="card z-depth-4">
            <div class="card-content">
                <span class="card-title">
                    <a href="{{ route('admin.users') }}" class="btn-floating waves-effect waves-light blue">
                        <i class="material-icons">arrow_back</i>
                    </a>
                    <a href="#" class="btn-floating"><i class="material-icons">edit</i></a> 
                    <span style="font-size: 20pt">Editar Usuário: <span class="red-text">{{$user->nome}}</span></span>
                </span>

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input id="nome" name="nome" type="text" class="validate" value="{{ $user->nome }}" required>
                            <label for="nome">Nome Completo</label>
                            @error('nome')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="email" name="email" type="email" class="validate" value="{{ $user->email }}" required>
                            <label for="email">E-mail</label>
                            @error('email')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <select id="nivel" name="nivel" required>
                                <option value="" disabled>Escolha o nível</option>
                                @if (auth()->user()->nivel === \App\Models\User::NIVEL_DIRETOR_GERAL || auth()->user()->nivel === 'admin')
                                    <option value="{{ \App\Models\User::NIVEL_DIRETOR_GERAL }}" {{ $user->nivel == \App\Models\User::NIVEL_DIRETOR_GERAL ? 'selected' : '' }}>
                                        Diretor Geral
                                    </option>
                                    <option value="{{ \App\Models\User::NIVEL_DIRETOR_PEDAGOGICO }}" {{ $user->nivel == \App\Models\User::NIVEL_DIRETOR_PEDAGOGICO ? 'selected' : '' }}>
                                        Diretor Pedagógico
                                    </option>
                                @endif
                                @if (auth()->user()->nivel === \App\Models\User::NIVEL_DIRETOR_GERAL || auth()->user()->nivel === \App\Models\User::NIVEL_DIRETOR_PEDAGOGICO || auth()->user()->nivel === 'admin')
                                    <option value="{{ \App\Models\User::NIVEL_PROFESSOR }}" {{ $user->nivel == \App\Models\User::NIVEL_PROFESSOR ? 'selected' : '' }}>
                                        Professor
                                    </option>
                                    <option value="{{ \App\Models\User::NIVEL_ALUNO }}" {{ $user->nivel == \App\Models\User::NIVEL_ALUNO ? 'selected' : '' }}>
                                        Aluno
                                    </option>
                                @endif
                            </select>
                            <label for="nivel">Nível de Acesso</label>
                            @error('nivel')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="password" name="password" type="password" class="validate">
                            <label for="password">Nova Senha (deixe em branco para manter a atual)</label>
                            @error('password')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="password_confirmation" name="password_confirmation" type="password" class="validate">
                            <label for="password_confirmation">Confirmar Nova Senha</label>
                            @error('password_confirmation')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>Imagem</span>
                                    <input type="file" name="imagem" accept="image/*">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Escolha uma imagem">
                                </div>
                            </div>
                            <p class="grey-text">Deixe em branco para manter a imagem atual</p>
                            @error('imagem')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col s12 m6">
                            @if($user->imagem)
                                <div class="card-panel">
                                    <h6>Imagem Atual:</h6>
                                    <img src="{{ asset('storage/' . $user->imagem) }}" 
                                         alt="Imagem do usuário" 
                                         style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                                </div>
                            @else
                                <div class="card-panel">
                                    <h6>Sem Imagem:</h6>
                                    <i class="material-icons" style="font-size: 150px; color: #ccc;">account_circle</i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 center">
                            <button type="submit" class="btn waves-effect waves-light blue">
                                <i class="material-icons left">save</i>
                                Atualizar Usuário
                            </button>
                            <a href="{{ route('admin.users') }}" class="btn waves-effect waves-light grey">
                                <i class="material-icons left">cancel</i>
                                Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection 