@extends('layouts.admin')
@section('title','Promotions Edit')
@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Edit Promotion</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item "><a >Merchants</a></div>
              <div class="breadcrumb-item active"><a >Promotions</a></div>
            </div>
        </div>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-header">
            <h4>Edit Promotion</h4>
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
            <form action="{{ route('subscription-adfood.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="text-capitalize">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="foto">Image Promotion</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-folder-open"></i></span>
                  </div>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="foto" id="inputGroupFile01">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                  </div>
                </div>
              </div>
            <div class="form-group">
              <label>Name</label>
              <input type="text" name="name" value="{{ $item->name }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Coupon Code</label>
              <input type="text" name="coupon_code" value="{{ $item->coupon_code }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Merchant</label>
              <select class="form-control form-control" name="merchants_id" required>
                <option value="{{ $item->merchants_id }}">-- Select --</option>
                @foreach ($item_merchants as $item_merchant)
                <option value="{{ $item_merchant->id }}">{{ $item_merchant->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Start Date</label>
              <input type="date" name="start_date" value="{{ $item->start_date }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label>End Date</label>
              <input type="date" name="end_date" value="{{ $item->end_date }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Min Purchase</label>
              <input type="number" name="min_purchase" value="{{ $item->min_purchase }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea name="description" rows="10" class="d-block w-100 h-100 form-control">{{ $item->description }}</textarea>
          </div>
            <div class="form-group">
              <label>Discount</label>
              <input type="number" name="discount" value="{{ $item->discount }}" class="form-control">
            </div>
            <div class="form-group">
              <label>Vendor</label>
              <input type="text" name="vendor" value="{{ $item->vendor }}" class="form-control">
            </div>
            <div class="form-group">
              <label class="d-block">Promotions</label>
              <div class="form-check">
                <input class="form-check-input" name="home" type="checkbox" id="defaultCheck1" {{ $item->home == 'on' ? 'checked' : '' }}>
                <label class="form-check-label" for="defaultCheck1">
                  Home
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" name="voucher" type="checkbox" id="defaultCheck3" {{ $item->voucher == 'on' ? 'checked' : '' }}>
                <label class="form-check-label" for="defaultCheck3">
                  Promotion
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

<script>
  $("#selectType").change(function() {
     var val=$(this).val();
     $("#valueType").val(val);
  });
 </script>

  
@endpush