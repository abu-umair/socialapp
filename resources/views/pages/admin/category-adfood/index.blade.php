@extends('layouts.admin')
@section('title','Categories')
@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Categories</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item "><a >Customers</a></div>
              <div class="breadcrumb-item active"><a >Categories</a></div>
            </div>
        </div>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-header d-sm-flex align-items-center justify-content-between">
            <h4>Categories</h4>
            <a href="{{ route('category-adfood.create')}}"
           class="btn btn-sm btn-primary shadow-sm rounded">
           <i class="fas fa-plus fa-sm text-white-50"></i>
           Category
            </a>        
          </div>
          <div class="card-body">
            <div class="table-responsive">
                <table id="mytable" class="table table-striped" style="width:100%">
                  <thead class="">
                    <tr>
                        <th>#</th>
                        <th style="width: 30%">Image</th>
                        <th>Category</th>
                        
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
                        
                          <img alt="image" src="{!!$item->foto ? Storage::url($item->foto) : url('backend/assets/img/avatar/menus_restaurant.png') !!}" class="img-thumbnail" width="100" data-toggle="title" title="">
                       
                      </td>
                      <td><span class="badge badge-info">{{ $item->category }}</span></td>
                      <td>
                        {{-- <a href="" 
                                  class="btn btn-success">
                                  <i class="fa fa-eye"></i>
                              </a> --}}

                              <a href="{{ route('category-adfood.edit', $item->id)}}" 
                                class="btn btn-info">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            
                            

                            {{-- <form action="{{ route('category-adfood.destroy', $item->id) }}"
                                method="POST" class="d-inline" id="data-{{ $item->id }}">
                                @csrf
                                @method('delete')
                            </form>
                            <button class="btn btn-warning" onclick="deleteRow( {{ $item->id }} )" >
                              <i class="fa-solid fa-spinner"></i>
                            </button> --}}

                            <form action="{{ route('category_adfood_delete', $item->id) }}"
                              method="POST" class="d-inline" id="dataPermanen-{{ $item->id }}">
                              @csrf
                              @method('delete')
                            </form>
                            <button class="btn btn-danger" onclick="deleteRowPermanen( {{ $item->id }} )" > 
                              <i class="fa fa-trash"></i> 
                            </button>
                            
                            
                            {{-- <form action="{{ route('category-adfood_delete')}}"
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