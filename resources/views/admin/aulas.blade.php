@extends('admin.layout')
@section('title','Disciplinas')

@section('conteudo')


    
  @can('create', App\Models\Aula::class)
  <div class="fixed-action-btn">
    <a href="{{route('admin.aula.create')}}" class="btn-floating btn-large bg-gradient-green modal-trigger waves-effects waves-light"> 
     <i class="large material-icons">add</i></a>
 </div>
  @endcan
   
 <div class="row container ">

        <br>
        <div class="row">
            <a href="{{ route('admin.dashboard') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px;">
                <i class="material-icons">arrow_back</i>
            </a>
            <h4 class="left"> <i class="material-icons btn-floating center" style="font-size:25pt">menu_book</i>Aulas</h4>
           <span class="right chip">{{$aulas->count()}} Total de aulas</span>
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
                 <th>Aula</th>
                 <th>Turma</th>
                 <th>Disciplina</th>
                 <th>Professor</th>
                 <th>Ações</th>
                 
             </tr>
           </thead>
   
           <tbody>

              @foreach ($aulas as $aula)
               
             <tr>
               
         @include('admin.aulas.delete')

               <td>{{$aula->id}}</td>
               <td>{{$aula->descricao}}</td>
               <td>{{$aula->turma->designacao}}</td>
               <td>{{$aula->disciplina->nome_disciplina}}</td>
               <td>{{$aula->professor->nome}}</td>
               
               <td>
                 
                 @can('update', $aula)
                 <a href="{{route('admin.aula.edit', $aula->id)}}" class="btn-floating modal-trigger  waves-effect waves-light blue"><i class="material-icons">mode_edit</i></a>
                 @endcan
                 @can('delete', $aula)
                 <a href="#delete-{{$aula->id}}" class="btn-floating modal-trigger waves-effect waves-light red"><i class="material-icons">delete</i></a>
                 @endcan
                 <a href="{{route('admin.aula.unica', $aula->id)}}" class="btn-floating modal-trigger waves-effect waves-light green"><i class="material-icons">visibility</i></a>
              
               </td>
             </tr>
            
             @endforeach
             
            
             
           </tbody>
         </table>
       </div>
 </div>
  
 <div class="center">
   {{ $aulas->links('pagination.pagination') }}
 </div>
@endsection


