@extends('layouts.admin')

@if ($items->first()->acc == 0)
  @section('title','Reservations')    
@else
  @section('title','Reservations Histories')    
@endif

@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>{{ $items->first()->acc == 0 ? 'Reservations' : 'Reservations Histories'}}</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item "><a >Merchants</a></div>
              <div class="breadcrumb-item active"><a>{{ $items->first()->acc == 0 ? 'Reservations' : 'Reservations Histories' }}</a></div>
            </div>
        </div>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-header d-sm-flex align-items-center justify-content-between">
            <h4>{{ $items->first()->acc == 0 ? 'Reservations' : 'Reservations Histories' }}</h4>
            <a href="{{ route('reservations.create')}}"
           class="btn btn-sm btn-primary shadow-sm rounded">
           <i class="fas fa-plus fa-sm text-white-50"></i>
           Reservations
            </a>        
          </div>
          <div class="card-body">
            <div class="table-responsive">
                <table id="mytable" class="table table-striped" style="width:100%">
                  <thead class="text-capitalize">
                      <tr>
                          <th>#</th>
                          <th>Order Id</th>
                          <th style="width: 20%">Customer</th>
                          <th>Date</th>
                          <th>Time</th>
                          <th>Total People</th>
                          <th>Merchant</th>
                          @if ($items->first()->acc == 1)
                          <th>Rate</th>  
                          @endif
                          <th>Status</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody class="">
                    @php
                          $s=1;                                                   
                      @endphp
                    @forelse ($items as $item)
                    <tr class="text-capitalize">
                        <td style="padding-top: 19px;">{{ $s }}</td>
                        <td style="padding-top: 19px;"><a href="{{ route('reservation-detail', $item->id) }}">{{ $item->order_id }}</a></td>
                        
                        <td>
                          @if ($item->customer->first())
                          <img alt="image" src="{!!$item->customer->first()->foto ? Storage::url($item->customer->first()->foto) : url('backend/assets/img/avatar/customer.png') !!}" class="rounded-circle" width="35" data-toggle="title" title="">
                          <a href="#" class="bb">
                            <div class="d-inline-block ml-1">{{ $item->customer->first()->name }}</div>
                          </a>
                          @else
                            <div class="d-inline-block ml-1 mt-2"><span class="text-danger"><i class="fa fa-trash fa-2xl mr-1" aria-hidden="true"></i>{{ $item->adfood_customers_id }}</span></div>
                          @endif
                          
                        </td>
                        <td style="padding-top: 19px;"> <span class="badge badge-danger">{{\Carbon\Carbon::parse($item->date)->format('d F y')}}</span></td>
                        <td style="padding-top: 19px;"> <span class="badge badge-warning">{{ \Carbon\Carbon::create($item->time)->format ('H:i')}}</span></td>
                        <td style="padding-top: 19px;"><span class="badge badge-info"> {{ $item->jumlah_orang }}</span></td>
                        <td>
                          @if ($item->merchant->first())
                            <img alt="image" src="{!!$item->merchant->first()->foto ? Storage::url($item->merchant->first()->foto) : url('backend/assets/img/avatar/merchant.png') !!}" class="rounded-circle" width="35" data-toggle="title" title="">
                            <a href="#" class="bb">
                              <div class="d-inline-block ml-1">{{ $item->merchant->first()->name }}</div>
                            </a>
                          @else
                            <div class="d-inline-block ml-1 mt-2"><span class="text-danger"><i class="fa fa-trash fa-2xl mr-1" aria-hidden="true"></i>{{ $item->adfood_merchants_id }}</span></div>
                          @endif
                        </td>
                        @if ($items->first()->acc == 1)
                          @if ($item->status == 'rejected')
                              <td></td>
                          @else
                            <td style="padding-top: 19px;">
                              @if ($item->rate)
                                @if ($item->rate == 1)
                                  <i class="fas fa-star text-warning"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                @elseif($item->rate == 2)
                                  <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                @elseif($item->rate == 3)
                                  <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                @elseif($item->rate == 4)
                                  <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star"></i>
                                @elseif($item->rate == 5)
                                  <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                                @else 
                                  <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                @endif
                              @else
                              <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                              @endif
                            </td>
                          @endif
                        @endif
                        
                        <td style="padding-top: 19px;">
                          @if ($item->status == 'accepted')
                          <span class="badge badge-info">{{ $item->status }}
                          @elseif ($item->status == 'rejected')
                          <span class="badge badge-danger">{{ $item->status }}
                            @elseif ($item->status == 'pending')
                          <span class="badge badge-warning">{{ $item->status }}
                          @endif 
                          </span></td>
                        {{-- <td>
                          <a href="#">
                             <img alt="image" src="{!!$item->user->first()->foto ? Storage::url($item->user->first()->foto) : url('backend/assets/img/avatar/merchant.png') !!}" class="rounded-circle" width="35" data-toggle="title" title="">
                          </a>
                          <div class="d-inline-block ml-1">{{ $item->user->first()->name }}</div>
                        </td> --}}
                        {{-- <td>{!! $item->status == 1 ? '<div class="badge badge-primary">active</div>' : '<div class="badge badge-danger">not active</div>' !!}</td> --}}
                        <td>
                          {{-- <a href="" 
                                    class="btn btn-success">
                                    <i class="fa fa-eye"></i>
                                </a> --}}

                                
                              @if ($item->status == 'accepted')
                              <a href="{{ route('reservations_rate', $item->id)}}" 
                                class="btn btn-success my-1">
                                <i class="fas fa-star-half-alt"></i>
                              </a>   
                              @endif

                              @if ($item->merchant->first() == true)
                                @if ($item->customer->first() == true)
                                <a href="{{ route('reservations.edit', $item->id)}}" 
                                  class="btn btn-info">
                                  <i class="fa fa-pencil-alt"></i>
                                </a>
                                @endif
                              @endif
                              

                              {{-- <form action="{{ route('reservations.destroy', $item->id) }}"
                                  method="POST" class="d-inline" id="data-{{ $item->id }}">
                                  @csrf
                                  @method('delete')
                              </form>
                              <button class="btn btn-warning" onclick="deleteRow( {{ $item->id }} )" > 
                                <i class="fa-solid fa-spinner"></i>
                              </button> --}}
                              
                              <form action="{{ route('reservations_adfood_delete', $item->id) }}"
                                method="POST" class="d-inline" id="dataPermanen-{{ $item->id }}">
                                @csrf
                                @method('delete')
                              </form>
                              <button class="btn btn-danger" onclick="deleteRowPermanen( {{ $item->id }} )" > 
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
                        @php
                        $s++; 
                        @endphp
                        @empty
                      <td colspan="8" class="text-center">
                        Empty
                    </td>                
                      @endforelse
                    </tr>
                  </tbody>
                  
              </table>
            </div>
          </div>
          <div class="card-footer bg-whitesmoke">
            
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