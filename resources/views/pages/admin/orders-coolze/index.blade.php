@extends('layouts.admin')
@section('title','Order')
@push('prepend-style')
{{-- datatable --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
<style>
  .dark-mode .table-bordered{
    border: none !important;
  }
  .table{
    background: #a5a58d;
    border-radius:3px;
    border-collapse: collapse;
    height: 320px;
    margin: auto;
    max-width: 600px;
    padding:5px;
    width: 100%;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    animation: float 5s infinite;
      }

  th {
    color:#ECEEE3;
    background:#AE775D;
    border: none !important;
    /* border-bottom:4px solid #9ea7af;
    border-right: 1px solid #343a45; */
    padding:24px;
    /* font-size:23px; */
    font-weight: 100;
    text-align:left;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    vertical-align:middle;
  }

  th:first-child {
    border-top-left-radius:3px; 
    
  }
  
  th:last-child {
    border-top-right-radius:3px;
    border-right:none;
  }
    
  tr {
    border-top: 1px solid #C1C3D1;
    border-bottom-: 1px solid #C1C3D1;
    color:D5DDE5;
    font-size:16px;
    font-weight:normal;
    text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
  }
  
  tr:hover td {
    background:#6c757d;
    color:#FFFFFF;
    border-top: 1px solid #22262e;
  }
  
  tr:first-child {
    border-top:none;
  }

  tr:last-child {
    border-bottom:none;
  }
  
  tr:nth-child(odd) td {
    background:#343a40;
  }
  
  tr:nth-child(odd):hover td {
    background:#6c757d;
  }

  tr:last-child td:first-child {
    border-bottom-left-radius:3px;
  }
  
  tr:last-child td:last-child {
    border-bottom-right-radius:3px;
  }
  
  td {
    background:#495057;
    padding:20px;
    text-align:left;
    vertical-align:middle;
    font-weight:300;
    border-right:0 !important;
    font-size:18px;
    text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
    border-right: 1px solid #C1C3D1;
  }

  td:last-child {
    border-right: 0px;
  }
</style>
@endpush
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Home Orders</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Orders</li>
            
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
            @if (Auth::user()->roles == 'ADMIN')
            <div class="card-header d-flex ml-auto ">
              <a href="{{ route('orders.create')}}"
             class="btn btn-sm btn-primary shadow-sm rounded">
             <i class="fas fa-plus fa-sm text-white-50"></i>
             Tambah Order
              </a>
            </div>    
            @endif
            
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="table-responsive">
                  
                <table class="table table-bordered " id="example" width="100%" collspacing="0">
                  <thead>
                      <tr>
                        <th><i class="far fa-clipboard d-block"></i> No</th>
                        <th><i class="fas fa-pager d-block"></i>Id Order</th>
                        <th><i class="fas fa-user-tie  d-block"></i> Customer</th>
                        <th><i class="fas fa-hands-helping d-block"></i> Mitra</th>
                        <th><i class="fas fa-motorcycle d-block"></i> Driver</th>                          
                        <th><i class="fas fa-ticket-alt d-block"></i> Voucher</th>
                        <th><i class="fas fa-cube d-block d-block"></i> Packages</th>
                        <th ><i class="far fa-map d-block"></i>Address</th>    
                        <th><i class="fas fa-ribbon d-block"></i> Merk</th>
                        <th><i class="fas fa-calculator d-block"></i> Qty</th>
                        <th><i class="fas fa-calendar-week d-block"></i> Range</th>
                        <th><i class="far fa-clock d-block"></i> Time</th>
                        <th><i class="far fa-paper-plane d-block"></i> Status</th>
                        <th><i class="fas fa-tools d-block"></i> Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @php
                          $s=1;                                                   
                      @endphp
                      @forelse ($items as $item)                      
                          <tr>
                            <td><span class="badge badge-pill badge-light">{{$s++}}</span></td>
                              {{-- <td>
                                <img src="{!!$item->url ? Storage::url($item->url) : url('backend/assets/images/news/img05.jpg') !!}" class="box-img mr-1 border-bottom" width="100">
                              </td> --}}
                              <td><span class="badge badge-success">{{ $item->id_unique }}</span> </td>
                              @if ($item->user_customer->status == 1)
                                <td><img src="{!!$item->user_customer->foto ? Storage::url($item->user_customer->foto) : url('backend/assets/images/avatar/customer.png') !!}" class="img-circle mr-1" width="35">{{ $item->user_customer->name }}</td>
                              @else
                                <td><i class="far fa-times-circle mr-1 text-danger"></i>{{ $item->user_customer->name }} </td>
                              @endif

                              @if ($item->user_partner->status == 1)
                                <td><img src="{!!$item->user_partner->foto ? Storage::url($item->user_partner->foto) : url('backend/assets/images/avatar/mitra.png') !!}" class="img-circle mr-1" width="35">{{ $item->user_partner->name }}</td>
                              @else
                                <td><i class="far fa-times-circle mr-1 text-danger"></i>{{ $item->user_partner->name }} </td>
                              @endif
                              @if ($item->driver->status == 1)
                                <td><img src="{!!$item->driver->foto ? Storage::url($item->driver->foto) : url('backend/assets/images/avatar/driver.png') !!}" class="img-circle mr-1" width="35">{{ $item->driver->name }}</td>
                              @else
                                <td><i class="far fa-times-circle mr-1 text-danger"></i>{{ $item->driver->name }} </td>
                              @endif
                              @if ($item->voucher)
                                @if ($item->voucher->status == 1)
                                  <td><img src="{!!$item->voucher->foto ? Storage::url($item->voucher->foto) : url('backend/assets/images/news/voucher.jpg') !!}" class="mr-1" width="35">{{ $item->voucher->name }}</td>
                                @else
                                  <td><i class="far fa-times-circle mr-1 text-danger"></i>{{ $item->voucher->name }} </td>
                                @endif
                              @else
                                <td>Null</td>
                              @endif
                              
                              @if ($item->package->status == 1)
                                <td><span class="badge badge-pill badge-success">{{ $item->package->title }} : {{$item->subpackage->deskripsi_title}}</span></td>
                              @else
                                <td><i class="far fa-times-circle mr-1 text-danger"></i>
                                  {{ $item->package->title }} : {{$item->subpackage->deskripsi_title}}</td>
                              @endif
                                
                              <td>
                                @if ($item->alamat_customer)
                                  @if ($item->alamat_customer->address)
                                    <span class="badge badge-warning"><i class="fas fa-map-marker-alt mr-1"></i>{{ $item->alamat_customer->address }}</span>
                                  @else
                                    <span class="badge badge-warning">
                                      <i class="fas fa-map-marker-alt mr-1"></i>Belum Ditentukan</span>
                                  @endif   
                                @else
                                  <span class="badge badge-warning">
                                  <i class="fas fa-map-marker-alt mr-1"></i>Belum Ditentukan</span>
                                @endif
                              </td>

                              <td><span class="badge badge-info">{{ $item->merk ? $item->merk : 'kosong' }}</span></td>
                              @php
                                  $end = \Carbon\Carbon::createFromFormat('Y-m-d',$item->end_date );
                                  $start = \Carbon\Carbon::createFromFormat('Y-m-d',$item->date );
                                  $diff = $end->diffInDays($start);
                                  if ($diff >= 8){
                                    $week = (int)($diff / 7);
                                    $selectedWeek =$week.' week more';
                                  } else {
                                    $selectedWeek = $diff.' day';
                                  }
                              @endphp
                              <td><span class="badge badge-light">{{ $item->qty }}</span></td>
                              <td><span class="badge badge-dark">{{$selectedWeek}}</span></td>
                              <td><span class="badge badge-dark">{{\Carbon\Carbon::create($item->time)->format('H:i')}}</span></td>
                              <td>
                                @if ($item->status == 'pending')
                                <span class="badge badge-pill badge-warning">{{ $item->status }}</span>
                                @elseif($item->status == 'cancel')
                                <span class="badge badge-pill badge-danger">{{ $item->status }}</span>
                                @else
                                <span class="badge badge-pill badge-success">{{ $item->status }}</span>
                                @endif
                              </td>
                              <td width="13%">
                                @if (Auth::user()->roles == 'ADMIN')
                                <a href="{{ route('orders.edit', $item->id)}}" 
                                    class="btn btn-info">
                                    <i class="fa fa-pencil-alt fa-xs"></i>
                                </a>
                                <form action="{{ route('orders.destroy', $item->id) }}"
                                    method="POST" class="d-inline" id="data-{{ $item->id }}">
                                    @csrf
                                    @method('delete')
                                </form>
                                <button class="btn btn-danger" onclick="deleteRow( {{ $item->id }} )" > 
                                <i class="fa fa-trash fa-xs"></i> 
                                </button>
                                @elseif(Auth::user()->roles == 'PARTNER')
                                <a href="{{ route('orders_withId.edit', $item->id)}}" 
                                    class="btn btn-info">
                                    <i class="fa fa-pencil-alt fa-xs"></i>
                                </a>
                                {{-- <form action="{{ route('orders_withId.destroy', $item->id) }}"
                                    method="POST" class="d-inline" id="data-{{ $item->id }}">
                                    @csrf
                                    @method('delete')
                                </form>
                                <button class="btn btn-danger" onclick="deleteRow( {{ $item->id }} )" > 
                                <i class="fa fa-trash fa-xs"></i> 
                                </button> --}}
                                @endif
                                
                              </td>
                          </tr>
                          
                      @empty
                      <td colspan="14" class="text-center">
                          Empty
                      </td>                                
                      @endforelse
                  </tbody>
              </table>
          
                    
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
    <!-- DataTables  & Plugins -->
    {{-- datable --}}
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
          $('#example').DataTable();
      } );
</script>


@endpush