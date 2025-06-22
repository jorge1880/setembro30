@extends('admin.layout')

@section('title', "Admins")
@section('conteudo')
    

  <div class="fixed-action-btn">
     <a href="#create" class="btn-floating btn-large bg-gradient-green modal-trigger waves-effects waves-light"> 
      <i class="large material-icons">add</i></a>
  </div>
      @include('admin.usuarios.create')
      
  <div class="row container ">

         <br>
         <div class="row">
             <a href="{{ route('admin.dashboard') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px;">
                 <i class="material-icons">arrow_back</i>
             </a>
             <h4 class="left"> <i class="material-icons btn-floating center" style="font-size:25pt">manage_accounts</i>Admins</h4>
            <span class="right chip">{{$users->count()}} Total de admins</span>
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
                  <th>Nível</th>
                  <th>Ações</th>
                  
              </tr>
            </thead>
    
            <tbody>

               @foreach ($users as $user)
                
              <tr>
                
                <td>{{$user->id}}</td>
                <td>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        {!! \App\Helpers\ViewHelper::displayUserThumbnail($user, '40px') !!}
                        <span>{{$user->nome}}</span>
                    </div>
                </td>
                <td>{{$user->email}}</td>
                <td>
                  @switch($user->nivel)
                      @case(\App\Models\User::NIVEL_DIRETOR_GERAL)
                          <span class="chip blue white-text">Diretor Geral</span>
                          @break
                      @case(\App\Models\User::NIVEL_DIRETOR_PEDAGOGICO)
                          <span class="chip green white-text">Diretor Pedagógico</span>
                          @break
                      @default
                          <span class="chip">{{$user->nivel}}</span>
                  @endswitch
                </td>
                
                <td>
                  
                  <a href="{{route('admin.users.show', $user->id)}}" class="btn-floating modal-trigger  waves-effect waves-light blue"><i class="material-icons">visibility</i></a>
                  <a href="#edit-{{$user->id}}" class="btn-floating modal-trigger  waves-effect waves-light orange"><i class="material-icons">mode_edit</i></a>
                  <a href="#delete-{{$user->id}}" class="btn-floating modal-trigger waves-effect waves-light red"><i class="material-icons">delete</i></a>
               
                </td>
              </tr>
             
              @endforeach
              
            </tbody>
          </table>
        </div>
  </div>
   
  <div class="center">
 {{----$users->links('pagination.pagination')---}}
  </div>


@endsection
