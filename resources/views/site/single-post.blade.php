@extends('site.layout')
@section('title', $post->titulo)

@section('conteudo')

<div class="container" style="max-width: 900px;">
    <!-- Botão Voltar -->
    <div class="row" style="margin-bottom: 20px;">
        <div class="col s12">
            <a href="" class="btn waves-effect waves-light grey darken-1" style="border-radius: 4px;">
                <i class="material-icons left">arrow_back</i>
                Voltar aos Posts
            </a>
        </div>
    </div>

    <!-- Card Principal do Post -->
    <div class="row">
        <div class="col s12">
            <div class="card" style="border-radius: 8px; overflow: hidden;">
                <!-- Header do Post -->
                <div class="card-content blue darken-1 white-text" style="padding: 30px;">
                    <h4 class="card-title" style="margin: 0; line-height: 1.3; font-weight: 400;">
                        {{$post->titulo}}
                    </h4>
                    
                    <!-- Meta informações -->
                    <div style="margin-top: 20px; opacity: 0.9;">
                        <div class="chip white blue-text" style="margin-right: 10px;">
                            <i class="material-icons left tiny">person</i>
                            {{$post->user->nome}}
                        </div>
                        <div class="chip white blue-text" style="margin-right: 10px;">
                            <i class="material-icons left tiny">date_range</i>
                            {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}
                        </div>
                        <div class="chip white blue-text">
                            <i class="material-icons left tiny">schedule</i>
                            {{ \Carbon\Carbon::parse($post->created_at)->format('H:i') }}
                        </div>
                    </div>
                </div>

                <div class="col s12">
                     <img src="{{asset('storage/'. $post->imagem)}}" alt="" srcset="" style="max-height: 350px; width:100%; object-fit:cover;">
                </div>

                <!-- Conteúdo do Post -->
                <div class="card-content" style="padding: 40px;">
                    <div class="post-content" style="line-height: 1.8; font-size: 1.1rem; color: #424242;">
                        {!! ($post->conteudo) !!}
                    </div>
                </div>

                <!-- Ações do Post -->
                <div class="card-action" style="background-color: #fafafa; padding: 20px 40px;">
                    <div class="row" style="margin-bottom: 0;">
                        <div class="col s12 m8">
                           
                        </div>
                        <div class="col s12 m4 right-align">
                            <!-- Botões secundários -->
                           
                            <a  onclick="print()" href="#" class="btn-flat waves-effect">
                                <i class="material-icons left">print</i>
                                Imprimir
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informações Adicionais -->
    <div class="row">
        <!-- Estatísticas -->
        <div class="col s12 m6">
            <div class="card" style="border-radius: 8px;">
                <div class="card-content">
                    <span class="card-title grey-text text-darken-2">
                        <i class="material-icons left">analytics</i>
                        Estatísticas
                    </span>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col s6 center-align">
                            <h5 class="blue-text">{{ strlen(strip_tags($post->conteudo)) }}</h5>
                            <p class="grey-text">Caracteres</p>
                        </div>
                        <div class="col s6 center-align">
                            <h5 class="blue-text">{{ str_word_count(strip_tags($post->conteudo)) }}</h5>
                            <p class="grey-text">Palavras</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações do Autor -->
        <div class="col s12 m6">
            <div class="card" style="border-radius: 8px;">
                <div class="card-content">
                    <span class="card-title grey-text text-darken-2">
                        <i class="material-icons left">person</i>
                        Sobre o Autor
                    </span>
                    <div style="margin-top: 20px;">
                        <div class="author-info">
                            <div class="chip blue lighten-5" style="width: 100%; margin-bottom: 10px;">
                                <i class="material-icons left blue-text">account_circle</i>
                                <span class="blue-text text-darken-2" style="font-weight: 500;">{{$post->user->nome}}</span>
                            </div>
                            @if(isset($post->user->email))
                            <div class="chip grey lighten-4" style="width: 100%;">
                                <i class="material-icons left grey-text">email</i>
                                <span class="grey-text text-darken-2">{{$post->user->email}}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Relacionados (Opcional) -->
    @if(isset($relatedPosts) && $relatedPosts->count() > 0)
    <div class="row">
        <div class="col s12">
            <div class="card" style="border-radius: 8px;">
                <div class="card-content">
                    <span class="card-title grey-text text-darken-2">
                        <i class="material-icons left">library_books</i>
                        Posts Relacionados
                    </span>
                    <div class="collection" style="margin-top: 20px; border: none;">
                        @foreach($relatedPosts as $relatedPost)
                        <a href="{{route('single.post', $relatedPost->id)}}" class="collection-item waves-effect" style="border-radius: 4px; margin-bottom: 5px;">
                            <div>
                                <span class="title">{{$relatedPost->titulo}}</span>
                                <p class="grey-text">Por {{$relatedPost->user->nome}} • {{ \Carbon\Carbon::parse($relatedPost->created_at)->format('d/m/Y') }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal de Confirmação de Exclusão -->
<div id="modal-delete" class="modal">
    <div class="modal-content">
        <h4 class="red-text">
            <i class="material-icons left">warning</i>
            Confirmar Exclusão
        </h4>
        <p>Tem certeza que deseja excluir este post? Esta ação não pode ser desfeita.</p>
        <div class="post-info" style="background-color: #f5f5f5; padding: 15px; border-radius: 4px; margin: 20px 0;">
            <strong>Post:</strong> {{$post->titulo}}<br>
            <strong>Autor:</strong> {{$post->user->nome}}<br>
            <strong>Data:</strong> {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i') }}
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        <form action="#" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn red waves-effect waves-light">
                <i class="material-icons left">delete</i>
                Excluir
            </button>
        </form>
    </div>
</div>

<style>
    /* Estilos personalizados */
    .post-content {
        text-align: justify;
    }
    
    .post-content p {
        margin-bottom: 20px;
    }
    
    .chip {
        border-radius: 20px;
        font-weight: 500;
    }
    
    .card {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .author-info .chip {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 0 15px;
        height: 40px;
    }
    
    .collection-item {
        border-radius: 4px !important;
        margin-bottom: 5px;
        border: 1px solid #e0e0e0 !important;
    }
    
    .collection-item:hover {
        background-color: #f5f5f5 !important;
    }
    
    .modal {
        border-radius: 8px;
        max-width: 500px;
    }
    
    /* Responsividade */
    @media only screen and (max-width: 600px) {
        .container {
            padding: 0 10px;
        }
        
        .card-content {
            padding: 20px !important;
        }
        
        .card-action {
            padding: 15px 20px !important;
        }
        
        .col.m4.right-align {
            text-align: left !important;
            margin-top: 10px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar modais
        var modals = document.querySelectorAll('.modal');
        M.Modal.init(modals);
        
        // Função para imprimir
        function printPost() {
            window.print();
        }
    });
</script>

@endsection