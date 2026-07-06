<script>
    function resetPhotoCapture(wrapper) {
        if (!wrapper) {
            return;
        }

        if (typeof Webcam !== 'undefined') {
            Webcam.reset();
        }

        var hiddenInput = wrapper.querySelector('[data-photo-hidden]');
        var zone = wrapper.querySelector('.photo-capture-zone');
        var cameraWrap = wrapper.querySelector('.photo-capture-camera');
        var previewContainer = wrapper.querySelector('.photo-capture-preview');
        var previewImg = previewContainer ? previewContainer.querySelector('img') : null;

        if (hiddenInput) {
            hiddenInput.value = '';
        }
        if (previewImg) {
            previewImg.removeAttribute('src');
        }
        if (previewContainer) {
            previewContainer.classList.add('d-none');
        }
        if (cameraWrap) {
            cameraWrap.classList.add('d-none');
        }
        if (zone) {
            zone.classList.remove('d-none');
        }
    }

    function setPhotoCapturePreview(wrapper, dataUri, label) {
        if (!wrapper || !dataUri) {
            return;
        }

        var hiddenInput = wrapper.querySelector('[data-photo-hidden]');
        var zone = wrapper.querySelector('.photo-capture-zone');
        var cameraWrap = wrapper.querySelector('.photo-capture-camera');
        var previewContainer = wrapper.querySelector('.photo-capture-preview');
        var previewImg = previewContainer.querySelector('img');
        var nameEl = previewContainer.querySelector('.signature-preview-name');

        hiddenInput.value = dataUri;
        previewImg.src = dataUri;
        if (nameEl) {
            nameEl.textContent = label || 'Foto capturada';
        }
        previewContainer.classList.remove('d-none');
        zone.classList.add('d-none');
        cameraWrap.classList.add('d-none');
    }

    function initPhotoCapture(wrapper) {
        if (!wrapper || wrapper.dataset.photoCaptureInit) {
            return;
        }
        wrapper.dataset.photoCaptureInit = '1';

        var hiddenInput = wrapper.querySelector('[data-photo-hidden]');
        var zone = wrapper.querySelector('.photo-capture-zone');
        var startBtn = wrapper.querySelector('.photo-capture-start');
        var cameraWrap = wrapper.querySelector('.photo-capture-camera');
        var cameraEl = wrapper.querySelector('.photo-capture-viewport');
        var snapBtn = wrapper.querySelector('.photo-capture-snap');
        var cancelBtn = wrapper.querySelector('.photo-capture-cancel');
        var previewContainer = wrapper.querySelector('.photo-capture-preview');
        var previewImg = previewContainer.querySelector('img');
        var viewBtn = wrapper.querySelector('.photo-capture-view');
        var retakeBtn = wrapper.querySelector('.photo-capture-retake');
        var removeBtn = wrapper.querySelector('.photo-capture-remove');

        function openCamera() {
            zone.classList.add('d-none');
            previewContainer.classList.add('d-none');
            cameraWrap.classList.remove('d-none');

            if (typeof Webcam === 'undefined') {
                return;
            }

            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 90
            });
            Webcam.attach(cameraEl);
        }

        startBtn.addEventListener('click', openCamera);
        retakeBtn.addEventListener('click', openCamera);

        cancelBtn.addEventListener('click', function() {
            Webcam.reset();
            cameraWrap.classList.add('d-none');
            if (hiddenInput.value && previewImg.src) {
                previewContainer.classList.remove('d-none');
            } else {
                zone.classList.remove('d-none');
            }
        });

        snapBtn.addEventListener('click', function() {
            Webcam.snap(function(dataUri) {
                Webcam.reset();
                setPhotoCapturePreview(wrapper, dataUri, 'Foto capturada');
            });
        });

        viewBtn.addEventListener('click', function() {
            if (typeof openSignatureViewer === 'function' && previewImg.src) {
                openSignatureViewer(previewImg.src, 'Foto del trabajador');
            }
        });

        previewContainer.querySelector('.signature-preview-thumb').addEventListener('click', function() {
            viewBtn.click();
        });

        removeBtn.addEventListener('click', function() {
            resetPhotoCapture(wrapper);
        });
    }

    function initAllPhotoCaptures() {
        document.querySelectorAll('[data-photo-capture]').forEach(initPhotoCapture);
    }
</script>
