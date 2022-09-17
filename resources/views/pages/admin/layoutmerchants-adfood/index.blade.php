@extends('layouts.admin')
@section('title','Merchants')
@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Merchants</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item "><a >Merchants</a></div>
              <div class="breadcrumb-item active"><a >Users</a></div>
            </div>
        </div>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-header d-sm-flex align-items-center justify-content-between">
            <h4>Merchants</h4>
            <a href="{{ route('merchants.create')}}"
           class="btn btn-sm btn-primary shadow-sm rounded">
           <i class="fas fa-plus fa-sm text-white-50"></i>
           User Merchant
            </a>        
          </div>
          <div class="card-body">
            <div class="table-responsive">
                <table id="mytable" class="table table-striped text-capitalize" style="width:100%">
                  <thead class="">
                      <tr>
                          <th>#</th>
                          <th style="width: 20%">Name</th>
                          <th>Email</th>
                          <th>Menu Restaurant</th>
                          {{-- <th>Phone</th> --}}
                          <th>Open - Close Restaurant</th>
                          {{-- <th>Transactions</th> --}}
                          {{-- <th>Role</th> --}}
                          <th>Status</th>
                      </tr>
                  </thead>
                  <tbody class="" id="tablecontents">
                    {{-- @php
                          $s=1;                                                   
                      @endphp --}}
                    @forelse ($posts as $post)
                    <tr class="text-capitalize row1" data-id="{{ $post->id }}">
                        {{-- <td>{{ $s }}</td> --}}
                        <td><i class="fa-solid fa-up-down-left-right"></i></td>
                        <td>
                          <a>
                             <img alt="image" src="{!!$post->foto ? Storage::url($post->foto) : url('backend/assets/img/avatar/merchant.png') !!}" class="rounded-circle" width="70" data-toggle="title" title="">
                          </a>
                          <div class="d-inline-block ml-1">{{ $post->name }}</div>
                        </td>
                        <td>{{ $post->email }}</td>
                        <td>
                          <img src="{!! $post->gallerymerchant->first() ? Storage::url($post->gallerymerchant->sortBy('urutan')->first()->menus_restaurant) : url('backend/assets/img/avatar/food.png')!!}" class="gallery-item mr-2 " width="70"> 

                          {{-- <a href="{{ route('image_menus', $post->id)}}">
                            @forelse ($post->gallerymerchant->sortBy('urutan') as $itemGallery)
                            <img src="{!! Storage::url($itemGallery->menus_restaurant) !!}" class="gallery-item mr-2 " width="35"> 
                            @empty
                            <img src="{!! url('backend/assets/img/avatar/menus_restaurant.png') !!}" class=" mr-2 " width="35">
                            @endforelse
                        </a> --}}
                        </td>
                        {{-- <td>{{ $item->phone }}</td> --}}
                        <td>{{\Carbon\Carbon::create($post->merchant->open_restaurant)->format('H:i')}} - {{\Carbon\Carbon::create($post->merchant->close_restaurant)->format('H:i')}}</td>
                        {{-- <td>{{ $post->name }}</td> --}}
                        {{-- <td><span class="badge badge-light">{{ $post->roles }}</span></td> --}}
                        <td>{!! $post->status == 1 ? '<div class="badge badge-primary">active</div>' : '<div class="badge badge-danger">not active</div>' !!}</td>
                        
                        {{-- @php
                        $s++; 
                        @endphp --}}
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

{{-- move / drag update  --}}

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script type="text/javascript">
  $(function () {
    // $("#table").DataTable();
// this is need to Move Ordera accordin user wish Arrangement
    $( "#tablecontents" ).sortable({
      items: "tr",
      cursor: 'move',
      opacity: 0.6,
      update: function() {
          sendOrderToServer();
      }
    });
    function sendOrderToServer() {
      var order = [];
      var token = $('meta[name="csrf-token"]').attr('content');
    //   by this function User can Update hisOrders or Move to top or under
      $('tr.row1').each(function(index,element) {
        order.push({
          id: $(this).attr('data-id'),
          position: index+1
        });
      });
// the Ajax Post update 
      $.ajax({
        type: "POST", 
        dataType: "json", 
        // url: "{{ url('Custom-sortable') }}",
        url: "{{ url('admin/layoutmerchantsortable') }}",
            data: {
          order: order,
          _token: token
        },
        success: function(response) {
            if (response.status == "success") {
              console.log(response);
            } else {
              console.log(response);
            }
        }
      });
    }
  });
</script>
  
@endpush