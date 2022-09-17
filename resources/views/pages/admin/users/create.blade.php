@extends('layouts.admin')
@section('title','Services - Groomers')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Partners</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a >Services</a></div>
        <div class="breadcrumb-item"><a >Groomers</a></div>
        <div class="breadcrumb-item">Input Groomers</div>
      </div>
    </div>

    <div class="section-body">
      {{-- <h2 class="section-title">This is Example Page</h2>
      <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
      <div class="card">
        <div class="card-header d-sm-flex align-items-center justify-content-between ">
          <h1 class="h3 mb-0 text-gray-800">Tambah Users</h1>
          
            </a>          
        </div>
        @if ($errors->any()) {{-- jika ada permasalahan/error --}}
            <div class="alert alert-danger"> {{-- maka muncul div error --}}
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>                        
                    @endforeach
                </ul>
            </div>        
        @endif
        @if(session('error'))                    
                <div class="alert alert-danger"> 
                <ul>
                     <li>{{ session('error') }}</li>
                </ul>
            </div> 
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ session()->get('success') }}</li>
                </ul>
            </div>
        @endif
        
          
            <div class="card-body">
                {{-- <form action="{{ route('services-groomer.store') }}" method="POST" enctype="multipart/form-data"> untuk menyimpan sebuah data menggunakan functioan 'store' --}}
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf{{-- setiap buat form pakai @csrf --}}
                    <div class="form-group">
                      <label for="foto">Image Driver</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-danger">
                            <span class="">
                              <i class="far fa-folder-open"></i>
                            </span>
                          </span>
                        </div>
                        <div class="custom-file">
                          <input type="file" name="foto" class="custom-file-input" required>
                          <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="name">Name</label>
                      <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-warning">
                              <span><i class="far fa-id-card"></i></span>
                            </span>
                          </div>
                          <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="">Veryfied</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-success">
                            <span><i class="fas fa-hands-helping"></i></span>
                          </span>
                        </div>
                        <select name="partners_id" class="form-control" required>
                          <option value="">Pilih Verified</option>
                          <option value="1">Aktif</option>
                          <option value="0">Tidak Aktif<option>
                          
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="phone">Phone</label>
                      <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-warning">
                              <span><i class="far fa-id-card"></i></span>
                            </span>
                          </div>
                          <input type="text" class="form-control" name="phone" placeholder="Name" value="{{ old('phone') }}" required>
                      </div>
                    </div>
                    <div class="form-group">
                        <label for="transaksi">Transaksi</label>
                        <input type="text" class="form-control" name="transaksi" placeholder="Transaksi" value="{{ old('transaksi') }}">
                    </div>
                    
                    <div class="form-group">
                      <label for="status">Status</label>
                      <select name="status" class="form-control" required>
                          <option value="">Pilih Status</option>                          
                          <option value="1">Aktif</option>
                          <option value="0">Tidak Aktif</option>                                                      
                      </select>
                  </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
                    </div>
                    
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" name="password" placeholder="Password" value="{{ old('password') }}">
                    </div>
                    <div class="form-group">
                      <label for="password_confirmation">Password Confirmation</label>
                      <input type="password" class="form-control" name="password_confirmation" placeholder="Password Confirmation" value="{{ old('password_confirmation') }}">
                    </div>
                    <div class="form-group">
                      <label for="roles">Role</label>
                      <select name="roles" class="form-control" required>
                          <option value="">Pilih Role</option>                          
                          <option value="USER">User</option>
                          <option value="ADMIN">Admin</option>                                                      
                      </select>
                  </div>
                  
                    <button type="submit" class="btn btn-primary btn-block">
                        Simpan
                    </button>
                </form>
            </div>
        
      
        <div class="card-footer bg-whitesmoke">
          
        </div>
      </div>
    </div>
  </section>
  </div>
@endsection