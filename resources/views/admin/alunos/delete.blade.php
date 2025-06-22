     <!-- Modal Structure -->
     @if($matricula->user)
     <div id="delete-{{$matricula->user->id}}" class="modal" style="max-width: 500px">
        <div class="modal-content">
          <h4><i class="material-icons">delete</i> Tem certeza </h4>
            <div class="row">
    
               <p>Que quer excluir o(a) aluno(a) <b style="color: red"> {{$matricula->user->nome}}</b> ?</p>
    
            <form action="{{route('admin.aluno.delete',$matricula->user->id)}}" method="POST">
                @method('DELETE') 
                @csrf
                    <div class="right">
                    <a href="#!" class="modal-close waves-effects waves-green btn orange">Não</a>
                    <button type="submit" class="waves-green btn red">Sim</button>
                    </div>
            </form>  
        </div>
      </div>
     @endif

