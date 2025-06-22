@extends('admin.layout')

@section('title', "Usuários")
@section('conteudo')

@can('create', App\Models\User::class)
<div class="fixed-action-btn">
   <a href="{{route('admin.users.create')}}" class="btn-floating btn-large bg-gradient-green modal-trigger waves-effects waves-light"> 
    <i class="large material-icons">add</i></a>
</div>
@endcan

<div class="row container ">

       <br>
       <div class="row">
           <a href="{{ route('admin.dashboard') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px;">
               <i class="material-icons">arrow_back</i>
           </a>
           <h4 class="left"> <i class="material-icons btn-floating center" style="font-size:25pt">admin_panel_settings</i>Usuários</h4>
          <span class="right chip">{{isset($users) ? $users->count() : 0}} Total de usuários</span>
     </div>

      @include('admin.mensagem.mensagem')
     
      <nav class="bg-gradient-green">
          <div class="nav-wrapper">
            <form action="{{ route('admin.users.search') }}" method="GET">
              <div class="input-field">
                <input placeholder="Pesquisar por nome, ID ou email..." id="search" name="search" type="search" value="{{ $query ?? '' }}" required>
                <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                <i class="material-icons">close</i>
              </div>
            </form>
          </div>
        </nav> 

     @if(isset($query) && $query)
        <div class="card-panel blue lighten-4">
            <i class="material-icons left">info</i>
            Resultados da pesquisa para: <strong>"{{ $query }}"</strong>
            <a href="{{ route('admin.users') }}" class="right">Limpar pesquisa</a>
        </div>
     @endif

     @if(isset($users) && $users->count() > 0)
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
                @if($user->imagem && \App\Helpers\ImageHelper::imageExists($user->imagem))
                    <img src="{{ asset('storage/' . $user->imagem) }}" 
                         alt="Foto do usuário" 
                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #ddd;">
                @else
                    <i class="material-icons" style="font-size: 50px; color: #ccc;">account_circle</i>
                @endif
              </td>
              <td>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="{{ \App\Helpers\ViewHelper::getUserImageUrl($user) }}" 
                         alt="Foto do usuário" 
                         style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
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
                    @case(\App\Models\User::NIVEL_PROFESSOR)
                        <span class="chip orange white-text">Professor</span>
                        @break
                    @case(\App\Models\User::NIVEL_ALUNO)
                        <span class="chip grey white-text">Aluno</span>
                        @break
                    @default
                        <span class="chip">{{$user->nivel}}</span>
                @endswitch
              </td>
              
              <td>
                
                <a href="{{route('admin.users.show', $user->id)}}" class="btn-floating modal-trigger  waves-effect waves-light blue"><i class="material-icons">visibility</i></a>
                @can('update', $user)
                <a href="{{route('admin.users.edit', $user->id)}}" class="btn-floating waves-effect waves-light orange"><i class="material-icons">mode_edit</i></a>
                @endcan
                @can('delete', $user)
                <a href="#delete-{{$user->id}}" class="btn-floating modal-trigger waves-effect waves-light red"><i class="material-icons">delete</i></a>
                @endcan
             
              </td>
            </tr>
           
            @endforeach
            
          </tbody>
        </table>
      </div>
     @else
     <div class="card z-depth-4">
        <div class="card-content center-align">
            <h5>Nenhum usuário encontrado</h5>
            <p>
                @if(isset($query) && $query)
                    Não foram encontrados usuários para a pesquisa "{{ $query }}".
                @else
                    Não há usuários cadastrados no sistema ou você não tem permissão para visualizá-los.
                @endif
            </p>
        </div>
     </div>
     @endif
</div>
 
<div class="center">
{{----$users->links('pagination.pagination')---}}
</div>

<!-- Modais de Confirmação de Exclusão -->
@if(isset($users))
  @foreach ($users as $user)
    @can('delete', $user)
    <div id="delete-{{$user->id}}" class="modal">
        <div class="modal-content">
            <h4>Confirmar Exclusão</h4>
            <p>Tem certeza que deseja excluir o usuário <strong>{{$user->nome}}</strong>?</p>
            <p class="red-text">Esta ação não pode ser desfeita!</p>
        </div>
        <div class="modal-footer">
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
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