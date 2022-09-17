@php
    function rupiah($angka){
	
      $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
      return $hasil_rupiah;

    }
@endphp
@extends('layouts.admin')
@section('title','Home - Dashboard')
@section('content')
@if (Auth::user()->roles == 'ADMIN')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Home</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Home</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-2">
          <div class="info-box">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-tie"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Customers</span>
              <span class="info-box-number">
                {{ $cust_users = $item_users->where('customers_id','!=',null)->count() }}
                <small>Member</small>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-2">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hands-helping"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Partners</span>
              <span class="info-box-number">
                {{ $part_users = $item_users->where('partners_id','!=',null)->count() }}
                <small>Member</small>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-2">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-motorcycle"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Drivers</span>
              <span class="info-box-number">
                {{ $driv_users = $item_users->where('drivers_id','!=',null)->count() }}
              <small>Member</small>
            </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-2">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total</span>
              <span class="info-box-number">
                {{ $total_user = $item_users->count() }}
                <small>Member</small>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

          <div class="col-4 ">
            {{-- <p class="text-center">
              <strong>Goal Completion</strong>
            </p> --}}
            <div class="bg-dark px-2 rounded" style="padding-top: 8px;padding-bottom: 1.3px;">
            <div class="progress-group bg-dark">
              {{-- Customers --}}
              {{-- <span class="float-right"><b><small> 160/200</small></b></span> --}}
              <div class="progress progress-sm bg-dark">
                <div class="progress-bar bg-primary" style="width: {{ $cust_users/$total_user*100 }}%"></div>
              </div>
            </div>
            <!-- /.progress-group -->

            <div class="progress-group bg-dark">
              {{-- Partners --}}
              {{-- <span class="float-right"><b><small> 310/400</small></b></span> --}}
              <div class="progress progress-sm bg-dark">
                <div class="progress-bar bg-danger" style="width: {{ $part_users/$total_user*100 }}%"></div>
              </div>
            </div>

            <!-- /.progress-group -->
            <div class="progress-group bg-dark">
              {{-- <span class="progress-text">Drivers</span> --}}
              {{-- <span class="float-right"><b><small> 480/800</small></b></span> --}}
              <div class="progress progress-sm bg-dark">
                <div class="progress-bar bg-success" style="width: {{ $driv_users/$total_user*100 }}%"></div>
              </div>
            </div>

            <!-- /.progress-group -->
            <div class="progress-group bg-dark">
              {{-- Total Member --}}
              {{-- <span class="float-right"><b><small> 250/500</small></b></span> --}}
              <div class="progress progress-sm bg-dark">
                <div class="progress-bar bg-warning" style="width: {{ $total_user/$total_user*100 }}%"></div>
              </div>
            </div>
            <!-- /.progress-group -->
          <!-- /.info-box -->
            </div>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        
        <!-- /.col -->
      </div>
      
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Monthly Recap Report</h5>
              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <p class="text-center">
                    <strong>Orders: 01 January {{\Carbon\Carbon::create(\Carbon\Carbon::now()->toDateTimeString())->format ('y')}}
                      - {{\Carbon\Carbon::create(\Carbon\Carbon::now()->toDateTimeString())->format ('d F y')}}</strong>
                    {{-- <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong> --}}
                  </p>

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="orderChart" height="180" style="height: 180px;"></canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                {{-- <div class="col-md-4">
                  <p class="text-center">
                    <strong>Goal Completion</strong>
                  </p>

                  <div class="progress-group">
                    Add Products to Cart
                    <span class="float-right"><b>160</b>/200</span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-primary" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->

                  <div class="progress-group">
                    Complete Purchase
                    <span class="float-right"><b>310</b>/400</span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-danger" style="width: 75%"></div>
                    </div>
                  </div>

                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Visit Premium Page</span>
                    <span class="float-right"><b>480</b>/800</span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-success" style="width: 60%"></div>
                    </div>
                  </div>

                  <!-- /.progress-group -->
                  <div class="progress-group">
                    Send Inquiries
                    <span class="float-right"><b>250</b>/500</span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-warning" style="width: 50%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                </div> --}}
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./card-body -->
            @php
                $convert_accept_only = $orders_accept_only->count() == null || $orders_accept_only->count() == 0  ? 1 : $orders_accept_only->count();
                $convert_Pending_only = $orders_Pending_only->count() == null || $orders_Pending_only->count() == 0 ? 1 : $orders_Pending_only->count();
                $convert_Cancel_only = $orders_Cancel_only->count() == null || $orders_Cancel_only->count() == 0 ? 1 : $orders_Cancel_only->count();
                $convert_all_status = $orders_all_status->count() == null || $orders_all_status->count() == 0 ? 1 : $orders_all_status->count();
                
            @endphp
            <div class="card-footer">
              <div class="row">
                <div class="col-4">
                  <div class="description-block border-right">
                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> {{ bcdiv($convert_accept_only / $convert_all_status * 100, 1, 2) }}%</span>
                    <h5 class="description-header">{{ $orders_accept_only->count() }}</h5>
                    <span class="description-text">Transactions Accept</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <div class="description-block border-right">
                    <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> {{ bcdiv($convert_Pending_only / $convert_all_status * 100, 1, 2) }}%</span>
                    <h5 class="description-header">{{ $orders_Pending_only->count() }}</h5>
                    <span class="description-text">Transactions Pending</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <div class="description-block">
                    <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> {{ bcdiv($convert_Cancel_only / $convert_all_status * 100, 1, 2) }}</span>
                    <h5 class="description-header">{{ $orders_Cancel_only->count() }}</h5>
                    <span class="description-text">Transactions Cancel  </span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          <!-- MAP & BOX PANE -->
          
          <!-- /.card -->
          <div class="row">
            
            <!-- /.col -->

            <div class="col">
              <!-- USERS LIST -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Vouchers</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <ul class="users-list clearfix">
                    @forelse ($item_vouchers as $item_voucher)
                    <li>
                      <img src="{!!$item_voucher->foto ? Storage::url($item_voucher->foto) : url('backend/assets/images/news/img05.jpg') !!}" class="box-img mr-1 border-bottom rounded-sm img-thumbnail" width="200">
                      <a class="users-list-name text-white text-capitalize">{{ $item_voucher->name }}
                      <span class="users-list-date">{{ rupiah($item_voucher->price) }}</span>
                    </a>
                    </li>
                    @empty
                        
                    @endforelse
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-center">
                  <a href="{{ route('vouchers.index')}}">View All Vouchers</a>
                </div>
                <!-- /.card-footer -->
              </div>
              <!--/.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Latest Orders</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Mitra</th>
                    <th>Driver</th>
                    <th>Packages</th>
                    <th>Voucher</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    @forelse ($item_lastedOrders as $item_lastedOrder)
                    <td><a href="{{route('invoice_withPartner',$item_lastedOrder->id)}}" class="text-white">{{ $item_lastedOrder->id_unique }}</a></td>
                    @if ($item_lastedOrder->user_customer->status == 1)
                    <td><a href="pages/examples/invoice.html">{{ Str::ucfirst($item_lastedOrder->user_customer->name) }}</a></td>
                    @else
                    <td><a href="pages/examples/invoice.html" class="text-danger">{{ Str::ucfirst($item_lastedOrder->user_customer->name) }}</a></td>
                    @endif

                    @if ($item_lastedOrder->user_partner->status == 1)
                    <td><a href="pages/examples/invoice.html" class="text-white">{{ Str::ucfirst($item_lastedOrder->user_partner->name) }}</a></td>
                    @else
                    <td><a href="pages/examples/invoice.html" class="text-danger">{{ Str::ucfirst($item_lastedOrder->user_partner->name) }}</a></td>
                    @endif

                    

                    @if ($item_lastedOrder->driver->status == 1)
                    <td><a href="pages/examples/invoice.html" class="text-white">{{ Str::ucfirst($item_lastedOrder->driver->name) }}</a></td>
                    @else
                    <td><a href="pages/examples/invoice.html" class="text-danger">{{ Str::ucfirst($item_lastedOrder->driver->name) }}</a></td>
                    @endif

                    @if ($item_lastedOrder->package->status == 1)
                    <td><span class="text-white">{{ Str::ucfirst($item_lastedOrder->package->title) }} : {{ Str::ucfirst($item_lastedOrder->subpackage->deskripsi_title)}}</span></td>
                    @else
                    <td><span class="text-danger">{{ Str::ucfirst($item_lastedOrder->package->title) }} : {{ Str::ucfirst($item_lastedOrder->subpackage->deskripsi_title) }}</span></td>
                    @endif

                    @if ($item_lastedOrder->voucher)
                        @if ($item_lastedOrder->voucher->status == 1)
                        <td><img src="{!!$item_lastedOrder->voucher->foto ? Storage::url($item_lastedOrder->voucher->foto) : url('backend/assets/images/news/voucher.jpg') !!}" class="mr-1" width="35"><span class="text-white">{{ Str::ucfirst($item_lastedOrder->voucher->name) }}</span></td>
                        @else
                        <td><img src="{!!$item_lastedOrder->voucher->foto ? Storage::url($item_lastedOrder->voucher->foto) : url('backend/assets/images/news/voucher.jpg') !!}" class="mr-1" width="35"><span class="text-danger">{{ Str::ucfirst($item_lastedOrder->voucher->name) }}</span></td>
                        @endif
                    @else
                      <td>Null</td>
                    @endif

                    
                    <td>
                      @if ($item_lastedOrder->status == 'pending')
                      <span class="badge badge-warning">{{ Str::ucfirst($item_lastedOrder->status) }}</span>
                      @elseif($item_lastedOrder->status == 'cancel')
                      <span class="badge badge-danger">{{ Str::ucfirst($item_lastedOrder->status) }}</span>
                      @else
                      <span class="badge badge-success">{{ Str::ucfirst($item_lastedOrder->status) }}</span>
                      @endif
                    </td>
                  </tr>
                    @empty
                        
                    @endforelse
                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              {{-- <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a> --}}
              <a href="{{ route('orders.index') }}" class="btn btn-sm btn-secondary float-right">View All Orders</a>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Packages</h3>
            </div>
          <!-- Info Boxes Style 2 -->
            @forelse ($item_packages as $item_package)
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="fas fa-cube"></i></span>

              <div class="info-box-content">
                <span class="info-box-text text-uppercase">{{ $item_package->title }} : {{ $item_package->subpackage[0]->deskripsi_title }}</span>
                <div class="row">
                  <div class="col"><span class="info-box-number">{{ rupiah($item_package->subpackage[0]->price_dasar) }}</span></div>
                  @if ($item_package->subpackage[0]->price_diskon)
                    <div class="col"><span class="info-box-number"><small>Diskon : {{ rupiah($item_package->subpackage[0]->price_diskon) }}</small></span></div>
                  @endif
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
            @empty

            @endforelse
            <div class="card-footer text-center mt-n3">
              <a href="{{ route('packages.index')}}">View All Packages</a>
            </div>
          </div>

          {{-- <div class="card">
            <div class="card-header">
              <h3 class="card-title">Browser Usage</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-8">
                  <div class="chart-responsive">
                    <canvas id="pieChart" height="150"></canvas>
                  </div>
                  <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <ul class="chart-legend clearfix">
                    <li><i class="far fa-circle text-danger"></i> Chrome</li>
                    <li><i class="far fa-circle text-success"></i> IE</li>
                    <li><i class="far fa-circle text-warning"></i> FireFox</li>
                    <li><i class="far fa-circle text-info"></i> Safari</li>
                    <li><i class="far fa-circle text-primary"></i> Opera</li>
                    <li><i class="far fa-circle text-secondary"></i> Navigator</li>
                  </ul>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer bg-light p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    United States of America
                    <span class="float-right text-danger">
                      <i class="fas fa-arrow-down text-sm"></i>
                      12%</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    India
                    <span class="float-right text-success">
                      <i class="fas fa-arrow-up text-sm"></i> 4%
                    </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    China
                    <span class="float-right text-warning">
                      <i class="fas fa-arrow-left text-sm"></i> 0%
                    </span>
                  </a>
                </li>
              </ul>
            </div>
            <!-- /.footer -->
          </div> --}}
          <!-- /.card -->

          <!-- PRODUCT LIST -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Contents</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                @forelse ($item_contents as $item_content)
                <li class="item">
                  <div class="product-img">
                    <img src="{!!$item_content->url ? Storage::url($item_content->url) : url('backend/assets/images/news/img05.jpg') !!}" alt="Product Image" class="img-size-50">
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title">{{ $item_content->title }}
                      {{-- <span class="badge badge-warning float-right">$1800</span> --}}
                    </a>
                    <span class="product-description">
                      {{ $item_content->isi }}
                    </span>
                  </div>
                </li>    
                @empty
                    
                @endforelse
                
              </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center mt-2">
              <a href="{{ route('content.index') }}" class="uppercase">View All Contents</a>
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

