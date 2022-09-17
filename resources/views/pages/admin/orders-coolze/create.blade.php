@extends('layouts.admin')
@section('title','Orders Create')
@push('prepend-style')
 
@endpush
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Create Orders </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Orders</a></li>
            <li class="breadcrumb-item active">Content Create</li>
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
                  <form action="{{ route('orders.store') }}" method="POST" >
                      @csrf{{-- setiap buat form pakai @csrf --}}
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
                      {{-- <div class="form-group">
                        <label for="">Customers</label>
                        <select name="customers_id" class="form-control" >
                            <option value="">Pilih Customers</option>
                            @foreach ($items_customers as $item_customer)
                              <option value="{{$item_customer->id}}">{{$item_customer->name}}</option>
                            @endforeach
                        </select>
                      </div> --}}
                      {{-- <div class="form-group">
                        <label for="">Mitra</label>
                        <select name="partners_id" class="form-control" id="sub_driver_name" >
                            <option value="">Pilih Mitra</option>
                            @foreach ($items_partners as $item_partners)
                            <option value="{{$item_partners->id}}">{{$item_partners->name}}</option>
                            @endforeach
                        </select>
                      </div> --}}

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
                          <select name="partners_id" class="form-control" id="sub_driver_name" >
                            <option value="">Pilih Mitra</option>
                            @foreach ($items_partners as $item_partners)
                            <option value="{{$item_partners->id}}">{{$item_partners->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="">Driver</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-success">
                              <span><i class="fas fa-motorcycle"></i></span>
                            </span>
                          </div>
                          <select class="form-control formselect" name="drivers_id" placeholder="Select Driver" id="sub_driver" required>
                            <option value="" disabled selected>Driver</option>
                          </select>
                        </div>
                      </div>
                      {{-- <div class="form-group">
                        <label for="drivers_id">Driver</label>
                        <select class="form-control formselect required" name="drivers_id" placeholder="Select Driver" id="sub_driver">
                          <option value="" disabled selected>Driver</option>
                        </select>
                      </div> --}}
                      <div class="form-group">
                        <label for="vouchers_id">Vouchers</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-success">
                              <span>
                                <i class="fas fa-ticket-alt"></i>
                              </span>
                            </span>
                          </div>
                          <select name="vouchers_id" class="form-control">
                            <option value="">Pilih Vouchers</option>
                            @foreach ($items_vouchers as $item_vouchers)
                            <option value="{{$item_vouchers->id}}">{{$item_vouchers->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="packages_id">Packages</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-success">
                              <span>
                                <i class="fas fa-cube"></i>
                              </span>
                            </span>
                          </div>
                          <select name="packages_id" class="form-control" id="subpackages_name">
                            <option value="">Pilih Packages</option>
                            @foreach ($items_packages as $item_packages)
                            <option value="{{$item_packages->id}}">{{$item_packages->title}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      
                      {{-- <div class="form-group">
                        <label for="">Packages</label>
                        <select name="packages_id" class="form-control" id="subpackages_name">
                            <option value="">Pilih Packages</option>
                            @foreach ($items_packages as $item_packages)
                            <option value="{{$item_packages->id}}">{{$item_packages->title}}</option>
                            @endforeach
                        </select>
                      </div> --}}
                      <div class="form-group">
                        <label for="subpackages_id">Subpackage</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-success">
                              <span><i class="fas fa-cubes"></i></span>
                            </span>
                          </div>
                          <select class="form-control formselect" name="subpackages_id" placeholder="Select Subpackage" id="subpackages" required>
                            <option value="" disabled selected>Subpackage</option>
                          </select>
                        </div>
                      </div>
                      {{-- <div class="form-group">
                        <label for="subpackages_id">Subpackage</label>
                        <select class="form-control formselect required" name="subpackages_id" placeholder="Select Subpackage" id="subpackages">
                          <option value="" disabled selected>Subpackage</option>
                        </select>
                      </div> --}}
                      <div class="form-group">
                        <label for="merk">Merk</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                              <span class="input-group-text bg-gradient-warning">
                                <span><i class="fas fa-ribbon"></i></span>
                              </span>
                          </div>
                          <input type="text" class="form-control" name="merk" placeholder="Merk" value="{{ old('merk') }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="qty">Qty</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-primary">
                              <span>
                                <i class="fas fa-calculator"></i>
                              </span>
                            </span>
                          </div>
                          <input type="number" class="form-control" name="qty" placeholder="Qty" value="{{ old('qty') }}"required >
                        </div>
                      </div>
                      
                      
                      <div class="form-group">
                        <label for="">Range Date</label>
                        <div class="col pl-0">
                          <div class="row">
                            <div class="col">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-gradient-light">
                                    <span>
                                     <i class="fas fa-pen-square"></i>
                                    </span>
                                  </span>
                                </div>
                                <input placeholder="Start Date" type="text" class="form-control datepicker" name="date" value="{{ old('date') }}">
                              </div>
                              {{-- <input placeholder="Start Date" type="text" class="form-control datepicker" name="date"> --}}
                            </div>
                            <div class="col-form-label-sm ">
                              <span class=""><i class="fas fa-arrow-circle-right"></i></span>
                            </div>
                            <div class="col">
                              <div class="input-group">
                                <input placeholder="End Date" type="text" class="form-control datepicker" name="end_date" value="{{ old('end_date') }}">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-gradient-light">
                                    <span><i class="fas fa-calendar-week"></i></span>
                                  </span>
                                </div>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                      </div>
                        <div class="form-group">
                          <label for="time">Time</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-gradient-warning">
                                  <span><i class="far fa-clock"></i></span>
                                </span>
                            </div>
                            <input type="time" class="form-control" name="time" placeholder="Name" value="{{ old('time') }}" >               
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="status">Status</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-gradient-success">
                                <span>
                                  <i class="far fa-paper-plane"></i>
                                </span>
                              </span>
                            </div>
                            <select name="status" class="form-control" required>
                              <option value="">Pilih Status</option>
                              <option value="pending">Pending</option>          
                            <option value="accept">Accept</option>
                            <option value="cancel">Cancel</option>   
                            </select>
                          </div>
                        </div>
                        {{-- <div class="form-group">
                          <label for="acc">Acc</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-gradient-success">
                                <span>
                                  <i class="fas fa-user-edit"></i>
                                </span>
                              </span>
                            </div>
                            <select name="acc" class="form-control" required>
                              <option value="">Pilih Acc</option>
                              <option value="0">No Acc</option>          
                              <option value="1">Acc</option>         
                            </select>
                          </div>
                        </div> --}}
                      
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
<script type="text/javascript">
  $(function(){
   $(".datepicker").datepicker({
       format: 'yyyy-mm-dd',
       autoclose: true,
       todayHighlight: true,
   });
  });

  //subcdriver
  $(document).ready(function () {
    $('#sub_driver_name').on('change', function () {
      let id = $(this).val();
      $('#sub_driver').empty();
      $('#sub_driver').append(`<option value="0" disabled selected>Processing...</option>`);
      var url = '{{ route("subdriver", ":id") }}';
      url = url.replace(':id',id);
      $.ajax({
      type: 'GET',
      url: url,
      // url: 'subdriver/' + id,
      success: function (response) {
        var response = JSON.parse(response);
        console.log(response);   
        $('#sub_driver').empty();
        // $('#sub_driver').append(`<option value="" disabled selected>Motode Layanan</option>`);
        response.forEach(element => {
            $('#sub_driver').append(`<option value="${element['id']}">${element['name']}</option>`);
            });
        }
      });
  });
});

//subpackages
$(document).ready(function () {
    $('#subpackages_name').on('change', function () {
      let id = $(this).val();
      $('#subpackages').empty();
      $('#subpackages').append(`<option value="0" disabled selected>Processing...</option>`);
      var url = '{{ route("subpackages", ":id") }}';
      url = url.replace(':id',id);
      $.ajax({
      type: 'GET',
      url: url,
      // url: 'subpackages/' + id,
      success: function (response) {
        var response = JSON.parse(response);
        console.log(response);   
        $('#subpackages').empty();
        // $('#subpackages').append(`<option value="" disabled selected>Subpackage</option>`);
        response.forEach(element => {
            $('#subpackages').append(`<option value="${element['id']}">${element['deskripsi_title']}</option>`);
            });
        }
      });
  });
});
 </script>
@endpush