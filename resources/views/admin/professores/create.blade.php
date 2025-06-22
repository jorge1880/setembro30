@extends('admin.layout')

@section('title', "Criar Professor")
@section('conteudo')

<div class="row container">
    <div class="col s12">
        <div class="card z-depth-4">
            <div class="card-content">
                <span class="card-title">
                    <a href="{{ route('admin.professores') }}" class="btn-floating waves-effect waves-light blue">
                        <i class="material-icons">arrow_back</i>
                    </a>
                    <a href="#" class="btn-floating"><i class="material-icons">add</i></a> 
                    <span style="font-size: 20pt">Criar Novo Professor</span>
                </span>

                <form action="{{ route('admin.professor.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input id="nome" name="nome" type="text" class="validate" value="{{ old('nome') }}" required>
                            <label for="nome">Nome Completo</label>
                            @error('nome')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="email" name="email" type="email" class="validate" value="{{ old('email') }}" required>
                            <label for="email">E-mail</label>
                            @error('email')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="password" name="password" type="password" class="validate" required>
                            <label for="password">Palavra-passe</label>
                            @error('password')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="morada" name="morada" type="text" class="validate" value="{{ old('morada') }}" required>
                            <label for="morada">Morada</label>
                            @error('morada')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="telefone" name="telefone" type="tel" class="validate" value="{{ old('telefone') }}" required>
                            <label for="telefone">Telefone</label>
                            @error('telefone')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="naturalidade" name="naturalidade" type="text" class="validate" value="{{ old('naturalidade') }}" required>
                            <label for="naturalidade">Naturalidade</label>
                            @error('naturalidade')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="num_agente" name="num_agente" type="text" class="validate" value="{{ old('num_agente') }}" required>
                            <label for="num_agente">Número de Agente</label>
                            @error('num_agente')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="n_bilhete" name="n_bilhete" type="text" class="validate" value="{{ old('n_bilhete') }}" required>
                            <label for="n_bilhete">Número do Bilhete</label>
                            @error('n_bilhete')
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
                            <p class="grey-text">Selecione uma imagem para o perfil do professor</p>
                            @error('imagem')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12">
                            <button class="btn waves-effect waves-light" type="submit">
                                Criar Professor
                                <i class="material-icons right">send</i>
                            </button>
                            <a href="{{ route('admin.professores') }}" class="btn waves-effect waves-light red">
                                Cancelar
                                <i class="material-icons right">cancel</i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection 