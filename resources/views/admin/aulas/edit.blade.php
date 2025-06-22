@extends('admin.layout')
@section('title', 'Editar Aula')

@section('conteudo')

<div class="container">
  <div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Editar Aula</span>
                
                <form action="{{ route('admin.aula.update', $aula->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="input-field">
                        <input id="descricao" name="descricao" type="text" value="{{ old('descricao', $aula->descricao) }}" required>
                        <label for="descricao">Descrição da Aula</label>
                        @error('descricao') <span class="red-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-field">
                        <textarea id="conteudo" name="conteudo" class="materialize-textarea" required>{{ old('conteudo', $aula->conteudo) }}</textarea>
                        <label for="conteudo">Conteúdo da Aula</label>
                        @error('conteudo') <span class="red-text">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-field">
                        <select name="id_curso" id="id_curso" required>
                            <option value="" disabled>Selecione o Curso</option>
                            @foreach ($cursos as $curso)
                                <option value="{{ $curso->id }}" {{ old('id_curso', $aula->id_curso) == $curso->id ? 'selected' : '' }}>
                                    {{ $curso->nome_curso }}
                                </option>
                            @endforeach
                        </select>
                        <label>Curso</label>
                    </div>

                    <div class="input-field">
                        <select name="id_disciplina" id="id_disciplina" required>
                            <option value="" disabled>Selecione a Disciplina</option>
                            @foreach ($disciplinas as $disciplina)
                                <option value="{{ $disciplina->id }}" {{ old('id_disciplina', $aula->id_disciplina) == $disciplina->id ? 'selected' : '' }}>
                                    {{ $disciplina->nome_disciplina }}
                                </option>
                            @endforeach
                        </select>
                        <label>Disciplina</label>
                    </div>

                    <div class="input-field">
                        <select name="id_turma" id="id_turma" required>
                            <option value="" disabled>Selecione a Turma</option>
                            @foreach ($turmas as $turma)
                                <option value="{{ $turma->id }}" {{ old('id_turma', $aula->id_turma) == $turma->id ? 'selected' : '' }}>
                                    {{ $turma->designacao }}
                                </option>
                            @endforeach
                        </select>
                        <label>Turma</label>
                    </div>

                    <div class="right-align">
                        <a href="{{ route('admin.aulas') }}" class="btn waves-effect waves-light grey">Cancelar</a>
                        <button type="submit" class="btn waves-effect waves-light blue">Atualizar Aula</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection 