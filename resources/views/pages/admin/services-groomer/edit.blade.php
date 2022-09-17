@extends('layouts.admin')
@section('title','Services - Groomers')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Partners</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a >Services</a></div>
        <div class="breadcrumb-item"><a >Groomers</a></div>
        <div class="breadcrumb-item">Edit Groomers</div>
      </div>
    </div>

    <div class="section-body">
      {{-- <h2 class="section-title">This is Example Page</h2>
      <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
      <div class="card">
        <div class="card-header d-sm-flex align-items-center justify-content-between ">
          <h1 class="h3 mb-0 text-gray-800">Edit Groomers</h1>
          
            </a>          
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>                            
        @endif
        
          
            <div class="card-body">
                <form action="{{ route('services-groomer.update', $item->id) }}" method="POST" enctype="multipart/form-data">{{-- untuk menyimpan sebuah data menggunakan functioan 'store' --}}
                    @csrf{{-- setiap buat form pakai @csrf --}}
                    @method('PUT')
                    <div class="form-group">
                      <label for="foto">Foto Profile</label>
                      <input type="file" name="foto" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $item->name }}">
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" name="kategori" placeholder="Kategori" value="{{ $item->kategori }}">
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <textarea name="lokasi" rows="10" class="d-block w-100 h-100 form-control">{{ $item->lokasi }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="lat">Latitude</label>
                      <input type="text" class="form-control" name="lat" placeholder="Latitude" value="{{ $item->lat }}">
                    </div>
                    <div class="form-group">
                      <label for="long">Longitude</label>
                      <input type="text" class="form-control" name="long" placeholder="Longitude" value="{{ $item->long }}">
                    <div class="form-group">
                        <label for="transaksi">Transaksi</label>
                        <input type="number" class="form-control" name="transaksi" placeholder="Transaksi" value="{{ $item->transaksi }}">
                    </div>
                    
                    <div class="form-group">
                      <label for="harga">Harga</label>
                      <input type="number" class="form-control" name="harga" placeholder="Harga / Konsultasi" value="{{ $item->harga }}">
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="pengalaman">Pengalaman</label>
                          <input type="number" class="form-control" name="pengalaman" placeholder="Pengalaman" value="{{ $item->pengalaman }}">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label for="jangka">Jangka</label>
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
                          <select name="jangka" class="form-control" required>
                              <option value="{{$item->jangka}}">Jangan Diubah ( {{$itemJangka}} )</option>                          
                              <option value="0">Minggu</option>
                              <option value="1">Bulan</option>
                              <option value="2">Tahun</option>                                                      
                          </select>
                      </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="status">Status</label>
                      <select name="status" class="form-control" required>
                          <option value="{{$item->status}}">Jangan Diubah ( {{$item->status==0 ? 'Tidak Aktif' : 'Aktif'}} )</option>                          
                          <option value="1">Aktif</option>
                          <option value="0">Tidak Aktif</option>                                                      
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="tentang">About</label>
                      <textarea name="tentang" rows="10" class="d-block w-100 h-100 form-control">{{ $item->tentang }}</textarea>
                    </div>
                    <table class="table ml-n4" id="dynamicAddRemove">
                      <tr>
                          <th>Layanan</th>
                          <th>Action</th>
                      </tr>
                      {{-- layanan --}}
                        @php
                        $i=0;
                        @endphp
                        @forelse ($layanan as $isilayanan)
                          <tr>
                            <td><input type="text" name="layanan[{{$i}}]" placeholder="Layanan" class="form-control" value="{{$isilayanan->title}}"/></td>
                            @if ($i > 0)
                              <td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td>
                            @else
                              <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Add Layanan</button></td>                              
                            @endif
                            
                          </tr>
                          @php
                              $i++
                          @endphp
                        @empty
                        <tr>
                          <td><input type="text" name="layanan[0]" placeholder="Layanan" class="form-control" />
                          </td>
                          <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Add Layanan</button></td>
                        </tr>
                        @endforelse
                    </table>
                    <button type="submit" class="btn btn-primary btn-block">
                        Ubah
                    </button>
                </form>
            </div>
        
      
        <div class="card-footer bg-whitesmoke">
          
        </div>
      </div>
    </div>
  </section>
  </div>
@endsection
@push('addon-script')
<script type="text/javascript">
  var i = {{$i}};
  $("#dynamic-ar").click(function () {
      ++i;
      $("#dynamicAddRemove").append('<tr><td><input type="text" name="layanan[' + i +
          ']" placeholder="layanan" class="form-control" /></td><td><button type="button" class="btn btn-outline-danger remove-input-field">Delete</button></td></tr>'
          );
  });
  $(document).on('click', '.remove-input-field', function () {
      $(this).parents('tr').remove();
  });
</script>
@endpush