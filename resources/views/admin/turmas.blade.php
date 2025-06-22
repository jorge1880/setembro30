@extends('admin.layout')

@section('title', "Turmas")
@section('conteudo')
    

@can('create', \App\Models\Turma::class)
  <div class="fixed-action-btn">
     <a href="{{route('admin.turma.create')}}" class="btn-floating btn-large bg-gradient-green modal-trigger waves-effects waves-light"> 
      <i class="large material-icons">add</i></a>
  </div>
@endcan

  <div class="row container ">

         <br>
         <div class="row">
             <a href="{{ route('admin.dashboard') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px;">
                 <i class="material-icons">arrow_back</i>
             </a>
             <h4 class="left"> <i class="material-icons btn-floating center" style="font-size:25pt">doorbell</i>Turmas</h4>
            <span class="right chip">{{$turmas->count()}} Total de turmas</span>
       </div>

        @include('admin.mensagem.mensagem')
       
        <nav class="bg-gradient-blue">
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
                  <th>Turma</th>
                  @can('create', \App\Models\Turma::class)
                  <th>Ações</th> 
                  @endcan
                  
              </tr>
            </thead>
    
            <tbody>

               @foreach ($turmas as $turma)
                
              <tr>
                
                 @include('admin.turmas.delete')

                <td>{{$turma->id}}</td>
                <td>{{$turma->designacao}}</td>
                
                <td>
                  
                  @can('update', $turma)
                  <a href="{{route('admin.turma.edit',$turma->id)}}" class="btn-floating modal-trigger  waves-effect waves-light blue"><i class="material-icons">mode_edit</i></a>
                  @endcan
                  @can('delete', $turma)
                  <a href="#delete-{{$turma->id}}" class="btn-floating modal-trigger waves-effect waves-light red"><i class="material-icons">delete</i></a>
                  @endcan
               
                </td>
              </tr>
             
              @endforeach
              
             
              
            </tbody>
          </table>
        </div>
  </div>
   
  <div class="center">
    {{$turmas->links('pagination.pagination')}}
  </div>


@endsection