@elseif(Auth::user()->roles == 'PARTNER')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Home</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Home</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      
      <!-- /.row -->

      <div class="row">
        
        <!-- /.col -->
      </div>
      
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Monthly Recap Report</h5>
              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <p class="text-center">
                    <strong>Orders: 01 January {{\Carbon\Carbon::create(\Carbon\Carbon::now()->toDateTimeString())->format ('y')}}
                      - {{\Carbon\Carbon::create(\Carbon\Carbon::now()->toDateTimeString())->format ('d F y')}}</strong>
                    {{-- <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong> --}}
                  </p>

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="orderChart" height="180" style="height: 180px;"></canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                {{-- <div class="col-md-4">
                  <p class="text-center">
                    <strong>Goal Completion</strong>
                  </p>

                  <div class="progress-group">
                    Add Products to Cart
                    <span class="float-right"><b>160</b>/200</span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-primary" style="width: 80%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->

                  <div class="progress-group">
                    Complete Purchase
                    <span class="float-right"><b>310</b>/400</span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-danger" style="width: 75%"></div>
                    </div>
                  </div>

                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Visit Premium Page</span>
                    <span class="float-right"><b>480</b>/800</span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-success" style="width: 60%"></div>
                    </div>
                  </div>

                  <!-- /.progress-group -->
                  <div class="progress-group">
                    Send Inquiries
                    <span class="float-right"><b>250</b>/500</span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-warning" style="width: 50%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                </div> --}}
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./card-body -->
            @php
                $convert_accept_only = $orders_accept_only->count() == null || $orders_accept_only->count() == 0  ? 1 : $orders_accept_only->count();
                $convert_Pending_only = $orders_Pending_only->count() == null || $orders_Pending_only->count() == 0 ? 1 : $orders_Pending_only->count();
                $convert_all_status = $orders_all_status->count() == null || $orders_all_status->count() == 0 ? 1 : $orders_all_status->count();
                $convert_Cancel_only = $orders_Cancel_only->count() == null || $orders_Cancel_only->count() == 0 ? 1 : $orders_Cancel_only->count();
                
            @endphp
            <div class="card-footer">
              <div class="row">
                <div class="col-4">
                  <div class="description-block border-right">
                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> {{ bcdiv($convert_accept_only / $convert_all_status * 100, 1, 2) }}%</span>
                    <h5 class="description-header">{{ $orders_accept_only->count() }}</h5>
                    <span class="description-text">Transactions Accept</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <div class="description-block border-right">
                    <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> {{ bcdiv($convert_Pending_only / $convert_all_status * 100, 1, 2) }}%</span>
                    <h5 class="description-header">{{ $orders_Pending_only->count() }}</h5>
                    <span class="description-text">Transactions Pending</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <div class="description-block">
                    <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> {{ bcdiv($convert_Cancel_only / $convert_all_status * 100, 1, 2) }}</span>
                    <h5 class="description-header">{{ $orders_Cancel_only->count() }}</h5>
                    <span class="description-text">Transactions Cancel  </span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          <!-- MAP & BOX PANE -->
          
          <!-- /.card -->
          <div class="row">
            
            <!-- /.col -->

            <div class="col">
              <!-- USERS LIST -->
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Vouchers</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <ul class="users-list clearfix">
                    @forelse ($item_vouchers as $item_voucher)
                    <li>
                      <img src="{!!$item_voucher->foto ? Storage::url($item_voucher->foto) : url('backend/assets/images/news/img05.jpg') !!}" class="box-img mr-1 border-bottom rounded-sm img-thumbnail" width="200">
                      <a class="users-list-name text-white text-capitalize">{{ $item_voucher->name }}
                      <span class="users-list-date">{{ rupiah($item_voucher->price) }}</span>
                    </a>
                    </li>
                    @empty
                        
                    @endforelse
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.card-body -->
                {{-- <div class="card-footer text-center">
                  <a href="{{ route('vouchers.index')}}">View All Vouchers</a>
                </div> --}}
                <!-- /.card-footer -->
              </div>
              <!--/.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Latest Orders</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Mitra</th>
                    <th>Driver</th>
                    <th>Packages</th>
                    <th>Voucher</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    @forelse ($item_lastedOrders as $item_lastedOrder)
                    <td><a href="{{route('invoice_withPartner',$item_lastedOrder->id)}}" class="text-white">{{ $item_lastedOrder->id_unique }}</a></td>
                    @if ($item_lastedOrder->user_customer->status == 1)
                    <td><a href="{{route('invoice_withPartner',$item_lastedOrder->id)}}" class="text-white">{{ Str::ucfirst($item_lastedOrder->user_customer->name) }}</a></td>
                    @else
                    <td><a href="{{route('invoice_withPartner',$item_lastedOrder->id)}}" class="text-danger">{{ Str::ucfirst($item_lastedOrder->user_customer->name) }}</a></td>
                    @endif

                    @if ($item_lastedOrder->user_partner->status == 1)
                    <td><a href="{{route('invoice_withPartner',$item_lastedOrder->id)}}" class="text-white">{{ Str::ucfirst($item_lastedOrder->user_partner->name) }}</a></td>
                    @else
                    <td><a href="{{route('invoice_withPartner',$item_lastedOrder->id)}}" class="text-danger">{{ Str::ucfirst($item_lastedOrder->user_partner->name) }}</a></td>
                    @endif

                    

                    @if ($item_lastedOrder->driver->status == 1)
                    <td><a href="{{route('invoice_withPartner',$item_lastedOrder->id)}}" class="text-white">{{ Str::ucfirst($item_lastedOrder->driver->name) }}</a></td>
                    @else
                    <td><a href="{{route('invoice_withPartner',$item_lastedOrder->id)}}" class="text-danger">{{ Str::ucfirst($item_lastedOrder->driver->name) }}</a></td>
                    @endif

                    @if ($item_lastedOrder->package->status == 1)
                    <td><a href="{{route('invoice_withPartner',$item_lastedOrder->id)}}" class="text-white">{{ Str::ucfirst($item_lastedOrder->package->title) }} : {{ Str::ucfirst($item_lastedOrder->subpackage->deskripsi_title)}}</a></td>
                    @else
                    <td><a href="{{route('invoice_withPartner',$item_lastedOrder->id)}}" class="text-danger">{{ Str::ucfirst($item_lastedOrder->package->title) }} : {{ Str::ucfirst($item_lastedOrder->subpackage->deskripsi_title) }}</a></td>
                    @endif

                    
                    @if ($item_lastedOrder->voucher)
                        @if ($item_lastedOrder->voucher->status == 1)
                        <td><a href="{{route('invoice_withPartner',$item_lastedOrder->id)}}" class="text-white"><img src="{!!$item_lastedOrder->voucher->foto ? Storage::url($item_lastedOrder->voucher->foto) : url('backend/assets/images/news/voucher.jpg') !!}" class="mr-1" width="35"><span class="text-white">{{ Str::ucfirst($item_lastedOrder->voucher->name) }}</span></a></td>
                        @else
                        <td><a href="{{route('invoice_withPartner',$item_lastedOrder->id)}}" class="text-white"><img src="{!!$item_lastedOrder->voucher->foto ? Storage::url($item_lastedOrder->voucher->foto) : url('backend/assets/images/news/voucher.jpg') !!}" class="mr-1" width="35"><span class="text-white">{{ Str::ucfirst($item_lastedOrder->voucher->name) }}</span></a></td>
                        @endif
                    @else
                      <td><a href="{{route('invoice_withPartner',$item_lastedOrder->id)}}" class="text-white">Null</a></td>
                    @endif

                    
                    <td>
                      <a href="{{route('invoice_withPartner',$item_lastedOrder->id)}}" class="text-white">
                      @if ($item_lastedOrder->status == 'pending')
                      <span class="badge badge-warning">{{ Str::ucfirst($item_lastedOrder->status) }}</span>
                      @elseif($item_lastedOrder->status == 'cancel')
                      <span class="badge badge-danger">{{ Str::ucfirst($item_lastedOrder->status) }}</span>
                      @else
                      <span class="badge badge-success">{{ Str::ucfirst($item_lastedOrder->status) }}</span>
                      @endif
                      </a>
                    </td>
                  </tr>
                    @empty
                        
                    @endforelse
                  
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              {{-- <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a> --}}
              <a href="{{ route('orders_withId.index') }}" class="btn btn-sm btn-secondary float-right">View All Orders</a>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Packages</h3>
            </div>
          <!-- Info Boxes Style 2 -->
            @forelse ($item_packages as $item_package)
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="fas fa-cube"></i></span>

              <div class="info-box-content">
                <span class="info-box-text text-uppercase">{{ $item_package->title }} : {{ $item_package->subpackage[0]->deskripsi_title }}</span>
                <div class="row">
                  <div class="col"><span class="info-box-number">{{ rupiah($item_package->subpackage[0]->price_dasar) }}</span></div>
                  @if ($item_package->subpackage[0]->price_diskon)
                    <div class="col"><span class="info-box-number"><small>Diskon : {{ rupiah($item_package->subpackage[0]->price_diskon) }}</small></span></div>
                  @endif
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
            @empty

            @endforelse
            {{-- <div class="card-footer text-center mt-n3">
              <a href="{{ route('packages.index')}}">View All Packages</a>
            </div> --}}
          </div>

          {{-- <div class="card">
            <div class="card-header">
              <h3 class="card-title">Browser Usage</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-8">
                  <div class="chart-responsive">
                    <canvas id="pieChart" height="150"></canvas>
                  </div>
                  <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <ul class="chart-legend clearfix">
                    <li><i class="far fa-circle text-danger"></i> Chrome</li>
                    <li><i class="far fa-circle text-success"></i> IE</li>
                    <li><i class="far fa-circle text-warning"></i> FireFox</li>
                    <li><i class="far fa-circle text-info"></i> Safari</li>
                    <li><i class="far fa-circle text-primary"></i> Opera</li>
                    <li><i class="far fa-circle text-secondary"></i> Navigator</li>
                  </ul>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer bg-light p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    United States of America
                    <span class="float-right text-danger">
                      <i class="fas fa-arrow-down text-sm"></i>
                      12%</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    India
                    <span class="float-right text-success">
                      <i class="fas fa-arrow-up text-sm"></i> 4%
                    </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    China
                    <span class="float-right text-warning">
                      <i class="fas fa-arrow-left text-sm"></i> 0%
                    </span>
                  </a>
                </li>
              </ul>
            </div>
            <!-- /.footer -->
          </div> --}}
          <!-- /.card -->

          
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>
  @endif
