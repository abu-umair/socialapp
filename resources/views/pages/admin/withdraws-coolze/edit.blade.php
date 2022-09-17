@extends('layouts.admin')
@section('title','Withdraws Edit')
@push('prepend-style')
 
@endpush
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Withdraws </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Withdraws</a></li>
            <li class="breadcrumb-item active">Withdraw  Edit</li>
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
                  <form action="{{ route('withdraws.update',$item->id) }}" method="POST" enctype="multipart/form-data" >
                      @csrf{{-- setiap buat form pakai @csrf --}}
                      @method('PUT')
                      <div class="form-group">
                        <label for="foto">Bukti Transfer</label>                        
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-danger">
                              <span class="">
                                <i class="fas fa-scroll"></i>
                              </span>
                            </span>
                          </div>
                          <div class="custom-file">
                            <input type="file" name="bukti_tf" class="custom-file-input">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                          </div>
                      </div>
                      <div class="form-group">
                        <label for="">Mitra</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-success">
                              <span>
                                <i class="fas fa-hands-helping"></i>
                              </span>
                            </span>
                          </div>
                          <select name="partners_id" class="form-control" required>
                            <option value="{{$item->partners_id}}">{{$item->user->name}}</option>
                              @foreach ($items_partners as $item_partner)
                              @if ($item_partner->id != $item->partners_id)
                              <option value="{{$item_partner->id}}">{{$item_partner->name}}</option>
                                  
                              @endif
                              @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-group"> 
                        <label for="bank_tujuan">Bank Tujuan</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-warning">
                              <i class="far fa-building"></i>
                              </span>
                            </span>
                          </div>
                          <input type="text" class="form-control" name="bank_tujuan" placeholder="Bank Tujuan" value="{{ $item->bank_tujuan }}" required>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="price">Nominal</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-primary">
                              <span>
                                <i class="fas fa-dollar-sign"></i>
                              </span>
                            </span>
                          </div>
                          <input type="number" class="form-control" name="nominal" placeholder="nominal" value="{{ $item->nominal }}" required>
                        </div>
                      </div>
                      <div class="form-group"> 
                        <label for="norek">Norek</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-warning">
                              <i class="far fa-credit-card"></i>
                              </span>
                            </span>
                          </div>
                          <input type="text" class="form-control" name="norek" placeholder="Norek" value="{{ $item->norek }}" required>
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