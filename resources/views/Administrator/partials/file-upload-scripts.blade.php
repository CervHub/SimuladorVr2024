<script>
    function initFileUpload(wrapper, onChange) {
        var input = wrapper.querySelector('.signature-upload-input');
        var zone = wrapper.querySelector('.signature-upload-zone');
        var container = wrapper.querySelector('.signature-preview-card');
        var nameEl = wrapper.querySelector('.signature-preview-name');
        var sizeEl = wrapper.querySelector('.signature-preview-size');
        var errorEl = wrapper.querySelector('.signature-upload-error');
        var changeBtn = wrapper.querySelector('.signature-change-btn');
        var removeBtn = wrapper.querySelector('.signature-remove-btn');
        var accept = wrapper.getAttribute('data-accept') || '.xlsx';
        var extensions = accept.split(',').map(function(ext) {
            return ext.trim().toLowerCase().replace(/^\./, '');
        }).filter(Boolean);

        var MAX_SIZE = 5 * 1024 * 1024;

        function formatSize(bytes) {
            if (bytes < 1024) {
                return bytes + ' B';
            }
            if (bytes < 1024 * 1024) {
                return (bytes / 1024).toFixed(1) + ' KB';
            }
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        }

        function showError(msg) {
            errorEl.textContent = msg;
            errorEl.classList.remove('d-none');
        }

        function hideError() {
            errorEl.textContent = '';
            errorEl.classList.add('d-none');
        }

        function notifyChange() {
            if (typeof onChange === 'function') {
                onChange(input.files && input.files[0] ? true : false);
            }
        }

        function reset() {
            input.value = '';
            nameEl.textContent = '';
            sizeEl.textContent = '';
            container.classList.add('d-none');
            zone.classList.remove('d-none');
            hideError();
            notifyChange();
        }

        function showPreview(name, size) {
            nameEl.textContent = name || 'Archivo seleccionado';
            sizeEl.textContent = size ? formatSize(size) : '';
            container.classList.remove('d-none');
            zone.classList.add('d-none');
            hideError();
            notifyChange();
        }

        function validateFile(file) {
            var extension = file.name.split('.').pop().toLowerCase();

            if (extensions.length && extensions.indexOf(extension) === -1) {
                showError('Solo se permiten archivos ' + accept + '.');
                return false;
            }

            if (file.size > MAX_SIZE) {
                showError('El archivo no debe superar 5 MB.');
                return false;
            }

            return true;
        }

        input.addEventListener('change', function() {
            if (!this.files || !this.files[0]) {
                reset();
                return;
            }

            var file = this.files[0];
            if (!validateFile(file)) {
                this.value = '';
                notifyChange();
                return;
            }

            showPreview(file.name, file.size);
        });

        changeBtn.addEventListener('click', function() {
            input.click();
        });

        removeBtn.addEventListener('click', function() {
            reset();
        });

        notifyChange();

        return {
            reset: reset
        };
    }

    function initAllFileUploads(root) {
        var scope = root || document;
        var instances = [];

        scope.querySelectorAll('[data-file-upload]').forEach(function(wrapper) {
            var submitSelector = wrapper.getAttribute('data-submit-button');
            var submitBtn = submitSelector ? document.querySelector(submitSelector) : null;

            instances.push(initFileUpload(wrapper, function(hasFile) {
                if (submitBtn) {
                    submitBtn.disabled = !hasFile;
                }
            }));
        });

        return instances;
    }
</script>