@endsection
@push('addon-script')
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('backend/dist/js/pages/dashboard2.js')}}"></script>

<!-- ChartJS -->
<script src="{{url('backend/plugins/chart.js/Chart.min.js')}}"></script>
<script>
  var salesChartCanvas = $('#orderChart').get(0).getContext('2d')
  
  // mendapatkan bulan
  var today = new Date();
  var monthNow = new Array();
  monthNow[0] = ['January'];
  monthNow[1] = ['January', 'February'];
  monthNow[2] = ['January', 'February', 'March'];
  monthNow[3] = ['January', 'February', 'March', 'April'];
  monthNow[4] = ['January', 'February', 'March', 'April', 'May'];
  monthNow[5] = ['January', 'February', 'March', 'April', 'May', 'June'];
  monthNow[6] = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
  monthNow[7] = ['January', 'February', 'March', 'April', 'May', 'June', 'July','August'];
  monthNow[8] = ['January', 'February', 'March', 'April', 'May', 'June', 'July','August','September'];
  monthNow[9] = ['January', 'February', 'March', 'April', 'May', 'June', 'July','August','September','October'];
  monthNow[10] = ['January', 'February', 'March', 'April', 'May', 'June', 'July','August','September','October','November'];
  monthNow[11] = ['January', 'February', 'March', 'April', 'May', 'June', 'July','August','September','October','November','December'];

  var monthNowNumber = monthNow[today.getMonth()];

  // document.write("The current month is " + monthNowNumber);
  

