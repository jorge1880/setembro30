@extends('admin.layout')
@section('title', 'Criar Fórum')
@section('conteudo')
<div class="container">
    <h4>Criar Novo Fórum</h4>
    <form action="{{ route('admin.forum.store') }}" method="POST">
        @csrf
        <div class="input-field">
            <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required>
            <label for="titulo">Título</label>
            @error('titulo')<span class="red-text">{{ $message }}</span>@enderror
        </div>
        <div class="input-field">
            <textarea name="descricao" id="descricao" class="materialize-textarea" required>{{ old('descricao') }}</textarea>
            <label for="descricao">Descrição</label>
            @error('descricao')<span class="red-text">{{ $message }}</span>@enderror
        </div>
        <div class="input-field">
            <select name="turmas[]" multiple required>
                <option value="" disabled>Selecione as turmas</option>
                @foreach($turmas as $turma)
                    <option value="{{$turma->id}}">{{$turma->designacao}}</option>
                @endforeach
            </select>
            <label>Turmas</label>
            @error('turmas')<span class="red-text">{{ $message }}</span>@enderror
        </div>
        <div class="row">
            <div class="input-field col s6">
                <input type="datetime-local" name="data_inicio" id="data_inicio" value="{{ old('data_inicio') }}" required>
                <label for="data_inicio">Data de Início</label>
                @error('data_inicio')<span class="red-text">{{ $message }}</span>@enderror
            </div>
            <div class="input-field col s6">
                <input type="datetime-local" name="data_fim" id="data_fim" value="{{ old('data_fim') }}" required>
                <label for="data_fim">Data de Fim</label>
                @error('data_fim')<span class="red-text">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="input-field">
            <button type="submit" class="btn green">Criar Fórum</button>
            <a href="{{ route('admin.forums') }}" class="btn grey">Cancelar</a>
        </div>
    </form>
</div>
@endsection 