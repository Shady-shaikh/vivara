<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
  <title>@yield('title')</title>
  @include('backend.includes.head')
  <link rel="stylesheet" type="text/css" href="{{ asset('public/backend-assets/assets/css/fontawesome/all.min.css') }}" referrerpolicy="no-referrer"  crossorigin="anonymous" >
  <link rel=" stylesheet" type="text/css" href="{{ asset('public/backend-assets/css/toastr.min.css') }}">
  <script src="{{ asset('public/backend-assets/assets/js/jquery-3.6.1.min.js') }}" crossorigin="anonymous"></script>
  <script src="{{ asset('public/backend-assets/js/toastr.min.js') }}"></script>
</head>
    <body>

      @yield('content')
      
      @include('backend.includes.alerts')
      @yield('scripts')
      
<script src="{{ asset('public/backend-assets/assets/js/query-3.3.1.slim.min.js') }}" crossorigin="anonymous"></script>
<script src="{{ asset('public/backend-assets/assets/js/popper.min.js') }}" crossorigin="anonymous"></script>
<script src="{{ asset('public/backend-assets/assets/js/bootstrap.min.js') }}" crossorigin="anonymous"></script>
</body>



</html>
