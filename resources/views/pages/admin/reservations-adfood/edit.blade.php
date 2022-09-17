@extends('layouts.admin')
@section('title','Reservations Edit')
@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Edit Reservation</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item "><a >Merchants</a></div>
              <div class="breadcrumb-item active"><a >Reservations</a></div>
            </div>
        </div>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-header">
            <h4>Input Reservation</h4>
          </div>
          <div class="card-body">
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
            <form action="{{ route('reservations.update', $item->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="merchants_id">Merchant</label>
                <select name="adfood_merchants_id" class="form-control" required>
                  <option value="{{ $item->adfood_merchants_id }}">-- {{ $item->merchant->first()->name }} --</option>
                    @foreach ($merchants as $merchant)
                      @if ($merchant)
                        <option value="{{$merchant->id}}">{{$merchant->name}}</option>
                      @endif
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="customers_id">Customer</label>
                <select name="adfood_customers_id" class="form-control" required>
                  <option value="{{ $item->adfood_customers_id }}">-- {{ $item->customer->first()->name }} --</option>
                    @foreach ($customers as $customer)
                      @if ($customer)
                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                      @endif
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Total People</label>
                <input type="number" name="jumlah_orang" value="{{ $item->jumlah_orang }}" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" value="{{ $item->date }}" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Time</label>
                <input type="time" name="time" value="{{ $item->time }}" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Tracking Register </label>
                <input type="{{ $item->tracking_register ? 'datetime' : 'datetime-local' }}" name="tracking_register" value="{{ $item->tracking_register }}" class="form-control">
              </div>
              <div class="form-group">
                <label>Tracking Restaurant Check</label>
                <input type="{{ $item->tracking_restaurant_check ? 'datetime' : 'datetime-local' }}" name="tracking_restaurant_check" value="{{ $item->tracking_restaurant_check }}" class="form-control">
              </div>
              <div class="form-group">
                <label>Tracking Confrimed Restaurant </label>
                <input  type="{{ $item->tracking_confrimed_restaurant ? 'datetime' : 'datetime-local' }}" name="tracking_confrimed_restaurant " value="{{$item->tracking_confrimed_restaurant}}" class="form-control">
              </div>
              
              <div class="form-group">
                <label>Tracking Done </label>
                <input type="{{ $item->tracking_done ? 'datetime' : 'datetime-local' }}" name="tracking_done" value="{{ $item->tracking_done }}" class="form-control">
              </div>
              <div class="form-group">
                <label>Status</label>
                <select class="form-control form-control" name="status" required>
                  <option value="{{ $item->status }}">-- {{ $item->status }} --</option>
                  <option value="accepted">Accepted</option>
                  <option value="pending">Pending</option>          
                  <option value="rejected">Rejected</option>   
                </select>
              </div>
              <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-edit fa-sm text-white-50"></i>
                Update
              </button>
          </form>
          </div>
        </div>
      </div>
      
      
  </section>
</div>
@endsection

@push('prepend-script')
@endpush

@push('addon-script')



  
@endpush