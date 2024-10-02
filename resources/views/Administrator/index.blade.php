@extends('Administrator.main')

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const iconSuperAdmin = document.querySelector('#departamentos');
        iconSuperAdmin.classList.add('active');
    });
</script>
@endsection