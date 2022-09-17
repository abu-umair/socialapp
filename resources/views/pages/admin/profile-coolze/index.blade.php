@extends('layouts.admin')
@section('title','Profile')
@push('prepend-style')
{{-- datatable --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
  <style>
    .activity-user{
      text-transform: lowercase;
    }
    .activity-user:first-letter{
      text-transform: uppercase;
    }

  </style>
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
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                @if ($user->customers_id)
                <img class="profile-user-img img-fluid img-circle"
                     src="{!!$user->foto ? Storage::url($user->foto) : url('backend/assets/images/avatar/customer.png') !!}"
                     >
                @elseif ($user->drivers_id)
                <img class="profile-user-img img-fluid img-circle"
                src="{!!$user->foto ? Storage::url($user->foto) : url('backend/assets/images/avatar/driver.png') !!}"
                >
                @elseif ($user->partners_id)
                <img class="profile-user-img img-fluid img-circle"
                src="{!!$user->foto ? Storage::url($user->foto) : url('backend/assets/images/avatar/mitra.png') !!}"
                >
                @endif
              </div>

              <h3 class="profile-username text-center text-capitalize mb-2 mt-4">
                {{$user->name}}  <span class="text-muted"><small>(
                  @if ($user->customers_id)
                      Customer
                  @elseif ($user->drivers_id)
                      Driver
                  @elseif ($user->partners_id)
                      Mitra
                  @endif
                  )</small>
                </span>
              </h3>

                <ul class="list-group list-group-unbordered mb-3">
                @if ($type_account > 3 && $type_account < 6 )
                <li class="list-group-item">
                  <b>
                    <span class="bg-secondary rounded py-2 px-3 ">
                      <img src="{{url('backend/assets/images/type-user/GOLD_MEMBER.png')}}" style="width: 7%; height: auto;" alt=""> Gold Member
                    </span>
                  </b>
                  <a class="float-right ">
                    <span class=" text-warning align-right">{{ bcdiv($type_account, 1, 1) }} / 5.0
                    </span>
                  </a>
                </li>
                @elseif ($type_account == 3 )
                <li class="list-group-item">
                  <b>
                    <span class="bg-secondary rounded py-2 px-3 ">
                      <img src="{{url('backend/assets/images/type-user/SILVER_MEMBER.png')}}" style="width: 7%; height: auto;" alt=""> Silver Member
                    </span>
                  </b>
                  <a class="float-right ">
                    <span class=" text-warning align-right">{{ bcdiv($type_account, 1, 1) }} / 5.0
                    </span>
                  </a>
                </li>
                @elseif ($type_account < 3 )
                <li class="list-group-item">
                  <b>
                    <span class="bg-secondary rounded py-2 px-3 ">
                      <img src="{{url('backend/assets/images/type-user/PLATINUM_MEMBER.png')}}" style="width: 7%; height: auto;" alt=""> Platinum Member
                    </span>
                  </b>
                  <a class="float-right ">
                    <span class=" text-warning align-right">{{ $type_account == null ? '0.0' : bcdiv($type_account, 1, 1) }} / 5.0
                    </span>
                  </a>
                </li>
                @endif
              
                <li class="list-group-item">
                  <b>Transactions Accept</b> <a class="float-right">{{$order_user->where('status','accept')->count()}}</a>
                </li>
                <li class="list-group-item">
                  <b>Transactions Pending</b> <a class="float-right">{{$order_user->where('status','pending')->count()}}</a>
                </li>
                <li class="list-group-item">
                  <b>Transactions Cancel</b> <a class="float-right">{{$order_user->where('status','cancel')->count()}}</a>
                </li>
              </ul>

              {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- About Me Box -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">About</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              @if ($cust_mitra_driv->no_anggota)
              <strong><i class="fas fa-id-card-alt mr-1"></i> No Anggota</strong>
              <p class="text-muted text-capitalize">{{$cust_mitra_driv->no_anggota}}</p>
              <hr>
              <strong><i class="fas fa-hands-helping mr-1"></i> From Mitra</strong>
              <p class="text-muted text-capitalize">
                {{$all_user->where('partners_id',$cust_mitra_driv->partners_id)->first()->name}}
              </p>
              <hr>
              @endif
              
              <strong><i class="fas fa-address-card mr-1"></i> Name</strong>
              <p class="text-muted text-capitalize">{{$user->name}}</p>
              <hr>
              <strong><i class="fas fa-mobile-alt mr-1"></i> Phone</strong>
              <p class="text-muted text-capitalize">{{$user->phone}}</p>
              <hr>
              @if ($cust_mitra_driv->jumlah_ac)
              <strong><i class="fas fa-calculator mr-1"></i> Qty Ac</strong>
              <p class="text-muted text-capitalize">{{$cust_mitra_driv->jumlah_ac}}</p>
              <hr>
              @endif
              <strong><i class="far fa-map mr-1"></i> Address</strong>
              {{-- @php
                  dd();
              @endphp --}}
              @if ($address_user)
                @if ($user->drivers_id )
                <p class="text-muted text-capitalize">{{$address_user}}</p>
                @elseif ($address_user->count())
                @if ($address_user->where('alamat_utama','on'))
                <p class="text-muted text-capitalize">{{$address_user->where('alamat_utama','on')->first()->address}}</p> 
                @else 
                <p class="text-muted text-capitalize">belum ditentukan</p> 
                @endif
                
                
                @else
                <p class="text-muted text-capitalize">Null</p>     
                @endif    
              @endif
              
              
              <hr>
              @if ($cust_mitra_driv->reveral)
              <strong><i class="fas fa-code-branch mr-1"></i> Reveral</strong>
              <p class="text-muted text-capitalize">{{$cust_mitra_driv->reveral}}</p>
              <hr>
              @endif
              <strong><i class="fab fa-gg-circle mr-1"></i> Role</strong>
              <p class="text-muted text-capitalize">{{$user->roles}}</p>
              @if ($user->status && $user->status == 1)
              <strong><i class="fas fa-user-check mr-1"></i> Status</strong>
              <p class="text-muted text-capitalize">Aktif</p>
              <hr>
              @else
              <strong><i class="fas fa-user-times mr-1"></i> Status</strong>
              <p class="text-muted text-capitalize">Nonaktif</p>
              <hr>
              @endif
              <hr>
              

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Transactions</a></li>
                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Activity</a></li>
                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Rate</a></li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="active tab-pane" id="activity">
                  <!-- Post -->
                  <div class="post">
                    <div class="col-12">
                      <div class="chart-responsive">
                        <canvas id="pieChart2" height="150"></canvas>
                      </div>
                      
                    </div>
                  </div>
                  <!-- /.post -->

                  <!-- Post -->
                  
                  <!-- /.post -->

                  <!-- Post -->
                  
                  <!-- /.post -->
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="timeline">
                  <!-- The timeline -->
                  <div class="timeline timeline-inverse">
                    <!-- timeline time label -->
                    @forelse ($order_user->sortByDesc('created_at') as $user_order)
                    <div class="time-label">
                      <span class="bg-danger">
                        {{\Carbon\Carbon::parse($user_order->created_at)->format('d F y')}}
                      </span>
                    </div>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    @php
                        if ($user_order->status == 'accept') {
                          $icon = '<i class="fas fa-check bg-success"></i>' ;
                          $transaction = 'Transaction Status Accept'; 
                        } elseif ($user_order->status == 'pending') {
                          $icon = '</span><i class="fas fa-exclamation bg-yellow text-white"></i>' ;
                          $transaction = 'Transaction Status Pending';
                        } else {
                          $icon = '<i class="fas fa-times bg-danger"></i>';
                          $transaction = 'Transaction Status Cancel';
                        }
                        

                        $end = \Carbon\Carbon::createFromFormat('Y-m-d',$user_order->end_date );
                        $start = \Carbon\Carbon::createFromFormat('Y-m-d',$user_order->date );
                        $diff = $end->diffInDays($start);
                        if ($diff >= 8){
                          $week = (int)($diff / 7);
                          $selectedWeek =$week.' week more';
                        } else {
                          $selectedWeek = $diff.' day';
                        }
                    @endphp
                    
                    <div>
                      {!!$icon!!}
                      <div class="timeline-item">
                        

                        <h3 class="timeline-header ">
                          <div class="d-flex">
                            <span>{{$transaction}}</span>
                            <span class="ml-auto"><small>Range Pemesanan : {{$selectedWeek}}</small></span>
                            <span class="ml-2 "><i class="mr-1 far fa-clock fa-xs"></i><small>{{\Carbon\Carbon::create($user_order->time)->format('H:i')}}</small></span>
                          </div>
                        </h3>

                        <div class="timeline-body">
                          <p class="activity-user">
                            {{$all_user->where('customers_id',$user_order->customers_id)->first()->name}} memesan {{$packages->where('id',$user_order->packages_id)->first()->title .' : '.$packages->where('id',$user_order->packages_id)->first()->subpackage->first()->deskripsi_title}} kepada {{$all_user->where('partners_id',$user_order->partners_id)->first()->name}} dengan driver {{$all_user->where('drivers_id',$user_order->drivers_id)->first()->name}} untuk memperbaiki {{$user_order->qty}} Ac merk : {{$user_order->merk}} {{$user_order->vouchers_id ?'dan memilih voucher : '.$vouchers->where('id',$user_order->vouchers_id)->first()->name : ''}} 
                          </p>
                          
                        </div>
                        <div class="timeline-footer">
                            @if ($user_order->status == 'accept' && $user_order->acc == 1)
                            <div >
                              @if ($user_order->rate)
                                <small>
                                  @if ($user_order->rate == 1)
                                    <i class="fas fa-star text-warning"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                  @elseif($user_order->rate == 2)
                                    <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                  @elseif($user_order->rate == 3)
                                    <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                  @elseif($user_order->rate == 4)
                                    <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star"></i>
                                  @elseif($user_order->rate == 5)
                                    <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                                  @else 
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                  @endif
                                </small>
                              @else
                                Null 
                              @endif
                            </div>
                            @if ($user_order->ulasan_rate)
                                <div>
                                  <img class="mr-1" style="width: 20px; height: auto;" src="{{ $all_user->where('customers_id',$user_order->customers_id)->first()->foto ? Storage::url($all_user->where('customers_id',$user_order->customers_id)->first()->foto) : url('backend/assets/images/avatar/customer.png') }}" alt="">
                                  <small>{{$user_order->ulasan_rate}}</small>
                                </div>
                            @endif
                                
                          @endif
                        </div>
                      </div>
                    </div>
                    <!-- END timeline item -->    
                    @empty
                    @endforelse
                    

                    
                    
                  </div>
                </div>
                <!-- /.tab-pane -->

                <div class="tab-pane" id="settings">
                  <div class="row bg-secondary rounded">
                    <div class="col mt-2">
                      @if ($type_account > 3 && $type_account < 6 )
                      <h1>
                        <span class=" py-1 px-2 ">
                          <img src="{{url('backend/assets/images/type-user/GOLD_MEMBER.png')}}" style="width: 7%; height: auto;" alt=""> Gold Member
                        </span>    
                        <span class="text-warning">{{ bcdiv($type_account, 1, 1) }} / 5.0</span>
                      </h1>
                      @elseif ($type_account == 3 )
                      <h1>
                        <span class=" py-1 px-2 ">
                          <img src="{{url('backend/assets/images/type-user/SILVER_MEMBER.png')}}" style="width: 7%; height: auto;" alt=""> Silver Member
                        </span>
                        <span class="text-warning">{{ bcdiv($type_account, 1, 1) }} / 5.0</span>
                      </h1>
                      @elseif ($type_account < 3 )
                      <h1>
                        <span class=" py-1 px-2 ">
                          <img src="{{url('backend/assets/images/type-user/PLATINUM_MEMBER.png')}}" style="width: 7%; height: auto;" alt=""> Platinum Member
                        </span>
                        <span class="text-warning">{{ $type_account == null ? '0.0' : bcdiv($type_account, 1, 1) }} / 5.0</span>
                      </h1>
                      @endif
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col border" style="border-color: #6c757d !important; border-radius: .25rem">
                      @forelse ($order_user->where('isreviewed',1)->sortByDesc('created_at') as $user_rate_review)
                      <div class="mt-3">
                        {{-- image --}}
                        <img src="{!! $all_user->where('customers_id',$user_rate_review->customers_id)->first()->foto ? Storage::url($all_user->where('customers_id',$user_rate_review->customers_id)->first()->foto) : url('backend/assets/images/avatar/customer.png')!!}" style="width: 4%; height: auto;" class="img-thumbnail mr-1">
                         {{--name  --}}
                         <h5 class="text-capitalize d-inline">{{ $all_user->where('customers_id',$user_rate_review->customers_id)->first()->name  }}</h5>
                      </div>
                      <div class="mt-1">
                        <small>
                          @if ($user_rate_review->rate == 1)
                            <i class="fas fa-star text-warning"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                          @elseif($user_rate_review->rate == 2)
                            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                          @elseif($user_rate_review->rate == 3)
                            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                          @elseif($user_rate_review->rate == 4)
                            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star"></i>
                          @elseif($user_rate_review->rate == 5)
                            <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                          @else 
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                          @endif
                                  
                          <p class="activity-user">
                            {{ $user_rate_review->ulasan_rate }}
                          </p>
                        </small>
                      </div>
                      @empty
                          
                      @endforelse
                      
                    </div>
                  </div>
                  {{-- <form class="form-horizontal">
                    <div class="form-group row">
                      <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputName" placeholder="Name">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputName2" placeholder="Name">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-danger">Submit</button>
                      </div>
                    </div>
                  </form> --}}
                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
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
<script src="{{url('backend/plugins/chart.js/Chart.min.js')}}"></script>
<script>
  var pieChartCanvas = $('#pieChart2').get(0).getContext('2d');
  var accept = {!! $order_user->where('status','accept')->count() !!};
  var pending = {!! $order_user->where('status','pending')->count() !!};
  var cancel = {!! $order_user->where('status','cancel')->count() !!};
  
  Chart.defaults.global.defaultFontColor = '#FFF';
  var pieChart = new Chart(pieChartCanvas, {
    
    type: 'bar',
    data: {
      labels: ["Accept", "Pending", "Cancel"],
      datasets: [
        {
          label: "Population (millions)",
          backgroundColor: ["#28a745", "#ffc107","#dc3545"],
          data: [accept,pending,cancel]
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Transaction User'
      }
    }
});

  
</script>


@endpush