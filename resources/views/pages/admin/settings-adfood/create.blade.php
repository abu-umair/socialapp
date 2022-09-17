@extends('layouts.admin')
@section('title','Merchants Create')
@push('prepend-style')
<link rel="stylesheet" href="{{ url('backend/node_modules/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ url('backend/node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
@endpush
@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Create Merchant</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item "><a >Merchants</a></div>
              <div class="breadcrumb-item active"><a >User</a></div>
            </div>
        </div>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-header">
            <h4>Input Merchant</h4>
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
            <form action="{{ route('merchants.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="foto">Image Profile</label>
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
              <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Email</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-at"></i>
                  </div>
                </div>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label for="menus_restaurant">Menus Restaurant</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="far fa-folder-open"></i></span>
              </div>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="menus_restaurant[]" id="inputGroupFile02" multiple="true">
                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Min Price</label>
            <input type="number" name="min_price" value="{{ old('min_price') }}" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Max Price</label>
            <input type="number" name="max_price" value="{{ old('max_price') }}" class="form-control" required>
          </div>
            <div class="form-group">
              <label>Open Restaurant</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-clock"></i>
                  </div>
                </div>
                <input type="time" name="open_restaurant" value="{{ old('open_restaurant') }}" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label>Close Restaurant</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-clock"></i>
                  </div>
                </div>
                <input type="time" name="close_restaurant" value="{{ old('close_restaurant') }}" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label>About</label>
              <textarea name="about" rows="5" class="form-control d-block w-100 h-100" required>{{ old('about') }}</textarea>
            </div>
            <div class="form-group">
              <label>Website</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa-solid fa-globe"></i>
                  </div>
                </div>
                <input type="text" name="website" value="{{ old('website') }}" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label>Password Strength</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-unlock"></i>
                  </div>
                </div>
                <input type="password" name="password" value="{{ old('password') }}" class="form-control pwstrength" data-indicator="pwindicator" required>
              </div>
              <div id="pwindicator" class="pwindicator">
                <div class="bar"></div>
                <div class="label"></div>
              </div>
            </div>
            <div class="form-group">
              <label>Password Confirmation</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-lock"></i>
                  </div>
                </div>
                <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control pwstrength" data-indicator="pwindicator" required>
              </div>
              <div id="pwindicator" class="pwindicator">
                <div class="bar"></div>
                <div class="label"></div>
              </div>
            </div>
            <div class="form-group">
              <label>Address</label>
              <textarea name="address" rows="5" class="form-control d-block w-100 h-100" required>{{ old('address') }}</textarea>
            </div>
            <div class="form-group">
              <label>Long</label>
              <input type="text" name="long" value="{{ old('long') }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Lat</label>
              <input type="text" name="lat" value="{{ old('lat') }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Role</label>
              <select class="form-control form-control" name="roles" required>
                <option value="MERCHANT"><code>Merchant</code></option>
                <option value="ADMIN"><code>Admin</code></option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Veryfied</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-gradient-success">
                    <span>
                      <i class="fas fa-user-check"></i>
                    </span>
                  </span>
                </div>
                <select name="isVerified" class="form-control" required>
                  <option value="1">Veryfied</option>
                  <option value="0">Not Veryfied</option>
                </select>
              </div>
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
<script src="{{ url('backend/node_modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ url('backend/node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>


  
@endpush