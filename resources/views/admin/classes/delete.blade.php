  <!-- Modal Structure -->
  <div id="delete-{{$classe->id}}" class="modal" style="max-width: 500px">
    <div class="modal-content">
      <h4><i class="material-icons">delete</i> Tem certeza </h4>
        <div class="row">

           <p>Que quer excluir a Classe <b style="color: red"> {{$classe->designacao}}</b> ?</p>

        <form action="{{route('admin.classe.delete', $classe->id)}}" method="POST">
            @method('DELETE') 
            @csrf
                <div class="right">
                <a href="#!" class="modal-close waves-effects waves-green btn blue">Não</a>
                <button type="submit" class="waves-green btn red">Sim</button>
                </div>
        </form>  
    </div>
  </div>



