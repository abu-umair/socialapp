@extends('layouts.admin')
@section('title','Users')
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
          <h1 class="m-0">Home Users</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            
            <li class="breadcrumb-item active">Users</li>
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
              <a href="{{ route('users.create')}}"
             class="btn btn-sm btn-primary shadow-sm rounded">
             <i class="fas fa-plus fa-sm text-white-50"></i>
             Tambah Users
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
                          {{-- <th>Id</th> --}}
                          <th><i class="fas fa-address-card mr-1"></i>Name</th>
                          <th><i class="fas fa-fingerprint mr-1"></i>Type</th>
                          <th><i class="fas fa-at mr-1"></i>Email</th>
                          <th><i class="fab fa-gg-circle mr-1"></i>Role</th>
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
                              
                              {{-- <td><a href="{{route('users-customer.profile',$item->id)}}" style="color: white;" class="font-weight-600">{{ $item->name }}</a></td> --}}
                              
                              
                                @if ($item->customers_id != null)
                                  @if ($item->status == 1)
                                    <td><img src="{!!$item->foto ? Storage::url($item->foto) : url('backend/assets/images/avatar/customer.png') !!}" class="img-circle mr-1" width="35"><span class="text-white">{{ $item->name }}</span></td>
                                  @else
                                    <td><i class="far fa-times-circle mr-1 text-danger"></i><span class="text-white">{{ $item->name }}</span> </td>
                                  @endif
                                  <td><span class="badge badge-danger"><i class="fas fa-user-tie mr-1"></i>Customer</span></td>
                                @elseif($item->partners_id != null)
                                  @if ($item->status == 1)
                                  <td><img src="{!!$item->foto ? Storage::url($item->foto) : url('backend/assets/images/avatar/mitra.png') !!}" class="img-circle mr-1" width="35"><span class="text-white">{{ $item->name }}</span></td>
                                  @else
                                    <td><i class="far fa-times-circle mr-1 text-danger"></i><span class="text-white">{{ $item->name }} </span></td>
                                  @endif
                                  @if ($item->roles == 'ADMIN')
                                  <td><span class="badge badge-info"><i class="fas fa-hands-helping mr-1"></i>Admin</span></td>
                                  @else
                                  <td><span class="badge badge-info"><i class="fas fa-hands-helping mr-1"></i>Mitra</span></td>
                                  @endif
                                  
                                @else
                                  @if ($item->status == 1)
                                    <td><img src="{!!$item->foto ? Storage::url($item->foto) : url('backend/assets/images/avatar/driver.png') !!}" class="img-circle mr-1" width="35"><span class="text-white">{{ $item->name }}</span></td>
                                  @else
                                    <td><i class="far fa-times-circle mr-1 text-danger"></i><span class="text-white">{{ $item->name }} </span></td>
                                  @endif
                                  <td><span class="badge badge-success"><i class="fas fa-motorcycle mr-1"></i>Driver</span></td>
                                @endif
                              
                              <td><span class="badge badge-warning">{{ $item->email }}</span></td>
                              <td><span class="badge badge-pill badge-light">{{ $item->roles == 'PARTNER' ? 'MITRA' : $item->roles }}</span></td>
                              {{-- <td>{{ $item->email_verified_at   }}</td> --}}
                              {{-- <td>{{ $item->password }}</td> --}}
                              
                              <td>
                                {{-- <a href="" 
                                    class="btn btn-success">
                                    <i class="fa fa-eye"></i>
                                </a> --}}

                                <a href="{{ route('users.edit', $item->id)}}" 
                                    class="btn btn-info">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                                
                                

                                <form action="{{ route('users.destroy', $item->id) }}"
                                    method="POST" class="d-inline" id="data-{{ $item->id }}">
                                    @csrf
                                    @method('delete')
                                </form>
                                <button class="btn btn-danger" onclick="deleteRow( {{ $item->id }} )" > 
                                <i class="fa fa-trash"></i> 
                                </button>
                                
                                
                                {{-- <form action="{{ route('services-groomer.restore')}}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('POST')
                                    <button class="btn btn-secondary"> 
                                    <i class="fa fa-trash-restore"></i> 
                                    </button>
                                </form>  --}}
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