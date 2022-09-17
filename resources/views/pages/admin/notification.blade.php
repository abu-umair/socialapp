@extends('layouts.admin')
@section('title','View Notification')
@section('content')
<div class="main-content">
  <section class="section">
    {{-- <div class="section-header">
        <h1>Partners</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a >Services</a></div>
              <div class="breadcrumb-item"><a >Groomers</a></div>
              
            </div>
        </div>
      </div> --}}

    <div class="section-body">
      {{-- <h2 class="section-title">This is Example Page</h2>
      <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
      <div class="card">
        
        
        <div class="card-body">
          <div class="table-responsive">
                      @php
                          $s=1;                                                   
                      @endphp
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                          </tr>
                          <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                          </tr>
                          <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                          </tr>
                        </tbody>
                      </table>
                    
                    
                    {{-- @empty
                    <td colspan="7" class="text-center">
                        Empty
                    </td>                                 --}}
          </div>
      </div> 
        <div class="card-footer bg-whitesmoke">
          
        </div>
      </div>
    </div>
  </section>
  </div>
@endsection