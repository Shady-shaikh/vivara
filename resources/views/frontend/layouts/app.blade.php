<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<head>
  <title>@yield('title')</title>
  @include('frontend.includes.head')
</head>

<body style="overflow-x:hidden" class="vertical-layout vertical-menu-modern 2-columns fixed-navbar" data-open="click"
  data-menu="vertical-menu-modern" data-col="2-columns">
  @include('frontend.includes.header')
  @include('frontend.includes.leftmenu')

  <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
      <div class="content-body">
        @yield('content')
      </div>
    </div>
  </div>

  @include('frontend.includes.footer')
  @include('frontend.includes.alerts')

  @yield('scripts')
</body>


</html>