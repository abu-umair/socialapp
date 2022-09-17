@extends('layouts.admin')
@section('title','Layanan Edit')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Partners</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a >Services</a></div>
        <div class="breadcrumb-item"><a >Layanan</a></div>
        <div class="breadcrumb-item">Edit Layanan</div>
      </div>
    </div>

    <div class="section-body">
      {{-- <h2 class="section-title">This is Example Page</h2>
      <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
      <div class="card">
        <div class="card-header d-sm-flex align-items-center justify-content-between ">
          <h1 class="h3 mb-0 text-gray-800">Edit Layanan</h1>
          
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
                <form action="{{ route('services.update', $item->id) }}" method="POST" >{{-- untuk menyimpan sebuah data menggunakan functioan 'store' --}}
                    @csrf{{-- setiap buat form pakai @csrf --}}
                    @method('PUT')

                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" class="form-control" name="title" placeholder="Title" value="{{ $item->title }}">
                  </div>
                  <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" name="price" placeholder="Price" value="{{ $item->price }}">
                  </div>
                  {{-- <div class="form-group">
                    <label for="note">Note</label>
                    <input type="text" class="form-control" name="note" placeholder="Note" value="{{ $item->note}}">
                  </div> --}}

                    
                  
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