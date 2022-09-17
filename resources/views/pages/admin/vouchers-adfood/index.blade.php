@extends('layouts.admin')
@section('title','Vouchers')
@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Vouchers</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item "><a >Merchants</a></div>
              <div class="breadcrumb-item active"><a >Vouchers</a></div>
            </div>
        </div>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-header d-sm-flex align-items-center justify-content-between">
            <h4>Vouchers</h4>
            <a href="{{ route('vouchers_adfood.create')}}"
           class="btn btn-sm btn-primary shadow-sm rounded">
           <i class="fas fa-plus fa-sm text-white-50"></i>
           Voucher
            </a>        
          </div>
          <div class="card-body">
            <div class="table-responsive">
                <table id="mytable" class="table table-striped" style="width:100%">
                  <thead class="">
                      <tr>
                          <th>#</th>
                          <th style="width: 20%">Name</th>
                          <th>Coupon Code</th>
                          <th style="width: 20%">Picture</th>
                          <th style="width: 20%">Merchant</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Min Purchase</th>
                          <th>Description</th>
                          <th>Discount</th>
                          <th>Price</th>
                          <th>Type</th>
                          <th>Home</th>
                          <th>Voucher</th>
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
                        <td>{{ $s }}</td>
                        
                        {{-- <td>
                          <div class="d-flex justify-content-start align-items-center">
                            @if ($item->status == 1)
                                <img src="{!!$item->foto ? Storage::url($item->foto) : url('backend/assets/img/avatar/merchant.png') !!}" class="avatar avatar-sm mr-2 " width="35">
                                {{ $item->name }}</div>    
                            @else
                                <i class="far fa-times-circle mr-1 text-danger"></i>{{ $item->name }}
                            @endif
                        </td> --}}
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->coupon_code }}</td>
                        <td>
                          <a href="{{ route('image_voucher', $item->id)}}">
                            
                            @forelse ($item->gallery->sortBy('urutan') as $itemGallery)
                            <img src="{!! Storage::url($itemGallery->foto) !!}" class="gallery-item mr-2 " width="35"> 
                            @empty
                            <img src="{!! url('backend/assets/img/avatar/voucher.png') !!}" class=" mr-2 " width="35">
                            @endforelse
                        </a>
                        </td>
                        <td>
                          <a href="#">
                             <img alt="image" src="{!!$item->merchant->foto ? Storage::url($item->merchant->foto) : url('backend/assets/img/avatar/merchant.png') !!}" class="rounded-circle" width="35" data-toggle="title" title="">
                          </a>
                          <div class="d-inline-block ml-1">{{ $item->merchant->name }}</div>
                        </td>
                        <td>{{\Carbon\Carbon::parse($item->expired_at)->format('d F y')}}</td>
                        <td>{{\Carbon\Carbon::parse( $item->expired_at_time)->format('H:i') }}</td>
                        <td>{{ $item->min_purchase }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->discount }}</td>
                        <td>{{ $item->price }}</td>
                        <td>
                          @if ($item->type == 11)
                          by one get one   
                          @elseif($item->type == 1)
                          Free One Dish
                          @else
                          {{ $item->type }}%
                          @endif
                        </td>
                        <td>{{ $item->home }}</td>
                        <td>{{ $item->voucher }}</td>
                        <td>{!! $item->status == 1 ? '<div class="badge badge-primary">active</div>' : '<div class="badge badge-danger">not active</div>' !!}</td>
                        <td>
                          {{-- <a href="" 
                                    class="btn btn-success">
                                    <i class="fa fa-eye"></i>
                                </a> --}}

                                <a href="{{ route('vouchers_adfood.edit', $item->id)}}" 
                                  class="btn btn-info">
                                  <i class="fa fa-pencil-alt"></i>
                              </a>
                              
                              

                              <form action="{{ route('vouchers_adfood.destroy', $item->id) }}"
                                  method="POST" class="d-inline" id="data-{{ $item->id }}">
                                  @csrf
                                  @method('delete')
                              </form>
                              <button class="btn btn-warning" onclick="deleteRow( {{ $item->id }} )" >
                                <i class="fa-solid fa-spinner"></i>
                              </button>

                              <form action="{{ route('vouchers_adfood_delete', $item->id) }}"
                                method="POST" class="d-inline" id="dataPermanen-{{ $item->id }}">
                                @csrf
                                @method('delete')
                              </form>
                              <button class="btn btn-danger" onclick="deleteRowPermanen( {{ $item->id }} )" > 
                                <i class="fa fa-trash"></i> 
                              </button>
                              
                              
                              {{-- <form action="{{ route('vouchers_adfood_delete')}}"
                                  method="POST" class="d-inline">
                                  @csrf
                                  @method('delete')
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