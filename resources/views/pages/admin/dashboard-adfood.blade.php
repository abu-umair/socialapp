@extends('layouts.admin')
@section('title','Home - Dashboard')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="row">
      <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card card-statistic-2">
          <div class="card-stats">
            <div class="card-stats-title text-primary">&nbsp;
            </div>
            <div class="card-stats-items">
              <div class="card-stats-item">
                <div class="card-stats-item-count"><i class="fa-solid fa-user-tie fa-sm"></i> {{ $item_users->where('merchants_id','!=',null)->count() }}</div>
                <div class="card-stats-item-label">Merchants</div>
              </div>
              <div class="card-stats-item ">
                <div class="card-stats-item-count"><i class="fa-solid fa-users fa-sm"></i> {{ $item_users->where('customers_id','!=',null)->count() }}</div>
                <div class="card-stats-item-label">Customers</div>
              </div>
              <div class="card-stats-item ">
                <div class="card-stats-item-count"><i class="fa-solid fa-users-line fa-sm"></i> {{ $item_users->count() }}</div>
                <div class="card-stats-item-label">Total Users</div>
              </div>
            </div>
          </div>
          <div class="card-icon shadow-primary bg-primary">
            <i class="fa-regular fa-circle-xmark text-white"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Reservation Rejected</h4>
            </div>
            <div class="card-body">
              {{ $reservation_Rejected_only->count() }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12">
        <div class="card card-statistic-2">
          <div class="card-chart">
            <canvas id="balance-chart" height="80"></canvas>
          </div>
          <div class="">
            <div class="card-icon shadow-primary bg-primary">
              <i class="fa-solid fa-spinner text-white"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Reservation Pending</h4>
              </div>
              <div class="card-body">
                {{ $reservation_Pending_only->count() }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12"> 
        <div class="card card-statistic-2">
          <div class="card-chart">
            <canvas id="sales-chart" height="80"></canvas>
          </div>
          <div class="card-icon shadow-primary bg-primary">
            <i class="fa-regular fa-circle-check text-white"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Reservation Accepted</h4>
            </div>
            <div class="card-body">
              {{ $reservation_accept_only->count() }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-8">
        <div class="card">
          <div class="card-header">
            <a href="{{ route('reservations.index')}}" style="text-decoration: none;"><h4>Transactions {{ now()->year }}</h4></a>
          </div>
          <div class="card-body">
            <canvas id="myChartTransaction" height="158"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <a href="{{ route('reservations.index')}}" style="text-decoration: none;"><h4>Tracking Order {{ now()->year }}</h4></a>
          </div>  
          <div class="card-body">
            <div class="row">
              <div class="col-sm-2">
                {{-- <div class="text-title mb-2">July</div> --}}
                <ul class="list-unstyled list-unstyled-border list-unstyled-noborder mb-0">
                  <li class="media">
                    <i class="fa-solid fa-box mt-3 fa-2xl" style="color: rgb(113, 132, 135)"></i>
                    {{-- <img class="img-fluid mt-1 img-shadow" src="{{ url('backend/node_modules/flag-icon-css/flags/4x3/id.svg') }}" alt="image" width="40"> --}}
                    <div class="media-body ml-3">
                      <div class="media-title">Registers</div>
                      <div class="text-small text-muted">{{ $reservation_all_status->where('tracking_register', !null )->where('tracking_restaurant_check', null )->count() }} 
                        {{-- <i class="fas fa-caret-down text-danger"></i> --}}
                      </div>
                    </div>
                  </li>
                  <li class="media">
                    <i class="fa-solid fa-person-breastfeeding mt-3 fa-2xl" style="color: rgb(76, 158, 175)"></i>
                    {{-- <img class="img-fluid mt-1 img-shadow" src="{{ url('backend/node_modules/flag-icon-css/flags/4x3/my.svg') }}" alt="image" width="40"> --}}
                    <div class="media-body ml-3">
                      <div class="media-title">Restaurant Checks</div>
                      <div class="text-small text-muted">{{ $reservation_all_status->where('tracking_restaurant_check', !null )->where('	tracking_confrimed_restaurant', null )->count() }} 
                        {{-- <i class="fas fa-caret-down text-danger"></i> --}}
                      </div>
                    </div>
                  </li>
                  <li class="media">
                    <i class="fa-solid fa-hand-holding-dollar mt-3 fa-2xl" style="color: rgb(39, 184, 215)"></i>
                    {{-- <img class="img-fluid mt-1 img-shadow" src="{{ url('backend/node_modules/flag-icon-css/flags/4x3/us.svg') }}" alt="image" width="40"> --}}
                    <div class="media-body ml-3">
                      <div class="media-title">Confrimed Restaurants</div>
                      <div class="text-small text-muted">{{ $reservation_all_status->where('tracking_confrimed_restaurant', !null )->where('		tracking_done', null )->count() }}
                        {{-- <i class="fas fa-caret-up text-success"></i> --}}
                      </div>
                    </div>
                  </li>
                  <li class="media">
                    <i class="fa-solid fa-rectangle-list mt-3 fa-2xl" style="color: rgb(143, 202, 131)" ></i>
                    {{-- <img class="img-fluid mt-1 img-shadow" src="{{ url('backend/node_modules/flag-icon-css/flags/4x3/us.svg') }}" alt="image" width="40"> --}}
                    <div class="media-body ml-3">
                      <div class="media-title">Tracking Dones</div>
                      <div class="text-small text-muted">{{ $reservation_all_status->where('tracking_done', !null )->count() }}
                        {{-- <i class="fas fa-caret-up text-success"></i> --}}
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
     
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h4>Foods</h4>
            <div class="card-header-action">
              <a href="{{ route('foods.index')}}" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive table-invoice">
              <table class="table table-striped">
                <tr class="text-capitalize">
                  <th>Category</th>
                  <th>Name</th>
                  <th>Merchant</th>
                  {{-- <th>Action</th> --}}
                </tr>
                @forelse ($item_foods as $item_food)
                <tr class="text-capitalize">
                    <td><a >{{ $item_food->category->category }}</a></td>
                    <td class="font-weight-600">{{ $item_food->name }}</td>
                    <td><div class="badge badge-warning">{{ $item_food->merchant->name }}</div></td>
                    {{-- <td>
                      <a  class="btn btn-primary">Detail</a>
                    </td> --}}
                  @empty
                    <td colspan="5" class="text-center">
                      Empty
                    </td> 
                  @endforelse
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h4>Promotions</h4>
            <div class="card-header-action">
              <a href="{{ route('orivouchers-adfood.index')}}" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive table-invoice">
              <table class="table table-striped">
                <tr class="text-capitalize">
                  <th>Coupon Code</th>
                  <th>Name</th>
                  <th>Merchant</th>
                  {{-- <th>Action</th> --}}
                </tr>
                @forelse ($item_promtions as $item_promtion)
                <tr class="text-capitalize">
                  <td><a >{{ $item_promtion->coupon_code }}</a></td>
                  <td class="font-weight-600">{{ $item_promtion->name }}</td>
                  <td><div class="badge badge-warning">{{ $item_promtion->merchant->name }}</div></td>
                  {{-- <td>
                    <a  class="btn btn-primary">Detail</a>
                  </td> --}}
                  @empty
                    <td colspan="5" class="text-center">
                      Empty
                    </td> 
                  @endforelse
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h4>Contents</h4>
          </div>
          <div class="card-body">
            <div class="owl-carousel owl-theme" id="contents-carousel">
              @foreach ($item_contents as $item_content)
              <div>
                <div class="product-item pb-3">
                  <div class="product-image">
                    <a href="{{ route('content.index')}}">
                      <img alt="image" src="{!! $item_content->url ? Storage::url($item_content->url) : url('backend/assets/img/news/img13.jpg') !!}" class="img-fluid">
                    </a>
                  </div>
                  <div class="product-details">
                    <div class="product-name">{{ $item_content->title }}</div>
                    {{-- <div class="product-review">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div> --}}
                    <div class="text-muted text-small">{{ Str::limit($item_content->isi, 15) }}</div>
                    {{-- <div class="product-cta">
                      <a  class="btn btn-primary">Detail</a>
                    </div> --}}
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-hero">
          <div class="card-header">
            <div class="card-icon">
              <i class="far fa-question-circle"></i>
            </div>
            <a href="{{ route('stripes-adfood.index')}}"><h4>Stripes</h4></a>
            <div class="card-description"></div>
          </div>
          <div class="card-body p-0">
            <div class="tickets-list">
              @forelse ($item_stripes as $item_stripe)
              <a href="" class="ticket-item">
                <div class="ticket-title">
                  <h4>{{ $item_stripe->card_information }}</h4>
                </div>
                <div class="ticket-info">
                  <div>{{ $item_stripe->country_region }}</div>
                  <div class="bullet"></div>
                  <div class="text-primary">{{ $item_stripe->created_at ? $item_stripe->created_at->diffForHumans() : '-' }}</div>
                </div>
              </a>
              @empty
                  <span>Empety</span>
              @endforelse
              
              
              <a href="features-tickets.html" class="ticket-item ticket-more">
                View All <i class="fas fa-chevron-right"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h4>Vouchers</h4>
          </div>
          <div class="card-body">
            <div class="owl-carousel owl-theme" id="vouchers-carousel">
              @foreach ($item_vouchers as $item_voucher)
              <div>
                <div class="product-item pb-3">
                  <div class="product-image">
                    <a href="{{ route('vouchers_adfood.index')}}">
                      <img alt="image" src="{!! Storage::url($item_voucher->gallery->sortBy('urutan')->first()->foto) !!}" class="img-fluid">
                    </a>
                  </div>
                  <div class="product-details">
                    <div class="product-name">{{ $item_voucher->name }}</div>
                    {{-- <div class="product-review">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div> --}}
                    <div class="text-muted text-small">{{ $item_voucher->coupon_code }}</div>
                    {{-- <div class="product-cta">
                      <a  class="btn btn-primary">Detail</a>
                    </div> --}}
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </section>
</div>
@endsection

@push('addon-script')

  {{-- <script src="https://code.highcharts.com/highcharts.js"></script>   --}}
  <script src="{{ url('backend/node_modules/chart.js/dist/Chart.min.js') }}"></script>

{{-- Chart --}}
<script>
  var ctx = document.getElementById("myChartTransaction").getContext('2d');
  // mendapatkan bulan
  var today = new Date();
  var monthNow = new Array();
  monthNow[0] = ['Jan'];
  monthNow[1] = ['Jan', 'Feb'];
  monthNow[2] = ['Jan', 'Feb', 'March'];
  monthNow[3] = ['Jan', 'Feb', 'March', 'April'];
  monthNow[4] = ['Jan', 'Feb', 'March', 'April', 'May'];
  monthNow[5] = ['Jan', 'Feb', 'March', 'April', 'May', 'June'];
  monthNow[6] = ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July'];
  monthNow[7] = ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July','Aug'];
  monthNow[8] = ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July','Aug','Sep'];
  monthNow[9] = ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July','Aug','Sep','Oct'];
  monthNow[10] = ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July','Aug','Sep','Oct','Nov'];
  monthNow[11] = ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July','Aug','Sep','Oct','Nov','Dec'];
  
  var monthNowNumber = monthNow[today.getMonth()];
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      // labels: ["Jan", "Feb", "March", "April", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Des"],
      labels: monthNowNumber ,
      datasets: [{
        label: 'Reservation Rejected',
        // data: [3200, 1800, 4305, 3022, 6310, 5120, 5880, 6154 , 6154, 6154, 6154, 6154],
        data: [ {!! $implodeOrderRejected !!}],
        borderWidth: 2,
        backgroundColor: 'rgba(199, 199, 199,.6)',
        borderWidth: 0,
        borderColor: 'transparent',
        pointBorderWidth: 0,
        pointRadius: 3.5,
        pointBackgroundColor: 'transparent',
        pointHoverBackgroundColor: 'rgba(199, 199, 199,.8)',
      },
      {
        label: 'Reservation Pending',
        // data: [2207, 3403, 2200, 5025, 2302, 4208, 3880, 4880, 4880, 4880, 4880, 4880],
        data: [ {!! $implodeOrderPending !!}],
        borderWidth: 2,
        backgroundColor: 'rgba(215, 237, 151,.7)',
        borderWidth: 0,
        borderColor: 'transparent',
        pointBorderWidth: 0 ,
        pointRadius: 3.5,
        pointBackgroundColor: 'transparent',
        pointHoverBackgroundColor: 'rgba(215, 237, 151,.8)',
      },
      {
        label: 'Reservation Accepted',
        // data: [2207, 3403, 2200, 5025, 2302, 4208, 3880, 4880, 4880, 4880, 4880, 4880],
        data: [ {!! $implodeOrderAccept !!}],
        borderWidth: 2,
        backgroundColor: 'rgba(173, 228, 240,.7)',
        borderWidth: 0,
        borderColor: 'transparent',
        pointBorderWidth: 0 ,
        pointRadius: 3.5,
        pointBackgroundColor: 'transparent',
        pointHoverBackgroundColor: 'rgba(173, 228, 240,.8)',
      }]
    },
    options: {
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          gridLines: {
            // display: false,
            drawBorder: false,
            color: '#f2f2f2',
          },
          ticks: {
            beginAtZero: true,
            stepSize: 0,
            callback: function(value, index, values) {
              return value;
            }
          }
        }],
        xAxes: [{
          gridLines: {
            display: false,
            tickMarkLength: 15,
          }
        }]
      },
    }
  });
  
  var balance_chart = document.getElementById("balance-chart").getContext('2d');
  
  var balance_chart_bg_color = balance_chart.createLinearGradient(0, 0, 0, 70);
  balance_chart_bg_color.addColorStop(0, 'rgba(247, 219, 47,.2)');
  balance_chart_bg_color.addColorStop(1, 'rgba(247, 219, 47,0)');
  
  var myChart = new Chart(balance_chart, {
    type: 'line',
    data: {
      // labels: ['16-07-2018', '17-07-2018', '18-07-2018', '19-07-2018', '20-07-2018', '21-07-2018', '22-07-2018', '23-07-2018', '24-07-2018', '25-07-2018', '26-07-2018', '27-07-2018', '28-07-2018', '29-07-2018', '30-07-2018', '31-07-2018'],
      labels: monthNowNumber ,
      datasets: [{
        label: 'Pending',
        // data: [50, 61, 80, 50, 72, 52, 60, 41, 30, 45, 70, 40, 93, 63, 50, 62],
        data: [ {!! $implodeOrderPending !!}],
        backgroundColor: balance_chart_bg_color,
        borderWidth: 3,
        borderColor: 'rgba(247, 219, 47,1)',
        pointBorderWidth: 0,
        pointBorderColor: 'transparent',
        pointRadius: 3,
        pointBackgroundColor: 'transparent',
        pointHoverBackgroundColor: 'rgba(247, 219, 47,1)',
      }]
    },
    options: {
      layout: {
        padding: {
          bottom: -1,
          left: -1
        }
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          gridLines: {
            display: false,
            drawBorder: false,
          },
          ticks: {
            beginAtZero: true,
            display: false
          }
        }],
        xAxes: [{
          gridLines: {
            drawBorder: false,
            display: false,
          },
          ticks: {
            display: false
          }
        }]
      },
    }
  });
  
  var sales_chart = document.getElementById("sales-chart").getContext('2d');
  
  var sales_chart_bg_color = sales_chart.createLinearGradient(0, 0, 0, 80);
  balance_chart_bg_color.addColorStop(0, 'rgba(247, 219, 47,.2)');
  balance_chart_bg_color.addColorStop(1, 'rgba(247, 219, 47,0)');
  
  var myChart = new Chart(sales_chart, {
    type: 'line',
    data: {
      // labels: ['16-07-2018', '17-07-2018', '18-07-2018', '19-07-2018', '20-07-2018', '21-07-2018', '22-07-2018', '23-07-2018', '24-07-2018', '25-07-2018', '26-07-2018', '27-07-2018', '28-07-2018', '29-07-2018', '30-07-2018', '31-07-2018'],
      labels: monthNowNumber ,
      datasets: [{
        label: 'Accepted',
        // data: [70, 62, 44, 40, 21, 63, 82, 52, 50, 31, 70, 50, 91, 63, 51, 60],
        data: [ {!! $implodeOrderAccept !!}],
        borderWidth: 2,
        backgroundColor: balance_chart_bg_color,
        borderWidth: 3,
        borderColor: 'rgba(247, 219, 47,1)',
        pointBorderWidth: 0,
        pointBorderColor: 'transparent',
        pointRadius: 3,
        pointBackgroundColor: 'transparent',
        pointHoverBackgroundColor: 'rgba(247, 219, 47,1)',
      }]
    },
    options: {
      layout: {
        padding: {
          bottom: -1,
          left: -1
        }
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          gridLines: {
            display: false,
            drawBorder: false,
          },
          ticks: {
            beginAtZero: true,
            display: false
          }
        }],
        xAxes: [{
          gridLines: {
            drawBorder: false,
            display: false,
          },
          ticks: {
            display: false
          }
        }]
      },
    }
  });
  
  $("#vouchers-carousel").owlCarousel({
    items: 5,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 5000,
    loop: true,
    responsive: {
      0: {
        items: 2
      },
      768: {
        items: 2
      },
      1200: {
        items: 5
      }
    }
  });

  $("#contents-carousel").owlCarousel({
    items: 3,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 5000,
    loop: true,
    responsive: {
      0: {
        items: 2
      },
      768: {
        items: 2
      },
      1200: {
        items: 3
      }
    }
  });
  
    </script>
  
  
@endpush