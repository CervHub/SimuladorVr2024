<script>
    function openSignatureViewer(src, title) {
        if (!src) {
            return;
        }

        var lightbox = document.getElementById('signatureLightbox');
        var img = document.getElementById('signatureLightboxImg');
        var titleEl = document.getElementById('signatureLightboxTitle');

        img.src = src;
        titleEl.textContent = title || 'Vista previa';
        lightbox.classList.remove('d-none');
    }

    function closeSignatureViewer() {
        var lightbox = document.getElementById('signatureLightbox');
        var img = document.getElementById('signatureLightboxImg');

        lightbox.classList.add('d-none');
        img.removeAttribute('src');
    }

    function initSignatureUpload(wrapper) {
        var input = wrapper.querySelector('.signature-upload-input');
        var zone = wrapper.querySelector('.signature-upload-zone');
        var container = wrapper.querySelector('.signature-preview-card');
        var preview = container.querySelector('img');
        var nameEl = wrapper.querySelector('.signature-preview-name');
        var sizeEl = wrapper.querySelector('.signature-preview-size');
        var errorEl = wrapper.querySelector('.signature-upload-error');
        var viewBtn = wrapper.querySelector('.signature-view-btn');
        var changeBtn = wrapper.querySelector('.signature-change-btn');
        var removeBtn = wrapper.querySelector('.signature-remove-btn');

        var MAX_SIZE = 1024 * 1024;
        var ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/gif'];

        function formatSize(bytes) {
            if (bytes < 1024) {
                return bytes + ' B';
            }
            return (bytes / 1024).toFixed(1) + ' KB';
        }

        function showError(msg) {
            errorEl.textContent = msg;
            errorEl.classList.remove('d-none');
        }

        function hideError() {
            errorEl.textContent = '';
            errorEl.classList.add('d-none');
        }

        function reset() {
            input.value = '';
            preview.removeAttribute('src');
            nameEl.textContent = '';
            sizeEl.textContent = '';
            container.classList.add('d-none');
            zone.classList.remove('d-none');
            hideError();
        }

        function showPreview(src, name, size) {
            preview.src = src;
            nameEl.textContent = name || 'Imagen';
            sizeEl.textContent = size ? formatSize(size) : '';
            container.classList.remove('d-none');
            zone.classList.add('d-none');
            hideError();
        }

        function validateFile(file) {
            if (!ALLOWED_TYPES.includes(file.type)) {
                showError('Solo se permiten archivos de imagen (JPG, PNG, WEBP o GIF).');
                return false;
            }
            if (file.size > MAX_SIZE) {
                showError('La imagen no debe superar 1 MB.');
                return false;
            }
            return true;
        }

        input.addEventListener('change', function() {
            if (!this.files || !this.files[0]) {
                return;
            }

            var file = this.files[0];
            if (!validateFile(file)) {
                this.value = '';
                return;
            }

            var reader = new FileReader();
            reader.onload = function(e) {
                showPreview(e.target.result, file.name, file.size);
            };
            reader.readAsDataURL(file);
        });

        viewBtn.addEventListener('click', function() {
            var src = preview.getAttribute('src');
            if (src) {
                openSignatureViewer(src, nameEl.textContent);
            }
        });

        wrapper.querySelector('.signature-preview-thumb').addEventListener('click', function() {
            var src = preview.getAttribute('src');
            if (src) {
                openSignatureViewer(src, nameEl.textContent);
            }
        });

        changeBtn.addEventListener('click', function() {
            input.click();
        });

        removeBtn.addEventListener('click', function() {
            reset();
        });

        var existingUrl = wrapper.getAttribute('data-existing-url');
        var existingLabel = wrapper.getAttribute('data-existing-label');
        if (existingUrl) {
            showPreview(existingUrl, existingLabel || 'Imagen actual', null);
        }

        return {
            reset: reset,
            showFromUrl: function(src, name) {
                showPreview(src, name || 'Imagen actual', null);
            }
        };
    }

    function initAllSignatureUploads(root) {
        var scope = root || document;
        var instances = [];

        scope.querySelectorAll('[data-signature-upload]').forEach(function(wrapper) {
            instances.push(initSignatureUpload(wrapper));
        });

        return instances;
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (!document.getElementById('signatureLightbox')) {
            return;
        }

        document.querySelectorAll('[data-signature-lightbox-close]').forEach(function(el) {
            el.addEventListener('click', closeSignatureViewer);
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSignatureViewer();
            }
        });
    });
</script>
