@extends('layouts.admin')
@section('title','Transaction Doctors')
@section('content')
<div class="main-content">
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Transactions</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="table_id" width="100%" collspacing="0">
                <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Appointment</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @forelse ($items as $item)
                    <tr>
                      <td>{{$item->id_unique}}</td>
                      <td>
                        
                          @if ($item->doctor != null && $item->groomer == null)
                            <a class="font-weight-600 ">
                            <img src="{!!$item->doctor->foto ? Storage::url($item->doctor->foto) : url('backend/assets/img/avatar/avatar-1.png') !!}" alt="avatar" class="img-thumbnail mr-1" width="35">
                            {{$item->doctor->name}} (Doctor)
                            </a>
                              
                          @elseif($item->doctor == null && $item->groomer != null)
                            <a class="font-weight-600 ">
                            <img src="{!!$item->groomer->foto ? Storage::url($item->groomer->foto) : url('backend/assets/img/avatar/avatar-1.png') !!}" alt="avatar" class="img-thumbnail mr-1" width="35">
                            {{$item->groomer->name}} (Groomer)
                            </a>
                          @elseif($item->groomer != null && $item->doctor != null)
                          <a class="font-weight-600 ">
                            <img src="{!!url('backend/assets/img/avatar/avatar-1.png') !!}" alt="avatar" class="img-thumbnail mr-1" width="35">
                            Groomer & Doctor Terpilih
                            </a>
                          @else
                          <a class="font-weight-600 ">
                            <img src="{!!url('backend/assets/img/avatar/avatar-1.png') !!}" alt="avatar" class="img-thumbnail mr-1" width="35">
                            Groomer & Doctor Tidak Terpilih
                            </a>
                          @endif
                          
                      </td>
                      <td>{{$item->date}}</td>
                      <td>Rp. {{number_format($item->harga) ?? 'Tarif Null'}}</td>
                      <td>
                        {!!$item->status == 1 ? '<div class="badge badge-success">Active</div>' : '<div class="badge badge-secondary">Non Active</div>'!!}
                        </td>
                      <td><a href="{{route('invoice-doctor',$item->id)}}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-print"></i> Invoice</a></td>
                      {{-- <td><a href="" class="btn btn-icon icon-left btn-primary"><i class="fas fa-print"></i> Invoice</a></td> --}}
                    </tr>
                @empty
                      <td colspan="7" class="text-center text-muted">
                          Empty
                      </td>                                
                @endforelse
                </tbody>
                {{-- <tr>
                  <td>12343242</td>
                  <td>
                    <a href="#" class="font-weight-600"><img src="../assets/img/avatar/avatar-1.png" alt="avatar" class="rounded-circle mr-1" width="35">  Bagus Dwi Cahya</a>
                  </td>
                  <td>2017-01-09</td>
                  <td>Rp. 200.000</td>
                  <td><div class="badge badge-success">Active</div></td>
                  <td><a href="#" class="btn btn-icon icon-left btn-primary"><i class="fas fa-print"></i> Invoice</a></td>
                </tr> <tr>
                  <td>15412323</td>
                  <td>
                    <a href="#" class="font-weight-600"><img src="../assets/img/avatar/avatar-1.png" alt="avatar" class="rounded-circle mr-1" width="35">  Bagus Dwi Cahya</a>
                  </td>
                  <td>2017-01-09</td>
                  <td>Rp. 200.000</td>
                  <td><div class="badge badge-success">Active</div></td>
                  <td><a href="#" class="btn btn-icon icon-left btn-primary"><i class="fas fa-print"></i> Invoice</a></td>
                </tr> <tr>
                  <td>1664642</td>
                  <td>
                    <a href="#" class="font-weight-600"><img src="../assets/img/avatar/avatar-1.png" alt="avatar" class="rounded-circle mr-1" width="35">  Bagus Dwi Cahya</a>
                  </td>
                  <td>2017-01-09</td>
                  <td>Rp. 200.000</td>
                  <td><div class="badge badge-success">Active</div></td>
                  <td><a href="#" class="btn btn-icon icon-left btn-primary"><i class="fas fa-print"></i> Invoice</a></td>
                </tr> --}}
              </table>
              <div class="card-footer bg-whitesmoke">
          
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
 









