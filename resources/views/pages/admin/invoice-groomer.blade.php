@extends('layouts.admin')
@section('title','Invoice Groomer')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Invoice</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">Invoice</div>
      </div>
    </div>

    <div class="section-body">
      <div class="invoice">
        <div class="invoice-print">
          <div class="row">
            <div class="col-lg-12">
              <div class="invoice-title">
                <h2>Invoice</h2>
                @foreach ($items as $item)
                <div class="invoice-number">Order {{$item->id_unique}}</div>
                @endforeach
              </div>
              <hr>
              <div class="row">
                <div class="col-md-6">
                  <address>
                    <strong>Billed To:</strong><br>
                      {{$item->user->name}}<br>
                      {{$item->user->email}}<br>
                      {{$item->user->phone}}
                      
                  </address>
                </div>
                <div class="col-md-6 text-md-right">
                  <address>
                    <strong>Shipped To:</strong><br>
                    {{$item->groomer->name ?? $item->doctor->name}}<br>
                    {{$item->groomer->kategori ?? $item->doctor->kategori}}<br>
                    {{$item->groomer->lokasi ?? $item->doctor->lokasi}}
                    
                  </address>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <address>
                    <strong>Payment Method:</strong><br>
                    Bayar Ditempat<br>
                    
                  </address>
                </div>
                <div class="col-md-6 text-md-right">
                  <address>
                    <strong>Order Date:</strong><br>
                    
                    {{\Carbon\Carbon::parse($item->date)->format('d F y')}}
                  </address>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row mt-4">
            <div class="col-md-12">
              <div class="section-title">Order Summary</div>
              {{-- <p class="section-lead">All items here cannot be deleted.</p> --}}
              <div class="table-responsive">
                <table class="table table-striped table-hover table-md">
                  <tbody><tr>
                    {{-- <th data-width="40" style="width: 40px;">#</th> --}}
                    <th>Customer</th>
                    <th>Appointment</th>
                    <th class="text-center">Schedule</th>
                    <th class="text-right">Service Method</th>
                    {{-- <th class="text-right">Status</th> --}}
                  </tr>
                  <tr>
                    <td>{{$item->user->name}}</td>
                    <td>{{$item->groomer->name ?? $item->doctor->name}}</td>
                    <td class="text-center">{{\Carbon\Carbon::parse($item->date)->format('d F y')}} <br>
                      <small>{{ \Carbon\Carbon::create($item->time)->format ('H:i')}} 
                        - 
                        {{ \Carbon\Carbon::create($item->time_akhir)->format ('H:i') }}</small>
                    </td>
                    <td class="text-right">{{ $item->metode_layanan == 1 ? 'Datang ke klinik / petshop' : 'Datang ke rumah'}}</td>
                    {{-- <td class="text-right">{{$item->status}}</td> --}}
                    
                  </tr>
                  {{-- <tr>
                    <td>1</td>
                    <td>Mouse Wireless</td>
                    <td class="text-center">$10.99</td>
                    <td class="text-center">1</td>
                    <td class="text-right">$10.99</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Keyboard Wireless</td>
                    <td class="text-center">$20.00</td>
                    <td class="text-center">3</td>
                    <td class="text-right">$60.00</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Headphone Blitz TDR-3000</td>
                    <td class="text-center">$600.00</td>
                    <td class="text-center">1</td>
                    <td class="text-right">$600.00</td>
                  </tr> --}}
                </tbody></table>
              </div>
              <div class="row mt-4">
                {{-- <div class="col-lg-8">
                  <div class="section-title">Payment Method</div>
                  <p class="section-lead">The payment method that we provide is to make it easier for you to pay invoices.</p>
                  <div class="images">
                    <img src="assets/img/visa.png" alt="visa">
                    <img src="assets/img/jcb.png" alt="jcb">
                    <img src="assets/img/mastercard.png" alt="mastercard">
                    <img src="assets/img/paypal.png" alt="paypal">
                  </div>
                </div> --}}
                <div class="col-lg-4 text-right ml-auto">
                  <div class="invoice-detail-item">
                    <div class="invoice-detail-name">Subtotal</div>
                    <div class="invoice-detail-value">Rp. 
                      {{number_format($item->groomer->harga ?? $item->doctor->harga)}}</div>
                  </div>
                  {{-- <div class="invoice-detail-item">
                    <div class="invoice-detail-name">Shipping</div>
                    <div class="invoice-detail-value">$15</div>
                  </div> --}}
                  <hr class="mt-2 mb-2">
                  <div class="invoice-detail-item">
                    <div class="invoice-detail-name">Total</div>
                    <div class="invoice-detail-value invoice-detail-value-lg">Rp. 
                      {{number_format($item->groomer->harga ?? $item->doctor->harga)}}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>
        {{-- <div class="text-md-right">
          <div class="float-lg-left mb-lg-0 mb-3">
            <button class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i> Process Payment</button>
            <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Cancel</button>
          </div>
          <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
        </div> --}}
      </div>
    </div>
  </section>
</div>

@endsection
 









