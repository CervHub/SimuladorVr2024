@include('Administrator.partials.image-upload', array_merge([
    'inputName' => 'signature',
    'uploadTitle' => 'Seleccionar imagen de firma',
    'uploadHint' => 'JPG, PNG o WEBP · máx. 1 MB · 700×400 px',
], get_defined_vars()))
