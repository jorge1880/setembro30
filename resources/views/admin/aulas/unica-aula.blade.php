<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização de Aula</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- AOS Animação CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --color-primary: #1dd3a6;
            --color-primary-dark: #15a281;
            --color-secondary: #f0fdf9;
            --color-text: #333;
            --color-text-light: #6c757d;
            --color-bg: #f8f9fa;
        }

        body {
            background-color: var(--color-bg);
            font-family: 'Poppins', sans-serif;
            color: var(--color-text);
        }

        .aula-banner {
            background: linear-gradient(135deg, rgba(29, 211, 166, 0.9), rgba(12, 172, 204, 0.9)), url('https://www.transparenttextures.com/patterns/cubes.png');
            padding: 4rem 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .aula-content h1, .aula-content h2, .aula-content h3 { color: var(--color-primary-dark); font-weight: 700; margin-top: 1.5rem; }
        .aviso-importante {
            background-color: var(--color-secondary);
            border-left: 5px solid var(--color-primary);
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin: 2rem 0;
        }
        .aviso-importante p { margin-bottom: 0; }

        .material-card {
            background: #fff;
            border: 0;
            border-radius: 0.75rem;
            box-shadow: 0 8px 25px rgba(0,0,0,0.07);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .material-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,0.1); }
        .material-card .card-body { padding: 1rem; }
        .material-card .icon-container { font-size: 2.5rem; min-width: 60px; text-align: center; }
        .material-card .btn-actions { opacity: 0; transition: opacity 0.3s ease; }
        .material-card:hover .btn-actions { opacity: 1; }

        .fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            background-color: var(--color-primary);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 5px 15px rgba(29, 211, 166, 0.4);
            transition: all 0.3s;
        }
        .fab:hover { background-color: var(--color-primary-dark); transform: scale(1.1); }
        
        .icon-pdf { color: #f40f02; }
        .icon-doc { color: #2a5699; }
        .icon-ppt { color: #d24726; }
        .icon-zip { color: #8a8a8a; }
        .icon-img { color: #00bcd4; }
        .icon-link { color: #3d8bfd; }
        .icon-youtube { color: #ff0000; }
        .icon-default { color: #6c757d; }
    </style>
</head>
<body>
    <div class="container py-5">
        <!-- Banner da Aula -->
        <div class="aula-banner text-center" data-aos="fade-down">
            <h1 class="display-5 fw-bold">{{ optional($aula->disciplina)->nome_disciplina ?? 'Disciplina' }}</h1>
            <p class="lead fs-4">{{ $aula->descricao }}</p>
        </div>

        <div class="row g-5">
            <!-- Conteúdo Principal -->
            <div class="col-lg-8">
                <div class="bg-white p-4 p-md-5 rounded-3 shadow-sm aula-content" data-aos="fade-up">
                    {!! $aula->conteudo !!}
                    <hr class="my-5" style="border-top: 2px solid var(--color-secondary);">
                    <div class="d-flex justify-content-between align-items-center text-muted small">
                        <span><i class="bi bi-person-fill me-2"></i>Professor: <strong>{{ $aula->professor->nome }}</strong></span>
                        <span><i class="bi bi-calendar3 me-2"></i>Data: <strong>{{ $aula->created_at->format('d/m/Y') }}</strong></span>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div data-aos="fade-left">
                    <h4 class="mb-4 fw-bold"><i class="bi bi-collection-fill me-2 text-primary"></i>Materiais de Apoio</h4>
                    @forelse($materiais as $material)
                        <div class="material-card mb-3">
                            @if($material->youtube_thumbnail)
                                <a href="{{ $material->link }}" target="_blank">
                                    <img src="{{ $material->youtube_thumbnail }}" class="img-fluid" alt="{{ $material->titulo }}">
                                </a>
                            @endif
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-container @switch($material->icon_class) @case('bi-file-earmark-pdf-fill') icon-pdf @break @case('bi-file-earmark-word-fill') icon-doc @break @case('bi-file-earmark-ppt-fill') icon-ppt @break @case('bi-file-earmark-zip-fill') icon-zip @break @case('bi-file-earmark-image-fill') icon-img @break @case('bi-link-45deg') icon-link @break @case('bi-youtube') icon-youtube @break @default icon-default @endswitch">
                                    <i class="bi {{ $material->icon_class }}"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0 fw-bold">{{ $material->titulo }}</h6>
                                    <small class="text-muted">{{ $material->descricao }}</small>
                                </div>
                                <div class="btn-actions">
                                    <a href="{{ $material->tipo === 'arquivo' ? asset('storage/' . $material->arquivo) : $material->link }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle ms-2" title="Abrir"><i class="bi bi-box-arrow-up-right"></i></a>
                                    @if(auth()->user()->nivel === 'professor' && $aula->id_user == auth()->user()->id)
                                    <button class="btn btn-sm btn-outline-warning rounded-circle ms-1" title="Editar" data-bs-toggle="modal" data-bs-target="#editarMaterialModal{{$material->id}}"><i class="bi bi-pencil"></i></button>
                                    <form action="{{ route('admin.aula.material.remover', [$aula->id, $material->id]) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle ms-1" title="Remover" onclick="return confirm('Tem certeza?')"><i class="bi bi-trash"></i></button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal de Edição -->
                        <div class="modal fade" id="editarMaterialModal{{$material->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.aula.material.editar', [$aula->id, $material->id]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editarMaterialLabel{{$material->id}}">Editar Material</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <label class="form-label">Título</label>
                                                <input type="text" name="titulo" class="form-control" value="{{$material->titulo}}" required>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">Tipo</label>
                                                <select name="tipo" class="form-select tipo-editar" data-material-id="{{$material->id}}" required>
                                                    <option value="arquivo" @if($material->tipo=='arquivo') selected @endif>Arquivo</option>
                                                    <option value="link" @if($material->tipo=='link') selected @endif>Link</option>
                                                </select>
                                            </div>
                                            <div class="mb-2 campo-arquivo-editar" id="campo-arquivo-editar-{{$material->id}}" @if($material->tipo!='arquivo') style="display:none" @endif>
                                                <label class="form-label">Arquivo (PDF, DOC, PPT, ZIP)</label>
                                                <input type="file" name="arquivo" class="form-control">
                                            </div>
                                            <div class="mb-2 campo-link-editar" id="campo-link-editar-{{$material->id}}" @if($material->tipo!='link') style="display:none" @endif>
                                                <label class="form-label">Link</label>
                                                <input type="url" name="link" class="form-control" value="{{$material->link}}">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">Descrição</label>
                                                <textarea name="descricao" class="form-control">{{$material->descricao}}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center p-4 bg-light rounded-3">
                            <p class="mb-0 text-muted">Nenhum material de apoio adicionado.</p>
                        </div>
                    @endforelse
                </div>

                @if(auth()->user()->nivel === 'professor' && $aula->id_user == auth()->user()->id)
                <div class="p-4 mt-5 bg-white rounded-3 shadow-sm" data-aos="fade-up" data-aos-delay="200">
                    <h4 class="mb-3 fw-bold"><i class="bi bi-plus-circle-fill me-2 text-primary"></i>Adicionar Material</h4>
                    <form action="{{ route('admin.aula.material.adicionar', $aula->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Título</label>
                            <input type="text" name="titulo" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Tipo</label>
                            <select name="tipo" class="form-select" id="tipo-material" required onchange="toggleMaterialFields()">
                                <option value="arquivo">Arquivo</option>
                                <option value="link">Link</option>
                            </select>
                        </div>
                        <div class="mb-2" id="campo-arquivo">
                            <label class="form-label">Arquivo (PDF, DOC, PPT, ZIP)</label>
                            <input type="file" name="arquivo" class="form-control">
                        </div>
                        <div class="mb-2 d-none" id="campo-link">
                            <label class="form-label">Link (YouTube, Google Drive, etc)</label>
                            <input type="url" name="link" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Descrição (opcional)</label>
                            <textarea name="descricao" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Adicionar</button>
                    </form>
                </div>
                <script>
                    function toggleMaterialFields() {
                        var tipo = document.getElementById('tipo-material').value;
                        document.getElementById('campo-arquivo').classList.toggle('d-none', tipo !== 'arquivo');
                        document.getElementById('campo-link').classList.toggle('d-none', tipo !== 'link');
                    }
                </script>
                @endif
            </div>
        </div>
    </div>
    
    <a href="{{ route('admin.forums') }}" class="fab" title="Ir para Fóruns" data-aos="fade-up" data-aos-delay="500"><i class="bi bi-chat-quote-fill"></i></a>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, duration: 800 });
        // Lógica dos modais e forms (editar/adicionar)
    </script>
</body>
</html>