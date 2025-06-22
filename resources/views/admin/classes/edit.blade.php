@extends('admin.layout')
@section('title','Classes')

@section('conteudo')


  <div class="container col s12 m6" style="margin-top: 50px; max-width:500px; ">
    <div class="card-panel">
        <form action="{{route('admin.classe.update', $classe->id)}}" method="POST" class="col s12 m6"> 
     
          @csrf
          <a href="{{ route('admin.classes') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px;">
              <i class="material-icons">arrow_back</i>
          </a>
         <a href="#" class="btn-floating"><i class="material-icons ">edit</i></a> <span style="font-size: 20pt">Editar Classe</span>
          <br>
     
  
          <div class="input-field col s12" style="margin-top: 30px">
            <input name="designacao" id="designacao" type="text" class="validate" value="{{$classe->designacao}}" >
            <label for="designacao">Designação da Classe *</label>
            @error('designacao')
               <span class="red-text">{{$message}}</span>
            @enderror
          </div>
          
          <a href="{{route('admin.classes')}}" class="modal-close waves-effect waves-green btn red">Cancelar</a>
          <button type="submit" class="waves-green btn blue right">Atualizar</button>
        
    </form> 
       
     
    </div>
</div>

@endsection



  