@extends('admin.layout')
@section('title','Criar Usuário')

@section('conteudo')

<div class="row container">
    <div class="col s12">
        <div class="card z-depth-4">
            <div class="card-content">
                <span class="card-title">
                    <a href="{{ route('admin.users') }}" class="btn-floating waves-effect waves-light blue">
                        <i class="material-icons">arrow_back</i>
                    </a>
                    <a href="#" class="btn-floating"><i class="material-icons">people</i></a>
                    <span style="font-size: 20pt">Criar Novo Usuário</span>
                </span>

                <form action="{{route('admin.users.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col s12 center">
                            <div style="width:300px; height:300px; margin: 10px auto;">
                                <div>
                                    <input type="file" id="imageInput" name="imagem" accept="image/*" style="display: none;">
                                    <br>
                                    <label for="imageInput" style="cursor: pointer;">
                                        <img id="preview" class="center" src="{{asset('img/staff.jpg')}}" alt="Imagem carregada" style="width:200px; height:200px; border-radius:100%; object-fit:cover; border:1px solid rgb(11, 192, 71);">
                                        <p class="center grey-text">Clique para selecionar uma imagem</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Opção para selecionar imagem do servidor -->
                    <div class="row">
                        <div class="col s12 m6">
                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>Upload</span>
                                    <input type="file" name="imagem" accept="image/*">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Escolha uma imagem do seu computador">
                                </div>
                            </div>
                            <p class="grey-text">Ou faça upload de uma nova imagem</p>
                        </div>

                        <div class="col s12 m6">
                            <button type="button" class="btn waves-effect waves-light green" onclick="openImageGallery()">
                                <i class="material-icons left">photo_library</i>
                                Escolher do Servidor
                            </button>
                            <p class="grey-text">Selecione uma imagem já existente no servidor</p>
                        </div>
                    </div>

                    <!-- Campo hidden para imagem do servidor -->
                    <input type="hidden" id="serverImagePath" name="server_image_path">

                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input id="nome" name="nome" type="text" class="validate" value="{{ old('nome') }}" required>
                            <label for="nome">Nome Completo</label>
                            @error('nome')
                                <span class="red-text">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="email" name="email" type="email" class="validate" value="{{ old('email') }}" required>
                            <label for="email">E-mail</label>
                            @error('email')
                                <span class="red-text">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="morada" name="morada" type="text" class="validate" value="{{ old('morada') }}">
                            <label for="morada">Morada</label>
                            @error('morada')
                                <span class="red-text">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="numerobi" type="text" name="n_bilhete" class="validate" value="{{ old('n_bilhete') }}">
                            <label for="numerobi">Nº de Bilhete de Identificação</label>
                            @error('n_bilhete')
                                <span class="red-text">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="num_agente" name="num_agente" type="text" class="validate" value="{{ old('num_agente') }}">
                            <label for="num_agente">Número de Agente</label>
                            @error('num_agente')
                                <span class="red-text">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="telefone" name="telefone" type="tel" class="validate" value="{{ old('telefone') }}">
                            <label for="telefone">Nº Telefone</label>
                            @error('telefone')
                                <span class="red-text">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="naturalidade" name="naturalidade" type="text" class="validate" value="{{ old('naturalidade') }}">
                            <label for="naturalidade">Naturalidade</label>
                            @error('naturalidade')
                                <span class="red-text">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input type="password" name="password" id="password" required>
                            <label for="password">Palavra-passe</label>
                            @error('password')
                                <span class="red-text">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <select name="nivel" id="nivel" required>
                                <option value="" selected disabled>Selecione a Função</option>
                                @if (auth()->user()->nivel === \App\Models\User::NIVEL_DIRETOR_GERAL || auth()->user()->nivel === 'admin')
                                    <option value="{{ \App\Models\User::NIVEL_DIRETOR_GERAL }}" {{ old('nivel') === \App\Models\User::NIVEL_DIRETOR_GERAL ? 'selected' : '' }}>
                                        Diretor Geral
                                    </option>
                                    <option value="{{ \App\Models\User::NIVEL_DIRETOR_PEDAGOGICO }}" {{ old('nivel') === \App\Models\User::NIVEL_DIRETOR_PEDAGOGICO ? 'selected' : '' }}>
                                        Diretor Pedagógico
                                    </option>
                                @endif
                                @if (auth()->user()->nivel === \App\Models\User::NIVEL_DIRETOR_GERAL || auth()->user()->nivel === \App\Models\User::NIVEL_DIRETOR_PEDAGOGICO || auth()->user()->nivel === 'admin')
                                    <option value="{{ \App\Models\User::NIVEL_PROFESSOR }}" {{ old('nivel') === \App\Models\User::NIVEL_PROFESSOR ? 'selected' : '' }}>
                                        Professor
                                    </option>
                                    <option value="{{ \App\Models\User::NIVEL_ALUNO }}" {{ old('nivel') === \App\Models\User::NIVEL_ALUNO ? 'selected' : '' }}>
                                        Aluno
                                    </option>
                                @endif
                            </select>
                            <label for="nivel">Função</label>
                            @error('nivel')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 center">
                            <button type="submit" class="btn waves-effect waves-light blue">
                                <i class="material-icons left">save</i>
                                Criar Usuário
                            </button>
                            <a href="{{route('admin.users')}}" class="btn waves-effect waves-light grey">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar componentes do Materialize
        M.AutoInit();

        // Inicializar file inputs
        var elems = document.querySelectorAll('.file-field');
        M.FileInput.init(elems);
    });

    document.getElementById('imageInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        console.log('Arquivo selecionado:', file); // Debug

        if (file) {
            // Verificar se é uma imagem
            if (!file.type.startsWith('image/')) {
                alert('Por favor, selecione apenas arquivos de imagem.');
                return;
            }

            console.log('Tipo do arquivo:', file.type); // Debug
            console.log('Tamanho do arquivo:', file.size); // Debug

            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview');
                preview.src = e.target.result;
                preview.style.display = 'block';
                console.log('Preview atualizado'); // Debug
            };
            reader.readAsDataURL(file);
        }
    });

    // Teste para verificar se o input está funcionando
    console.log('Input de imagem encontrado:', document.getElementById('imageInput'));
</script>

@endsection
