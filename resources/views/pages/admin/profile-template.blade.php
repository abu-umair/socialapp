@extends('layouts.admin')
@section('title','Profile')
@section('content')
<div class="main-content">
  <div class="section-body">
  

  <div class="row mt-sm-4">
    <div class="col-12 col-md-12 col-lg-5">
      <div class="card profile-widget">
        <div class="profile-widget-header mt-3">
          <img alt="image" src="{{url('backend/assets/img/avatar/avatar-1.png')}}" class="rounded-circle profile-widget-picture">
          <div class="profile-widget-items">
            <div class="profile-widget-item">
              <div class="profile-widget-item-label">Pengalaman</div>
              @php   
               if ($customer->jangka == 0){
                   $itemJangka = 'Minggu';
               }
               elseif($customer->jangka == 1){
                 $itemJangka = 'Bulan';
               }
                 else {
                 $itemJangka = 'Tahun';
                 }
              @endphp
              <div class="profile-widget-item-value">{!!$customer->pengalaman.' '.$itemJangka!!}</div>
            </div>
            <div class="profile-widget-item">
              <div class="profile-widget-item-label">Tarif</div>
              <div class="profile-widget-item-value">Rp. 50.000</div>
            </div>
            {{-- <div class="profile-widget-item">
              <div class="profile-widget-item-label">Following</div>
              <div class="profile-widget-item-value">2,1K</div>
            </div> --}}
          </div>
        </div>
        <div class="profile-widget-description">
          <div class="profile-widget-name"><h5 class="d-inline">{{$customer->name}}</h5> <div class="text-muted d-inline font-weight-normal"><div class="slash"></div> Customer</div></div>
          <p class="font-weight-normal">
            Ujang maman is a superhero name in <b>Indonesia</b>, especially in my family. He is not a fictional character but an original hero in my family, a hero for his children and for his wife. So, I use the name as a user in this template. Not a tribute, I'm just bored with <b>'John Doe'</b>.
          </p>
          
        </div>
        {{-- <div class="card-footer text-center">
          <div class="font-weight-bold mb-2">Follow Ujang On</div>
          <a href="#" class="btn btn-social-icon btn-facebook mr-1">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" class="btn btn-social-icon btn-twitter mr-1">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" class="btn btn-social-icon btn-github mr-1">
            <i class="fab fa-github"></i>
          </a>
          <a href="#" class="btn btn-social-icon btn-instagram">
            <i class="fab fa-instagram"></i>
          </a>
        </div> --}}
      </div>
    </div>
    <div class="col-12 col-md-12 col-lg-7">
      <div class="card mt-4">
        <form method="post" class="needs-validation" novalidate="">
          <div class="card-header">
            <h4>Jejak Transaksi</h4>
          </div>
          <div class="card-body">
            <table class="table table-sm">              
              <tbody>
                @forelse ($ongoings as $ongoing)                    
                <tr class="">
                  <td><p>{{$ongoing->customer->name}} menambahkan 
                    @if ($ongoing->doctor == true || $ongoing->groomer == true)
                      {!!$ongoing->doctor ? $ongoing->doctor->name .' <span class="border-bottom">sebagai doctor</span> ' : $ongoing->groomer->name.' sebagai groomer '!!}  
                    @elseif($ongoing->doctor == false && $ongoing->groomer == false)
                      <span class="border-bottom">sebagai doctor/groomer(telah dihapus)</span>
                    @else
                      <span class="border-bottom">sebagai doctor/groomer(dipilih keduanya)</span>
                    @endif
                      hewannya dengan status 
                      {!!$ongoing->status == 1 ? '<span class="border-bottom">Completed</span>' : '<span class="border-bottom">No Completed</span>'!!}
                  </p></td>
                  @php
                      $now = \Carbon\Carbon::now();
                      $past   = $now->subMonth();
                      $future = $now->addMonth();
                      // $mydate = $now->toDateTimeString();
                      $created_at = \Carbon\Carbon::parse($ongoing->created_at);
                      $mydate = $created_at->toDateString();
                      $myTime = $created_at->toTimeString();
                      // $mytimedatetime = $created_at->toDateTimeString();
                      $covertDate = \Carbon\Carbon::createFromDate($mydate);
                      // $cobadatetime = \Carbon\Carbon::createFromDateTime($mytimedatetime);
                      $convertTime = \Carbon\Carbon::createFromTimeString($myTime);


                      //$diffHuman = $created_at->diffForHumans($past);  // 3 Months ago
                      $time = $convertTime->diffForHumans();
                      $date = $covertDate->diffForHumans();
                      //$diffHours = $created_at->diffInHours($future);  // 3 
                      //$diffMinutes = $created_at->diffInMinutes($now)   // 180

                      $difference = ($created_at->diff($now)->days < 1)
                                    ? $time : $date;
                  @endphp                  
                  <td class=" pt-2"><small class="secondary ">{{$difference}}</small></td>
                </tr>
                @empty
                      <td colspan="7" class="text-center text-muted">
                          Empty
                      </td>                                
                @endforelse
                
              </tbody>
            </table>
          </div>
          <div class="card-footer text-right">
            
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>
</div>
@endsection
















