@extends('admin.layout')
@section('title','Cursos')

@section('conteudo')

  <div class="container col s12 m6" style="margin-top: 50px; max-width:500px; ">
    <div class="card-panel">
     <form action="{{route('admin.curso.update', $curso->id)}}" method="POST" class="col s12 m6"> 

       @csrf
       <a href="{{ route('admin.cursos') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px;">
           <i class="material-icons">arrow_back</i>
       </a>
      <a href="#" class="btn-floating"><i class="material-icons ">edit</i></a> <span style="font-size: 20pt">Editar Curso</span>
       <br>
      
      <div class="row">

       <div class="input-field col s12">
         <input name="nome" id="first_name" type="text" value="{{$curso->nome}}" class="validate" >
           <label for="first_name">Nome do Curso</label>
         @error('nome')
             <span class="red-text">{{$message}}</span>
         @enderror
       </div>

       <div class="input-field col s12">
         <textarea name="descricao" id="textarea1" class="materialize-textarea">{{$curso->descricao}}</textarea>
         <label for="textarea1">Descrição</label>
         @error('descricao')
             <span class="red-text">{{$message}}</span>
         @enderror
       </div>
      </div>

      <div class="modal-footer">
       
       <a href="{{route('admin.cursos')}}" class="modal-close waves-effect waves-green btn red">Cancelar</a>
       <button type="submit" class="waves-green btn blue right">Atualizar</button>
     </div>
 </form> 
     
    </div>
</div>

@endsection


