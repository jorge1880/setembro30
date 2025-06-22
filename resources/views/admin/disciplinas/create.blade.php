@extends('admin.layout')
@section('title','Disciplinas')

@section('conteudo')
  {{--MODAL --}}



  <div class="container col s12 m6" style="margin-top: 50px; max-width:500px; ">
    <div class="card-panel">
        <form action="{{route('admin.disciplina.store')}}" method="POST" class="col s12 m6"> 
     
          @csrf
          <a href="{{ route('admin.disciplinas') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px;">
              <i class="material-icons">arrow_back</i>
          </a>
         <a href="#" class="btn-floating"><i class="material-icons ">menu_book</i></a> <span style="font-size: 20pt">Nova Disciplina</span>
          <br>
     
  
          <div class="input-field col s12" style="margin-top: 30px">
            <input name="nome_disciplina" id="designacao" type="text" class="validate" >
            <label for="designacao">Disciplina*</label>
            @error('nome_disciplina')
               <span class="red-text">{{$message}}</span>
            @enderror
          </div>
    
          <a href="{{route('admin.disciplinas')}}" class="modal-close waves-effect waves-green btn red">Cancelar</a>
          <button type="submit" class="waves-green btn blue right">Cadastrar</button>
        
    </form> 
       
     
    </div>
</div>

  
  

@endsection


