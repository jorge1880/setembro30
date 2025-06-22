@extends('admin.layout')
@section('title','Alunos')

@section('conteudo')
  {{--MODAL --}}



  <div class="container col s12 m6" style="margin-top: 50px; max-width:750px">
    <div class="card-panel">
        <form action="{{route('admin.aluno.store')}}" method="POST" class="col s12 m6" enctype="multipart/form-data">

          @csrf
             <a href="{{ route('admin.alunos') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px;">
                 <i class="material-icons">arrow_back</i>
             </a>
             <a href="#" class="btn-floating"><i class="material-icons ">people</i></a> <span style="font-size: 20pt">Matricular Aluno</span>
          <br>


          <input type="hidden" name="nivel" value="aluno">




          <div style="width:300px; height:300px; margin: 0 auto">

            <div>
                <input type="file" id="imageInput" name="imagem" accept="image/*" style="visibility: hidden">
               <br>
               <label for="imageInput">

                    <img id="preview" class="center" src="{{asset('img/profileestude.webp')}}" alt="Imagem carregada" style="width:250px; height:250px; border-radius:100%; object-fit:cover;">

               </label>

            </div>
          </div>

          <div class="row">


            <div class="input-field  col s12 m6">
              <input id="nome" name="nome" type="text" class="validate">
              <label for="nome">Nome Completo</label>
              @error('nome')
                   <span class="red-text">{{$message}}</span>
              @enderror
            </div>


            <div class="input-field col s12 m6">
              <input id="email" name="email" type="email" class="validate">
              <label for="email">E-mail</label>
              @error('email')
                 <span class="red-text">{{$message}}</span>
              @enderror
            </div>


            <div class="input-field col s12 m6">
                <input id="morada" name="morada" type="text" class="validate">
                <label for="morada">Morada</label>
                @error('morada')
                 <span class="red-text">{{$message}}</span>
              @enderror
              </div>


              <div class="input-field col s12 m6">
                <input id="nascimento" name="nascimento" type="date" class="validate">
                <label for="nascimento">Data Nascimento</label>
                @error('nascimento')
                 <span class="red-text">{{$message}}</span>
              @enderror
              </div>


              <div class="input-field col s12 m6">
                <input id="numerobi" type="text" name="n_bilhete" class="validate">
                <label for="numerobi">Nº de Bilhete de Identificação</label>
                @error('n_bilhete')
                 <span class="red-text">{{$message}}</span>
              @enderror
              </div>

              <div class="input-field col s12 m6">
                <input id="nome_pai" name="nome_pai" type="text" class="validate">
                <label for="nome_pai">Nome completo  da Pai</label>
                @error('nome_pai')
                 <span class="red-text">{{$message}}</span>
              @enderror
              </div>

              <div class="input-field col s12 m6">
                <input id="telefone" name="telefone" type="tel" class="validate">
                <label for="telefone">Nº Telefone</label>
                @error('telefone')
                 <span class="red-text">{{$message}}</span>
              @enderror
              </div>

              <div class="input-field col s12 m6">
                <input id="nome_mae" name="nome_mae" type="text" class="validate">
                <label for="nome_mae">Nome completo da mãe</label>
                @error('nome_mae')
                 <span class="red-text">{{$message}}</span>
                @enderror
              </div>


              <div class="input-field col s12 m6">
                <select name="area_formacao" id="area_formacao">
                    <option value="">Selecione a área de formação</option>
                    <option value="Informatica">Infomática</option>
                    <option value="area_formacao">Electricidade</option>
                </select>
                <label for="area_formacao">Área de Formação</label>
                @error('area_formacao')
                 <span class="red-text">{{$message}}</span>
                 @enderror
              </div>

              <div class="input-field col s12 m6">
                <input id="naturalidade" name="naturalidade" type="text" class="validate">
                <label for="naturalidade">Naturalidade</label>
                @error('naturalidade')
                 <span class="red-text">{{$message}}</span>
              @enderror
              </div>

              <div class="input-field col s12 m6">
                <select name="id_classe" id="classe">
                    <option value="">Selecione a classe</option>
                    @foreach ($classes as $classe)
                       <option value="{{$classe->id}}">{{$classe->designacao}}<sup>ª</sup></option>
                    @endforeach

                </select>
                <label for="classe">Classe</label>
                @error('id_classe')
                 <span class="red-text">{{$message}}</span>
              @enderror
              </div>

              <div class="input-field col s12 m6">
                <select name="id_curso" id="curso">
                    <option value="">Selecione um curso</option>

                    @foreach ($cursos as $curso)
                      <option value="{{$curso->id}}">{{$curso->nome}}</option>
                    @endforeach
                </select>
                <label for="curso">Curso</label>
                @error('id_curso')
                 <span class="red-text">{{$message}}</span>
              @enderror
              </div>

              <div class="input-field col s12 m6">
                <select name="id_turma" id="turma">
                    <option value="">Selecione a turma</option>

                    @foreach ($turmas as $turma)
                    <option value="{{$turma->id}}">{{$turma->designacao}}</option>

                    @endforeach

                </select>
                <label for="turma">Turma</label>
                @error('id_turma')
                 <span class="red-text">{{$message}}</span>
              @enderror
              </div>

              <div class="input-field col s12 m6">
                <select name="id_ano" id="ano">
                       <option value="{{$ano->id}}">{{$ano->ano}}</option>

                </select>
                <label for="ano">Ano Lectivo</label>
                @error('id_ano')
                 <span class="red-text">{{$message}}</span>
              @enderror
              </div>

              <div class="input-field col s12 m6">
                 <input type="password" name="password" id="password">
                <label for="password">Palavra-passe</label>
                @error('password')
                 <span class="red-text">{{$message}}</span>
              @enderror
              </div>

              {{---------<div class="input-field col s12 m6">
                <input type="password" name="confirm" id="confirm">
               <label for="confirm">Confirmar Palavra-passe</label>
             </div>-------}}


          </div>



        <div class="" style="text-align: right">

          <a href="{{route('admin.alunos')}}" class="waves-effect waves-green btn red">Cancelar</a>
          <button type="submit" class="waves-green btn blue">Matricular</button>

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
