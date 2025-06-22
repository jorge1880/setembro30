@extends('admin.layout')
@section('title','Criar Post')

@section('conteudo')
 

  <div class="container col s12 m4" style="margin-top: 50px; max-width:900px">
    <div class="card-panel">
        <form action="{{route('admin.post.store')}}" method="POST"  enctype="multipart/form-data"> 
        
          @csrf

          
         <div class="row">
        <div class="col s12 center-align" style="margin-bottom: 30px;">
            <a href="{{ route('admin.posts') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px; position: absolute; top: 0; left: 20px;">
                <i class="material-icons">arrow_back</i>
            </a>
            <h4 class="blue-text text-darken-2">
                <i class="material-icons left" style="font-size: 30pt">article</i>
                Criar Posts
            </h4>
            <h6 class="grey-text">Crie Posts informátivos para os estudantes e toda comunidade</h6>
        </div>
    </div>
        
      
          
          <div style="width:300px; height:200px; margin: 10px auto -10px auto;">
               
            <div>
                <input type="file" id="imageInput" name="imagem" accept="image/*" style="visibility: hidden">
               <br>  
               <label for="imageInput">

                    <img id="preview" class="center" src="{{asset('img/staff.jpg')}}" alt="Imagem carregada" style="width:200px; height:200px;object-fit:cover; border:1px solid rgb(11, 192, 71);">

               </label>
            
            </div>
          </div>
        

          <input type="hidden"  name="id_user" value="{{auth()->user()->id}}">

          <div class="row">

         <div class="input-field col s12">
                <input type="text" name="titulo" value="" id="titulo">
                  <label for="titulo">TÍTULO</label>
                @error('titulo')
                 <span class="red-text">{{$message}}</span>
                 @enderror
              </div>

          
           
              <div class="input-field col s12">
                <textarea name="conteudo" id="summernote" cols="30" rows="50" ></textarea>
                @error('conteudo')
                 <span class="red-text">{{$message}}</span>
                 @enderror
              </div>

                    <script>
                    $('#summernote').summernote({
                        placeholder: 'Escreva o post...',
                        tabsize: 2,
                        height: 350,
                        toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                        ]
                    });
                    </script>
          </div>
          
        <div class="" style="text-align: right">
          <a href="{{route('admin.aulas')}}" class="waves-effect waves-green btn red">Cancelar</a>
          <button type="submit" class="waves-green btn blue">Cadastrar</button>
          
        </div>
        
    </form> 
       
     
    </div>
</div>


<script>
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview');
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection


