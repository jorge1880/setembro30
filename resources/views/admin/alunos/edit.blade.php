@extends('admin.layout')
@section('title','Alunos')

@section('conteudo')
  {{--MODAL --}}



  <div class="container col s12 m6" style="margin-top: 50px; max-width:800px">
    <div class="card-panel">
        @php
            $user = auth()->user();
            $isAluno = $user->nivel === \App\Models\User::NIVEL_ALUNO;
        @endphp
        <form action="{{route('admin.aluno.update', $matricula->user->id)}}" method="POST" class="col s12 m6" enctype="multipart/form-data"> 
        
          @csrf
          <a href="{{ route('admin.alunos') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px;">
              <i class="material-icons">arrow_back</i>
          </a>
          <a href="#" class="btn-floating"><i class="material-icons ">people</i></a> <span style="font-size: 20pt">@if($isAluno) Perfil: @else Editar aluno(a): @endif <span class="red-text">{{$matricula->user->nome}}</span>
          <br>
          

          <input type="hidden" name="nivel" value="aluno">

          
          <div style="width:300px; height:300px; margin: 0 auto">
               
            <div>
                <input type="file" id="imageInput" name="imagem" accept="image/*" style="visibility: hidden">
               <br>  <label for="imageInput">

                <img id="preview" class="center" src="{{$matricula->user->imagem ? asset('storage/'.$matricula->user->imagem) : asset('img/profileestude.webp')}}" alt="Imagem carregada" style="width:250px; height:250px; border-radius:100%; object-fit:cover;">
                          {{------ <img id="preview" class="center" src="{{asset('img/profileestude.webp')}}" alt="Imagem carregada" style="width:250px; height:250px; border-radius:100%; object-fit:cover;">-------}}

               </label>
            
            </div>
          </div>
        
          <div class="row">

       
            <div class="input-field  col s12 m6">
               <input id="nome" name="nome" type="text" class="validate" value="{{$matricula->user->nome}}" @if($isAluno) readonly @endif >
              <label for="nome">Nome Completo</label>
            </div> 

            
            <div class="input-field col s12 m6">
                <input id="email" name="email" type="email" class="validate" value="{{$matricula->user->email}}" @if($isAluno) readonly @endif >
                <label for="email">E-mail</label>
            </div>


            <div class="input-field col s12 m6">
                <input id="morada" name="morada" type="text" class="validate" value="{{$matricula->morada}}" @if($isAluno) readonly @endif >
                <label for="morada">Morada</label>
              </div>
           
           
              <div class="input-field col s12 m6">
                <input id="nascimento" name="nascimento" type="date" class="validate" value="{{$matricula->nascimento}}" @if($isAluno) readonly @endif >
                <label for="nascimento">Data Nascimento</label>
              </div>
           
          
              <div class="input-field col s12 m6">
                <input id="numerobi" type="text" name="n_bilhete" class="validate" value="{{$matricula->n_bilhete}}" @if($isAluno) readonly @endif >
                <label for="numerobi">Nº de Bilhete de Identificação</label>
                
              </div>

              <div class="input-field col s12 m6">
                <input id="nome_pai" name="nome_pai" type="text" class="validate" value="{{$matricula->nome_pai}}" @if($isAluno) readonly @endif >
                <label for="nome_pai">Nome completo  da Pai</label>
             
              </div>

              <div class="input-field col s12 m6">
                <input id="telefone" name="telefone" type="tel" class="validate" value="{{$matricula->telefone}}" @if($isAluno) readonly @endif >
                <label for="telefone">Nº Telefone</label>
                
              </div>

              <div class="input-field col s12 m6">
                <input id="nome_mae" name="nome_mae" type="text" class="validate" value="{{$matricula->nome_mae}}" @if($isAluno) readonly @endif >
                <label for="nome_mae">Nome completo da mãe</label>
              
              </div>


              <div class="input-field col s12 m6">
                <input id="area_formacao" name="area_formacao" type="text" class="validate" value="{{$matricula->area_formacao}}" @if($isAluno) readonly @endif >
                <label for="area_formacao">Área de Formação</label>
               
              </div>

              <div class="input-field col s12 m6">
                <input id="naturalidade" name="naturalidade" type="text" class="validate" value="{{$matricula->naturalidade}}" @if($isAluno) readonly @endif >
                <label for="naturalidade">Naturalidade</label>
                
              </div>

              <div class="input-field col s12 m6">
                <input id="classe" name="id_classe" type="text" class="validate" value="{{$matricula->classe ? $matricula->classe->designacao : ''}}" readonly >
                <label for="classe">Classe</label>
              </div>
              
              <div class="input-field col s12 m6">
                <input id="curso" name="id_curso" type="text" class="validate" value="{{$matricula->curso ? $matricula->curso->nome : ''}}" readonly >
                <label for="curso">Curso</label>
              </div>

              <div class="input-field col s12 m6">
                <input id="turma" name="id_turma" type="text" class="validate" value="{{$matricula->turma ? $matricula->turma->designacao : ''}}" readonly >
                <label for="turma">Turma</label>
              </div>

              <div class="input-field col s12 m6">
                <input id="ano" name="id_ano" type="text" class="validate" value="{{$ano->ano}}" readonly >
                <label for="ano">Ano Lectivo</label>
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
          
           
          
        @if(!$isAluno)
        <div class="" style="text-align: right">
            
          <a href="{{route('admin.alunos')}}" class="waves-effect waves-green btn red">Cancelar</a>
          <button type="submit" class="waves-green btn blue">Atualizar</button>
          
        </div>
        @endif
        
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


