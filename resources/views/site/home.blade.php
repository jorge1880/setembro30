@extends('site.layout')
@section('title',"Home")
    
@section('conteudo')

<style>
    #home.bloco, #posts.section {
        background-image: url('{{ asset('img/banner-01.png') }}');
        background-size: cover;
        background-position: center;
        position: relative;
        z-index: 1;
    }
    #home.bloco::before, #posts.section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to right, rgba(21, 101, 192, 0.7), rgba(0, 0, 0, 0.5));
        z-index: -1;
    }
    #posts.section h4 {
        color: white;
    }
</style>

    <!-- HOME -->
    <section class="bloco scrollspy" id="home" >
    	<div class="row container">
    		<div class="col s12 center">
    			<h3 class="white-text"> INSTITUTO POLITÉCNICO 30 DE SETEMBRO</h3>
    			
    		</div>
    	</div>
    </section>

     <!-- Carrossel de Imagens Principal -->
  <div class="carousel carousel-slider center">
    <div class="carousel-item amber white-text" href="#two!">
      
    <img src="{{asset('img/banner-05.png')}}">
      <h2>Inovação & Tecnologia</h2>
      <p class="white-text">Preparando líderes do amanhã</p>
    </div>

    <div class="carousel-item green white-text" href="#three!">
        <img src="{{asset('img/banner-02.png')}}">
      <h2>Educação de Qualidade</h2>
      <p class="white-text">Compromisso com o sucesso dos alunos</p>
    </div>

    <div class="carousel-item blue white-text" href="#four!">
        <img src="{{asset('img/banner-04.png')}}">
      <h2>Desenvolvimento Integral</h2>
      <p class="white-text">Formando cidadãos conscientes</p>
    </div>

  </div>

  <!-- Sobre Nós - Com duas colunas -->
  <div id="sobre" class="section container animated-section">
    <h4 class="center-align">Sobre Nós</h4>
    <div class="row">
      <!-- Carrossel à esquerda -->
      <div class="col s12 m6" >
        <div class="carousel carousel-slider center sobre-carousel" >
          <div class="carousel-item blue lighten-3 white-text" href="#sobre1!" >
             <img src="{{asset('img/banner-03.png')}}" alt="Feira de Ciências">
            <h5>Nossa História</h5>
            <p class="white-text">Fundada em 1990 com uma missão clara</p>
          </div>
          <div class="carousel-item teal lighten-3 white-text" href="#sobre2!">
            <img src="{{asset('img/bg.jpg')}}" alt="Feira de Ciências">
            <h5>Nossa Missão</h5>
            <p class="white-text">Formar cidadãos completos e preparados</p>
          </div>
          <div class="carousel-item purple lighten-3 white-text" href="#sobre3!">
             <img src="{{asset('img/bg2.jpg')}}" alt="Feira de Ciências">
            <h5>Nossos Valores</h5>
            <p class="white-text">Respeito, inovação e excelência</p>
          </div>
        </div>
      </div>
      <!-- Texto à direita -->
      <div class="col s12 m6">
        <div class="card-panel">
          <h5>Excelência em Educação</h5>
          <p>Somos uma escola comprometida com o ensino de qualidade, focada no desenvolvimento intelectual, social e emocional dos nossos alunos.</p>
          <div class="row" style="margin-top: 30px; margin-bottom: 10px;">
            <div class="col s4 center-align">
              <span class="counter-animate" data-count="{{ $totalAlunos }}" style="font-size:2rem; font-weight:bold; color:#1565c0;">{{ $totalAlunos }}</span><br>
              <span>Alunos</span>
            </div>
            <div class="col s4 center-align">
              <span class="counter-animate" data-count="{{ $totalCursos }}" style="font-size:2rem; font-weight:bold; color:#1565c0;">{{ $totalCursos }}</span><br>
              <span>Cursos</span>
            </div>
            <div class="col s4 center-align">
              <span class="counter-animate" data-count="{{ $totalProfessores }}" style="font-size:2rem; font-weight:bold; color:#1565c0;">{{ $totalProfessores }}</span><br>
              <span>Professores</span>
            </div>
          </div>
          <p>Nossa equipe de educadores altamente qualificados trabalha incansavelmente para garantir que cada estudante alcance seu potencial máximo em um ambiente acolhedor e estimulante.</p>
          <p>Oferecemos uma infraestrutura moderna, com laboratórios bem equipados, áreas de lazer espaçosas e salas de aula com tecnologia de ponta.</p>
          <a href="{{ route('site.sobre') }}" class="btn waves-effect waves-light blue darken-3">Saiba mais
            <i class="material-icons right">arrow_forward</i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Posts Recentes -->
  <div id="posts" class="section animated-section">
    <div class="container">
      <h4 class="center-align">Posts Recentes</h4>
      <div class="row">


         @foreach ($posts as $post)
             
        
        <div class="col s12 m4">
          <div class="card">
            <div class="card-image waves-effect waves-block waves-light">
              <img src="{{asset('storage/'.$post->imagem)}}" alt="Feira de Ciências" style="height:250px;width: 100%; object-fit: cover; object-position: center;">
              <span class="card-title bg alert-primary">{{$post->titulo}}</span>
            </div>
            <div class="card-content">
              {!! strip_tags(Str::limit($post->conteudo, 120)) !!}
            </div>
            <div class="card-action">
              <a href="{{route('single.post', $post->id)}}" class="blue-text">Leia mais</a>
            </div>
          </div>
        </div>

         @endforeach


      </div>
    </div>
  </div>

  <!-- Contactos -->
  <div id="contactos" class="section grey lighten-4 animated-section">
    <div class="container">
      <h4 class="center-align">Contactos</h4>
      <div class="row">
        <form class="col s12 m6" style="margin-bottom: 20px">
            <div class="card-panel">
              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">account_circle</i>
                  <input id="nome" type="text" class="validate">
                  <label for="nome">Nome</label>
                </div>
                <div class="input-field col s12">
                  <i class="material-icons prefix">email</i>
                  <input id="email" type="email" class="validate">
                  <label for="email">Email</label>
                </div>
                <div class="input-field col s12">
                  <i class="material-icons prefix">message</i>
                  <textarea id="mensagem" class="materialize-textarea"></textarea>
                  <label for="mensagem">Mensagem</label>
                </div>
                <div class="input-field col s12">
                  <button class="btn waves-effect waves-light blue darken-3">Enviar
                    <i class="material-icons right">send</i>
                  </button>
                </div>
              </div>
            </div>
          </form>

        <div class="col s12 m6">
          <div class="card">
            <div class="card-content">
              <span class="card-title"><i class="material-icons left">location_on</i>Localização</span>
              <div class="card-image">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3857.9703745713323!2d-39.26573268527739!3d-14.770698889694328!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x739009ddf8f3277%3A0x10113c57b40aa420!2sNode+Studio+Treinamentos!5e0!3m2!1spt-BR!2sbr!4v1508690488190" width="100%" height="90" frameborder="0" allowfullscreen></iframe>
              </div>
              <div class="card-content">
                <ul class="collection">
                  <li class="collection-item"><i class="material-icons left tiny">place</i>Endereço: Rua Principal, Luanda, Angola</li>
                  <li class="collection-item"><i class="material-icons left tiny">phone</i>Telefone: +244 123 456 789</li>
                  <li class="collection-item"><i class="material-icons left tiny">email</i>Email: contato@30setembro.com</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
       
      </div>
    </div>
  </div>

    @endsection