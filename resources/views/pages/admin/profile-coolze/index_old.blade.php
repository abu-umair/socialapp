@extends('layouts.admin')
@section('title','Profile')
@push('prepend-style')
{{-- datatable --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
  
@endpush
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Home Profile</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Profile</li>
            
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
              <div class="row">
                <div class="col-5">
                  <div class="profile-widget-items">
                    <div class="profile-widget-item">
                      <img alt="image" src="{!!$cust_part->foto ? Storage::url($cust_part->foto) : url('backend/assets/images/avatar/avatar-1.png')!!}" class="img-thumbnail ">
                      @php
                              $nowCust = \Carbon\Carbon::now();
                              $past   = $nowCust->subMonth();
                              $future = $nowCust->addMonth();
                              $created_customer = \Carbon\Carbon::parse($user->created_at);
                              $mydateCust = $created_customer->toDateString();
                              $myTimeCust = $created_customer->toTimeString();
                              $covertDateCust = \Carbon\Carbon::createFromDate($mydateCust);
                              $convertTimeCust = \Carbon\Carbon::createFromTimeString($myTimeCust);
                                
                              $timeCust = $convertTimeCust->diffForHumans();
                              $dateCust = $covertDateCust->diffForHumans();
                                
                              $differenceCust = ($created_customer->diff($nowCust)->days < 1)
                                            ? $timeCust : $dateCust;
                      @endphp
                      <div class="row m-3">
                        <div class="col">
                          <div class="profile-widget-item-label text-muted"><h5>
                            @if ($user->customers_id)
                            Customer
                            @else
                            Partner    
                            @endif</h5></div>
                          <div class="profile-widget-item-label"><h5>Waktu Pendaftaran</h5></div>
                          <div class="profile-widget-item-label"><h5>Email</h5></div>
                          <div class="profile-widget-item-label"><h5>Phone</h5></div>
                          @if ($cust_part->jumlah_ac)
                          <div class="profile-widget-item-label"><h5>Jumlah Ac</h5></div>
                          @endif
                          <div class="profile-widget-item-label"><h5>Status</h5></div>
                          <div class="profile-widget-item-label"><h5>Code Reveral</h5></div>
                        </div>
                        <div class="col">
                          <div class="profile-widget-item-value text-right"><h5>{{$user->name}}</h5></div>
                          <div class="profile-widget-item-value text-right"><h5>{{$differenceCust}}</h5></div>
                          <div class="profile-widget-item-value text-right"><h5>{{$user->email}}</h5></div>
                          <div class="profile-widget-item-value text-right"><h5>{{$user->phone}}</h5></div>
                          @if ($cust_part->jumlah_ac)
                          <div class="profile-widget-item-value text-right"><h5>{{$cust_part->jumlah_ac}}</h5></div>
                          @endif
                          <div class="profile-widget-item-value text-right"><h5>{{$user->status == 0 ? 'Tidak Aktif' : 'Aktif'}}</h5></div>
                          <div class="profile-widget-item-value text-right"><h5>{{$cust_part->reveral}}</h5></div>
                        </div>
                      </div> 
                    </div>
                  </div>
                  {{-- @php   
                       if ($customer->jangka == 0){
                           $itemJangka = 'Minggu';
                       }
                       elseif($customer->jangka == 1){
                         $itemJangka = 'Bulan';
                       }
                         else {
                         $itemJangka = 'Tahun';
                         }
                      @endphp --}}
                </div>
                <div class="col-7">
                  <div class="chart-responsive">
                    <canvas id="pieChart2" height="150"></canvas>
                  </div>
                  <div class="row chart-legend clearfix">
                    {{-- <div class="col"><i class="far fa-circle text-danger"></i> Chrome</div>
                    <div class="col"><i class="far fa-circle text-success"></i> IE</div>
                    <div class="col"><i class="far fa-circle text-warning"></i> FireFox</div> --}}
                    <div class="col d-flex" >
                      <div class="mx-auto">
                        <i class="far fa-circle text-danger"></i> Chrome
                      </div>
                    </div>
                    <div class="col d-flex">
                      <div class="mx-auto">
                        <i class="far fa-circle text-success"></i> IE
                      </div>
                    </div>
                    <div class="col d-flex" >
                      <div class="mx-auto">
                        <i class="far fa-circle text-warning"></i> FireFox
                      </div>
                    </div>
                    <div class="col d-flex" >
                      <div class="mx-auto">
                        <i class="far fa-circle text-info"></i> Safari
                      </div>
                    </div>
                    <div class="col d-flex">
                      <div class="mx-auto">
                        <i class="far fa-circle text-primary"></i> Opera
                      </div>
                    </div>
                    <div class="col d-flex">
                      <div class="mx-auto">
                        <i class="far fa-circle text-secondary"></i> Navigator
                      </div>
                    </div>
                  </div>
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

{{-- chart --}}
<script>
  var pieChartCanvas = $('#pieChart2').get(0).getContext('2d')
  var pieData = {
    labels: [
      'Chrome',
      'IE',
      'FireFox',
      'Safari',
      'Opera',
      'Navigator'
    ],
    datasets: [
      {
        data: [700, 500, 400, 600, 300, 100],
        backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de']
      }
    ]
  }
  var pieOptions = {
    legend: {
      display: false
    }
  }
  // Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  // eslint-disable-next-line no-unused-vars
  var pieChart = new Chart(pieChartCanvas, {
    type: 'doughnut',
    data: pieData,
    options: pieOptions
  })
</script>


@endpush