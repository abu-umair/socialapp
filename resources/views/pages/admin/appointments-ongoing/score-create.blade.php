@extends('layouts.admin')
@section('title','Score - Ongoing Booking')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Partners</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a >Appointments</a></div>
        <div class="breadcrumb-item"><a >Ongoing Bookings</a></div>
        <div class="breadcrumb-item">Index Bookings</div>
        <div class="breadcrumb-item">Score</div>
      </div>
    </div>

    <div class="section-body">
      {{-- <h2 class="section-title">This is Example Page</h2>
      <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
      <div class="card">
        <div class="card-header d-sm-flex align-items-center justify-content-between ">
          <h1 class="h3 mb-0 text-gray-800">{{$item->user->name}}</h1>
          
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
              {{-- {{ route('score.create') }} --}}
                <form action="{{ route('score.store', $item->id) }}" method="POST">{{-- untuk menyimpan sebuah data menggunakan functioan 'store' --}}
                    @csrf{{-- setiap buat form pakai @csrf --}}
                    @method('PUT')
                    <div class="form-group">
                      <label for="nilai_product">Nilai Produk</label>
                      <input type="number" class="form-control" name="nilai_product" placeholder="Score" value="{{$item->nilai_product ?? old('nilai_product') }}">
                    </div>
                    <div class="form-group">
                      <label for="review_product">Deskripsi Nilai</label>
                      <textarea name="review_product" rows="10" class="d-block w-100 h-100 form-control" >{{$item->review_product ?? old('review_product')}}</textarea>
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