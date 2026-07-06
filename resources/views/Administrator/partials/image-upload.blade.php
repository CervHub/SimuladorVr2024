@php
    $inputId = $inputId ?? 'signature';
    $inputName = $inputName ?? 'signature';
    $zoneId = $zoneId ?? $inputId . '_zone';
    $previewId = $previewId ?? $inputId . '_preview';
    $containerId = $containerId ?? $inputId . '_container';
    $nameId = $nameId ?? $containerId . '_name';
    $sizeId = $sizeId ?? $containerId . '_size';
    $uploadTitle = $uploadTitle ?? 'Seleccionar imagen';
    $uploadHint = $uploadHint ?? 'JPG, PNG o WEBP · máx. 1 MB';
    $existingUrl = $existingUrl ?? null;
    $existingLabel = $existingLabel ?? 'Imagen actual';
@endphp

<div class="signature-upload" data-signature-upload
    @if ($existingUrl) data-existing-url="{{ $existingUrl }}" data-existing-label="{{ $existingLabel }}" @endif>
    <div class="signature-upload-zone" id="{{ $zoneId }}">
        <input type="file"
            id="{{ $inputId }}"
            name="{{ $inputName }}"
            accept="image/jpeg,image/png,image/jpg,image/webp,image/gif"
            class="signature-upload-input">
        <label for="{{ $inputId }}" class="signature-upload-label">
            <i class="mdi mdi-cloud-upload-outline signature-upload-icon"></i>
            <span class="signature-upload-text">
                <span class="signature-upload-title">{{ $uploadTitle }}</span>
                <small class="signature-upload-hint">{{ $uploadHint }}</small>
            </span>
        </label>
    </div>

    <div id="{{ $containerId }}" class="signature-preview-card d-none">
        <div class="signature-preview-thumb">
            <img id="{{ $previewId }}" src="" alt="Vista previa">
        </div>
        <div class="signature-preview-info">
            <span class="signature-preview-name" id="{{ $nameId }}"></span>
            <span class="signature-preview-size" id="{{ $sizeId }}"></span>
        </div>
        <div class="signature-preview-actions">
            <button type="button" class="btn btn-sm btn-light signature-view-btn" title="Ver imagen">
                <i class="mdi mdi-eye-outline"></i>
            </button>
            <button type="button" class="btn btn-sm btn-light signature-change-btn" title="Cambiar imagen">
                <i class="mdi mdi-swap-horizontal"></i>
            </button>
            <button type="button" class="btn btn-sm btn-light text-danger signature-remove-btn" title="Quitar imagen">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </div>
    </div>

    <div class="signature-upload-error text-danger small mt-1 d-none"></div>
</div>
