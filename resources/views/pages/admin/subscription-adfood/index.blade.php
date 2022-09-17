@extends('layouts.admin')
@section('title','Subscriptions')
@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Subscriptions</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item "><a >Customers</a></div>
              <div class="breadcrumb-item active"><a >Subscriptions</a></div>
            </div>
        </div>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-header d-sm-flex align-items-center justify-content-between">
            <h4>Subscriptions</h4>
            <a href="{{ route('subscription-adfood.create')}}"
           class="btn btn-sm btn-primary shadow-sm rounded">
           <i class="fas fa-plus fa-sm text-white-50"></i>
           Subscription
            </a>        
          </div>
          <div class="card-body">
            <div class="table-responsive">
                <table id="mytable" class="table table-striped" style="width:100%">
                  <thead class="">
                    <tr>
                        <th>#</th>
                        <th style="width: 30%">Category</th>
                        <th>Price</th>
                        <th>Price Discount</th>
                        <th>Extra Posts</th>
                        <th>Extra Images</th>
                        <th>Weeks</th>
                        <th>Status</th>
                        <th style="width: 20%">Action</th>
                    </tr>
                </thead>
                <tbody class="">
                  @php
                        $s=1;                                                   
                    @endphp
                  @forelse ($items as $item)
                  <tr class="text-capitalize">
                      <td>{{ $s }}</td>
                      <td>
                        <a href="#">
                           <img alt="image" src="{!!$item->foto ? Storage::url($item->foto) : url('backend/assets/img/avatar/subscription.png') !!}" class="rounded-circle" width="35" data-toggle="title" title="">
                        </a>
                        <div class="d-inline-block ml-1 badge badge-success">{{ $item->category }}</div>
                      </td>
                      
                      <td class="mb-2">{{ $item->price }} $</td>
                      <td>{{ $item->price_discount }} $</td>
                      <td>{{ $item->extra_posts }} Extra Posts</td>
                      <td>{{ $item->extra_images }} Extra Images</td>
                      <td>{{ $item->weeks }} weeks ({{ $item->weeks*7 }} Days)</td>
                      <td>{!! $item->status == 1 ? '<div class="badge badge-primary">active</div>' : '<div class="badge badge-danger">not active</div>' !!}</td>
                      <td>
                        {{-- <a href="" 
                                  class="btn btn-success">
                                  <i class="fa fa-eye"></i>
                              </a> --}}

                              <a href="{{ route('subscription-adfood.edit', $item->id)}}" 
                                class="btn btn-info">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            
                            

                            <form action="{{ route('subscription-adfood.destroy', $item->id) }}"
                                method="POST" class="d-inline" id="data-{{ $item->id }}">
                                @csrf
                                @method('delete')
                            </form>
                            <button class="btn btn-warning" onclick="deleteRow( {{ $item->id }} )" >
                              <i class="fa-solid fa-spinner"></i>
                            </button>

                            <form action="{{ route('subscription-adfood-delete', $item->id) }}"
                              method="POST" class="d-inline" id="dataPermanen-{{ $item->id }}">
                              @csrf
                              @method('delete')
                            </form>
                            <button class="btn btn-danger" onclick="deleteRowPermanen( {{ $item->id }} )" > 
                              <i class="fa fa-trash"></i> 
                            </button>
                            
                            
                            {{-- <form action="{{ route('subscription-adfood_delete')}}"
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
                    <td colspan="11" class="text-center">
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