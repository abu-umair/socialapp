@extends('layouts.admin')
@section('title','Content')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Contents</h1>
      <div class="section-header-breadcrumb">
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a >Contents</a></div>
            
          </div>
      </div>
    </div>

    <div class="section-body">
      {{-- <h2 class="section-title">This is Example Page</h2>
      <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
      <div class="card">
        <div class="card-header d-sm-flex align-items-center justify-content-between ">
          <h4>Contents</h4>
          <a href="{{ route('content.create')}}"
           class="btn btn-sm btn-primary shadow-sm rounded">
           <i class="fas fa-plus fa-sm text-white-50"></i>
           Add Content
            </a>     
            
                 
        </div>
        
        <div class="card-body">
          <div class="table-responsive">
              <table class="table table-striped" id="mytable" width="100%" collspacing="0">
                  <thead>
                      <tr>
                          <th>No</th>
                          {{-- <th>Id</th>                           --}}
                          <th>Url</th>
                          {{-- <th>Title Banner</th> --}}
                          <th>Title</th>                          
                          <th>Content</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @php
                          $s=1;                                                   
                      @endphp
                      @forelse ($items as $item)                      
                          <tr>
                              <td>{{ $s}}</td>
                              
                                <td>
                                    <img src="{!!$item->url ? Storage::url($item->url) : url('backend/assets/img/news/img13.jpg') !!}" class="box-img mr-1 border-bottom" width="100">
                                  
                                </td>
                                {{-- <td>{{ $item->title_banner }}</td> --}}
                                <td>{{ $item->title }}</td>
                              <td>{{ $item->isi }}</td>
                              <td width="13%">
                                {{-- <a href="" 
                                    class="btn btn-success">
                                    <i class="fa fa-eye"></i>
                                </a> --}}

                                <a href="{{ route('content.edit', $item->id)}}" 
                                    class="btn btn-info">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                                
                                

                                <form action="{{ route('content.destroy', $item->id) }}"
                                    method="POST" class="d-inline" id="data-{{ $item->id }}">
                                    @csrf
                                    @method('delete')
                                </form>
                                <button class="btn btn-danger" onclick="deleteRow( {{ $item->id }} )" > 
                                <i class="fa fa-trash"></i> 
                                </button>
                                
                                
                                {{-- <form action="{{ route('content.restore')}}"
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