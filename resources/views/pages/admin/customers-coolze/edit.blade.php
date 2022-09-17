@extends('layouts.admin')
@section('title','Customers')
@push('prepend-style')
 
@endpush
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Customers </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item">Customers</li>
            <li class="breadcrumb-item active">Edit</li>
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
                  <form action="{{ route('customers.update', $item->id) }}" method="POST" enctype="multipart/form-data">{{-- untuk menyimpan sebuah data menggunakan functioan 'store' --}}
                      @csrf{{-- setiap buat form pakai @csrf --}}
                      @method('PUT')
                      <div class="form-group">
                        <div class="form-group">
                          <label for="foto">Image Profile</label>
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
                            <option value="{{$item->isVerified != 1 ? 0 : 1}}">{{$item->isVerified == 1 ? 'Veryfied' : 'Belum Veryfied'}}</option>
                            @if ($item->isVerified == 1)
                            <option value="0">Belum Veryfied</option>
                            @else
                            <option value="1">Veryfied</option>
                            @endif
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="phone">Phone</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-primary">
                              <span>
                                <i class="fas fa-phone"></i>
                              </span>
                            </span>
                          </div>
                          <input type="text" class="form-control" name="phone" placeholder="Phone" value="{{ $item->phone }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text bg-gradient-warning">
                                <span>
                                  <i class="fas fa-at"></i>
                                </span>
                              </span>
                          </div>
                          <input type="text" class="form-control" name="email" placeholder="Email" value="{{ $item->email }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="jumlah_ac">Jumlah Ac</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-gradient-warning">
                                <span>
                                  <i class="far fa-snowflake"></i>
                                </span>
                              </span>
                            </div>
                            <input type="text" class="form-control" name="jumlah_ac" placeholder="Jumlah Ac" value="{{ $item->customer->jumlah_ac != null ? $item->customer->jumlah_ac : 0 }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="password">Password New</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text bg-gradient-warning">
                                <span>
                                  <i class="fas fa-unlock"></i>
                                </span>
                              </span>
                          </div>
                          <input type="password" class="form-control" name="password" placeholder="Password New">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="password_confirmation">Password Confirmation</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text bg-gradient-warning">
                                <span>
                                  <i class="fas fa-lock"></i>
                                </span>
                              </span>
                          </div>
                          <input type="password" class="form-control" name="password_confirmation" placeholder="Password Confirmation">
                        </div>
                      </div>


                      {{-- <div class="form-group">
                        <label for="roles">Role</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-success">
                              <span>
                                <i class="fab fa-gg-circle"></i>
                              </span>
                            </span>
                          </div>
                          <select name="roles" class="form-control" required>
                            <option value="{{$item->roles}}">{{$item->roles}}</option>  
                            @if ($item->roles == 'USER')
                            <option value="ADMIN">Admin</option>          
                            @else
                            <option value="USER">User</option>    
                            @endif        
                          </select>
                        </div>
                      </div> --}}
                      <input type="hidden" name="roles" value="USER">
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