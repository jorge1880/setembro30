@extends('site.layout')
@section('title', 'Sobre Nós')

@section('conteudo')

<style>
    .hero-section {
        background-image: url('{{ asset('img/banner-02.png') }}');
        background-size: cover;
        background-position: center;
        position: relative;
        z-index: 1;
        padding: 60px 0;
        color: white;
    }
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to right, rgba(21, 101, 192, 0.8), rgba(0, 0, 0, 0.6));
        z-index: -1;
    }
    .timeline {
        position: relative;
        padding: 20px 0;
    }
    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 4px;
        height: 100%;
        background-color: #1565c0; /* Azul escuro */
    }
    .timeline-item {
        position: relative;
        width: 50%;
        padding: 10px 40px;
        box-sizing: border-box;
    }
    .timeline-item:nth-child(odd) {
        left: 0;
    }
    .timeline-item:nth-child(even) {
        left: 50%;
    }
    .timeline-item .timeline-content {
        background: #fff;
        padding: 20px;
        border-radius: 6px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .timeline-item::after {
        content: '';
        position: absolute;
        width: 25px;
        height: 25px;
        right: -12.5px;
        top: 25px;
        background-color: white;
        border: 4px solid #1565c0;
        border-radius: 50%;
        z-index: 1;
    }
    .timeline-item:nth-child(even)::after {
        left: -12.5px;
    }
    .tabs .tab a {
        color: #1565c0;
    }
    .tabs .tab a:hover, .tabs .tab a.active {
        background-color: #e3f2fd; /* Azul claro */
        color: #1565c0;
    }
    .tabs .indicator {
        background-color: #1565c0;
    }
</style>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container center-align">
        <h1>Sobre o Instituto 30 de Setembro</h1>
        <p class="flow-text">Compromisso com a excelência na educação desde 1990.</p>
    </div>
</div>

<div class="container">
    <!-- História da Instituição - Timeline -->
    <div id="historia" class="section scrollspy">
        <h4 class="center-align">Nossa História</h4>
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-content">
                    <h5>1990 - Fundação</h5>
                    <p>O instituto foi fundado com a visão de oferecer educação de qualidade e formar líderes para o futuro.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content">
                    <h5>2005 - Expansão</h5>
                    <p>Inauguramos nosso novo campus, com instalações modernas e laboratórios de última geração para diversos cursos.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-content">
                    <h5>2015 - Reconhecimento</h5>
                    <p>Recebemos o prêmio nacional de excelência acadêmica, consolidando nossa posição como referência no país.</p>
                </div>
            </div>
             <div class="timeline-item">
                <div class="timeline-content">
                    <h5>Hoje</h5>
                    <p>Continuamos a inovar, oferecendo novos cursos e uma plataforma digital completa para nossos alunos.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Missão, Visão e Valores - Tabs -->
    <div id="missao" class="section scrollspy">
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s4"><a class="active" href="#missao-tab">Missão</a></li>
                    <li class="tab col s4"><a href="#visao-tab">Visão</a></li>
                    <li class="tab col s4"><a href="#valores-tab">Valores</a></li>
                </ul>
            </div>
            <div id="missao-tab" class="col s12 card-panel">
                <h5>Missão</h5>
                <p>Promover uma educação integral e de excelência, desenvolvendo habilidades e competências para que nossos alunos se tornem cidadãos críticos, criativos e éticos, capazes de transformar a sociedade.</p>
            </div>
            <div id="visao-tab" class="col s12 card-panel">
                <h5>Visão</h5>
                <p>Ser uma instituição de referência em educação inovadora, reconhecida pela qualidade de seu ensino, pesquisa e impacto positivo na comunidade, preparando os líderes do amanhã.</p>
            </div>
            <div id="valores-tab" class="col s12 card-panel">
                <h5>Valores</h5>
                <ul>
                    <li><i class="material-icons tiny left">check</i>Excelência Acadêmica</li>
                    <li><i class="material-icons tiny left">check</i>Inovação e Criatividade</li>
                    <li><i class="material-icons tiny left">check</i>Ética e Respeito</li>
                    <li><i class="material-icons tiny left">check</i>Responsabilidade Social</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Infraestrutura - Galeria de Imagens -->
    <div id="infraestrutura" class="section scrollspy">
        <h4 class="center-align">Nossa Infraestrutura</h4>
        <div class="row">
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        <img class="materialboxed" src="{{asset('img/banner-03.png')}}" alt="Laboratório de Informática">
                    </div>
                    <div class="card-content">
                        <p>Laboratórios de informática equipados com a mais alta tecnologia.</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                 <div class="card">
                    <div class="card-image">
                        <img class="materialboxed" src="{{asset('img/bg.jpg')}}" alt="Biblioteca">
                    </div>
                    <div class="card-content">
                        <p>Biblioteca com um vasto acervo de livros e ambiente de estudo.</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                 <div class="card">
                    <div class="card-image">
                        <img class="materialboxed" src="{{asset('img/bg2.jpg')}}" alt="Área de Convivência">
                    </div>
                    <div class="card-content">
                        <p>Áreas de convivência para promover a interação e o bem-estar dos alunos.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializador para as abas (Tabs)
        var tabs = document.querySelectorAll('.tabs');
        M.Tabs.init(tabs);

        // Inicializador para as imagens que expandem (Materialbox)
        var elems = document.querySelectorAll('.materialboxed');
        M.Materialbox.init(elems);
    });
</script>
@endpush 