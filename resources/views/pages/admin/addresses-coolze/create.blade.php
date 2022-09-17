@extends('layouts.admin')
@section('title','Address Create')
@push('prepend-style')
 
@endpush
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Create Address </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Address</a></li>
            <li class="breadcrumb-item active">Address Create</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header d-flex ml-auto ">
              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="table-responsive">
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
                  <form action="{{ route('addresses.store') }}" method="POST" >
                      @csrf{{-- setiap buat form pakai @csrf --}}
                      
                      <div class="col">
                        <div class="row mb-4">
                          <div class="col mx-3">
                            <div class=" text-center mt-3"><h5>Pilih Salah Satu</h5></div>
                            <div class="dropdown-divider"></div>
                            <div class="row justify-content-center">
                              <div class="col-6">
                                <div class="form-group">
                                  <label for="customers_id">Customers</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text bg-gradient-success">
                                        <span>
                                          <i class="fas fa-user-tie"></i>
                                        </span>
                                      </span>
                                    </div>
                                    <select name="customers_id" class="form-control">
                                      <option value="">Pilih Customers</option>
                                      @foreach ($items_customers as $item_customers)
                                      <option value="{{$item_customers->id}}">{{$item_customers->name}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="form-group">
                                  <label for="partners_id">Mitra</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text bg-gradient-success">
                                        <span>
                                          <i class="fas fa-hands-helping"></i>
                                        </span>
                                      </span>
                                    </div>
                                    <select name="partners_id" class="form-control">
                                      <option value="">Pilih Mitra</option>
                                      @foreach ($items_partners as $item_partners)
                                      <option value="{{$item_partners->id}}">{{$item_partners->name}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="dropdown-divider"></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="address">Address</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text bg-gradient-info">
                                <span>
                                  <i class="far fa-map"></i>
                                </span>
                              </span>
                          </div>
                          <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>                        
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="long">Longitude</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text bg-gradient-warning">
                                <span>
                                  <i class="fas fa-map-marker-alt"></i>
                                </span>
                              </span>
                          </div>
                          <input type="text" class="form-control" name="long" placeholder="Longitude" value="{{ old('long') }}" required>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="lat">Latitude</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text bg-gradient-warning">
                                <span>
                                  <i class="fas fa-map-marker"></i>
                                </span>
                              </span>
                          </div>
                          <input type="text" class="form-control" name="lat" placeholder="Latitude" value="{{ old('lat') }}" required>
                        </div>
                      </div>
                      <div class="form-group border-bottom">
                        <label for="type" class=" ">Type</label><br>
                        <div class="input-group mb-3  text-white-50">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <input type="checkbox" name="alamat_utama" id="defaultCheck1" {{ old('alamat_utama') == 'on' ? 'checked' : '' }}>
                            </div>
                          </div>
                          <label class="form-check-label pl-2 pr-5" for="defaultCheck1">
                            <span><i class="fas fa-home mr-1"></i>Alamat Utama</span>
                          </label>
                          
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-plus fa-sm text-white-50"></i>
                        Tambah
                      </button>
                  </form>
                </div>
              </div>
              
            </div>
            <!-- ./card-body -->
            <div class="card-footer">
              <div class="row">
                
              
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      
    </div><!--/. container-fluid -->
  </section>
@endsection
@push('addon-script')
 
@endpush