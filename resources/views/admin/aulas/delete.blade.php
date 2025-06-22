  <!-- Modal Structure -->
  <div id="delete-{{$aula->id}}" class="modal" style="max-width: 500px">
    <div class="modal-content">
      <h4><i class="material-icons">delete</i> Tem certeza </h4>
        <div class="row">

           <p>Que quer excluir a aula <b style="color: red"> {{$aula->descricao}}</b> ?</p>

        <form action="{{route('admin.aula.delete', $aula->id)}}" method="POST">
            @method('DELETE') 
            @csrf
                <div class="right">
                <button type="button" class="modal-close waves-effects waves-green btn blue">Não</button>
                <button type="submit" class="waves-green btn red">Sim</button>
                </div>
        </form>  
    </div>
  </div>


