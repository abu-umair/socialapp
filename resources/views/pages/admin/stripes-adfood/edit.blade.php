@extends('layouts.admin')
@section('title','Stripes Edit')
@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Edit Stripe</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item "><a >Merchants</a></div>
              <div class="breadcrumb-item active"><a >Stripes</a></div>
            </div>
        </div>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-header">
            <h4>Edit Stripe</h4>
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
            <form action="{{ route('stripes-adfood.update', $item->id) }}" method="POST" class="text-capitalize">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label>Card Information</label>
                <input type="text" name="card_information" value="{{ $item->card_information }}" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" value="{{ $item->date }}" class="form-control" required>
              </div>
              <div class="form-group">
                <label>CVC</label>
                <input type="text" name="cvc" value="{{ $item->cvc }}" class="form-control">
              </div>
              <div class="form-group">
                <label>Country Region</label>
                <input type="text" name="country_region" value="{{ $item->country_region }}" class="form-control">
              </div>
              <div class="form-group">
                <label>Zip</label>
                <input type="text" name="zip" value="{{ $item->zip }}" class="form-control">
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