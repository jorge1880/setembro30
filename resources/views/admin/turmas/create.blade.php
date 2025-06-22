  @extends('admin.layout')
  @section('title','Turmas')
  
  @section('conteudo')
  
    <div class="container col s12 m6" style="margin-top: 50px; max-width:500px; ">
      <div class="card-panel">
       <form action="{{route('admin.turma.store')}}" method="POST" class="col s12 m6"> 
 
         @csrf
         <a href="{{ route('admin.turmas') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px;">
             <i class="material-icons">arrow_back</i>
         </a>
        <a href="#" class="btn-floating"><i class="material-icons ">doorbell</i></a> <span style="font-size: 20pt">Nova Turma</span>
         <br>
        
        <div class="row">

         <div class="input-field col s12">
          <input name="designacao" id="designacao" value="{{ old('designacao') }}" type="text" class="validate" >
          <label for="designacao">Nome da Turma</label>
          @error('designacao')
               <span class="red-text">{{$message}}</span>
           @enderror
        </div>
        </div>
 
        <div class="modal-footer">
         <a href="{{route('admin.turmas')}}" class="modal-close waves-effect waves-green btn red">Cancelar</a>
         <button type="submit" class="waves-green btn blue right">Cadastrar</button>
       </div>
   </form> 
       
      </div>
  </div>
  
  @endsection
  
  
