@extends('layouts.admin')
@section('title','Foods Create')
@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Create Food</h1>
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
            <h4>Input Food</h4>
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
            <form action="{{ route('foods.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="foto">Image Foods</label>
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
              <label for="categories_id">Category</label>
              <select name="categories_id" class="form-control" required>
                  @foreach ($categories as $category)
                    @if ($category)
                      <option value="{{$category->id}}">{{$category->category}}</option>
                    @endif
                  @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Price</label>
              <input type="number" name="price" value="{{ old('price') }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Promo</label>
              <input type="number" name="promo" value="{{ old('promo') }}" class="form-control">
            </div>
            <div class="form-group">
              <label>Status</label>
              <select class="form-control form-control" name="status" required>
                <option value="1">Active</option>
                <option value="0">Not active</option>
              </select>
            </div>
            <div class="form-group">
              <label for="merchants_id">Merchant</label>
              <select name="merchants_id" class="form-control" required>
                  @foreach ($merchants as $merchant)
                    @if ($merchant)
                      <option value="{{$merchant->id}}">{{$merchant->name}}</option>
                    @endif
                  @endforeach
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



  
@endpush