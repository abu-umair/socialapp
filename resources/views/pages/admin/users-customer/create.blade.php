@extends('layouts.admin')
@section('title','Services - Customers')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Customers</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a >users</a></div>
        <div class="breadcrumb-item"><a >Customers</a></div>
        <div class="breadcrumb-item">Input Costumers</div>
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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>                            
        @endif
        
          
            <div class="card-body">
                <form action="{{ route('users-customer.store') }}" method="POST" enctype="multipart/form-data">{{-- untuk menyimpan sebuah data menggunakan functioan 'store' --}}
                    @csrf{{-- setiap buat form pakai @csrf --}}
                    <div class="form-group">
                      <label for="foto">Foto Profile</label>
                      <input type="file" name="foto" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                      <label for="isVerified">Veryfied</label>
                      <select name="isVerified" class="form-control" required>
                          <option value="">Pilih Verified</option>                          
                          <option value="1">Aktif</option>
                          <option value="0">Tidak Aktif<option>            
                      </select>
                  </div>
                    
                    <div class="form-group">
                      <label for="phone">Phone</label>
                      <input type="text" class="form-control" name="phone" placeholder="Phone" value="{{ old('phone') }}" required>
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