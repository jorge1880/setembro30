@extends('admin.layout')

@section('title', "Professores")
@section('conteudo')
    

  @can('create', App\Models\Professor::class)
  <div class="fixed-action-btn">
     <a href="{{route('admin.professor.create')}}" class="btn-floating btn-large bg-gradient-green modal-trigger waves-effects waves-light"> 
      <i class="large material-icons">add</i></a>
  </div>
  @endcan

  <div class="row container ">

         <br>
         <div class="row">
             <a href="{{ route('admin.dashboard') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px;">
                 <i class="material-icons">arrow_back</i>
             </a>
             <h4 class="left"> <i class="material-icons btn-floating center" style="font-size:25pt">manage_accounts</i>Professores</h4>
            <span class="right chip">{{$professores->count()}} Total de professores</span>
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
                  <th>Imagem</th>
                  <th>Nome</th>
                  <th>Email</th>
                  <th>Nº de Agente</th>
                  <th>Ações</th>
                  
              </tr>
            </thead>
    
            <tbody>

               @foreach ($professores as $prof)
                
              <tr>
                
                {{--@include('admin.users.delete')--}} 

                <td>{{$prof->id}}</td>
                <td>
                    {!! \App\Helpers\ViewHelper::displayUserThumbnail($prof->user, '50px') !!}
                </td>
                <td>{{$prof->user->nome}}</td>
                <td>{{$prof->user->email}}</td>
                <td>{{$prof->num_agente}}</td>
                
                
               
                
                <td>
                  
                  <a href="{{route('admin.professor.show', $prof->id)}}" class="btn-floating modal-trigger  waves-effect waves-light blue"><i class="material-icons">visibility</i></a>
                  @can('update', $prof)
                  <a href="{{route('admin.professor.edit', $prof->id)}}" class="btn-floating waves-effect waves-light orange"><i class="material-icons">mode_edit</i></a>
                  @endcan
                  @can('delete', $prof)
                  <a href="#delete-{{$prof->id}}" class="btn-floating modal-trigger waves-effect waves-light red"><i class="material-icons">delete</i></a>
                  @endcan
               
                </td>
                   {{---@include('admin.users.update')--}}  
              </tr>
             
              @endforeach
              
             
              
            </tbody>
          </table>
        </div>
  </div>
   
  <div class="center">
 {{----$professores->links('pagination.pagination')---}}
  </div>

  <!-- Modais de Confirmação de Exclusão -->
  @foreach ($professores as $prof)
    @can('delete', $prof)
    <div id="delete-{{$prof->id}}" class="modal">
        <div class="modal-content">
            <h4>Confirmar Exclusão</h4>
            <p>Tem certeza que deseja excluir o professor <strong>{{$prof->user->nome}}</strong>?</p>
            <p class="red-text">Esta ação não pode ser desfeita!</p>
        </div>
        <div class="modal-footer">
            <form action="{{ route('admin.professor.destroy', $prof->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="modal-close waves-effect waves-red btn-flat">Sim, Excluir</button>
            </form>
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        </div>
    </div>
    @endcan
  @endforeach

@endsection
