@php
    $inputId = $inputId ?? 'archivo_trabajadores';
    $inputName = $inputName ?? 'archivo_trabajadores';
    $zoneId = $zoneId ?? $inputId . '_zone';
    $containerId = $containerId ?? $inputId . '_container';
    $nameId = $nameId ?? $containerId . '_name';
    $sizeId = $sizeId ?? $containerId . '_size';
    $uploadTitle = $uploadTitle ?? 'Seleccionar archivo Excel';
    $uploadHint = $uploadHint ?? 'Solo archivos .xlsx';
    $accept = $accept ?? '.xlsx';
    $fileIcon = $fileIcon ?? 'mdi-file-excel-outline';
    $submitButtonId = $submitButtonId ?? null;
@endphp

<div class="signature-upload file-upload-inline" data-file-upload data-accept="{{ $accept }}"
    @if ($submitButtonId) data-submit-button="#{{ $submitButtonId }}" @endif>
    <div class="signature-upload-zone" id="{{ $zoneId }}">
        <input type="file"
            id="{{ $inputId }}"
            name="{{ $inputName }}"
            accept="{{ $accept }}"
            class="signature-upload-input"
            required>
        <label for="{{ $inputId }}" class="signature-upload-label">
            <i class="mdi {{ $fileIcon }} signature-upload-icon"></i>
            <span class="signature-upload-text">
                <span class="signature-upload-title">{{ $uploadTitle }}</span>
                <small class="signature-upload-hint">{{ $uploadHint }}</small>
            </span>
        </label>
    </div>

    <div id="{{ $containerId }}" class="signature-preview-card d-none">
        <div class="signature-preview-thumb file-upload-thumb">
            <i class="mdi {{ $fileIcon }} file-upload-thumb-icon"></i>
        </div>
        <div class="signature-preview-info">
            <span class="signature-preview-name" id="{{ $nameId }}"></span>
            <span class="signature-preview-size" id="{{ $sizeId }}"></span>
        </div>
        <div class="signature-preview-actions">
            <button type="button" class="btn btn-sm btn-light signature-change-btn" title="Cambiar archivo">
                <i class="mdi mdi-swap-horizontal"></i>
            </button>
            <button type="button" class="btn btn-sm btn-light text-danger signature-remove-btn" title="Quitar archivo">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </div>
    </div>

    <div class="signature-upload-error text-danger small mt-1 d-none"></div>
</div>
