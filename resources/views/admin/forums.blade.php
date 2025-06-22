@extends('admin.layout')
@section('title','Forums')

@section('conteudo')

<div class="container">
    <!-- Botão de adicionar -->
    <div class="fixed-action-btn">
        <a href="{{route('admin.forum.create')}}" class="btn-floating btn-large bg-gradient-green modal-trigger waves-effect waves-light tooltipped" data-position="left" data-tooltip="Adicionar novo post"> 
            <i class="large material-icons">add</i>
        </a>
    </div>

    <!-- Header da seção -->
    <div class="row">
        <div class="col s12 center-align" style="margin-bottom: 30px;">
            <a href="{{ route('admin.dashboard') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px; position: absolute; top: 0; left: 20px;">
                <i class="material-icons">arrow_back</i>
            </a>
            <h4 class="blue-text text-darken-2">
                <i class="material-icons left">article</i>
                Gerenciar Forums
            </h4>
            <p class="grey-text">Visualize e gerencie todos os forums do sistema</p>
        </div>
    </div>
   <!-- Cards dos posts -->
<div class="row">
    @forelse ($forums as $forun)

     {{------@include('admin.posts.delete')----}}
    

        <div class="col s12 m6 l4">
            <div class="card hoverable" style="border-radius: 8px; overflow: hidden; height: auto; min-height: 450px;">
                     
                <!-- Imagem do post -->
                @if(isset($forun->imagem) && $forun->imagem)
                    <div class="card-image" style="position: relative;">
                        <img src="{{ asset('storage/' . $forun->imagem) }}" 
                             alt="{{$forun->titulo}}" 
                             style="height:250px;width: 100%; object-fit: cover; object-position: center;">
                        
                        <!-- Overlay com ações rápidas -->
                        <div class="card-image-overlay" style="position: absolute; top: 10px; right: 10px; opacity: 0; transition: opacity 0.3s ease;">
                            <a href="#" class="btn-floating btn-small waves-effect waves-light white tooltipped" data-position="left" data-tooltip="Visualizar">
                                <i class="material-icons blue-text">visibility</i>
                            </a>
                        </div>
                        
                        <!-- Badge opcional -->
                        @if(isset($forun->categoria))
                            <span class="new badge blue" data-badge-caption="" style="position: absolute; top: 10px; left: 10px; background: rgba(33, 150, 243, 0.9); border-radius: 12px; padding: 4px 12px; font-size: 0.8rem;">
                                {{$forun->categoria}}
                            </span>
                        @endif
                    </div>
                @else
                    <!-- Placeholder quando não há imagem -->
                    <div class="card-image-placeholder" style="height: 150px; background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%); display: flex; align-items: center; justify-content: center; flex-direction: column;">
                        <i class="material-icons large grey-text text-lighten-2" style="font-size: 3rem; margin-bottom: 8px;">image</i>
                        <span class="grey-text text-lighten-1" style="font-size: 0.9rem; font-weight: 500;">Sem imagem</span>
                    </div>
                @endif

                <!-- Header do card com título -->
                <div class="card-content blue darken-1 white-text center-align" style="padding: 15px;">
                    <span class="card-title" style="font-size: 1.2rem; font-weight: 500; line-height: 1.3; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{$forun->tema_forum}}">
                        {{$forun->tema_forum}}
                    </span>
                </div>

                <!-- Conteúdo do card -->
                <div class="card-content" style="padding: 20px; display: flex; flex-direction: column; justify-content: space-between; min-height: 200px;">
                    <!-- Conteúdo do forun -->
                    <div style="flex-grow: 1; margin-bottom: 15px;">
                        <p class="grey-text text-darken-1" style="line-height: 1.5; text-align: justify; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; margin-bottom: 15px;">
                            {!! strip_tags(Str::limit($forun->conteudo, 120)) !!}
                        </p>
                        
                        <!-- Data de publicação -->
                        <div style="margin-bottom: 15px;">
                            <div class="chip grey lighten-4" style="font-size: 0.8rem; margin-right: 8px;">
                                <i class="material-icons left tiny grey-text">schedule</i>
                                <span class="grey-text text-darken-1">
                                    {{ \Carbon\Carbon::parse($forun->created_at)->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>

                        <div style="margin-bottom: 15px;">
                            <div class="chip grey lighten-4" style="font-size: 0.8rem; margin-right: 8px;">
                                <i class="material-icons left tiny grey-text">school</i>
                                <span class="grey-text text-darken-1">
                                     {{$forun->turma->designacao}}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Informações do autor e ações -->
                    <div>
                        <!-- Autor -->
                        <div class="author" style="margin-bottom: 15px; padding: 8px 0; border-top: 1px solid #e0e0e0;">
                            <div class="chip blue lighten-5">
                                <i class="material-icons left tiny blue-text">person</i>
                                <span class="blue-text text-darken-2" style="font-size: 0.9rem;">{{$forun->user->nome}}</span>
                            </div>
                        </div>

                      
                <div class="card-action center-align" style="padding: 0;">
                    <a href="{{ route('single.post', $forun->id) }}" class="btn waves-effect waves-light blue darken-1" style="margin-right: 5px; border-radius: 4px; font-size: 0.9rem;">
                        <i class="material-icons left small">visibility</i>
                        Ver mais
                    </a>

                    <a href="{{ route('admin.post.edit', $forun->id) }}" class="btn-small waves-effect waves-light orange tooltipped" style="border-radius: 4px; margin-right: 3px;" data-position="top" data-tooltip="Editar">
                        <i class="material-icons">edit</i>
                    </a>

                    <!-- Gatilho do modal de exclusão -->
                    <a href="#delete-{{ $forun->id }}" class="btn btn-small modal-trigger waves-effect waves-light red tooltipped" style="border-radius: 4px;" data-position="top" data-tooltip="Excluir">
                        <i class="material-icons">delete</i>
                    </a>

                </div>

                </div> 
                </div>
            </div>
        </div>
     

        
    @empty
        <!-- Estado vazio -->
        <div class="col s12">
            <div class="card-panel center-align grey lighten-4" style="padding: 60px 20px; border-radius: 8px;">
                <i class="material-icons large grey-text" style="font-size: 5rem; margin-bottom: 20px;">article</i>
                <h5 class="grey-text text-darken-1">Nenhum forum encontrado</h5>
                <p class="grey-text">Clique no botão + para adicionar seu primeiro forum</p>
                <a href="{{route('admin.post.create')}}" class="btn waves-effect waves-light blue darken-1" style="margin-top: 20px; border-radius: 4px;">
                    <i class="material-icons left">add</i>
                    Criar primeiro forum
                </a>
            </div>
        </div>

        
    @endforelse
</div>

    <!-- Paginação (se necessário) -->
    @if(method_exists($forums, 'links'))
        <div class="row">
            <div class="col s12 center-align" style="margin-top: 30px;">
                {{ $forums->links('pagination.pagination') }}
            </div>
        </div>
    @endif
</div>


 
<style>
    /* Estilos personalizados para melhorar a aparência */
    .card {
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .card-title {
        margin-bottom: 0 !important;
    }
    
    .chip {
        border-radius: 20px;
        font-weight: 500;
    }
    
    .btn, .btn-small {
        text-transform: none;
        font-weight: 500;
    }
    
    .fixed-action-btn {
        z-index: 997;
    }
    
    /* Responsividade melhorada */
    @media only screen and (max-width: 992px) {
        .card {
            height: auto !important;
            min-height: 350px;
        }
    }
    
    @media only screen and (max-width: 600px) {
        .container {
            padding: 0 10px;
        }
        
        .card-content {
            padding: 15px !important;
        }
        
        .card {
            height: auto !important;
            min-height: 320px;
        }
    }


    /* Estilos específicos para os cards com imagem */
    .card {
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    /* Efeitos da imagem */
    .card-image img {
        transition: transform 0.3s ease;
    }
    
    .card-image:hover img {
        transform: scale(1.05);
    }
    
    .card-image:hover .card-image-overlay {
        opacity: 1;
    }
    
    /* Placeholder da imagem */
    .card-image-placeholder {
        transition: background 0.3s ease;
    }
    
    .card:hover .card-image-placeholder {
        background: linear-gradient(135deg, #eeeeee 0%, #d0d0d0 100%) !important;
    }
    
    /* Chips e badges */
    .chip {
        border-radius: 20px;
        font-weight: 500;
    }
    
    .badge {
        backdrop-filter: blur(10px);
    }
    
    /* Botões */
    .btn, .btn-small {
        text-transform: none;
        font-weight: 500;
    }
    
    /* Responsividade */
    @media only screen and (max-width: 992px) {
        .card {
            min-height: 400px !important;
        }
        
        .card-image img {
            height: 180px !important;
        }
        
        .card-image-placeholder {
            height: 130px !important;
        }
    }
    
    @media only screen and (max-width: 600px) {
        .card {
            min-height: 350px !important;
            margin-bottom: 20px;
        }
        
        .card-content {
            padding: 15px !important;
        }
        
        .card-image img {
            height: 160px !important;
        }
        
        .card-image-placeholder {
            height: 120px !important;
        }
        
        .card-image-overlay {
            opacity: 1 !important;
        }
    }
    
    /* Animação de entrada */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .card {
        animation: slideInUp 0.6s ease forwards;
    }
</style>

@endsection