@extends('admin.layout')
@section('title', 'Meus Materiais de Apoio')

@section('conteudo')
<style>
    body {
        background-color: #f4f7f6;
    }
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2.5rem;
        border-radius: 0.75rem;
        margin-bottom: 2rem;
        color: white;
    }
    .material-card {
        background-color: #fff;
        border-radius: 0.75rem;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .material-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
    .card-icon {
        font-size: 2.5rem;
        width: 60px;
        height: 60px;
        line-height: 60px;
        text-align: center;
        border-radius: 50%;
        background-color: #f0f3ff;
        color: #667eea;
    }
    .card-footer {
        background-color: #fafbff;
        border-top: 1px solid #eef;
    }
</style>

<div class="container-fluid my-4">
    <div class="page-header text-center text-lg-start d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px; position: absolute; top: 20px; left: 20px;">
                <i class="material-icons">arrow_back</i>
            </a>
            <h1 class="h2 fw-bold">Gerenciar Materiais</h1>
            <p class="lead mb-0">Adicione, edite ou remova seus materiais de apoio.</p>
        </div>
        <a href="{{ route('professores.materiais.create') }}" class="btn btn-light mt-3 mt-lg-0 d-flex align-items-center">
            <i class="bi bi-plus-circle-fill me-2"></i>
            Adicionar Novo
        </a>
    </div>

    @include('admin.mensagem.mensagem')

    <div class="row g-4">
        @forelse ($materiais as $material)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="material-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="card-icon me-3">
                                <i class="bi {{ $material->icon_class }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="card-title fw-bold mb-1">{{ Str::limit($material->titulo, 40) }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit($material->descricao, 60) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            <i class="bi bi-journal-text me-1"></i>
                            {{ Str::limit(optional($material->aula)->descricao, 20) }}
                        </div>
                        <div>
                            <a href="{{ route('professores.materiais.edit', $material->id) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="bi bi-pencil-fill"></i> Editar
                            </a>
                            <form action="{{ route('professores.materiais.destroy', $material->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Remover">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center p-5 bg-white rounded-3 shadow-sm">
                    <img src="https://img.icons8.com/plasticine/100/000000/empty-box.png" alt="Caixa vazia" class="mb-3">
                    <h4 class="fw-bold">Nenhum material encontrado.</h4>
                    <p class="text-muted">Parece que você ainda não adicionou nenhum material de apoio.</p>
                    <a href="{{ route('professores.materiais.create') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-circle-fill me-2"></i>
                        Adicionar seu primeiro material
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if ($materiais->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $materiais->links('pagination.pagination') }}
        </div>
    @endif
</div>
@endsection 