@extends('layouts.admin')
@section('title','Drivers')
@push('prepend-style')
 
@endpush
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Drivers </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item">Drivers</a>
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
                  <form action="{{ route('drivers.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                      @csrf{{-- setiap buat form pakai @csrf --}}
                      @method('PUT')
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
                            <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $item->driver_lengkap[0]->name }}" required>
                        </div>
                    </div>
                      <div class="form-group">
                        <label for="">Mitra</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-success">
                              <span><i class="fas fa-hands-helping"></i></span>
                            </span>
                          </div>
                          <select name="partners_id" class="form-control" required>
                            <option value="{{$item->partners_id}}">{{$item->partner_lengkap->name}}</option>
                            @foreach ($items_partners as $item_partners)
                            <option value="{{$item_partners->id}}">{{$item_partners->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      {{-- <div class="form-group">
                        <label for="no_anggota">Nomor Anggota</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-primary">
                              <span><i class="fas fa-id-card-alt"></i></span>
                            </span>
                          </div>
                          <input type="text" class="form-control" name="no_anggota" placeholder="Nomor Anggota" value="{{ $item->no_anggota }}" required>
                        </div>
                    </div> --}}
                    <div class="form-group">
                      <label for="tarif">Tarif</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-primary">
                            <span><i class="fas fa-dollar-sign"></i></span>
                          </span>
                        </div>
                        <input type="text" class="form-control" name="tarif" placeholder="Tarif" value="{{ $item->tarif }}" required>
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
                        <input type="text" class="form-control" name="long" placeholder="Longitude" value="{{ $item->long }}" required>
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
                        <input type="text" class="form-control" name="lat" placeholder="Latitude" value="{{ $item->lat }}" required>
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
                          <textarea name="alamat" class="form-control" required >{{ $item->alamat }}</textarea>              
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
                            <option value="{{$item->driver_lengkap[0]->isVerified}}">{{$item->driver_lengkap[0]->isVerified == 1 ? 'Veryfied' : 'Belum Veryfied'}}</option>
                            @if ($item->driver_lengkap[0]->isVerified == 1 )
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
                          <input type="text" class="form-control" name="phone" placeholder="Phone" value="{{ $item->driver_lengkap[0]->phone  }}" required>
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
                          <input type="text" class="form-control" name="email" placeholder="Email" value="{{ $item->driver_lengkap[0]->email }}" required>
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
                      <div class="form-group border-bottom">
                        <label for="type" class=" ">Type</label><br>
                        <div class="input-group mb-3  text-white">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <input type="checkbox" name="confirm" id="defaultCheck1" {{ $item->confirm == 'on' ? 'checked' : '' }}>
                            </div>
                          </div>
                          <label class="form-check-label pl-2 pr-5" for="defaultCheck1">
                            <span>
                              <i class="fas fa-check-circle"></i>
                              Confirmation
                            </span>
                          </label>
                        </div>
                      </div>
                      <input type="hidden" name="roles" value="USER">
                      {{-- <div class="form-group">
                        <label for="roles">Role</label>
                        <select name="roles" class="form-control" required>
                            <option value="">Pilih Role</option>                          
                            <option value="USER">User</option>
                            <option value="ADMIN">Admin</option>                                                      
                        </select>
                      </div> --}}
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