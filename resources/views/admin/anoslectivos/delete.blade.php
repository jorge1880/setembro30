  <!-- Modal Structure -->
  <div id="delete-{{$ano->id}}" class="modal" style="max-width: 500px">
    <div class="modal-content">
      <h4><i class="material-icons">delete</i> Tem certeza </h4>
        <div class="row">

           <p>Que quer excluir a ano <b style="color: red"> {{$ano->ano}}</b> ?</p>

        <form action="{{route('admin.ano.delete', $ano->id)}}" method="POST">
            @method('DELETE') 
            @csrf
                <div class="right">
                <a href="#!" class="modal-close waves-effects waves-green btn blue">Não</a>
                <button type="submit" class="waves-green btn red">Sim</button>
                </div>
        </form>  
    </div>
  </div>
  </div>

