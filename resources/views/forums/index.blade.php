@extends('admin.layout')
@section('title', 'Fóruns')
@section('conteudo')
<div class="container">
    <h4>Fóruns</h4>
    <form method="GET" class="row">
        <div class="input-field col s4">
            <select name="turma_id">
                <option value="">Todas as turmas</option>
                @foreach($turmas as $turma)
                    <option value="{{$turma->id}}" {{ request('turma_id') == $turma->id ? 'selected' : '' }}>{{$turma->designacao}}</option>
                @endforeach
            </select>
            <label>Turma</label>
        </div>
        <div class="input-field col s4">
            <select name="status">
                <option value="">Todos os status</option>
                <option value="novo" {{ request('status') == 'novo' ? 'selected' : '' }}>Novo</option>
                <option value="em_andamento" {{ request('status') == 'em_andamento' ? 'selected' : '' }}>Em andamento</option>
                <option value="encerrado" {{ request('status') == 'encerrado' ? 'selected' : '' }}>Encerrado</option>
            </select>
            <label>Status</label>
        </div>
        <div class="input-field col s4">
            <button class="btn blue">Filtrar</button>
            @can('create', App\Models\Forum::class)
                <a href="{{ route('admin.forum.create') }}" class="btn green">Novo Fórum</a>
            @endcan
        </div>
    </form>
    <table class="striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Turmas</th>
                <th>Status</th>
                <th>Início</th>
                <th>Fim</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($forums as $forum)
                <tr>
                    <td>{{ $forum->titulo }}</td>
                    <td>
                        @foreach($forum->turmas as $turma)
                            <span class="chip">{{ $turma->designacao }}</span>
                        @endforeach
                    </td>
                    <td>{{ ucfirst(str_replace('_', ' ', $forum->status)) }}</td>
                    <td>{{ \Carbon\Carbon::parse($forum->data_inicio)->format('d/m/Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($forum->data_fim)->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('forums.show', $forum->id) }}" class="btn-small blue">Ver</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">Nenhum fórum encontrado.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="center">{{ $forums->links() }}</div>
</div>
@endsection 