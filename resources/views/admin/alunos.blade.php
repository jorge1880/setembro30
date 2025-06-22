@extends('admin.layout')

@section('title', "Alunos")
@section('conteudo')
    

  @can('create', App\Models\Matricula::class)
  <div class="fixed-action-btn">
     <a href="{{route('admin.aluno.create')}}" class="btn-floating btn-large bg-gradient-green modal-trigger waves-effects waves-light"> 
      <i class="large material-icons">add</i></a>
  </div>
  @endcan
    
  <div class="row container ">

         <br>
         <div class="row">
             <h4 class="left"> <i class="material-icons btn-floating center" style="font-size:25pt">manage_accounts</i>Alunos</h4>
            <span class="right chip">{{$matriculas->total()}} Total de alunos</span>
       </div>
 
        @include('admin.mensagem.mensagem')
       
        <nav class="bg-gradient-green">
            <div class="nav-wrapper">
              <form>
                <div class="input-field">
                  <input placeholder="Pesquisar..." id="search" type="search" required>
                  <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                  <i class="material-icons">close</i>
                </div>
              </form>
            </div>
          </nav> 


       <div class="card z-depth-4">
        <table style="margin: 5px" class="striped highlight centered center">

            <thead>
              <tr>
                  <th>ID</th>
                  <th>Nome</th>
                  <th>Turma</th>
                  <th>Ações</th>
                  
              </tr>
            </thead>
    
            <tbody>

               @foreach ($matriculas as $matricula)
                
              <tr>
                
                @if($matricula->user)
                @include('admin.alunos.delete')
                @endif

                <td>{{$matricula->id}}</td>
                <td>{{$matricula->user ? $matricula->user->nome : 'Usuário não encontrado'}}</td>
                <td>{{$matricula->turma ? $matricula->turma->designacao : 'Turma não encontrada'}}</td>
                
                <td>
                  @if($matricula->user)
                  @can('update', $matricula)
                  <a href="{{route('admin.aluno.edit', $matricula->id)}}" class="btn-floating modal-trigger  waves-effect waves-light orange"><i class="material-icons">mode_edit</i></a>
                  @endcan
                  @can('delete', $matricula)
                  <a href="#delete-{{$matricula->user->id}}" class="btn-floating modal-trigger waves-effect waves-light red"><i class="material-icons">delete</i></a>
                  @endcan
                  <a href="{{route('admin.aluno.show', $matricula->user->id)}}" class="btn-floating modal-trigger waves-effect waves-light green"><i class="material-icons">visibility</i></a>
                  @else
                  <span class="chip red white-text">Usuário inválido</span>
                  @endif
                </td>
                   {{---@include('admin.users.update')--}}  
              </tr>
             
              @endforeach
              
             
              
            </tbody>
          </table>
        </div>
  </div>
   
  <div class="center">
 {{$matriculas->links('pagination.pagination')}}
  </div>


@endsection