@extends('layouts.admin')
@section('title','History Notifications')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Partners</h1>
      <div class="section-header-breadcrumb">
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a >Services</a></div>
            <div class="breadcrumb-item"><a >Content</a></div>
            
          </div>
      </div>
    </div>

    <div class="section-body">
      {{-- <h2 class="section-title">This is Example Page</h2>
      <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
      <div class="card">
        <div class="card-header d-sm-flex align-items-center justify-content-between ">
          <h1 class="h3 mb-0 text-gray-800">History Notifications</h1>
          {{-- <a href="{{ route('content.create')}}"
           class="btn btn-sm btn-primary shadow-sm rounded">
           <i class="fas fa-plus fa-sm text-white-50"></i>
           Tambah Content
            </a>           --}}
        </div>
        
        <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="mytable" width="100%" collspacing="0">
                  <thead>
                      <tr>
                          <th>No</th>
                          
                          <th>Title</th>                          
                          <th>Body</th>
                          <th>Date Create</th>
                          {{-- <th>Action</th> --}}
                      </tr>
                  </thead>
                  <tbody>
                      @php
                          $s=1;                                                   
                      @endphp
                      @forelse ($items as $item)                      
                          <tr>
                              <td>{{ $s}}</td>  
                              <td>{{ $item->title }}</td>
                              <td>{{ $item->body }}</td>
                              <td>{{\Carbon\Carbon::parse( $item->created_at)->format('d F y ( H:i )') }}</td>
                          </tr>
                          @php
                              $s++; 
                          @endphp
                          
                      @empty
                      <td colspan="7" class="text-center">
                          Data Kosong
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