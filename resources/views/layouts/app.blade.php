<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('title')</title>
    @stack('prepend-style') {{-- stack sebelum (agar tdk tertimpa dg css lain)--}}

    @include('includes.admin.style')
    
    @stack('addon-style'){{-- stack sesudah --}}
    
</head>

{{-- <body class="hold-transition login-page"> --}}
<body>
    {{-- @include('includes.admin.navbar') --}}

    @yield('content')

    {{-- @include('includes.admin.footer') --}}

    @stack('prepend-script'){{-- stack sebelum (agar tdk tertimpa dg script lain)--}}

    @include('includes.admin.script')

    @stack('addon-script'){{-- stack sesudah --}}
    
</body>

</html>