@extends('layouts.admin')
@section('title','Customers')
@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Customers</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item "><a >Customers</a></div>
              <div class="breadcrumb-item active"><a >Users</a></div>
            </div>
        </div>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-header d-sm-flex align-items-center justify-content-between">
            <h4>Customers</h4>
            <a href="{{ route('customers.create')}}"
           class="btn btn-sm btn-primary shadow-sm rounded">
           <i class="fas fa-plus fa-sm text-white-50"></i>
           User Customer
            </a>        
          </div>
          <div class="card-body">
            <div class="table-responsive">
                <table id="mytable" class="table table-striped" style="width:100%">
                  <thead class="">
                      <tr>
                          <th>#</th>
                          <th style="width: 20%">Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          {{-- <th>Address</th> --}}
                          <th>Transactions</th>
                          <th>Role</th>
                          <th>Status</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody class="">
                    @php
                          $s=1;                                                   
                      @endphp
                    @forelse ($items as $item)
                    <tr>
                        <td>{{ $s }}</td>
                        <td>
                          <a href="{{ route('profile-user',$item->id)  }}">
                             <img alt="image" src="{!!$item->foto ? Storage::url($item->foto) : url('backend/assets/img/avatar/customer.png') !!}" class="rounded-circle" width="35" data-toggle="title" title="">
                          </a>
                          <div class="d-inline-block ml-1">{{ $item->name }}</div>
                        </td>
                        {{-- <td>
                          <div class="d-flex justify-content-start align-items-center">
                              <img src="{!!$item->foto ? Storage::url($item->foto) : url('backend/assets/img/avatar/customer.png') !!}" class="avatar avatar-sm mr-2 " width="35">
                                {{ $item->name }}
                          </div>    
                            
                        </td> --}}
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->phone }}</td>
                        {{-- <td>{{ $item->customer->address }}</td> --}}
                        <td>{{ $item->name }}</td>
                        <td><span class="badge badge-light">{{ $item->roles }}</span></td>
                        <td>{!! $item->status == 1 ? '<div class="badge badge-primary">active</div>' : '<div class="badge badge-danger">not active</div>' !!}</td>
                        <td>
                          {{-- <a href="" 
                                    class="btn btn-success">
                                    <i class="fa fa-eye"></i>
                                </a> --}}

                                <a href="{{ route('customers.edit', $item->id)}}" 
                                  class="btn btn-info">
                                  <i class="fa fa-pencil-alt"></i>
                              </a>
                              
                              

                              <form action="{{ route('customers.destroy', $item->id) }}"
                                  method="POST" class="d-inline" id="data-{{ $item->id }}">
                                  @csrf
                                  @method('delete')
                              </form>
                              <button class="btn btn-warning" onclick="deleteRow( {{ $item->id }} )" > 
                                <i class="fa-solid fa-spinner"></i>
                              </button>
                              
                              <form action="{{ route('customers_adfood_delete', $item->id) }}"
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