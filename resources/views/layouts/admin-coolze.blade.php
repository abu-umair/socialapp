<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <title>@yield('title')</title>

  @stack('prepend-style') {{-- stack sebelum (agar tdk tertimpa dg css lain)--}}

  @include('includes.admin.style')

  @stack('addon-style'){{-- stack sesudah --}}
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">
<div class="wrapper">

  <!-- Preloader -->
{{-- <div class="preloader flex-column justify-content-center align-items-center">
  <img class="animation__wobble" src="{{ url('backend/assets/images/icon.png') }}" height="70" width="70">
</div> --}}

@include('sweetalert::alert')
  @include('includes.admin.navbar')
  

  @include('includes.admin.sidebar')

  <div class="content-wrapper">

    @yield('content')

  </div>
  
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  @include('includes.admin.footer')
</div>

@stack('prepend-script'){{-- stack sebelum (agar tdk tertimpa dg script lain)--}}

@include('includes.admin.script')

@stack('addon-script'){{-- stack sesudah --}}
</body>
</html>
