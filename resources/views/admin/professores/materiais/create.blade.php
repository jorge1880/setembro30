@extends('admin.layout')

@section('conteudo')
<style>
    body { background-color: #f6f8fb; }
    .form-card {
        background: linear-gradient(120deg, #fafdff 60%, #e3f0ff 100%);
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 8px 32px rgba(13,110,253,0.07), 0 1.5px 4px rgba(0,0,0,0.03);
        overflow: hidden;
        padding-bottom: 0.5rem;
    }
    .form-card .card-header {
        background: linear-gradient(135deg, #6ea8fe 60%, #b7eaff 100%);
        color: #1a237e;
        border-bottom: none;
    }
    .form-card .card-header .bi {
        font-size: 3rem !important;
        color: #0d6efd;
        filter: drop-shadow(0 2px 8px #b7eaff);
    }
    .form-card .card-header h2 {
        font-family: 'Poppins', Arial, sans-serif;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .form-card .card-header p {
        font-size: 1.1rem;
        color: #3b4a6b;
        opacity: 0.7;
    }

    /* Card-like Radio Buttons */
    .type-selector .form-check-input {
        display: none;
    }
    .type-selector .form-check-label {
        display: block;
        border: 2px solid #e3eafc;
        border-radius: 1rem;
        padding: 2rem 1rem 1.2rem 1rem;
        text-align: center;
        cursor: pointer;
        background: #fafdff;
        box-shadow: 0 2px 8px rgba(13,110,253,0.04);
        transition: all 0.25s cubic-bezier(.4,2,.6,1);
        font-size: 1.1rem;
        color: #1a237e;
        font-family: 'Poppins', Arial, sans-serif;
        position: relative;
    }
    .type-selector .form-check-label:hover {
        border-color: #6ea8fe;
        background: #e3f0ff;
        color: #0d6efd;
        box-shadow: 0 4px 16px rgba(13,110,253,0.08);
    }
    .type-selector .form-check-input:checked + .form-check-label {
        border-color: #0d6efd;
        background: #e3f0ff;
        box-shadow: 0 0 0 3px #b7eaff;
        color: #0d6efd;
    }
    .type-selector .form-check-label .bi {
        font-size: 2.5rem;
        display: block;
        margin-bottom: 0.5rem;
        color: #6ea8fe;
        transition: color 0.2s;
    }
    .type-selector .form-check-input:checked + .form-check-label .bi {
        color: #0d6efd;
    }

    /* Custom File Input */
    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: block;
        width: 100%;
        border: 2.5px dashed #b7eaff;
        border-radius: 0.75rem;
        padding: 2.5rem 1rem 1.5rem 1rem;
        text-align: center;
        cursor: pointer;
        background: #fafdff;
        transition: all .25s cubic-bezier(.4,2,.6,1);
        box-shadow: 0 2px 8px rgba(13,110,253,0.04);
    }
    .file-input-wrapper:hover, .file-input-wrapper.dragover {
        border-color: #0d6efd;
        background: #e3f0ff;
        box-shadow: 0 4px 16px rgba(13,110,253,0.08);
    }
    .file-input-wrapper.dragover {
        border-style: solid;
        box-shadow: 0 0 15px rgba(13, 110, 253, 0.13);
    }
    .file-input-wrapper input[type=file] {
        position: absolute;
        font-size: 100px;
        left: 0;
        top: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }
    .file-input-label {
        color: #0d6efd;
        font-weight: 500;
        font-size: 1.1rem;
        margin-top: 0.5rem;
    }
    .file-input-icon {
        font-size: 2.5rem;
        color: #6ea8fe;
        margin-bottom: 0.5rem;
    }
    #file-name {
        margin-top: 1rem;
        font-weight: 500;
        color: #495057;
        font-size: 1.05rem;
    }

    /* Inputs e selects modernos */
    .form-control, .form-select {
        border-radius: 0.7rem;
        border: 1.5px solid #e3eafc;
        font-size: 1.1rem;
        font-family: 'Poppins', Arial, sans-serif;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #fafdff;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 2px #b7eaff;
        background: #fff;
    }
    label.form-label {
        font-weight: 600;
        color: #1a237e;
        font-size: 1.08rem;
        margin-bottom: 0.4rem;
    }
    textarea.form-control {
        min-height: 90px;
    }
    /* Transition for showing/hiding fields */
    .field-transition {
        transition: opacity 0.4s cubic-bezier(.4,2,.6,1), max-height 0.4s cubic-bezier(.4,2,.6,1), transform 0.4s cubic-bezier(.4,2,.6,1);
        opacity: 1;
        max-height: 500px;
        overflow: hidden;
        transform: translateY(0);
    }
    .field-hidden {
        opacity: 0;
        max-height: 0;
        transform: translateY(-10px);
    }
    /* Botões */
    .btn-primary {
        background: linear-gradient(90deg, #0d6efd 60%, #6ea8fe 100%);
        border: none;
        border-radius: 0.7rem;
        font-size: 1.1rem;
        font-weight: 600;
        padding: 0.7rem 2.2rem;
        box-shadow: 0 2px 8px rgba(13,110,253,0.07);
        transition: background 0.2s, box-shadow 0.2s;
    }
    .btn-primary:hover, .btn-primary:focus {
        background: linear-gradient(90deg, #6ea8fe 60%, #0d6efd 100%);
        box-shadow: 0 4px 16px rgba(13,110,253,0.13);
    }
    .btn-outline-secondary {
        border-radius: 0.7rem;
        font-size: 1.1rem;
        font-weight: 500;
        padding: 0.7rem 2.2rem;
    }
</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="card-header text-center py-4">
                    <a href="{{ route('professores.materiais.index') }}" class="btn-floating waves-effect waves-light blue left" style="margin-right: 10px; position: absolute; top: 20px; left: 20px;">
                        <i class="material-icons">arrow_back</i>
                    </a>
                    <i class="bi {{ isset($material) ? 'bi-pencil-square' : 'bi-file-earmark-plus' }}"></i>
                    <h2 class="h3 fw-bold mt-2 mb-0">{{ isset($material) ? 'Editar Material de Apoio' : 'Adicionar Novo Material' }}</h2>
                    <p class="mb-0 mt-1">Preencha os campos para gerenciar o material.</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ isset($material) ? route('professores.materiais.update', $material->id) : route('professores.materiais.store') }}" method="POST" enctype="multipart/form-data" id="material-form">
                        @csrf
                        @if(isset($material))
                            @method('PUT')
                        @endif

                        @include('admin.professores.materiais._form')

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4 pt-3 border-top">
                            <a href="{{ route('professores.materiais.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi {{ isset($material) ? 'bi-check-circle' : 'bi-plus-circle' }} me-2"></i>
                                {{ isset($material) ? 'Salvar Alterações' : 'Adicionar Material' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tipoRadios = document.querySelectorAll('input[name="tipo"]');
    const campoArquivo = document.getElementById('campo-arquivo');
    const campoLink = document.getElementById('campo-link');

    function toggleFields() {
        if (document.querySelector('input[name="tipo"]:checked').value === 'arquivo') {
            campoArquivo.classList.remove('field-hidden');
            campoLink.classList.add('field-hidden');
        } else {
            campoArquivo.classList.add('field-hidden');
            campoLink.classList.remove('field-hidden');
        }
    }

    tipoRadios.forEach(radio => radio.addEventListener('change', toggleFields));
    toggleFields();

    // Enhanced file input
    const fileInputWrapper = document.querySelector('.file-input-wrapper');
    const fileInput = document.getElementById('arquivo');
    const fileNameDisplay = document.getElementById('file-name');

    if(fileInputWrapper) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileNameDisplay.textContent = 'Arquivo: ' + this.files[0].name;
            } else {
                fileNameDisplay.textContent = '';
            }
        });

        // Drag and Drop events
        fileInputWrapper.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileInputWrapper.classList.add('dragover');
        });

        fileInputWrapper.addEventListener('dragleave', () => {
            fileInputWrapper.classList.remove('dragover');
        });

        fileInputWrapper.addEventListener('drop', () => {
            fileInputWrapper.classList.remove('dragover');
        });
    }
});
</script>
@endpush 