@extends('admin.layout')
@section('title', $forum->titulo)
@section('conteudo')
<style>
    body {
        background: linear-gradient(135deg, #e3f0ff 0%, #f8fafc 100%) !important;
    }
    .forum-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }
    .forum-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #1976d2;
        margin-right: 18px;
    }
    .forum-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #1976d2;
        margin-bottom: 0;
    }
    .forum-status {
        font-size: 1rem;
        font-weight: 500;
        padding: 4px 14px;
        border-radius: 12px;
        background: #e3f2fd;
        color: #1976d2;
        margin-left: 10px;
        display: inline-block;
    }
    .forum-description {
        font-size: 1.1rem;
        color: #444;
        margin-bottom: 18px;
        background: #f5f5f5;
        border-radius: 8px;
        padding: 18px 20px;
        box-shadow: 0 1px 4px #0001;
    }
    .forum-meta {
        margin-bottom: 18px;
        display: flex;
        flex-wrap: wrap;
        gap: 18px;
    }
    .forum-meta .chip {
        background: #e3f2fd;
        color: #1976d2;
        font-weight: 500;
    }
    .forum-meta .meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 1rem;
        color: #555;
    }
    .comment-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 4px #0001;
        margin-bottom: 18px;
        padding: 16px 18px;
        position: relative;
    }
    .comment-card.destaque {
        border-left: 5px solid #43a047;
        background: #e8f5e9;
    }
    .comment-card.silenciado {
        opacity: 0.6;
        background: #ffebee;
    }
    .comment-user {
        font-weight: 600;
        color: #1976d2;
    }
    .comment-date {
        font-size: 0.95rem;
        color: #888;
        margin-left: 8px;
    }
    .comment-actions {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        gap: 6px;
    }
    .floating-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 100;
    }
    @media (max-width: 600px) {
        .forum-header { flex-direction: column; align-items: flex-start; }
        .forum-title { font-size: 1.4rem; }
        .forum-avatar { width: 40px; height: 40px; margin-bottom: 10px; }
    }
</style>
<div class="container">
    <div class="forum-header">
        <div style="display: flex; align-items: center;">
            <img src="{{ $forum->user->imagem ? asset('storage/'.$forum->user->imagem) : asset('img/user.png') }}" class="forum-avatar" alt="Avatar">
            <div>
                <span class="forum-title">{{ $forum->titulo }}</span>
                <span class="forum-status">
                    <i class="material-icons tiny">fiber_manual_record</i>
                    {{ ucfirst(str_replace('_', ' ', $forum->status)) }}
                </span>
            </div>
        </div>
        <div>
            <span class="meta-item"><i class="material-icons tiny">person</i> {{ $forum->user->nome }}</span>
        </div>
    </div>
    <div class="forum-description">
        <i class="material-icons left">info</i> <b>Descrição:</b> {!! nl2br(e($forum->descricao)) !!}
    </div>
    <div class="forum-meta">
        <div class="meta-item"><i class="material-icons tiny">group</i> Turmas:
            @foreach($forum->turmas as $turma)
                <span class="chip">{{ $turma->designacao }}</span>
            @endforeach
        </div>
        <div class="meta-item"><i class="material-icons tiny">event</i> Início: {{ \Carbon\Carbon::parse($forum->data_inicio)->format('d/m/Y H:i') }}</div>
        <div class="meta-item"><i class="material-icons tiny">event_available</i> Fim: {{ \Carbon\Carbon::parse($forum->data_fim)->format('d/m/Y H:i') }}</div>
    </div>
    <h5 style="margin-top: 30px; color: #1976d2;"><i class="material-icons left">forum</i> Comentários</h5>
    <div>
        @forelse($forum->comentarios as $comentario)
            <div class="comment-card @if($comentario->destaque) destaque @endif @if($comentario->silenciado) silenciado @endif">
                <div>
                    <span class="comment-user">{{ $comentario->user->nome }}</span>
                    <span class="comment-date">({{ $comentario->created_at->format('d/m/Y H:i') }})</span>
                </div>
                <div style="margin: 8px 0;">{{ $comentario->texto }}</div>
                @if($comentario->anexo)
                    <a href="{{ asset('storage/' . $comentario->anexo) }}" target="_blank" class="blue-text"><i class="material-icons left">attach_file</i>Ver anexo</a>
                @endif
                @if($comentario->destaque)
                    <span class="badge green white-text" style="margin-left:8px;">Destaque</span>
                @endif
                @if($comentario->silenciado)
                    <span class="badge red white-text" style="margin-left:8px;">Silenciado</span>
                @endif
                @can('moderar', $forum)
                <div class="comment-actions">
                    <form action="{{ route('forums.comentario.destacar', [$forum->id, $comentario->id]) }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="btn-flat tooltipped" data-tooltip="Destacar/Remover destaque"><i class="material-icons">star</i></button>
                    </form>
                    <form action="{{ route('forums.comentario.silenciar', [$forum->id, $comentario->id]) }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="btn-flat tooltipped" data-tooltip="Silenciar/Ativar"><i class="material-icons">volume_off</i></button>
                    </form>
                </div>
                @endcan
            </div>
        @empty
            <p class="grey-text">Nenhum comentário ainda.</p>
        @endforelse
    </div>
    @if(
        (auth()->user()->nivel === \App\Models\User::NIVEL_ALUNO && $forum->turmas->pluck('id')->contains(optional(auth()->user()->matricula)->id_turma))
        || (auth()->user()->nivel === \App\Models\User::NIVEL_PROFESSOR && auth()->user()->professor && $forum->turmas->pluck('id')->intersect(auth()->user()->professor->turmas->pluck('id'))->count() > 0)
        || (in_array(auth()->user()->nivel, [\App\Models\User::NIVEL_DIRETOR_GERAL, \App\Models\User::NIVEL_DIRETOR_PEDAGOGICO]))
    )
    <form action="{{ route('forums.responder', $forum->id) }}" method="POST" enctype="multipart/form-data" style="margin-top: 30px;">
        @csrf
        <div class="input-field">
            <textarea name="texto" class="materialize-textarea" required placeholder="Escreva sua resposta..."></textarea>
            <label for="texto">Sua resposta</label>
        </div>
        <div class="file-field input-field">
            <div class="btn"><span>Anexo</span><input type="file" name="anexo"></div>
            <div class="file-path-wrapper"><input class="file-path validate" type="text" placeholder="Envie um arquivo (opcional)"></div>
        </div>
        <button type="submit" class="btn blue"><i class="material-icons left">send</i>Responder</button>
    </form>
    @endif
    @can('moderar', $forum)
        @if($forum->status !== 'encerrado')
            <form action="{{ route('forums.fechar', $forum->id) }}" method="POST" style="margin-top:20px;">
                @csrf
                <button type="submit" class="btn red"><i class="material-icons left">lock</i>Fechar Fórum</button>
            </form>
        @endif
    @endcan
    <a href="{{ route('admin.forums') }}" class="btn grey floating-btn"><i class="material-icons left">arrow_back</i>Voltar</a>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.tooltipped');
        M.Tooltip.init(elems);
    });
</script>
@endsection 