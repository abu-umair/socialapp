@extends('layouts.admin')
@section('title','Layanan')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
          <h1>Partners</h1>
          <div class="section-header-breadcrumb">
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a >Services</a></div>
                <div class="breadcrumb-item"><a >Layanan</a></div>
                
              </div>
          </div>
        </div>
  
      <div class="section-body">
        {{-- <h2 class="section-title">This is Example Page</h2>
        <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
        <div class="card">
          <div class="card-header d-sm-flex align-items-center justify-content-between ">
            <h1 class="h3 mb-0 text-gray-800">Layanan</h1>
            
            <a href="{{ route('services.create')}}"
             class="btn btn-sm btn-primary shadow-sm rounded">
             <i class="fas fa-plus fa-sm text-white-50"></i>
             Tambah Layanan
              </a>          
          </div>
          
          <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table_id" width="100%" collspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            {{-- <th>Id</th> --}}
                            <th>Title</th>
                            <th>Price</th>
                            <th>note</th>
                            {{-- <th>Email Veryified </th> --}}
                            {{-- <th>Password</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $s=1;                                                   
                        @endphp
                        @forelse ($items as $item)                      
                            <tr>
                                <td>{{$s}}</td>
                                {{-- <td>{{ $item->id }}</td> --}}
                                <td>{{ $item->title }}</td>
                                {{-- <td>Relasi table customer</td> --}}

                                <td>{{ $item->price }}</td>
                                <td>{{ $item->note }}</td>
                                {{-- <td>{{ $item->email_verified_at   }}</td> --}}
                                {{-- <td>{{ $item->password }}</td> --}}
                                
                                <td>
                                  {{-- <a href="" 
                                      class="btn btn-success">
                                      <i class="fa fa-eye"></i>
                                  </a> --}}
  
                                  <a href="{{ route('services.edit', $item->id)}}" 
                                      class="btn btn-info">
                                      <i class="fa fa-pencil-alt"></i>
                                  </a>
                                  
                                  
  
                                  <form action="{{ route('services.destroy', $item->id) }}"
                                      method="POST" class="d-inline" id="data-{{ $item->id }}">
                                      @csrf
                                      @method('delete')
                                  </form>
                                  <button class="btn btn-danger" onclick="deleteRow( {{ $item->id }} )" > 
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
                            </tr>
                            @php
                                $s++; 
                            @endphp
                            
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
            
          </div>
        </div>
      </div>
    </section>
    </div>
  @endsection