@extends('layouts.admin')
@section('title','History Notification')
@push('prepend-style')
{{-- datatable --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
  
@endpush
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Notification</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item ">Send Notification</li>
            <li class="breadcrumb-item active">History Notification</li>
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
            <div class="card-header d-sm-flex align-items-center justify-content-between ">
              <h1 class="h3 mb-0 text-gray-800">History Notifications</h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="table-responsive">
                  
                <table class="table table-bordered" id="example" width="100%" collspacing="0">
                  <thead>
                    <tr>
                        <th>No</th>
                        
                        <th>Title</th>                          
                        <th>Body</th>
                        <th>Date Create</th>
                        {{-- <th>Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @php
                        $s=1;                                                   
                    @endphp
                    @forelse ($items as $item)                      
                        <tr>
                            <td>{{ $s}}</td>  
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->body }}</td>
                            <td>{{\Carbon\Carbon::parse( $item->created_at)->format('d F y ( H:i )') }}</td>
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
            <div class="card-footer bg-whitesmoke">
              
                
              
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
