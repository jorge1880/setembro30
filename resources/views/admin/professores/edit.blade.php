@extends('admin.layout')

@section('title', "Editar Professor")
@section('conteudo')

<div class="row container">
    <div class="col s12">
        <div class="card z-depth-4">
            <div class="card-content">
                <span class="card-title">
                    <a href="{{ route('admin.professores') }}" class="btn-floating waves-effect waves-light blue">
                        <i class="material-icons">arrow_back</i>
                    </a>
                    <a href="#" class="btn-floating"><i class="material-icons">edit</i></a> 
                    <span style="font-size: 20pt">Editar Professor: <span class="red-text">{{$professor->user->nome}}</span></span>
                </span>

                <form action="{{ route('admin.professor.update', $professor->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input id="nome" name="nome" type="text" class="validate" value="{{ $professor->user->nome }}" required>
                            <label for="nome">Nome Completo</label>
                            @error('nome')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="email" name="email" type="email" class="validate" value="{{ $professor->user->email }}" required>
                            <label for="email">E-mail</label>
                            @error('email')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="morada" name="morada" type="text" class="validate" value="{{ $professor->morada }}" required>
                            <label for="morada">Morada</label>
                            @error('morada')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="telefone" name="telefone" type="text" class="validate" value="{{ $professor->telefone }}" required>
                            <label for="telefone">Telefone</label>
                            @error('telefone')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="naturalidade" name="naturalidade" type="text" class="validate" value="{{ $professor->naturalidade }}" required>
                            <label for="naturalidade">Naturalidade</label>
                            @error('naturalidade')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="num_agente" name="num_agente" type="text" class="validate" value="{{ $professor->num_agente }}" required>
                            <label for="num_agente">Número de Agente</label>
                            @error('num_agente')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-field col s12 m6">
                            <input id="n_bilhete" name="n_bilhete" type="text" class="validate" value="{{ $professor->n_bilhete }}" required>
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
                            <p class="grey-text">Deixe em branco para manter a imagem atual</p>
                            @error('imagem')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col s12 m6">
                            @if($professor->user->imagem)
                                <div class="card-panel">
                                    <h6>Imagem Atual:</h6>
                                    <img src="{{ asset('storage/' . $professor->user->imagem) }}" 
                                         alt="Imagem do professor" 
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
                        <div class="input-field col s12">
                            <select name="turmas[]" id="turmas" multiple>
                                <option value="" disabled>Selecione as turmas</option>
                                @foreach($turmas as $turma)
                                    <option value="{{ $turma->id }}" {{ in_array($turma->id, $turmasProfessor) ? 'selected' : '' }}>
                                        {{ $turma->designacao }}
                                    </option>
                                @endforeach
                            </select>
                            <label>Turmas Associadas</label>
                            @error('turmas')
                                <span class="red-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 center">
                            <button type="submit" class="btn waves-effect waves-light blue">
                                <i class="material-icons left">save</i>
                                Atualizar Professor
                            </button>
                            <a href="{{ route('admin.professores') }}" class="btn waves-effect waves-light grey">
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