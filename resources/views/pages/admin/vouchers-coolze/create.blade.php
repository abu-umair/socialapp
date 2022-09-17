@extends('layouts.admin')
@section('title','Vouchers Create')
@push('prepend-style')
 
@endpush
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Create Vouchers </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Vouchers</a></li>
            <li class="breadcrumb-item active">Voucher Create</li>
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
                  <form action="{{ route('vouchers.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf{{-- setiap buat form pakai @csrf --}}
                     
                      <div class="form-group">
                        <label for="foto">Picture Vouchers</label>                        
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
                      <div class="form-group">
                        <label for="name">Name</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text bg-gradient-warning">
                                <span>
                                  <i class="fas fa-file-signature"></i>
                                </span>
                              </span>
                          </div>
                          <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="price">Price</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-primary">
                              <span>
                                <i class="fas fa-dollar-sign"></i>
                              </span>
                            </span>
                          </div>
                          <input type="number" class="form-control" name="price" placeholder="Price" value="{{ old('price') }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="expired_at">Expired Date</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-light">
                              <span>
                                <i class="fas fa-hourglass-half"></i>
                              </span>
                            </span>
                          </div>
                          <input type="date" class="form-control" name="expired_at" placeholder="Name" value="{{ old('expired_at') }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="expired_at_time">Expired Time</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text bg-gradient-warning">
                                <span>
                                  <i class="fas fa-history"></i>
                                </span>
                              </span>
                          </div>
                          <input type="time" class="form-control" name="expired_at_time" placeholder="Name" value="{{ old('expired_at_time') }}" >               
                        </div>  
                      </div>
                      <div class="form-group border-bottom">
                        <label for="type" class=" ">Type</label><br>
                        <div class="input-group mb-3  text-white-50">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <input type="checkbox" name="home" id="defaultCheck1" {{ old('home') == 'on' ? 'checked' : '' }}>
                            </div>
                          </div>
                          <label class="form-check-label pl-2 pr-5" for="defaultCheck1">
                            <span><i class="fas fa-home mr-1"></i>Home</span>
                          </label>
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <input type="checkbox" name="voucher" value="1" id="defaultCheck2" {{ old('voucher') == 'on' ? 'checked' : '' }}>
                            </div>
                          </div>
                          <label class="form-check-label pl-2" for="defaultCheck2">
                            <span><i class="fas fa-ticket-alt mr-1"></i>Voucher</span>
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