@extends('layouts.admin')
@section('title','Layanan')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Partners</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a >Services</a></div>
        <div class="breadcrumb-item"><a >Layanan</a></div>
        <div class="breadcrumb-item">Input Layanan</div>
      </div>
    </div>

    <div class="section-body">
      {{-- <h2 class="section-title">This is Example Page</h2>
      <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
      <div class="card">
        <div class="card-header d-sm-flex align-items-center justify-content-between ">
          <h1 class="h3 mb-0 text-gray-800">Tambah Layanan</h1>
          
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
                    <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf{{-- setiap buat form pakai @csrf --}}
                    
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Title" value="{{ old('title') }}">
                    </div>
                    <div class="form-group">
                      <label for="price">Price</label>
                      <input type="number" class="form-control" name="price" placeholder="Price" value="{{ old('price') }}">
                    </div>
                    {{-- <div class="form-group">
                      <label for="note">Note</label>
                      <input type="text" class="form-control" name="note" placeholder="Note" value="{{ old('note') }}">
                    </div> --}}
                  
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