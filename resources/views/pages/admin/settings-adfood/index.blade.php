@extends('layouts.admin')
@section('title','Settings')
@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Settings</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active">Settings</div>
      </div>
    </div>

    <div class="section-body">
      {{-- <h2 class="section-title">Overview</h2>
      <p class="section-lead">
        Organize and adjust all settings about this site.
      </p> --}}

      <div class="row">
        <div class="col-lg-6">
          <div class="card card-large-icons">
            <div class="card-icon bg-primary text-white">
              <i class="fas fa-s"></i>
            </div>
            <div class="card-body">
              <h4>Credit</h4>
              <p>In the construction of this backend using the free template <a href="https://getstisla.com">Stisla</a> </p>
              <a href="https://getstisla.com" class="card-cta">Template <i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
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