@extends('layouts.admin')
@section('title','Services - Groomers')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
        <h1>Partners</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a >Services</a></div>
              <div class="breadcrumb-item"><a >Groomers</a></div>
              
            </div>
        </div>
      </div>

    <div class="section-body">
      {{-- <h2 class="section-title">This is Example Page</h2>
      <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
      <div class="card">
        <div class="card-header d-sm-flex align-items-center justify-content-between ">
          <h1 class="h3 mb-0 text-gray-800">Groomers</h1>
          <a href="{{ route('services-groomer.create')}}"
           class="btn btn-sm btn-primary shadow-sm rounded">
           <i class="fas fa-plus fa-sm text-white-50"></i>
           Tambah Groomer
            </a>          
        </div>
        
        <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="table_id" width="100%" collspacing="0">
                  <thead>
                      <tr>
                          <th>No</th>
                          {{-- <th>Id</th>                           --}}
                          <th>Name</th>                          
                          <th>Kategori</th>
                          <th>Lokasi </th>
                          <th>Transaksi</th>
                          
                          <th>Harga</th>
                          <th>Pengalaman</th>
                          <th>Status</th>
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
                              {{-- <td>{{ $item->id }}</td>                               --}}
                              <td><a href="{{route('services-groomer.profile',$item->id)}}" class="font-weight-600"><img src="{!!$item->foto ? Storage::url($item->foto) : url('backend/assets/img/avatar/avatar-1.png') !!}" alt="avatar" class="img-thumbnail mr-1" width="35">{{ $item->name }}</a></td>                              
                              <td>{{ $item->kategori }}</td>
                              <td>{{ $item->lokasi}}</td>
                              <td><a href="{{route('transactions-groomer',$item->id)}}" class="font-weight-600">{{ $item->transaksi}} Transaksi</a></td>
                              
                              <td>Rp. {{number_format($item->harga) ?? 'Tarif Null'}}</td> 
                              @php   
                              if ($item->jangka == 0){
                                  $itemJangka = 'Minggu';
                              }
                              elseif($item->jangka == 1){
                                $itemJangka = 'Bulan';
                              }
                                else {
                                $itemJangka = 'Tahun';
                                }
                             @endphp
                             
                             <td>{!! $item->pengalaman .' '.$itemJangka!!}</td>
                              @if ($item->status == 0)
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

                                <a href="{{ route('services-groomer.edit', $item->id)}}" 
                                    class="btn btn-info">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                                
                                

                                <form action="{{ route('services-groomer.destroy', $item->id) }}"
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
                      <td colspan="10" class="text-center">
                          Empty
                      </td>                                
                      @endforelse
                  </tbody>
              </table>
          </div>
      </div> 
      <div class="card-footer bg-whitesmoke">
        <a href="{{ route('services.index')}}"
        class="btn btn-sm btn-primary shadow-sm rounded">
        <i class="fas fa-plus fa-sm text-white-50"></i>
        Layanan
         </a>    
        </div>
        </div>
      </div>
    </div>
  </section>
  </div>
@endsection