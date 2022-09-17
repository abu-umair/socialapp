@extends('layouts.admin')
@section('title','Wallets Edit')
@push('prepend-style')
 
@endpush
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Wallets </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Wallets</a></li>
            <li class="breadcrumb-item active">Wallet  Edit</li>
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
                  <form action="{{ route('wallets.update',$item[0]->id) }}" method="POST">
                      @csrf{{-- setiap buat form pakai @csrf --}}
                      @method('PUT')
                      <div class="row mb-4">
                        <div class="col mx-5">
                          <div class=" text-center mt-3"><h5>Pilih Salah Satu</h5></div>
                          <div class="dropdown-divider"></div>
                          <div class="row justify-content-center">
                            
                            <div class="col">
                              <div class="form-group">
                                <label for="">Customers</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text bg-gradient-success">
                                      <span class="fas fa-user-tie"></span>
                                    </span>
                                  </div>
                                  <select name="customers_id" class="form-control">
                                    @if ($item[0]->customers_id)
                                      <option value="{{$item[0]->customers_id}}">{{$item[0]->user->name}}</option>
                                      <option value="">Pilih Customers</option>
                                    @else
                                      <option value="">Pilih Customers</option>
                                    @endif  
                                      @foreach ($items_customers as $item_customer)
                                        @if ($item_customer->id != $item[0]->customers_id)
                                        <option value="{{$item_customer->id}}">{{($item_customer->name)}}</option>    
                                        @endif
                                      @endforeach
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <label for="">Partners</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text bg-gradient-success">
                                      <span class="fas fa-hands-helping"></span>
                                    </span>
                                  </div>
                                  <select name="partners_id" class="form-control">
                                    @if ($item[0]->partners_id)
                                    <option value="{{$item[0]->partners_id}}">{{$item[0]->user_partner->name}}</option>
                                    <option value="">Pilih Partners</option>
                                    @else
                                      <option value="">Pilih Partners</option>
                                    @endif 
                                      @foreach ($items_partners as $item_partner)
                                        @if ($item_partner->id != $item[0]->partners_id)
                                        <option value="{{$item_partner->id}}">{{$item_partner->name}}</option>    
                                        @endif
                                      @endforeach
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="type">Type</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-success">
                              <span><i class="fas fa-retweet"></i></span>
                            </span>
                          </div>
                          <select name="type" class="form-control" required>
                              <option value="{{$item[0]->type}}">{{strtoupper($item[0]->type)}}</option>
                              @if ($item[0]->type == 'IN' || $item[0]->type == 'in')
                              <option value="out">OUT</option>    
                              @else
                              <option value="in">IN</option>    
                              @endif
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="by">By</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-warning">
                              <span><i class="fas fa-money-check"></i></span>
                            </span>
                          </div>
                          <input type="text" class="form-control" name="by" placeholder="By" value="{{ $item[0]->by}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="total">Total</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-warning">
                            <span><i class="fas fa-cash-register "></i></span>
                          </span>
                        </div>
                      <input type="text" class="form-control" name="total" placeholder="Total" value="{{ $item[0]->total}}" >
                    </div>
                    </div>
                    <div class="form-group">
                      <label for="coolpoin">Cool Point</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-gradient-warning">
                            <span><i class="fas fa-coins"></i></span>
                          </span>
                        </div>
                        <input type="text" class="form-control" name="coolpoin" placeholder="Cool Point" value="{{ $item[0]->coolpoin}}" >
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