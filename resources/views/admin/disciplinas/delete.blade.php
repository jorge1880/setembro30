  <!-- Modal Structure -->
  <div id="delete-{{$disciplina->id}}" class="modal" style="max-width: 500px">
    <div class="modal-content">
      <h4><i class="material-icons">delete</i> Tem certeza </h4>
        <div class="row">

           <p>Que quer excluir a Classe <b style="color: red"> {{$disciplina->nome_disciplina}}</b> ?</p>

        <form action="{{route('admin.disciplina.delete', $disciplina->id)}}" method="POST">
            @method('DELETE') 
            @csrf
                <div class="right">
                <button type="button" class="modal-close waves-effects waves-green btn blue">Não</button>
                <button type="submit" class="waves-green btn red">Sim</button>
                </div>
        </form>  
    </div>
  </div>


