@php
    function rupiah($angka){
	
      $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
      return $hasil_rupiah;

    }
@endphp
@extends('layouts.admin')
@section('title','Withdraws Create')
@push('prepend-style')
 
@endpush
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Create Withdraws </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Withdraws</a></li>
            <li class="breadcrumb-item active">Withdraw  Create</li>
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
            <!-- /.card-header -->
            <div class="card-body">
              @if (Auth::user()->roles == 'PARTNER')
              <div class="row justify-content-center">
                <div class="col-3 m-3 align-center">
                  <div class="border-bottom shadow-sm">
                    <p class="text-center h3"><i class="fas fa-wallet text-warning"></i> Saldo</p>
                  </div>
                  <div class=""><p class="text-center h3">{{ rupiah(1000) }}</p></div>
                </div>
              </div>
              @endif
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
                  @if (Auth::user()->roles == 'ADMIN')
                  <form action="{{ route('withdraws.store') }}" method="POST" enctype="multipart/form-data" >    
                  @else
                  <form action="{{ route('withdraws_withId.store') }}" method="POST" enctype="multipart/form-data" >
                  @endif
                  
                      @csrf{{-- setiap buat form pakai @csrf --}}
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
                            <input type="file" name="bukti_tf" class="custom-file-input" required>
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                          </div>
                        </div>
                      </div>
                      @if (Auth::user()->roles == 'ADMIN')
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
                              <option value="">Pilih Mitra</option>
                              @foreach ($items_partners as $item_partner)
                                <option value="{{$item_partner->id}}">{{$item_partner->name}}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>    
                      @else
                          <input type="hidden" name="partners_id" value="{{ Auth::user()->id }}">
                      @endif
                      
                      <div class="form-group"> 
                        <label for="bank_tujuan">Bank Tujuan</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-warning">
                              <i class="far fa-building"></i>
                              </span>
                            </span>
                          </div>
                          <input type="text" class="form-control" name="bank_tujuan" placeholder="Bank Tujuan" value="{{ old('bank_tujuan') }}" required>
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
                          <input type="number" class="form-control" name="nominal" placeholder="nominal" value="{{ old('nominal') }}" required>
                        </div>
                      </div>
                      <div class="form-group"> 
                        <label for="norek">Norek</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-primary">
                              <i class="far fa-credit-card"></i>
                              </span>
                            </span>
                          </div>
                          <input type="text" class="form-control" name="norek" placeholder="Norek" value="{{ old('norek') }}" required>
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