@extends('layouts.admin')
@section('title','Profile')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Profile {{ $user->customers_id ? 'Customer' : 'Merchant' }}</h1>
      <div class="section-header-breadcrumb">
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a >Profile</a></div>
            
          </div>
      </div>
    </div>

    <div class="section-body">
      {{-- <h2 class="section-title">This is Example Page</h2>
      <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
      {{-- <div class="card"> --}}
        {{-- <div class="card-header d-sm-flex align-items-center justify-content-between ">
        </div> --}}
        <div class="card-body">
          <div class="row">
            <div class="container-fluid">
              <div class="card profile-widget">
                <div class="profile-widget-header">
                  @if ($user->merchants_id)
                  <img alt="image" src="{!!$user->foto ? Storage::url($user->foto) : url('backend/assets/img/avatar/merchant.png') !!}" class="rounded-circle profile-widget-picture">
                  @else
                  <img alt="image" src="{!!$user->foto ? Storage::url($user->foto) : url('backend/assets/img/avatar/customer.png') !!}" class="rounded-circle profile-widget-picture">
                  @endif
                  
                  <div class="profile-widget-items">
                    <div class="profile-widget-item">
                      <div class="profile-widget-item-label">Reservation Rejected</div>
                      <div class="profile-widget-item-value">{{ $user->reservation_merchant->where('status','rejected')->count() }}</div>
                    </div>
                    <div class="profile-widget-item">
                      <div class="profile-widget-item-label">Reservation Pending</div>
                      <div class="profile-widget-item-value">{{ $user->reservation_merchant->where('status','pending')->count() }}</div>
                    </div>
                    <div class="profile-widget-item">
                      <div class="profile-widget-item-label">Reservation Accepted</div>
                      <div class="profile-widget-item-value">{{ $user->reservation_merchant->where('status','accepted')->count() }}</div>
                    </div>
                  </div>
                </div>
                <div class="profile-widget-description pb-0 ">
                  <div class="profile-widget-name text-capitalize {{ $user->isVerified ? 'text-success' : "text-danger" }} "><i class="fa-solid fa-user-check"></i> {{ $user->name }} 
                    <div class="text-muted d-inline font-weight-normal">
                      @if ($user->merchants_id)
                      <div class="slash">
                      </div>
                        <i class="fas fa-star text-warning"></i> {{ round ($avg, 2) }}
                      </div>
                      @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          {{-- body --}}
              <div class="row">
                {{-- menu Email --}}
                <div class="col">
                  <table class="table card card-secondary"> 
                    <tbody>
                      <tr>
                        <th scope="row">Email</th>
                        <td class="text-capitalize">{{ $user->email }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Phone</th>
                        <td class="text-capitalize">{{ $user->phone }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Gender</th>
                        <td class="text-capitalize">{{ $user->gender }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Day of Birth</th>
                        <td class="text-capitalize">{{ $user->day_of_birth }}</td>
                      </tr>
                      @if ($user->merchant)
                      <tr>
                        <th scope="row">Min Price</th>
                        <td class="text-capitalize"><i class="fa-solid fa-dollar-sign"></i> {{ $user->merchant->min_price }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Max Price</th>
                        <td class="text-capitalize"><i class="fa-solid fa-dollar-sign"></i> {{ $user->merchant->max_price }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Open - CLose Restaurant</th>
                        <td class="text-capitalize"> {{ \Carbon\Carbon::create($user->merchant->open_restaurant)->format ('H:i'). ' - ' .\Carbon\Carbon::create($user->merchant->open_restaurant)->format ('H:i') }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Phone Restaurant</th>
                        <td class="text-capitalize">{{ $user->merchant->phone_restaurant }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Website</th>
                        <td class="text-capitalize">{{ $user->merchant->website }}</td>
                      </tr>
                      <tr>
                        <th scope="row">Address</th>
                        <td class="text-capitalize">{{ $user->merchant->address }}</td>
                      </tr>
                      <tr>
                        <th scope="row">About</th>
                        <td class="text-capitalize">{{ $user->merchant->about }}</td>
                      </tr>
                      @else
                      <tr>
                        <th scope="row">Address</th>
                        <td class="text-capitalize">{{ $user->customer->address }}</td>
                      </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
                
                @if ($user->merchants_id)
                <div class="col">
                  {{-- Menu Restaurant --}}
                  <div class="card card-secondary">
                    <div class="card-header">
                      <h4>Menu Restaurant</h4>
                    </div>
                    <div class="card-body">
                      <div class="gallery">
                        @forelse ($user->gallerymerchant as $itemGallery)
                        <div class="gallery-item" data-image=" {!! Storage::url($itemGallery->menus_restaurant) !!} " data-title="Image 1" href=" {!! Storage::url($itemGallery->menus_restaurant) !!}" title="Image 1" style="background-image: url(&quot;''{{ Storage::url($itemGallery->menus_restaurant) }}&quot;);"></div>
                            
                        @empty
                        <div class="gallery-item" data-image=" {!! url('backend/assets/img/avatar/menus_restaurant.png') !!} " data-title="Image 1" href=" {!! url('backend/assets/img/avatar/menus_restaurant.png') !!}" title="Image 1" style="background-image: url(&quot;''{{ url('backend/assets/img/avatar/menus_restaurant.png') }}&quot;);"></div>
                        @endforelse
                      </div>
                    </div>
                  </div>

                  {{-- Foods --}}
                  <div class="card card-secondary">
                    <div class="card-header">
                      <h4>Foods</h4>
                    </div>
                    <div class="card-body ">
                      <ul class="list-unstyled">
                        @forelse ($food as $itemFood)
                        <li class="media mb-4">
                          @if ($itemFood->gallery->first())
                          <img class="mr-3" src="{!! Storage::url($itemFood->gallery->sortBy('urutan')->first()->foto) !!}" class="gallery-item mr-2 " width="100">
                          @else
                          <img src="{!! url('backend/assets/img/avatar/food.png') !!}" class=" mr-2 " width="100">
                          @endif
                          
                          <div class="media-body">
                            <h5 class="mt-0 mb-1 text-capitalize {{ $itemFood->status ? 'text-success' : 'text-danger' }}">{{ $itemFood->name }}</h5>
                          </div>
                        </li>     
                          @empty
                          <img src="{!! url('backend/assets/img/avatar/food.png') !!}" class=" mr-3 " width="100">
                          @endforelse
                      </ul>
                    </div>
                  </div>
                </div>
                @endif
                
              </div>
            
          

        </div>
          
      {{-- </div>  --}}
        <div class="card-footer bg-whitesmoke">
          
        </div>
      </div>
    </div>
  </section>
  </div>
@endsection