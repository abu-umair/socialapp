
@push('prepend-style')
<link rel="stylesheet" href="{{url('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
@endpush
@extends('layouts.app')
@section('content')
    
    <div class="login-box ">
      <div class="login-logo ">
        <img src="{{ url('backend/assets/images/coolze.png') }}" alt="logo" width="400" class="ml-n3">
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in to start your session</p>
          {{-- @if ($errors->any())
              <div class="alert alert-danger"> 
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>                        
                      @endforeach
                  </ul>
              </div>        
          @endif
           @if(session()->has('error'))                    
              <div class="alert alert-danger"> 
                  <ul>
                       <li>{{ session()->get('error') }}</li>
                  </ul>
              </div> 
          @endif
          @if(session()->has('success'))
              <div class="alert alert-success">
                  <ul>
                      <li>{{ session()->get('success') }}</li>
                  </ul>
              </div>
          @endif --}}
          <form  method="POST" action="{{ route('login') }}" id="quickForm" novalidate="novalidate" class="needs-validation">
            @csrf
            <div class="input-group mb-3">
              <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" id="exampleInputEmail1" value="{{ old('email') }}" required autofocus>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
              @error('email')
                    <div class="invalid-feedback" role="alert">
                      {{-- Please fill in your email --}}
                      {{ $message }}
                    </div>
                    @enderror
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control @error('password') is-invalid @enderror"" placeholder="Password" name="password" id="exampleInputPassword1" required autocomplete="current-password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
              @error('password')
                    <div class="invalid-feedback" role="alert">
                      {{ $message }}
                    </div>
                    @enderror
            </div>
            <div class="row">
              {{-- <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember">
                  <label for="remember">
                    Remember Me
                  </label>
                </div>
              </div> --}}
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
              </div>
              <!-- /.col -->
            </div>
          </form>

          {{-- <div class="social-auth-links text-center mb-3">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-primary">
              <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-block btn-danger">
              <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
            </a>
          </div> --}}
          <!-- /.social-auth-links -->

          {{-- <p class="mb-1">
            <a href="forgot-password.html">I forgot my password</a>
          </p> --}}
          {{-- <p class="mb-0">
            <a href="register.html" class="text-center">Register a new membership</a>
          </p> --}}
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->
@endsection

@push('addon-script')

@endpush
