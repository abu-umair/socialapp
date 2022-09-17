@extends('layouts.admin')
@section('title','Services - Customers')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
        <h1>Customers</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a >Users</a></div>
              <div class="breadcrumb-item"><a >Customers</a></div>
              
            </div>
        </div>
      </div>

    <div class="section-body">
      {{-- <h2 class="section-title">This is Example Page</h2>
      <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
      <div class="card">
        <div class="card-header d-sm-flex align-items-center justify-content-between ">
          <h1 class="h3 mb-0 text-gray-800">All Users</h1>
          {{-- <a href="{{ route('users-customer.create')}}"
           class="btn btn-sm btn-primary shadow-sm rounded">
           <i class="fas fa-plus fa-sm text-white-50"></i>
           Tamabah User
            </a>           --}}
        </div>
        
        <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="table_id" width="100%" collspacing="0">
                  <thead>
                      <tr>
                          <th>No</th>
                          {{-- <th>Id</th>                           --}}
                          <th>Name</th>                          
                          <th>Email</th>
                          <th>Phone </th>
                          <th>Transaksi</th>
                          <th>Status</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @php
                          $s=1;                                                   
                      @endphp
                      
                      @forelse ($items as $item)             
                                 
                          @if ($item->user->roles != 'ADMIN')
                            <tr>
                              <td>{{ $s}}</td>
                              {{-- <td>{{ $item->id }}</td>                               --}}
                              <td>
                                  <a href="{{route('users-customer.profile',$item->id)}}" class="font-weight-600">
                                    <img src="{!!$item->customer->foto ? Storage::url($item->customer->foto) : url('backend/assets/img/avatar/avatar-1.png') !!}" alt="avatar" class="img-thumbnail mr-1" width="35">{{ $item->name}}
                                  </a>
                                </td>                              
                              <td>{{ $item->email }}</td>
                              <td>{{ $item->phone}}</td>
                              <td><a href="{{route('transactions-customer',$item->customer->id)}}" class="font-weight-600">{{ $item->customer->transaksi}} Transaksi</a></td>
                              @if ($item->customer->status == 0)
                                  <td><span class="badge badge-secondary">Tidak Aktif</span></td>
                              @else
                                  <td><span class="badge badge-info">Aktif</span></td>
                              @endif
                              
                              
                              {{-- <td>
                                  <a href="{{ route('sellproperties.show', $item->id) }}" 
                                      class="btn btn-success">
                                      <i class="fa fa-eye"></i>
                                  </a>

                                  <a href="{{ route('sellproperties.edit', $item->id) }}" 
                                      class="btn btn-info">
                                      <i class="fa fa-pencil-alt"></i>
                                  </a>
                                  
                                  <form action="{{ route('sellproperties.destroy', $item->id) }}"
                                      method="POST" class="d-inline" id="data-{{ $item->id }}">
                                      @csrf
                                      @method('delete')
                                  </form>
                                  <button class="btn btn-danger" onclick="deleteRow( {{ $item->id }} )" > 
                                  <i class="fa fa-trash"></i> 
                                  </button>
                                  
                                  <form action="{{ route('sellproperties.restore') }}"
                                      method="POST" class="d-inline">
                                      @csrf
                                      @method('POST')
                                      <button class="btn btn-secondary"> 
                                      <i class="fa fa-trash-restore"></i> 
                                      </button>
                                  </form> 

                                  
                              </td> --}}
                              <td>
                                {{-- <a href="" 
                                    class="btn btn-success">
                                    <i class="fa fa-eye"></i>
                                </a> --}}

                                <a href="{{ route('users-customer.edit', $item->id)}}" 
                                    class="btn btn-info">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                                
                                

                                <form action="{{ route('users-customer.destroy', $item->id) }}"
                                    method="POST" class="d-inline" id="data-{{ $item->id }}">
                                    @csrf
                                    @method('delete')
                                </form>
                                <button class="btn btn-danger" onclick="deleteRow( {{ $item->id }} )" > 
                                <i class="fa fa-trash"></i> 
                                </button>
                                
                                
                                {{-- <form action="{{ route('users-customer.restore')}}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('POST')
                                    <button class="btn btn-secondary"> 
                                    <i class="fa fa-trash-restore"></i> 
                                    </button>
                                </form>  --}}
                              </td>
                            </tr>
                            @php
                                $s++; 
                            @endphp
                          
                          @endif
                      @empty
                      <td colspan="7" class="text-center">
                          Empty
                      </td>                                
                      @endforelse
                  </tbody>
              </table>
          </div>
      </div> 
        <div class="card-footer bg-whitesmoke">
          {{--  --}}
        </div>
      </div>
    </div>
  </section>
  </div>
@endsection