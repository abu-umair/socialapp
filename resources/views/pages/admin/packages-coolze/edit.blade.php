@extends('layouts.admin')
@section('title','Packages Edit')
@push('prepend-style')
 
@endpush
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Packages </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Packages</a></li>
            <li class="breadcrumb-item active">Packages Edit</li>
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
                  <form action="{{ route('packages.update', $item->id) }}" method="POST">
                      @csrf{{-- setiap buat form pakai @csrf --}}
                      @method('PUT')
                      <div class="form-group">
                        <label for="title">Layanan</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-gradient-warning">
                                <span>
                                  <i class="fas fa-poll-h"></i>
                                </span>
                              </span>
                            </div>
                            <input type="text" class="form-control" name="title" placeholder="Layanan" value="{{ $item->title }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="deskripsi_title">Deskripsi Layanan</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text bg-gradient-info">
                                <span>
                                  <i class="fas fa-pen-alt"></i>
                                </span>
                              </span>
                          </div>
                          <textarea name="deskripsi_title" class="form-control" required>{{ $item->subpackage[0]->deskripsi_title }}</textarea>                        
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="price_dasar">Harga Dasar</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-primary">
                              <span>
                                <i class="fas fa-dollar-sign"></i>
                              </span>
                            </span>
                          </div>
                          <input type="number" class="form-control" name="price_dasar" placeholder="Harga Dasar" value="{{ $item->subpackage[0]->price_dasar }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="price_diskon">Harga Diskon</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-primary">
                              <span>
                                <i class="fas fa-search-dollar"></i>
                              </span>
                            </span>
                          </div>
                          <input type="number" class="form-control" name="price_diskon" placeholder="Harga Diskon" value="{{ $item->subpackage[0]->price_diskon != null ? $item->subpackage[0]->price_diskon : '' }}" >
                        </div>
                      </div>
                    
                        <button type="submit" class="btn btn-primary btn-block">
                          Update
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