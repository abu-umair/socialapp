@extends('layouts.admin')
@section('title','Reservations Rate')
@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Rate Reservation</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item "><a >Merchants</a></div>
              <div class="breadcrumb-item active"><a >Reservations</a></div>
            </div>
        </div>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-header">
            <h4>Rate Reservation</h4>
          </div>
          <div class="card-body">
            @if ($errors->any()) {{-- jika ada permasalahan/error --}}
              <div class="alert alert-danger"> {{-- maka muncul div error --}}
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>                        
                      @endforeach
                  </ul>
              </div>        
            @endif
            @if(session('error'))                    
                    <div class="alert alert-danger"> 
                    <ul>
                        <li>{{ session('error') }}</li>
                    </ul>
                </div> 
            @endif
            @if(session()->has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{{ session()->get('success') }}</li>
                    </ul>
                </div>
            @endif
            <form action="{{ route('reservations_rate_update', $item->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="">Rate</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-gradient-success">
                      <span>
                        <i class="fas fa-star"></i>
                      </span>
                    </span>
                  </div>
                  <select name="rate" class="form-control">
                    @if ($item->rate)
                    <option value="{{$item->rate}}">-- {{$item->rate}} --</option>
                    @endif
                    <option value="0">-</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label>Review</label>
                @if ($item->ulasan_rate)
                <textarea name="ulasan_rate" rows="5" class="form-control d-block w-100 h-100">{{$item->ulasan_rate}}</textarea>
                @else
                <textarea name="ulasan_rate" rows="5" class="form-control d-block w-100 h-100">{{ old('ulasan_rate') }}</textarea>    
                @endif
              </div>
              <div class="form-group">
                <label for="pothos_coment">Image Rate</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-folder-open"></i></span>
                </div>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="pothos_coment" id="inputGroupFile01">
                  <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
              </div>
              </div>
              <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-plus fa-sm text-white-50"></i>
                Rate
              </button>
          </form>
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