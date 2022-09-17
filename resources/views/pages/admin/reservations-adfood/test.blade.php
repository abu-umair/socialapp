@extends('layouts.admin')

@section('test','Test saja')    

@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
      
      <div class="section-body">
        <div class="card">
          <p>{{ $items }}</p>
          <br>
          <p>{{ $avg }}</p>
        </div>
      </div>
      
      
  </section>
</div>
@endsection

@push('prepend-script')
    
@endpush

@push('addon-script')


  
@endpush