var salesChartData = {
  labels: monthNowNumber ,
  datasets: [
    {
      label: 'Transactions Success',
      backgroundColor: 'rgba(75, 148, 191)', //biru
      borderColor: 'rgba(68, 135, 174 )',
      pointRadius: false,
      pointColor: 'rgba(68, 135, 174)',
      pointStrokeColor: '#c1c7d1',
      pointHighlightFill: '#fff',
      pointHighlightStroke: 'rgba(220,220,220,1)',
      data: [{!! $implodeOrderAccept !!}]
    },
    {
      label: 'Transactions Pending',
      backgroundColor: 'rgba(255, 166, 43)', //kuning
      borderColor: 'rgba(255, 174, 62)',
      pointRadius: false,
      pointColor: 'rgba(255, 174, 62)',
      pointStrokeColor: 'rgba(60,141,188,1)',
      pointHighlightFill: '#fff',
      pointHighlightStroke: 'rgba(60,141,188,1)',
      data: [{!! $implodeOrderPending !!}]
    },
    {
      label: 'Transactions Cancel',
      backgroundColor: 'rgba(222, 110, 75)', //merah
      borderColor: 'rgba(158, 50, 69)',
      pointRadius: false,
      pointColor: 'rgba(158, 50, 69)',
      pointStrokeColor: '#c1c7d1',
      pointHighlightFill: '#fff',
      pointHighlightStroke: 'rgba(220,220,220,1)',
      data: [{!! $implodeOrderCancel !!}]
    }
    
  ]
}

var salesChartOptions = {
  maintainAspectRatio: false,
  responsive: true,
  legend: {
    display: false
  },
  scales: {
    xAxes: [{
      gridLines: {
        display: false
      }
    }],
    yAxes: [{
      gridLines: {
        display: false
      }
    }]
  }
}

// This will get the first returned node in the jQuery collection.
// eslint-disable-next-line no-unused-vars
var salesChart = new Chart(salesChartCanvas, {
  type: 'line',
  data: salesChartData,
  options: salesChartOptions
}
)
</script>

@endpush