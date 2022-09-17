@extends('layouts.admin')
@section('title','Wallets')
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
          <h1 class="m-0">Home Wallets</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Wallets</li>
            
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
              <a href="{{ route('wallets.create')}}"
             class="btn btn-sm btn-primary shadow-sm rounded">
             <i class="fas fa-plus fa-sm text-white-50"></i>
             Tambah Wallets
              </a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="table-responsive">
                  
                <table class="table table-bordered" id="example" width="100%" collspacing="0">
                  <thead>
                      <tr>
                        <th><i class="far fa-clipboard mr-1"></i> No</th>
                        <th><i class="fas fa-users mr-1"></i> Users</th>
                        <th><i class="fas fa-retweet mr-1"></i>Type</th>                          
                        <th><i class="fas fa-money-check mr-1"></i>By</th>
                        <th><i class="fas fa-cash-register  mr-1"></i>Total</th>
                        <th><i class="fas fa-coins mr-1"></i>Cool Point</th>
                        <th><i class="far fa-calendar-alt mr-1"></i>Date</th>
                        <th><i class="fas fa-tools mr-1"></i> Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @php
                          $s=1;                                                   
                      @endphp
                      @forelse ($items as $item)                      
                          <tr>
                            <td><span class="badge badge-pill badge-light">{{$s}}</span></td>
                              @if ($item->user)
                              <td>
                                <i class="fas fa-user-tie mr-1"></i>
                                @if ($item->user->status == 1)
                                  <img src="{!!$item->user->foto ? Storage::url($item->user->foto) : url('backend/assets/images/avatar/customer.png') !!}" class="img-circle mr-1" width="35">{{ $item->user->name }}
                                @else
                                  <i class="far fa-times-circle mr-1 text-danger"></i>{{ $item->user->name }} 
                                @endif
                              </td>    
                              @else
                              <td>
                                <i class="fas fa-hands-helping mr-1"></i>
                              @if ($item->user_partner->status == 1)
                                <img src="{!!$item->user_partner->foto ? Storage::url($item->user_partner->foto) : url('backend/assets/images/avatar/mitra.png') !!}" class="img-circle mr-1" width="35">{{ $item->user_partner->name }}
                              @else
                                <i class="far fa-times-circle mr-1 text-danger"></i>{{ $item->user_partner->name }}
                              @endif
                              @endif
                              </td>
                              
                              @if ($item->type == 'in')
                              <td><span class="badge badge-success"><i class="fas fa-arrow-circle-up mr-1"></i>{{ $item->type }}</span></td>    
                              @else
                              <td><span class="badge badge-danger"><i class="fas fa-arrow-circle-down mr-1"></i>{{ $item->type }}</span></td>    
                              @endif
                              
                              <td><i class="fas fa-university text-warning mr-1"></i>{{ $item->by }}</td>
                              <td><span class="badge badge-pill badge-info">{{ $item->total }}</span></td>                              
                              <td><span class="badge badge-light">{{ $item->coolpoin != 0 || $item->coolpoin != null ?  $item->coolpoin : 0}}</span></td>
                              @php
                                  $convert=$item->created_at->toDateTimeString();
                              @endphp
                              <td><span class="badge  badge-warning"><i class="far fa-calendar-minus text-white mr-1 mr-1"></i>{{\Carbon\Carbon::create($item->created_at->toDateTimeString())->format ('d F y')}} <span class="badge badge-pill badge-light ml-1">{{\Carbon\Carbon::create($convert)->format('H:i')}}</span></span></td>
                              
                              <td width="13%">

                                <a href="{{ route('wallets.edit', $item->id)}}" 
                                    class="btn btn-info">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>

                                <form action="{{ route('wallets.destroy', $item->id) }}"
                                    method="POST" class="d-inline" id="data-{{ $item->id }}">
                                    @csrf
                                    @method('delete')
                                </form>
                                <button class="btn btn-danger" onclick="deleteRow( {{ $item->id }} )" > 
                                <i class="fa fa-trash"></i> 
                                </button>
                              </td>
                          </tr>
                          @php
                              $s++; 
                          @endphp
                          
                      @empty
                      <td colspan="7" class="text-center">
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