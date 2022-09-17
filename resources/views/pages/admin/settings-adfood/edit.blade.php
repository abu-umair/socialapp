@extends('layouts.admin')
@section('title','Merchants Edit')
@push('prepend-style')
<link rel="stylesheet" href="{{ url('backend/node_modules/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ url('backend/node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
@endpush
@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Edit Merchant</h1>
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
            <h4>Edit Merchant</h4>
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
            <form action="{{ route('merchants.update', $item->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
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
              <input type="text" name="name" value="{{ $item->name }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input type="text" name="phone" value="{{ $item->phone }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Email</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-at"></i>
                  </div>
                </div>
                <input type="email" name="email" value="{{ $item->email }}" class="form-control" required>
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
            <input type="number" name="min_price" value="{{ $item->merchant->min_price }}" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Max Price</label>
            <input type="number" name="max_price" value="{{ $item->merchant->max_price }}" class="form-control" required>
          </div>
            <div class="form-group">
              <label>Open Restaurant</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-clock"></i>
                  </div>
                </div>
                <input type="time" name="open_restaurant" value="{{ $item->merchant->open_restaurant }}" class="form-control" required>
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
                <input type="time" name="close_restaurant" value="{{ $item->merchant->close_restaurant }}" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label>About</label>
              <textarea name="about" rows="5" class="form-control d-block w-100 h-100" required>{{ $item->merchant->about }}</textarea>
            </div>
            <div class="form-group">
              <label>Website</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa-solid fa-globe"></i>
                  </div>
                </div>
                <input type="text" name="website" value="{{ $item->merchant->website }}" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label>New Password</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-unlock"></i>
                  </div>
                </div>
                <input type="password" name="password" class="form-control pwstrength" data-indicator="pwindicator">
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
                <input type="password" name="password_confirmation" class="form-control pwstrength" data-indicator="pwindicator" >
              </div>
              <div id="pwindicator" class="pwindicator">
                <div class="bar"></div>
                <div class="label"></div>
              </div>
            </div>
            <div class="form-group">
              <label>Address</label>
              <textarea name="address" rows="5" class="form-control d-block w-100 h-100" required>{{ $item->merchant->address }}</textarea>
            </div>
            <div class="form-group">
              <label>Long</label>
              <input type="text" name="long" value="{{ $item->merchant->long }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Lat</label>
              <input type="text" name="lat" value="{{ $item->merchant->lat }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Status</label>
              <select class="form-control form-control" name="status" required>
                <option value="1"><code>Active</code></option>
                <option value="0"><code>Not Active</code></option>
              </select>
            </div>
            <div class="form-group">
              <label>Role</label>
              <select class="form-control form-control" name="roles" required>
                @if ($item->roles == 'MERCHANT')
                  <option value="MERCHANT">Merchant</option>
                  <option value="ADMIN">Admin</option>    
                @else
                  <option value="ADMIN">Admin</option>  
                  <option value="MERCHANT">Merchant</option>
                @endif
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
                  @if ($item->isVerified == 1)
                    <option value="1">Veryfied</option>
                    <option value="0">Not Veryfied</option>    
                  @else
                    <option value="0">Not Veryfied</option>
                    <option value="1">Veryfied</option>
                  @endif
                </select>
              </div>
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
<script src="{{ url('backend/node_modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ url('backend/node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>


  
@endpush