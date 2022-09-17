@extends('layouts.admin')
@section('title','Subscriptions Edit')
@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Edit Subscription</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item "><a >Merchants</a></div>
              <div class="breadcrumb-item active"><a >Subscriptions</a></div>
            </div>
        </div>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-header">
            <h4>Edit Subscription</h4>
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
                <label for="foto">Image</label>
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
                <label>Category</label>
                <input type="text" name="category" value="{{ $item->category }}" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Price</label>
                <input type="number" name="price" value="{{ $item->price }}" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Price Discount</label>
                <input type="number" name="price_discount" value="{{ $item->price_discount }}" class="form-control">
              </div>
              <div class="form-group">
                <label>Extra Posts</label>
                <input type="number" name="extra_posts" value="{{ $item->extra_posts }}" class="form-control">
              </div>
              <div class="form-group">
                <label>Extra Images</label>
                <input type="number" name="extra_images" value="{{ $item->extra_images }}" class="form-control">
              </div>
              <div class="form-group">
                <label>Weeks</label>
                <input type="number" name="weeks" value="{{ $item->weeks }}" class="form-control">
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