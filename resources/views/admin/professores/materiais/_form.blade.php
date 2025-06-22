@php
    // Fallback de segurança: garantir que $material sempre exista
    if (!isset($material)) {
        $material = null;
    }
@endphp

<div class="row">
    <!-- Título -->
    <div class="col-12 mb-4">
        <label for="titulo" class="form-label fs-5">Título do Material</label>
        <input type="text" name="titulo" id="titulo" class="form-control form-control-lg @error('titulo') is-invalid @enderror" value="{{ old('titulo', $material->titulo ?? '') }}" required placeholder="Ex: Slides da Aula 1 - Introdução">
        @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <!-- Aula Associada -->
    <div class="col-12 mb-4">
        <label for="aula_id" class="form-label fs-5">Aula Associada</label>
        <select name="aula_id" id="aula_id" class="form-select form-select-lg @error('aula_id') is-invalid @enderror" required>
            <option value="">Selecione a qual aula este material pertence</option>
            @foreach($aulasAgrupadas as $curso => $aulas)
                <optgroup label="{{ $curso }}">
                    @foreach($aulas as $aula)
                        <option value="{{ $aula->id }}" {{ old('aula_id', $material->aula_id ?? null) == $aula->id ? 'selected' : '' }}>
                            {{ $aula->descricao }} ({{ $aula->turma->designacao }})
                        </option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        @error('aula_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <!-- Tipo de Material (Radio Cards) -->
    <div class="col-12 mb-4">
        <label class="form-label fs-5 mb-3">Tipo de Material</label>
        <div class="row g-3 type-selector">
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo" id="tipo_arquivo" value="arquivo" {{ old('tipo', $material->tipo ?? 'arquivo') == 'arquivo' ? 'checked' : '' }}>
                    <label class="form-check-label" for="tipo_arquivo">
                        <i class="bi bi-file-earmark-arrow-up"></i>
                        <span>Arquivo</span>
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo" id="tipo_link" value="link" {{ old('tipo', $material->tipo ?? '') == 'link' ? 'checked' : '' }}>
                    <label class="form-check-label" for="tipo_link">
                        <i class="bi bi-link-45deg"></i>
                        <span>Link Externo</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Campo Arquivo -->
    <div class="col-12 mb-4 field-transition" id="campo-arquivo">
        <label class="form-label">Anexar Arquivo</label>
        <div class="file-input-wrapper">
            <input type="file" name="arquivo" id="arquivo" class="@error('arquivo') is-invalid @enderror">
            <i class="bi bi-cloud-arrow-up file-input-icon"></i>
            <div class="file-input-label">Clique para escolher um arquivo ou arraste e solte aqui</div>
            <div id="file-name" class="mt-2"></div>
        </div>
        @error('arquivo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        @if(isset($material) && $material->arquivo && $material->tipo == 'arquivo')
            <small class="text-muted mt-2 d-block">Arquivo atual: <a href="{{ Storage::url($material->arquivo) }}" target="_blank"><i class="bi bi-paperclip"></i> {{ $material->titulo }}</a></small>
        @endif
    </div>

    <!-- Campo Link -->
    <div class="col-12 mb-4 field-transition" id="campo-link">
        <label for="link" class="form-label">URL do Link</label>
        <input type="url" name="link" id="link" class="form-control form-control-lg @error('link') is-invalid @enderror" value="{{ old('link', $material->link ?? '') }}" placeholder="https://exemplo.com/recurso">
        @error('link') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <!-- Descrição -->
    <div class="col-12">
        <label for="descricao" class="form-label">Descrição (Opcional)</label>
        <textarea name="descricao" id="descricao" class="form-control" rows="4" placeholder="Forneça um breve resumo ou instruções sobre este material...">{{ old('descricao', $material->descricao ?? '') }}</textarea>
    </div>
</div> 