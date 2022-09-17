@extends('layouts.admin')
@section('title','Drivers Create')
@push('prepend-style')
 
@endpush
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Create Drivers </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Drivers</a></li>
            <li class="breadcrumb-item active">Driver Create</li>
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
                  <form action="{{ route('drivers.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf{{-- setiap buat form pakai @csrf --}}
                      
                      <div class="form-group">
                        <label for="">Mitra</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-success">
                              <span><i class="fas fa-hands-helping"></i></span>
                            </span>
                          </div>
                          <select name="partners_id" class="form-control" required>
                            <option value="">Pilih Mitra</option>
                            @foreach ($items_partners as $item_partners)
                            <option value="{{$item_partners->id}}" required>{{$item_partners->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="foto">Image Driver</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-danger">
                              <span class="">
                                <i class="far fa-folder-open"></i>
                              </span>
                            </span>
                          </div>
                          <div class="custom-file">
                            <input type="file" name="foto" class="custom-file-input" required>
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="name">Name</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-gradient-warning">
                                <span><i class="far fa-id-card"></i></span>
                              </span>
                            </div>
                            <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="no_anggota">Nomor Anggota</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-primary">
                              <span><i class="fas fa-id-card-alt"></i></span>
                            </span>
                          </div>
                          <input type="text" class="form-control" name="no_anggota" placeholder="Nomor Anggota" value="{{ old('no_anggota') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="tarif">Tarif</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-primary">
                            <span><i class="fas fa-dollar-sign"></i></span>
                          </span>
                        </div>
                        <input type="text" class="form-control" name="tarif" placeholder="Tarif" value="{{ old('tarif') }}" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="long">Longitude</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-warning">
                              <span><i class="fas fa-map-marker-alt"></i></span>
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
                              <span><i class="fas fa-map-marker"></i></span>
                            </span>
                        </div>
                        <input type="text" class="form-control" name="lat" placeholder="Latitude" value="{{ old('lat') }}" required>
                      </div>
                    </div>
                      <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text bg-gradient-info">
                                <span><i class="far fa-map"></i></span>
                              </span>
                          </div>
                          <textarea name="alamat" class="form-control" required>{{ old('alamat') }}</textarea>                        
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