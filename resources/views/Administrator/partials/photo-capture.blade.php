@php
    $hiddenInputId = $hiddenInputId ?? 'photo_base64';
    $inputName = $inputName ?? 'photo_base64';
    $zoneId = $zoneId ?? $hiddenInputId . '_zone';
    $cameraWrapId = $cameraWrapId ?? $hiddenInputId . '_camera_wrap';
    $cameraId = $cameraId ?? $hiddenInputId . '_camera';
    $previewContainerId = $previewContainerId ?? $hiddenInputId . '_preview_container';
    $previewId = $previewId ?? $hiddenInputId . '_preview';
    $previewNameId = $previewNameId ?? $hiddenInputId . '_preview_name';
@endphp

<div class="photo-capture" data-photo-capture>
    <div class="signature-upload-zone photo-capture-zone" id="{{ $zoneId }}">
        <button type="button" class="photo-capture-start signature-upload-label w-100 border-0 bg-transparent">
            <i class="mdi mdi-camera-outline signature-upload-icon"></i>
            <span class="signature-upload-text">
                <span class="signature-upload-title">Tomar foto</span>
                <small class="signature-upload-hint">Use la cámara del dispositivo (opcional)</small>
            </span>
        </button>
    </div>

    <div class="photo-capture-camera d-none" id="{{ $cameraWrapId }}">
        <div class="photo-capture-viewport" id="{{ $cameraId }}"></div>
        <div class="photo-capture-actions">
            <button type="button" class="btn btn-sm btn-primary photo-capture-snap">
                <i class="mdi mdi-camera"></i> Capturar
            </button>
            <button type="button" class="btn btn-sm btn-light photo-capture-cancel">
                Cancelar
            </button>
        </div>
    </div>

    <div id="{{ $previewContainerId }}" class="signature-preview-card photo-capture-preview d-none">
        <div class="signature-preview-thumb">
            <img id="{{ $previewId }}" src="" alt="Foto del trabajador">
        </div>
        <div class="signature-preview-info">
            <span class="signature-preview-name" id="{{ $previewNameId }}">Foto capturada</span>
            <span class="signature-preview-size">Cámara web</span>
        </div>
        <div class="signature-preview-actions">
            <button type="button" class="btn btn-sm btn-light photo-capture-view" title="Ver foto">
                <i class="mdi mdi-eye-outline"></i>
            </button>
            <button type="button" class="btn btn-sm btn-light photo-capture-retake" title="Tomar de nuevo">
                <i class="mdi mdi-camera"></i>
            </button>
            <button type="button" class="btn btn-sm btn-light text-danger photo-capture-remove" title="Quitar foto">
                <i class="mdi mdi-trash-can-outline"></i>
            </button>
        </div>
    </div>

    <input type="hidden" id="{{ $hiddenInputId }}" name="{{ $inputName }}" data-photo-hidden>
</div>
