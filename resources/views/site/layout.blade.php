<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>INSTITUTO 30 DE SETEMBRO</title>
  <!-- Import MaterializeCSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
  <!-- Import Google Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/custom.css')}}">
  <style>
    
  </style>
</head>
<body>

<header>

    <!-- Dropdown Structure -->
    <ul id='dropdown3' class='dropdown-content'>     
      <li><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
      <li><a href="{{route('login.logout')}}">Sair</a></li> 
    </ul>

  <!-- Navbar -->
  <div class="navbar-fixed">
    <nav class="blue darken-3">
      <div class="nav-wrapper container">
        <a href="#" class="brand-logo"><i class="material-icons">auto_stories</i></a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
          <li><a href="{{ route('site.sobre') }}">Sobre Nós</a></li>
          <li><a href="#posts">Posts</a></li>
          <li><a href="#contactos">Contactos</a></li>
          @auth
          <li><a href="#" class="dropdown-trigger" data-target='dropdown3'>{{Str::limit(auth()->user()->nome, 5)}} <i class="material-icons right">expand_more</i> </a></li>
          @else
          <li><a href="{{route('login.form')}}" class="active modal-trigger">Login </a></li>
          @endauth
        </ul>
      </div>
    </nav>
  </div>

  <!-- Menu Mobile -->
  <ul class="sidenav" id="mobile-demo">
    <li><div class="user-view">
      <div class="background blue darken-3">
      </div>

    
      
      <h3 href="#"><span class="white-text name center">IP30 SETEMBRO</span></h3> 
     @auth
       
      <a href="#"><span class="white-text email center">{{auth()->user()->nome}}</span></a>
          
      @endauth
    </div></li>
    <li><a href="{{ route('site.sobre') }}"><i class="material-icons">info</i>Sobre Nós</a></li>
    <li><a href="#posts"><i class="material-icons">description</i>Posts Recentes</a></li>
    <li><a href="#contactos"><i class="material-icons">contact_mail</i>Contactos</a></li>

     @auth
       <li><a href="{{route('login.logout')}}" class="active modal-trigger"><i class="material-icons">lock</i>Logout </a></li>
      @else
      <li><a href="{{route('login.form')}}" class="active modal-trigger"><i class="material-icons">lock</i>Login </a></li>
     @endauth

    <li><div class="divider"></div></li>
    <li><a class="subheader">Portal</a></li>
    <li><a class="waves-effect" href="#">Portal do Aluno</a></li>
    <li><a class="waves-effect" href="#">Secretaria Online</a></li>
  </ul>
</header>


      

   @yield('conteudo')


{{---RODAPE---}}
   <footer class="page-footer blue darken-3">
	 <div class="container">
	   <div class="row">
		 <div class="col s12 m4">
		   <h5 class="white-text">Links Importantes</h5>
		   <ul>
			 <li><a class="white-text" href="#"><i class="material-icons tiny left">school</i>Portal do Aluno</a></li>
			 <li><a class="white-text" href="#"><i class="material-icons tiny left">book</i>Secretaria Online</a></li>
			 <li><a class="white-text" href="#"><i class="material-icons tiny left">date_range</i>Calendário Escolar</a></li>
		   </ul>
		 </div>
		 <div class="col s12 m4">
		   <h5 class="white-text">Redes Sociais</h5>
		   <div class="social-icons">
			 <a href="#" class="white-text"><i class="material-icons">facebook</i></a>
			 <a href="#" class="white-text"><i class="material-icons">chat</i></a>
			 <a href="#" class="white-text"><i class="material-icons">photo_camera</i></a>
			 <a href="#" class="white-text"><i class="material-icons">video_library</i></a>
		   </div>
		 </div>
		 <div class="col s12 m4">
		   <h5 class="white-text">Newsletter</h5>
		   <div class="input-field">
			 <input id="newsletter" type="email" class="white-text">
			 <label for="newsletter">Seu email</label>
			 <button class="btn waves-effect waves-light yellow darken-3">Inscrever-se</button>
		   </div>
		 </div>
	   </div>
	 </div>
	 <div class="footer-copyright">
	   <div class="container">
	   © 2025 Escola Exemplo - Todos os direitos reservados
	   </div>
	 </div>
   </footer>
 
   <!-- Scripts -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	  <script src="{{asset('js/script.js')}}" type="text/javascript"></script>
	  <script src="{{asset('js/main.js')}}"></script>
    @stack('scripts')
 </body>
 </html>