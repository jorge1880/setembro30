<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>   
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
     <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

    <!-- Custom CSS-->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
   
    <style>
       
    </style>
    </style>
 
</head>
<body>
     
    <!-- Dropdown Structure -->
    <ul id='dropdown2' class='dropdown-content'>     
      <li><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
      <li><a href="{{route('site.home')}}">Home</a></li>
      <li><a href="{{route('admin.profile')}}">Meu Perfil</a></li>
      @php
        $user = auth()->user();
      @endphp

    @if($user)
        <li><a href="{{route('site.home')}}">{{ $user->nivel }}</a></li>
        <li><a href="{{route('login.logout')}}">Sair</a></li>
    @endif
    </ul>


    <nav class="blue">
        <div class="nav-wrapper container ">
            <a href="#" class="center brand-logo " href="index.html"><i class="material-icons" style="font-size: 40px">school</i>30</a>          
          <ul class="right ">                                 
              @if($user)
                  <li class="hide-on-med-and-down">
                      <a href="#">
                          <img src="{{ asset('storage/' . $user->imagem ) }}" alt="" style="width: 60px; height:60px; object-fit: cover; border-radius:100%;">
                      </a>
                  </li>
                  <li>
                      <a href="#" class="dropdown-trigger" data-target='dropdown2'>{{ Str::limit($user->nome, 9) }} <i class="material-icons right">expand_more</i></a>
                  </li>     
              @endif
          </ul>
          <a href="#" data-target="slide-out" class="sidenav-trigger left  show-on-large"><i class="material-icons">menu</i></a>
        </div>
      </nav>
    

    @if($user)
    <ul id="slide-out" class="sidenav " >
      <li><div class="user-view center">
        <div class="background blue "></div >
          <a href="#user" class="white-text"><i class="material-icons prefix" style="font-size: 70px;">account_circle</i></a>
          <a href="#name"><span class="white-text name">{{$user->nome}}</span></a>
          <a href="#email"><span class="white-text email">{{$user->email}}</span></a>
       </div></li> 

        <li><a href="{{route('admin.dashboard')}}"><i class="material-icons">dashboard</i>Dashboard</a></li>
        <li><a href="{{route('admin.profile')}}"><i class="material-icons">account_circle</i>Meu Perfil</a></li>
        @can('viewAny', App\Models\Curso::class)
        <li><a href="{{route('admin.cursos')}}"><i class="material-icons">library_books</i>Cursos</a></li>
        @endcan
        @can('viewAny', App\Models\Turma::class)
        <li><a href="{{route('admin.turmas')}}"><i class="material-icons">doorbell</i>Turmas</a></li>
        @endcan
        @can('viewAny', App\Models\Disciplina::class)
        <li><a href="{{route('admin.disciplinas')}}"><i class="material-icons">menu_book</i>Disciplinas</a></li>
        @endcan
        @can('viewAny', App\Models\Classe::class)
        <li><a href="{{route('admin.classes')}}"><i class="material-icons">school</i>Classes</a></li>
        @endcan
        @can('viewAny', App\Models\Aula::class)
        <li><a href="{{route('admin.aulas')}}"><i class="material-icons">auto_stories</i>Aulas</a></li>
        @endcan
        @can('viewAny', App\Models\Matricula::class)
        <li><a href="{{route('admin.alunos')}}"><i class="material-icons">people</i>Alunos</a></li>
        @endcan
        @can('viewAny', App\Models\Professor::class)
        <li><a href="{{route('admin.professores')}}"><i class="material-icons">manage_accounts</i>Professores</a></li>
        @endcan
        @if (in_array(auth()->user()->nivel, [\App\Models\User::NIVEL_DIRETOR_GERAL, \App\Models\User::NIVEL_DIRETOR_PEDAGOGICO, 'admin']))
        <li><a href="{{route('admin.users')}}"><i class="material-icons">admin_panel_settings</i>Usuários</a></li>
        @endif
        @can('viewAny', App\Models\Ano_lectivo::class)
        <li><a href="{{route('admin.anos')}}"><i class="material-icons">calendar_month</i>Anos Lectivos</a></li>
        @endcan
        @can('viewAny', App\Models\Post::class)
        <li><a href="{{route('admin.posts')}}"><i class="material-icons">local_post_office</i>Posts</a></li>
        @endcan
        @can('viewAny', App\Models\Forum::class)
        <li><a href="{{route('admin.forums')}}"><i class="material-icons">help</i>Fóruns</a></li>
        @endcan
    </ul>
    @endif



      @yield('conteudo')

      @include('admin.mensagem.mensagem')

      



        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script src="{{asset('js/chart.js')}}" ></script>
        <script src="{{asset('js/main.js')}}"></script>

        <script>
          document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.modal');
            var instances = M.Modal.init(elems);
        
            @if(session('sucesso'))
                // Espera o DOM estar pronto, então mostra o modal de sucesso
                var modal = M.Modal.getInstance(document.getElementById('modal-confirmacao'));
                if (modal) {
                    modal.open();
                }
            @endif

            @if(session('success'))
                // Espera o DOM estar pronto, então mostra o modal de sucesso
                var modal = M.Modal.getInstance(document.getElementById('modal-confirmacao'));
                if (modal) {
                    modal.open();
                }
            @endif

            @if(session('error'))
                // Espera o DOM estar pronto, então mostra o modal de erro
                var modalErro = M.Modal.getInstance(document.getElementById('modal-erro'));
                if (modalErro) {
                    modalErro.open();
                }
            @endif
          });
        </script>
        
        @stack('scripts')
    
    </body>
    </html>
