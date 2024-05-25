<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Vivara') }}</title>



<!-- BEGIN: Theme CSS-->
<link type="text/css" href="{{ asset('public/backend-assets/app-assets/vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">

<!-- Notyf -->
<link type="text/css" href="{{ asset('public/backend-assets/app-assets/vendor/notyf/notyf.min.css') }}" rel="stylesheet">

<!-- Volt CSS -->
<link type="text/css" href="{{ asset('public/backend-assets/app-assets/css/volt.css') }}" rel="stylesheet">

<!-- END: Theme CSS-->

{{-- custom css --}}
<link type="text/css" href="{{ asset('public/backend-assets/css/style.css') }}" rel="stylesheet">

<!-- Favicon -->

<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('public/backend-assets/app-assets/assets/img/favicon/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/backend-assets/app-assets/assets/img/favicon/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/backend-assets/app-assets/assets/img/favicon/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('public/backend-assets/app-assets/assets/img/favicon/site.webmanifest') }}">
<link rel="mask-icon" href="{{ asset('public/backend-assets/app-assets/assets/img/favicon/safari-pinned-tab.svg') }}" color="#ffffff">

{{-- fontawsm --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
    integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

{{-- toastr --}}
<link rel="stylesheet" type="text/css" href="{{ asset('public/frontend-assets/css/toastr.min.css') }}">

{{-- daterangepicker --}}
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />



{{-- jquery --}}
<script src="{{ asset('public/backend-assets/assets/js/jquery-3.6.1.min.js') }}"></script>