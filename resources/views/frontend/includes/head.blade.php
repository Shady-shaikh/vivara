<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'SkinClinic MLM') }}</title>

<!-- Styles -->

<link
rel="stylesheet"
href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
/>

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
/>
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
<link rel="stylesheet" href="{{ asset('public/frontend-assets/css/lightbox.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/frontend-assets/css/owl.theme.default.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/frontend-assets/css/owl.theme.green.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/frontend-assets/css/owl.carousel.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/frontend-assets/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/frontend-assets/css/style.css') }}" />



{{-- tabler theme --}}
{{-- <link rel=" stylesheet" type="text/css" href="{{ asset('public/frontend-assets/css/tabler.min.css') }}"> --}}
<link rel=" stylesheet" type="text/css" href="{{ asset('public/frontend-assets/css/tabler-flags.min.css') }}">
{{-- <link rel=" stylesheet" type="text/css" href="{{ asset('public/frontend-assets/css/tabler-payments.min.css') }}"> --}}
<link rel=" stylesheet" type="text/css" href="{{ asset('public/frontend-assets/css/tabler-vendors.min.css') }}">
<link rel=" stylesheet" type="text/css" href="{{ asset('public/backend-assets/vendors/css/datatables.min.css') }}">
<link rel=" stylesheet" type="text/css" href="{{ asset('public/frontend-assets/css/magnific-popup.css') }}">
<link rel=" stylesheet" type="text/css" href="{{ asset('public/frontend-assets/css/toastr.min.css') }}">


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<style>
    thead input {
        width: 100%;
    }

    thead th.action input,
    thead th.file_uploaded input {
        display: none !important;
    }
    select.form-control {
        padding: 0.6rem 1.375rem !important;
        -webkit-appearance: auto !important;
        -moz-appearance: auto !important;
        appearance: auto !important;
    }
    
    
</style>