@extends('layouts.admin')
@section('title','Services - Doctor')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Partners</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a >Services</a></div>
        <div class="breadcrumb-item"><a >Doctors</a></div>
        <div class="breadcrumb-item">Input Doctors</div>
      </div>
    </div>

    <div class="section-body">
      
      <div class="card">
        <div class="card-header d-sm-flex align-items-center justify-content-between ">
          <h1 class="h3 mb-0 text-gray-800">Tambah Doctor</h1>
          
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
                <form action="{{ route('services-doctor.store') }}" method="POST" enctype="multipart/form-data">{{-- untuk menyimpan sebuah data menggunakan functioan 'store' --}}
                    @csrf{{-- setiap buat form pakai @csrf --}}
                    <div class="form-group">
                      <label for="foto">Foto Profile</label>
                      <input type="file" name="foto" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" name="kategori" placeholder="Kategori" value="{{ old('kategori') }}">
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <textarea name="lokasi" rows="10" class="d-block w-100 h-100 form-control">{{ old('lokasi') }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="lat">Latitude</label>
                      <input type="text" class="form-control" name="lat" placeholder="Latitude" value="{{ old('lat') }}">
                    </div>
                    <div class="form-group">
                      <label for="long">Longitude</label>
                      <input type="text" class="form-control" name="long" placeholder="Longitude" value="{{ old('long') }}">
                    </div>
                    <div class="form-group">
                        <label for="transaksi">Transaksi</label>
                        <input type="number" class="form-control" name="transaksi" placeholder="Transaksi" value="{{ old('transaksi') }}">
                    </div>
                    {{-- <div class="form-group">
                      <label for="layanan">Layanan</label>
                      <input type="text" class="form-control" name="layanan" placeholder="Kategori" value="{{ old('layanan') }}">
                  </div> --}}
                  
                    <div class="form-group">
                      <label for="harga">Harga \ Konsultasi</label>
                      <input type="number" class="form-control" name="harga" placeholder="Harga" value="{{ old('harga') }}">
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="pengalaman">Pengalaman</label>
                          <input type="number" class="form-control" name="pengalaman" placeholder="Pengalaman" value="{{ old('pengalaman') }}">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label for="jangka">Jangka</label>
                          <select name="jangka" class="form-control" required>
                              <option value="">Pilih</option>                          
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
                          <option value="">Pilih Status</option>                          
                          <option value="1">Aktif</option>
                          <option value="0">Tidak Aktif</option>                                                      
                      </select>
                  </div>
                  <div class="form-group">
                    <label for="tentang">About</label>
                    <textarea name="tentang" rows="10" class="d-block w-100 h-100 form-control" required>{{ old('tentang') }}</textarea>
                  </div>

                  <table class="table ml-n4" id="dynamicAddRemove">
                    <tr>
                        <th>Layanan</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td><input type="text" name="layanan[0]" placeholder="Layanan" class="form-control" />
                        </td>
                        <td><button type="button" name="add" id="dynamic-ar" class="btn btn-outline-primary">Add Layanan</button></td>
                    </tr>
                  </table>

                    <button type="submit" class="btn btn-primary btn-block">
                        Simpan
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
  var i = 0;
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