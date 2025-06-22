@extends('admin.layout')

@section('title', "Cursos")
@section('conteudo')
    
@can('create', App\Models\Curso::class)
<div class="fixed-action-btn">
    <a href="{{route('admin.curso.create')}}" class="btn-floating btn-large bg-gradient-green modal-trigger waves-effects waves-light"> 
     <i class="large material-icons">add</i></a>
</div>
@endcan

<div class="row container ">

    <br>
    <div class="row">
        <a href="{{ route('admin.dashboard') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px;">
            <i class="material-icons">arrow_back</i>
        </a>
        <h4 class="left"> <i class="material-icons btn-floating center" style="font-size:25pt">library_books</i> Cursos</h4>
        <span class="right chip">{{$cursos->count()}} Total de cursos</span>
    </div>

    @include('admin.mensagem.mensagem')
       
    <nav class="bg-gradient-blue">
        <div class="nav-wrapper">
            <form>
                <div class="input-field">
                    <input placeholder="Pesquisar cursos..." id="search" type="search" required>
                    <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                    <i class="material-icons">close</i>
                </div>
            </form>
        </div>
    </nav>   

    @if($cursos->count() > 0)
    <div class="card z-depth-4">
        <table style="margin: 5px" class="striped highlight centered center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Curso</th>
                    <th>Descrição</th>
                    @if(auth()->user()->nivel !== \App\Models\User::NIVEL_ALUNO)
                    <th>Ações</th>
                    @endif
                </tr>
            </thead>
    
            <tbody>
                @foreach ($cursos as $curso)
                <tr>
                    <td>{{$curso->id}}</td>
                    <td>
                        <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                            <i class="material-icons" style="color: #26a69a;">school</i>
                            <span>{{$curso->nome}}</span>
                        </div>
                    </td>
                    <td>{{$curso->descricao}}</td>
                    
                    @if(auth()->user()->nivel !== \App\Models\User::NIVEL_ALUNO)
                    <td>
                        @can('edit', $curso)
                        <a href="{{route('admin.curso.edit', $curso->id)}}" class="btn-floating modal-trigger waves-effect waves-light blue">
                            <i class="material-icons">mode_edit</i>
                        </a>
                        @endcan
                        @can('delete', $curso)
                        <a href="#delete-{{$curso->id}}" class="btn-floating modal-trigger waves-effect waves-light red">
                            <i class="material-icons">delete</i>
                        </a>
                        @endcan
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="card z-depth-4">
        <div class="card-content center-align">
            <h5>Nenhum curso encontrado</h5>
            <p>Não há cursos cadastrados no sistema.</p>
        </div>
    </div>
    @endif
</div>
   
<div class="center">
    {{$cursos->links('pagination.pagination')}}
</div>

<!-- Modais de Confirmação de Exclusão -->
@if(auth()->user()->nivel !== \App\Models\User::NIVEL_ALUNO)
    @foreach ($cursos as $curso)
        @can('delete', $curso)
        <div id="delete-{{$curso->id}}" class="modal">
            <div class="modal-content">
                <h4>Confirmar Exclusão</h4>
                <p>Tem certeza que deseja excluir o curso <strong>{{$curso->nome}}</strong>?</p>
                <p class="red-text">Esta ação não pode ser desfeita!</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('admin.curso.delete', $curso->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modal-close waves-effect waves-red btn-flat">Sim, Excluir</button>
                </form>
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
            </div>
        </div>
        @endcan
    @endforeach
@endif

@endsection