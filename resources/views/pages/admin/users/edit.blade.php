@extends('layouts.admin')
@section('title','Users Edit')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Partners</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a >Services</a></div>
        <div class="breadcrumb-item"><a >Groomers</a></div>
        <div class="breadcrumb-item">Edit Users</div>
      </div>
    </div>

    <div class="section-body">
      {{-- <h2 class="section-title">This is Example Page</h2>
      <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
      <div class="card">
        <div class="card-header d-sm-flex align-items-center justify-content-between ">
          <h1 class="h3 mb-0 text-gray-800">Edit Users</h1>
          
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
                <form action="{{ route('users.update', $item->id) }}" method="POST" enctype="multipart/form-data">{{-- untuk menyimpan sebuah data menggunakan functioan 'store' --}}
                    @csrf{{-- setiap buat form pakai @csrf --}}
                    @method('PUT')
                    <div class="form-group">
                      <label for="foto">Foto Profile</label>
                      <input type="file" name="foto" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $item->name }}">
                    </div>
                    <div class="form-group">
                      <label for="isVerified">Veryfied</label>
                      <select name="isVerified" class="form-control" required>
                        <option value="{{$item->isVerified != 1 ? 0 : 1}}">Jangan Diubah ( {{$item->isVerified == 1 ? 'Aktif' : 'Tidak Aktif'}} )</option>                              
                          <option value="1">Aktif</option>
                          <option value="0">Tidak Aktif<option>            
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="phone">Phone</label>
                      <input type="text" class="form-control" name="phone" placeholder="Phone" value="{{ $item->phone }}">
                    </div>
                    <div class="form-group">
                        <label for="transaksi">Transaksi</label>
                        <input type="text" class="form-control" name="transaksi" placeholder="Transaksi" value="{{ $item->customer->transaksi }}"}}">
                    </div>
                    <div class="form-group">
                      <label for="status">Status</label>
                      <select name="status" class="form-control" required>
                          <option value="{{$item->customer->status != null ? 1 : 0}}">Jangan Diubah ( {{$item->customer->status== 1 ? 'Aktif' : 'Tidak Aktif'}} )</option>
                           
                          <option value="1">Aktif</option>
                          <option value="0">Tidak Aktif</option>                                                      
                      </select>
                  </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $item->email }}">
                    </div>
                    
                    <div class="form-group">
                      <label for="password">Password Old</label>
                      <input type="password" name="current_password" id="current_password"
                        class="form-control" placeholder="Password User Old"> 
                    </div>
                    <div class="form-group">
                        <label for="password">Password New</label>
                        <input type="password" name="password" id="password"
                        class="form-control" placeholder="Password User New">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                        class="form-control" placeholder="Password User Confirm New">     
                    </div>
                    <div class="form-group">
                      <label for="roles">Role</label>
                      <select name="roles" class="form-control" required>
                          <option value="{{$item->roles}}">Jangan Diubah Role : {{$item->roles}}</option>                          
                          <option value="USER">User</option>
                          <option value="ADMIN">Admin</option>                                                      
                      </select>
                  </div>
                  
                    <button type="submit" class="btn btn-primary btn-block">
                        Ubah
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