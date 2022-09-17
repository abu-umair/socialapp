@extends('layouts.admin')
@section('title','Appointments - Ongoing')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Partners</h1>
      <div class="section-header-breadcrumb">
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a >Appointments</a></div>
            <div class="breadcrumb-item"><a >History</a></div>
            
          </div>
      </div>
    </div>

    <div class="section-body">
      {{-- <h2 class="section-title">This is Example Page</h2>
      <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
      <div class="card">
        <div class="card-header d-sm-flex align-items-center justify-content-between ">
          <h1 class="h3 mb-0 text-gray-800">Histories</h1>
          <a href="{{ route('appointments-ongoing.create')}}"
           class="btn btn-sm btn-primary shadow-sm rounded">
           <i class="fas fa-plus fa-sm text-white-50"></i>
           Tamabah Booking
            </a>          
        </div>
        
        <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="table_id" width="100%" collspacing="0">
                  <thead>
                      <tr>
                          {{-- <th>Id</th>                           --}}
                          <th class="text-left">No
                        </th>
                        <th>Customers</th>
                        <th>Appointments</th>
                        <th>Jadwal</th>
                        <th>Metode Layanan</th>
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
                              <td>
                                <a href="{{route('users-customer.profile',$item->customer->id)}}" class=""><img src="{!!$item->customer->foto ? Storage::url($item->customer->foto) : url('backend/assets/img/avatar/avatar-1.png') !!}" alt="avatar" class="img-thumbnail mr-1" width="35">{{ $item->customer == true ? $item->user->name : 'Telah Dihapus' }}</a>  
                                </td>                              
                                <td>
                                  @if ($item->doctor == true && $item->groomer == false)
                                  {{-- {{ $item->doctor->name }} --}}
                                  <a href="{{route('services-doctor.profile',$item->doctor->id)}}" class="font-weight-600"><img src="{!!$item->doctor->foto ? Storage::url($item->doctor->foto) : url('backend/assets/img/avatar/avatar-1.png') !!}" alt="avatar" class="img-thumbnail mr-1" width="35">{{ $item->doctor->name}}</a> 
                                  
  
                                  @elseif(($item->doctor == false && $item->groomer == true))
                                  {{-- Petshop --}}
                                  <a href="{{route('services-groomer.profile',$item->groomer->id)}}" class="font-weight-600"><img src="{!!$item->groomer->foto ? Storage::url($item->groomer->foto) : url('backend/assets/img/avatar/avatar-1.png') !!}" alt="avatar" class="img-thumbnail mr-1" width="35">
                                  {{ $item->groomer->name }}</a>
                                  
                                  @elseif(($item->doctor == false && $item->groomer == false))
                                  {{-- Petshop --}}
                                  <a href="{{route('appointments-ongoing.index')}}" class=""><img src="{{ url('backend/assets/img/avatar/avatar-4.png')}}" alt="avatar" class="rounded-circle mr-1" width="35">
                                  Doctor & Groomer tidak di pilih / dihapus</a>
  
                                  @elseif(($item->doctor == true && $item->groomer == true))
                                  {{-- Petshop --}}
                                  <a href="{{route('appointments-ongoing.index')}}" class=""><img src="{{ url('backend/assets/img/avatar/avatar-4.png')}}" alt="avatar" class="rounded-circle mr-1" width="35">
                                  Doctor & Groomer di pilih</a>
                                  @endif
                              </td>
                            
                              <td>
                                <div class="media-body">
                                    <div class="media-title">{{ $item->date }}</div>
                                    <div class="text-job text-muted">
                                      {{ \Carbon\Carbon::create($item->time)->format ('H:i')}} 
                                        - 
                                        {{ \Carbon\Carbon::create($item->time_akhir)->format ('H:i') }}
                                    
                                </div>
                                  
                              <td>{{ $item->metode_layanan == 1 ? 'Datang ke klinik / petshop' : 'Datang ke rumah'}}</td>
                              
                               {{-- <td>{{$item->service->title}}</td> --}}
                              <td>
                                
                              @if ($item->status == 0)
                              <div class="badge badge-secondary">Pending</div>
                              @elseif ($item->status == 1)
                              <div class="badge badge-success">Diterima</div>                                
                              @else
                              <div class="badge badge-secondary">Ditolak</div>                          
                              @endif
                                 
                              
                              </td>
                              
                              {{-- @if ($item->status == 0)
                                  <td><span class="badge badge-secondary">Tidak Aktif</span></td>
                              @else
                                  <td><span class="badge badge-info">Aktif</span></td>
                              @endif --}}
                              
                              
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
                                <button type="button" class="btn btn-icon btn-warning" data-whatever="{{$item->masalah_hewan}}" data-toggle="modal" data-target="#exampleModal">
                                  <i class="fas fa-info-circle my-1"></i>
                                </button>

                                <a href="{{ route('appointments-ongoing.edit', $item->id)}}" 
                                    class="btn btn-info">
                                    <i class="fas fa-edit my-1"></i>
                                </a>
                                @if ($item->isreviewed != 1)
                                  <a href="{{ route('score.create', $item->id)}}" 
                                    class="btn btn-success">
                                    <i class="fas fa-star-half-alt my-1"></i>
                                  </a>
                                @endif
                                
                                <form action="{{ route('appointments-history.destroy', $item->id) }}"
                                  method="POST" class="d-inline " id="data-{{ $item->id }}">
                                  @csrf
                                  @method('delete')
                              </form>
                              <button class="btn btn-danger " onclick="deleteRow( {{ $item->id }} )" > 
                              <i class="fa fa-trash my-1"></i> 
                              </button>
                                

                                {{-- <form action="{{ route('appointments-ongoing.destroy', $item->id) }}"
                                    method="POST" class="d-inline" id="data-{{ $item->id }}">
                                    @csrf
                                    @method('delete')
                                </form>
                                <button class="btn btn-danger" onclick="deleteRow( {{ $item->id }} )" > 
                                <i class="fa fa-trash"></i> 
                                </button> --}}
                                
                                
                                {{-- <form action="{{ route('appointments-ongoing.restore')}}"
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


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalTitle">Permasalahan Hewan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
            <textarea rows="20" class="d-block w-100 h-100 form-control" id="isi" disabled></textarea>
      </div>
      <div class="modal-footer">
        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> --}}
      </div>
    </div>
  </div>
</div>