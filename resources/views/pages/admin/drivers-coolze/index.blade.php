@extends('layouts.admin')
@section('title','Driver')
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
          <h1 class="m-0">Home Drivers</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Drivers</li>
            
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
              <a href="{{ route('drivers.create')}}"
             class="btn btn-sm btn-primary shadow-sm rounded">
             <i class="fas fa-plus fa-sm text-white-50"></i>
             Tambah Driver
              </a>
            </div>
            @endif
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="table-responsive">
                  
                <table class="table table-bordered" id="example" width="100%" collspacing="0">
                  <thead>
                      <tr>
                        <th><i class="far fa-clipboard d-block"></i> No</th>
                        <th><i class="fas fa-hands-helping d-block"></i> Mitra</th>
                        <th><i class="fas fa-motorcycle d-block"></i> Driver</th>
                        <th><i class="fas fa-folder-open d-block"></i> Document</th>  
                        <th><i class="fas fa-id-card-alt d-block"></i>Id</th>
                        <th><i class="fas fa-dollar-sign d-block"></i>Tarif</th>
                        <th><i class="fas fa-map-marker-alt d-block"></i>Longitude</th>
                        <th><i class="fas fa-map-marker d-block"></i>Latitude</th>
                        <th><i class="far fa-map d-block"></i>Alamat</th>
                        <th><i class="fas fa-cash-register d-block"></i>Jumlah transaksi</th>
                        <th><i class="fas fa-calculator d-block"></i>Total transaksi</th>
                        <th><i class="fas fa-tools d-block"></i> Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @php
                          $s=1;                                                   
                      @endphp
                      @forelse ($items as $item)
                          <tr>
                              <td><span class="badge badge-pill badge-light">{{$s}}</span></td>
                              <td>
                              @if (Auth::user()->roles == 'ADMIN')
                                  <a href="{{route('user-profile-coolze',$item->partners_id)}}" class="text-white">
                              @elseif(Auth::user()->roles == 'PARTNER')
                                  <a href="{{route('user-profile-coolze_withId',$item->partners_id)}}" class="text-white">
                              @endif
                              @if ($item->partner_lengkap->status == 1)
                              <img src="{!!$item->partner_lengkap->foto ? Storage::url($item->partner_lengkap->foto) : url('backend/assets/images/avatar/mitra.png') !!}" class="img-circle mr-1" width="35">{{ $item->partner_lengkap->name }}
                              @else
                              <i class="far fa-times-circle mr-1 text-danger"></i>{{ $item->partner_lengkap->name }}  
                              @endif
                              </a>
                              </td>
                              
                              <td>
                                @if (Auth::user()->roles == 'ADMIN')
                                    <a href="{{route('user-profile-coolze',$item->driver_lengkap->first()->id)}}" class="text-white">
                                @elseif(Auth::user()->roles == 'PARTNER')
                                    <a href="{{route('user-profile-coolze_withId',$item->driver_lengkap->first()->id)}}" class="text-white">
                                @endif
                              @if ($item->driver_lengkap[0]->status == 1)
                                <img src="{!!$item->driver_lengkap[0]->foto ? Storage::url($item->driver_lengkap[0]->foto) : url('backend/assets/images/avatar/driver.png') !!}" class="img-circle mr-1" width="35">{{ $item->driver_lengkap[0]->name }}
                              @else
                                <i class="far fa-times-circle mr-1 text-danger"></i>{{ $item->driver_lengkap[0]->name }}
                              @endif
                                </a>
                              </td>
                              <td>
                                @if ($item->file)
                                <a class="text-white" href="{{ route('download', $item->file_name) }}"><i class="fas fa-file-download"></i> File</a>
                                @else
                                <p> - </p>
                                @endif
                              </td>
                              <td><i class="fas fa-fingerprint text-warning mr-1"></i>{{ $item->no_anggota }}</td>
                              <td><i class="fas fa-money-bill-wave text-info mr-1"></i>{{ $item->tarif }}</td>
                              <td><i class="far fa-map text-danger mr-1"></i>{{ $item->long }}</td>
                              <td><i class="fas fa-map text-warning mr-1"></i>{{ $item->lat}}</td>
                              <td><span class="badge badge-pill badge-secondary"><i class="fas fa-search-location text-danger"></i>{{ $item->alamat}}</span></td>
                              @php
                              if ($item->order->first()) {
                                $item_transaksi = $item->order->where('status','accept');
                                // $jumlah_transaksi = $item_transaksi->sum('qty');
                                $jumlah_transaksi = $item_transaksi->count();
                                
                                $total_transaksi = $jumlah_transaksi * $item->tarif;
                              }else {
                                $jumlah_transaksi= '0';
                                $total_transaksi= '0';
                              }
                                
                              
                              
                              
                              // $jumlah_transaksi = '-';
                              // $total_transaksi = '-';

                              // if ($acc == 1) {
                              //   $jumlah_transaksi = $item->order->count('drivers_id');
                              //   $total_transaksi =$jumlah_transaksi * $item->tarif;
                              // }
                              @endphp
                              
                              <td>
                                
                                  @if (Auth::user()->roles == 'PARTNER')
                                  <a href="{{route('transactions-driver_withPartner',$item->id)}}" class="font-weight-600">
                                  <span class="text-white border-bottom">{{$item->order->where('partners_id', Auth::user()->partners_id)->count()}} Transaction</span>    
                                  @elseif(Auth::user()->roles == 'ADMIN')
                                  <a href="{{route('transactions-driver',$item->id)}}" class="font-weight-600">
                                  <span class="text-white border-bottom">{{$item->order->count()}} Transaction</span>
                                  @endif
                                  
                                  </a>
                              </td>
                              
                              <td><span class="badge badge-success"><i class="fas fa-funnel-dollar mr-1"></i>{{$total_transaksi}}</span></td>
                              {{-- <td>{{ $key->count('drivers_id') ? 'a':'b'}}</td> --}}
                              
                              {{-- <td>{{ $item->order->first()->acc == 1 ? $jumlah_transaksi * $item->tarif : '-'}}</td> --}}
                              <td width="13%">
                                @if (Auth::user()->roles == 'ADMIN')
                                <a href="{{ route('drivers.edit', $item->id)}}" 
                                    class="btn btn-info">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>

                                <form action="{{ route('drivers.destroy', $item->id) }}"
                                    method="POST" class="d-inline" id="data-{{ $item->id }}">
                                    @csrf
                                    @method('delete')
                                </form>
                                <button class="btn btn-danger" onclick="deleteRow( {{ $item->id }} )" > 
                                <i class="fa fa-trash"></i> 
                                </button>
                                @elseif (Auth::user()->roles == 'PARTNER')
                                <form action="{{ route('drivers_withId.destroy', $item->id) }}"
                                    method="POST" class="d-inline" id="data-{{ $item->id }}">
                                    @csrf
                                    @method('delete')
                                </form>
                                <button class="btn btn-danger" onclick="deleteRow( {{ $item->id }} )" > 
                                <i class="fa fa-trash"></i> 
                                </button>
                                @endif
                              </td>
                          </tr>
                          @php
                              $s++; 
                          @endphp
                         
                      @empty
                      <td colspan="11" class="text-center">
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