@extends('layouts.admin')
@section('title','Appointments - Ongoing Booking')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Partners</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a >Appointments</a></div>
        <div class="breadcrumb-item"><a >Ongoing Bookings</a></div>
        <div class="breadcrumb-item">Create Bookings</div>
      </div>
    </div>

    <div class="section-body">
      {{-- <h2 class="section-title">This is Example Page</h2>
      <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
      <div class="card">
        <div class="card-header d-sm-flex align-items-center justify-content-between ">
          <h1 class="h3 mb-0 text-gray-800">Create Booking</h1>
          
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
                <form action="{{ route('appointments-ongoing.store') }}" method="POST">{{-- untuk menyimpan sebuah data menggunakan functioan 'store' --}}
                    @csrf{{-- setiap buat form pakai @csrf --}}
                    
                    <div class="form-group">
                      <label for="customers_id">Customer</label>
                      <select name="customers_id" class="form-control" required>
                          <option value="">Pilih Customer</option>
                          @foreach ($customers as $items_customers)
                            @if ($items_customers->user->roles != 'ADMIN')
                              <option value="{{$items_customers->id}}">{{$items_customers->user->name}}</option>
                            @endif
                          @endforeach
                      </select>
                    </div>
                    <div class="row mb-4">
                      <div class="col mx-3">
                        <div class=" text-center mt-3"><h5>Pilih Salah Satu</h5></div>
                        <div class="dropdown-divider"></div>
                        <div class="row justify-content-center">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="">Appointment Doctor</label>
                              <select name="doctors_id" class="form-control" >
                                  <option value="">Pilih Doctor</option>
                                  @foreach ($doctors as $items_doctors)
                                  <option value="{{$items_doctors->id}}">{{$items_doctors->name}}</option>
                                  @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="">Appointment Groomer</label>
                              <select name="groomers_id" class="form-control" >
                                 
                                  <option value="">Pilih Groomer</option>
                                  @foreach ($groomers as $items_groomers)
                                  <option value="{{$items_groomers->id}}">{{$items_groomers->name}}</option>
                                  @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="dropdown-divider"></div>
                      </div>
                    </div>
                    
                  
                  <div class="form-group">
                    <label for="metode_layanan">Metode Layanan</label>
                    <select name="metode_layanan" class="form-control" required>
                        <option value="">Pilih Metode</option>                    
                        <option value="0">Datang ke rumah</option>          
                        <option value="1">Datang ke klinik / petshop</option>
                        
                        {{-- @foreach ($services as $service)
                        <option value="{{$service->id}}">{{$service->title}}</option>
                        @endforeach --}}
                    </select>
                </div>
                <div class="dropdown-divider"></div>
                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label for="date">Jadwal Date</label>
                      <input type="date" class="form-control" name="date" placeholder="Date" value="{{ old('date') }}">
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label for="time">Jadwal Waktu Mulai</label>
                      <input type="time" class="form-control" name="time" placeholder="Waktu Mulai" value="{{ old('time') }}">
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <label for="time_akhir">Jadwal Waktu Selesai</label>
                      <input type="time" class="form-control" name="time_akhir" placeholder="Waktu Selesai" value="{{ old('time_akhir') }}">
                    </div>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="form-group">
                  <label for="masalah_hewan">Masalah Hewan</label>
                  <textarea name="masalah_hewan" rows="10" class="d-block w-100 h-100 form-control">{{ old('masalah_hewan') }}</textarea>
                </div>
                <div class="form-group">
                  <label for="status">Status</label>
                  <select name="status" class="form-control" required>
                      <option value="">Pilih Status</option>                          
                      <option value="0">Pending</option>          
                      <option value="1">Diterima</option>
                      <option value="2">Ditolak / Dibatalkan</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="acc">Acc</label>
                  <select name="acc" class="form-control" required>
                      <option value="">Pilih</option>                    
                      <option value="0">No Acc</option>          
                      <option value="1">Acc</option>
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