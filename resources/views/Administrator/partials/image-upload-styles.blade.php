<style>
    .signature-upload-zone {
        border: 1px dashed #c9cdd3;
        border-radius: 8px;
        background: #fafbfc;
        transition: border-color 0.2s, background 0.2s;
    }

    .signature-upload-zone:hover {
        border-color: #4b49ac;
        background: #f5f6ff;
    }

    .signature-upload-input {
        position: absolute;
        width: 0;
        height: 0;
        opacity: 0;
        overflow: hidden;
    }

    .signature-upload-label {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 0.65rem;
        margin: 0;
        padding: 0.55rem 0.75rem;
        cursor: pointer;
        text-align: left;
    }

    .signature-upload-icon {
        font-size: 1.25rem;
        color: #4b49ac;
        flex-shrink: 0;
    }

    .signature-upload-text {
        display: flex;
        flex-direction: column;
        gap: 0.1rem;
        min-width: 0;
    }

    .signature-upload-title {
        font-weight: 600;
        font-size: 0.875rem;
        color: #343a40;
        line-height: 1.2;
    }

    .signature-upload-hint {
        color: #6c757d;
        font-size: 0.75rem;
        line-height: 1.2;
    }

    .signature-preview-card {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.65rem 0.75rem;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        background: #fff;
    }

    .signature-preview-thumb {
        flex-shrink: 0;
        width: 56px;
        height: 56px;
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid #e9ecef;
        background: #f8f9fa;
        cursor: pointer;
    }

    .signature-preview-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .signature-preview-info {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
    }

    .signature-preview-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: #343a40;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .signature-preview-size {
        font-size: 0.75rem;
        color: #6c757d;
    }

    .signature-preview-actions {
        display: flex;
        gap: 0.35rem;
        flex-shrink: 0;
    }

    .signature-preview-actions .btn {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
    }

    .signature-lightbox {
        position: fixed;
        inset: 0;
        z-index: 2000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .signature-lightbox-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.65);
    }

    .signature-lightbox-content {
        position: relative;
        z-index: 1;
        background: #fff;
        border-radius: 8px;
        max-width: 900px;
        width: 100%;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    }

    .signature-lightbox-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #dee2e6;
        font-weight: 600;
        color: #343a40;
    }

    .signature-lightbox-body {
        padding: 1rem;
        overflow: auto;
        text-align: center;
        background: #f8f9fa;
    }

    .signature-lightbox-body img {
        max-width: 100%;
        max-height: calc(90vh - 5rem);
        object-fit: contain;
        border-radius: 4px;
        background: #fff;
    }

    .file-upload-inline {
        min-width: 280px;
        max-width: 380px;
    }

    .file-upload-thumb {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef8f1;
    }

    .file-upload-thumb-icon {
        font-size: 1.5rem;
        color: #1d6f42;
    }

    .import-workers-form {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .page-toolbar-row {
        padding-bottom: 1rem;
    }

    .photo-capture-camera {
        border: 1px dashed #c9cdd3;
        border-radius: 8px;
        padding: 0.75rem;
        background: #fafbfc;
        text-align: center;
    }

    .photo-capture-viewport {
        width: 100%;
        max-width: 320px;
        height: 240px;
        margin: 0 auto 0.75rem;
        overflow: hidden;
        border-radius: 6px;
        background: #000;
    }

    .photo-capture-viewport video,
    .photo-capture-viewport canvas {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover;
    }

    .photo-capture-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .photo-capture-start {
        text-align: left;
    }

    .area-loading {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 0.35rem;
    }
</style>
