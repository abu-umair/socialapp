<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <link rel="shortcut icon" href="{{ url('backend/assets/img/adfood.png') }}">
  <link rel="icon" type="image/png" href="{{ url('backend/assets/img/adfood.png') }}">
  <title>@yield('title')</title>

  @stack('prepend-style') {{-- stack sebelum (agar tdk tertimpa dg css lain)--}}

  @include('includes.admin.style')
  
  @stack('addon-style'){{-- stack sesudah --}}

</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      @include('sweetalert::alert')

      @include('includes.admin.navbar')
      
      @include('includes.admin.sidebar')

      <!-- Main Content -->
      @yield('content')
      
      @include('includes.admin.footer')
    </div>
  </div>

  <!-- General JS Scripts -->
  
  @stack('prepend-script'){{-- stack sebelum (agar tdk tertimpa dg script lain)--}}

  @include('includes.admin.script')

  @stack('addon-script'){{-- stack sesudah --}}
</body>
</html>
