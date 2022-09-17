@extends('layouts.admin')
@section('title','Vouchers Create')
@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Create Voucher</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item "><a >Vouchers</a></div>
              <div class="breadcrumb-item active"><a >User</a></div>
            </div>
        </div>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-header">
            <h4>Input Voucher</h4>
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
            <form action="{{ route('vouchers_adfood.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="foto">Image Voucher</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-folder-open"></i></span>
                  </div>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="foto[]" id="inputGroupFile01" multiple="true" required>
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                  </div>
                </div>
              </div>
            <div class="form-group">
              <label>Name</label>
              <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>
            
            <div class="form-group">
              <label>Coupon Code</label>
              <input type="text" name="coupon_code" value="{{ old('coupon_code') }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Merchant</label>
              <select class="form-control form-control" name="merchants_id" required>
                <option value="">-- Select --</option>
                @foreach ($items as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Start Date</label>
              <input type="date" name="expired_at" value="{{ old('expired_at') }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label>End Date</label>
              <input type="time" name="expired_at_time" value="{{ old('expired_at_time') }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Min Purchase</label>
              <input type="number" name="min_purchase" value="{{ old('min_purchase') }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea name="description" rows="10" class="d-block w-100 h-100 form-control">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
              <label>Discount</label>
              <input type="number" name="discount" value="{{ old('discount') }}" class="form-control">
            </div>
            <div class="form-group">
              <label>Price</label>
              <input type="number" name="price" value="{{ old('price') }}" class="form-control" required>
            </div>
            <div class="d-flex flex-row bd-highlight mb-2">
              <div class="p-2 bd-highlight ">
                <div class="form-group">
                  <label>Select</label>
                  <select class="form-control" id="selectType">
                    <option value="">-- Select --</option>
                    <option value="5">5%</option>
                    <option value="10">10%</option>
                    <option value="15">15%</option>
                    <option value="20">20%</option>
                    <option value="25">25%</option>
                    <option value="30">30%</option>
                    <option value="35">35%</option>
                    <option value="40">40%</option>
                    <option value="45">45%</option>
                    <option value="50">50%</option>
                    <option value="55">55%</option>
                    <option value="60">60%</option>
                    {{-- <option value="11">By One Get One</option>
                    <option value="1">free one dish</option> --}}
                    <option value="By One Get One">By One Get One</option>
                    <option value="Free One Dish">Free One Dish</option>
                  </select>
                </div>
              </div>
              <div class="p-2 bd-highlight flex-grow-1 ">
                <div class="form-group">
                  <label>Option</label>
                  <input type="text" name="type" id="valueType" value="{{ old('type') }}" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="d-block">Vouchers</label>
              <div class="form-check">
                <input class="form-check-input" name="home"  name="" type="checkbox" id="defaultCheck1" {{ old('home') == 'on' ? 'checked' : '' }}>
                <label class="form-check-label" for="defaultCheck1">
                  Home
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" name="voucher" type="checkbox" id="defaultCheck3" {{ old('voucher') == 'on' ? 'checked' : '' }}>
                <label class="form-check-label" for="defaultCheck3">
                  Voucher
                </label>
              </div>
            </div>
            <div class="form-group">
              <label>Status</label>
              <select class="form-control form-control" name="status" required>
                <option value="1">Active</option>
                <option value="0">Not active</option>
              </select>
            </div>
            

            
            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-plus fa-sm text-white-50"></i>
              Create
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

<script>
  $("#selectType").change(function() {
     var val=$(this).val();
     $("#valueType").val(val);
  });
 </script>
  
@endpush