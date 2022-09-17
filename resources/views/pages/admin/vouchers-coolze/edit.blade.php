@extends('layouts.admin')
@section('title','Voucher Edit')
@push('prepend-style')
 
@endpush
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Voucher </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Vouchers</a></li>
            <li class="breadcrumb-item active">Voucher Edit</li>
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
                  <form action="{{ route('vouchers.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                      @csrf{{-- setiap buat form pakai @csrf --}}
                      @method('PUT')<div class="form-group">
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
                            <input type="file" name="foto" class="custom-file-input">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
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
                            <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $item->name }}" required>
                          </div>
                      </div>
                      <div class="form-group">
                        <label for="price">Price</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-primary">
                              <span><i class="fas fa-dollar-sign"></i></span>
                            </span>
                          </div>
                          <input type="number" class="form-control" name="price" placeholder="Price" value="{{ $item->price }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="expired_at">Expired Date</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-light">
                              <span><i class="fas fa-hourglass-half"></i></span>
                            </span>
                          </div>
                          <input type="date" class="form-control" name="expired_at" placeholder="Name" value="{{ $item->expired_at }}" required>     
                        </div>             
                      </div>
                      <div class="form-group">
                        <label for="expired_at_time">Expired Time</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text bg-gradient-warning">
                                <span><i class="fas fa-history"></i></span>
                              </span>
                          </div>
                          <input type="time" class="form-control" name="expired_at_time" placeholder="Name" value="{{ $item->expired_at_time != null ? \Carbon\Carbon::create($item->expired_at_time)->format ('H:i') : '' }}" >     
                        </div>             
                      </div>
                      <div class="form-group border-bottom">
                        <label for="type" class=" ">Type</label><br>
                        <div class="input-group mb-3  text-white-50">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <input type="checkbox" name="home" id="defaultCheck1" {{ $item->home == 'on' ? 'checked' : '' }}>
                            </div>
                          </div>
                          <label class="form-check-label pl-2 pr-5" for="defaultCheck1">
                            <span><i class="fas fa-home mr-1"></i>Home</span>
                          </label>
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <input type="checkbox" name="voucher" id="defaultCheck2" {{ $item->voucher == 'on' ? 'checked' : '' }}>
                            </div>
                          </div>
                          <label class="form-check-label pl-2" for="defaultCheck2">
                            <span><i class="fas fa-ticket-alt mr-1"></i>Voucher</span>
                          </label>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-edit fa-sm text-white-50"></i>
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