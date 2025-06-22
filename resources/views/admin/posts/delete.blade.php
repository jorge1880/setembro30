   <div id="delete-{{$post->id}}" class="modal" style="max-width: 500px">
        <div class="modal-content">
          <h4><i class="material-icons">delete</i> Tem certeza </h4>
            <div class="row">
    
               <p>Que quer excluir o post <b style="color: red"> {{$post->titulo}}</b> ?</p>
    
            <form action="{{route('admin.post.delete', $post->id)}}" method="POST">
                @method('DELETE') 
                @csrf
                    <div class="right">
                    <a href="#!" class="modal-close waves-effects waves-green btn orange">Não</a>
                    <button type="submit" class="waves-green btn red">Sim</button>
                    </div>
            </form>  
        </div>
      </div>
      </div>