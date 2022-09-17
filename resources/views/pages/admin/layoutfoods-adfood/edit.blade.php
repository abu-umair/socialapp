@extends('layouts.admin')
@section('title','Foods Edit')
@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Edit Food</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item "><a >Merchants</a></div>
              <div class="breadcrumb-item active"><a >Foods</a></div>
            </div>
        </div>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-header">
            <h4>Edit Food</h4>
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
            <form action="{{ route('foods.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="text-capitalize">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="foto">Image Profile</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-folder-open"></i></span>
                </div>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="foto[]" id="inputGroupFile01" multiple="true">
                  <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Name</label>
              <input type="text" name="name" value="{{ $item->name }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="categories_id">Category</label>
              <select name="categories_id" class="form-control" required>
                @if ($item->category)
                  <option value="{{$item->categories_id}}">-- {{$item->category->category}} --</option>
                @else
                  <option value="">-- Category Removed --</option>
                @endif
                
                @forelse ($categories as $category)
                    <option value="{{$category->id}}">{{$category->category}}</option>
                @empty
                    <option value="">-- Null --</option>
                @endforelse
              </select>
            </div>
            <div class="form-group">
              <label>Price</label>
              <input type="number" name="price" value="{{ $item->price }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Promo</label>
              <input type="number" name="promo" value="{{ $item->promo }}" class="form-control">
            </div>
            <div class="form-group">
              <label>Status</label>
              <select class="form-control form-control" name="status" required>
                <option value="1"><code>Active</code></option>
                <option value="0"><code>Not Active</code></option>
              </select>
            </div>
            <div class="form-group">
              <label for="merchants_id">Merchant</label>
              <select name="merchants_id" class="form-control" required>
                <option value="{{$item->user->id}}">-- {{$item->user->name}} --</option>
                  @foreach ($merchants as $merchant)
                    @if ($merchant)
                      <option value="{{$merchant->id}}">{{$merchant->name}}</option>
                    @endif
                  @endforeach
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