@extends('admin.layout')
@section('title','Cadaastro aula')

@section('conteudo')
 

  <div class="container col s12 m4" style="margin-top: 50px; max-width:900px">
    <div class="card-panel">
        <form action="{{route('admin.aula.store')}}" method="POST"  enctype="multipart/form-data"> 
        
          @csrf

          
        
      
        <div class="row">
        <div class="col s12 center-align" style="margin-bottom: 30px;">
            <h4 class="blue-text text-darken-2">
                <a href="#" class="btn-floating" ><i class="material-icons ">auto_stories</i></a>
                ELABORAR UMA AULA
            </h4>
            <p class="grey-text">Visualize e gerencie todos os posts do sistema</p>
        </div>
    </div>
        

          <input type="hidden"  name="id_user" value="{{auth()->user()->id}}">

          <div class="row">

         <div class="input-field col s12">
                <input type="text" name="descricao" value="" id="aula">
                  <label for="aula">Tema da aula</label>
                @error('descricao')
                 <span class="red-text">{{$message}}</span>
                 @enderror
              </div>

            <div class="input-field col s12">
                <select name="id_curso" id="id_curso">
                    @foreach ($cursos as $curso)
                        <option value="{{$curso->id}}">{{$curso->nome}}</option>
                    @endforeach
                    
                </select>
                <label for="id_curso">Curso</label>
                @error('id_curso')
                 <span class="red-text">{{$message}}</span>
                 @enderror
              </div>


              <div class="input-field col s12">
                <select name="id_disciplina" id="id_disciplina">

                  @foreach ($disciplinas as $disciplina)
                    <option value="{{$disciplina->id}}" >{{$disciplina->nome_disciplina}}</option>
                  @endforeach
                </select>
                <label for="id_disciplina">Disciplina</label>
                @error('id_disciplina')
                 <span class="red-text">{{$message}}</span>
                 @enderror
              </div>

               <div class="input-field col s12">
                <select name="id_turma" id="id_turma">

                  @foreach ($turmas as $turma)
                    <option value="{{$turma->id}}" >{{$turma->designacao}}</option>
                  @endforeach
                </select>

                <label for="id_turma">Turma</label>
                @error('id_turma')
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
                        placeholder: 'Escreva a sua aula...',
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


