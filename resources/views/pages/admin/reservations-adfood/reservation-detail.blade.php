@extends('layouts.admin')
@section('title','Reservation')
@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Reservation Detail</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">Reservation Detail</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">
        @if ($item->status == 'pending')
            <span class="text-warning">Pending</span>
        @elseif ($item->status == 'accepted')
        <span class="text-success">Accepted</span>
        @else
        <span class="text-danger">Rejected</span>
        @endif
      </h2>
      

      <div class="row">
        <div class="col-12">
          <div class="activities">
            @if ($item->tracking_register)
            <div class="activity">
              <div class="activity-icon bg-primary text-white shadow-primary">
                <i class="fa-solid fa-box"></i>
              </div>
                <div class="activity-detail">
                  <div class="mb-2">
                    <span class="text-job text-primary">{{\Carbon\Carbon::parse($item->tracking_register)->format('d F y') }}</span>
                    <span class="bullet"></span>
                    <a class="text-job" >{{ \Carbon\Carbon::create($item->tracking_register)->format ('H:i')}}</a>

                  </div>
                  C<span class="text-lowercase">ustomer <a href="{{ route('profile-user',$item->	adfood_customers_id)  }}"> {{ $item->customer->first()->name }}</a> registers a place at the merchant<a href="{{ route('profile-user',$item->	adfood_merchants_id)  }}"> {{ $item->merchant->first()->name }}</a></span>
                </div>
            </div>
            @if ($item->tracking_restaurant_check)
            <div class="activity">
              <div class="activity-icon bg-primary text-white shadow-primary">
                <i class="fa-solid fa-person-breastfeeding"></i>
              </div>
              <div class="activity-detail">
                <div class="mb-2">
                  <span class="text-job text-primary">{{\Carbon\Carbon::parse($item->tracking_restaurant_check)->format('d F y') }}</span>
                  <span class="bullet"></span>
                  <a class="text-job" >{{ \Carbon\Carbon::create($item->tracking_restaurant_check)->format ('H:i')}}</a>

                </div>
                M<span class="text-lowercase">erchant <a href="{{ route('profile-user',$item->	adfood_merchants_id)  }}"> {{ $item->merchant->first()->name }}</a> check reservation customer<a href="{{ route('profile-user',$item->	adfood_customers_id)  }}"> {{ $item->customer->first()->name }}</a></span>
              </div>
            </div>
            @if ($item->tracking_confrimed_restaurant)
            <div class="activity">
              <div class="activity-icon bg-primary text-white shadow-primary">
                <i class="fa-solid fa-hand-holding-dollar"></i>
              </div>
              <div class="activity-detail">
                <div class="mb-2">
                  <span class="text-job text-primary">{{\Carbon\Carbon::parse($item->tracking_confrimed_restaurant)->format('d F y') }}</span>
                  <span class="bullet"></span>
                  <a class="text-job" >{{ \Carbon\Carbon::create($item->tracking_confrimed_restaurant)->format ('H:i')}}</a>

                </div>
                M<span class="text-lowercase">erchant <a href="{{ route('profile-user',$item->	adfood_merchants_id)  }}"> {{ $item->merchant->first()->name }}</a> confirm reservation customer<a href="{{ route('profile-user',$item->	adfood_customers_id)  }}"> {{ $item->customer->first()->name }}</a></span>
              </div>
            </div>
            @if ($item->tracking_done)
            <div class="activity">
              <div class="activity-icon bg-primary text-white shadow-primary">
                <i class="fa-solid fa-rectangle-list"></i>
              </div>
              <div class="activity-detail">
                <div class="mb-2">
                  <span class="text-job text-primary">{{\Carbon\Carbon::parse($item->tracking_done)->format('d F y') }}</span>
                  <span class="bullet"></span>
                  <a class="text-job" >{{ \Carbon\Carbon::create($item->tracking_done)->format ('H:i')}}</a>

                </div>
                <p>Reservation complete</p>
              </div>
            </div>
            @endif
            @endif
            @endif
            
            @else
                <Span>Null</Span>
            @endif
              
            {{-- <div class="activity">
              <div class="activity-icon bg-primary text-white shadow-primary">
                <i class="fas fa-arrows-alt"></i>
              </div>
              <div class="activity-detail">
                <div class="mb-2">
                  <span class="text-job">1 hour ago</span>
                  <span class="bullet"></span>
                  <a class="text-job" href="#">View</a>
                  <div class="float-right dropdown">
                    <a href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                    <div class="dropdown-menu">
                      <div class="dropdown-title">Options</div>
                      <a href="#" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                      <a href="#" class="dropdown-item has-icon"><i class="fas fa-list"></i> Detail</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item has-icon text-danger trigger--fire-modal-2" data-confirm="Wait, wait, wait...|This action can't be undone. Want to take risks?" data-confirm-text-yes="Yes, IDC"><i class="fas fa-trash-alt"></i> Archive</a>
                    </div>
                  </div>
                </div>
                <p>Moved the task "<a href="#">Fix some features that are bugs in the master module</a>" from Progress to Finish.</p>
              </div>
            </div> --}}
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('prepend-script')
    
@endpush

@push('addon-script')


  
@endpush