@extends('admin.layout')
@section('title','Anos Lectivos')

@section('conteudo')

  <div class="container col s12 m6" style="margin-top: 50px; max-width:500px; ">
    <div class="card-panel">
     <form action="{{route('admin.ano.update', $ano->id)}}" method="POST" class="col s12 m6"> 

       @csrf
       <a href="{{ route('admin.anos') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px;">
           <i class="material-icons">arrow_back</i>
       </a>
      <a href="#" class="btn-floating"><i class="material-icons ">calendar_month</i></a> <span style="font-size: 20pt">Editar Ano Lectivo</span>
       <br>
      
      <div class="row">

       <div class="input-field col s12">
        <input name="ano" id="ano" type="text" value="{{$ano->ano}}" class="validate">
          <label for="ano"> Ano Lectivo</label>
        @error('ano')
             <span class="red-text">{{$message}}</span>
         @enderror
      </div>
      </div>

      <div class="modal-footer">
       <a href="{{route('admin.anos')}}" class="modal-close waves-effect waves-green btn red">Cancelar</a>
       <button type="submit" class="waves-green btn blue right">Atualizar</button>
     </div>
 </form> 
     
    </div>
</div>

@endsection
