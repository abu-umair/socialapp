@extends('layouts.admin')
@section('title','Invoice')
@push('prepend-style')
{{-- datatable --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
  <style>
    .activity-user{
      text-transform: lowercase;
    }
    .activity-user:first-letter{
      text-transform: uppercase;
    }

    .font-custom{
      text-transform: capitalize;
      display: inline-block;
    }

    .dark-mode .content-wrapper {
    /* background-color: #fff !important; */
    color: black !important;
    }
    .dark-mode .invoice {
      /* background-color: #99b3cc; */
      background-color: #EDF0DA !important;
    }
}

  </style>
@endpush
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Invoice</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Invoice</li>
            
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          {{-- <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Note:</h5>
            This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
          </div> --}}


          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4>
                  <i class="fas fa-globe"></i> Coolze, Inc.
                  <small class="float-right">Date: {{\Carbon\Carbon::create(\Carbon\Carbon::now()->toDateTimeString())->format ('d F y')}}</small>
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                From
                <address>
                  <strong>Coolze, Inc.</strong><br>
                  795 Folsom Ave, Suite 600<br>
                  San Francisco, CA 94107<br>
                  Phone: (804) 123-5432<br>
                  Email: info@almasaeedstudio.com
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                To
                <address>
                  
                  <strong >
                    <span class="font-custom">
                      {{ $item->first()->user_customer->name }}</strong><br>
                  {{ $item->first()->alamat_customer ? $item->first()->alamat_customer->address : 'Belum Ditentukan' }}<br>
                  Phone: {{ $item->first()->user_customer->phone }}<br></span>
                  Email: {{ $item->first()->user_customer->email }}
                
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <b>Invoice #{{ $item->first()->id_unique }}</b><br>
                <br>
                {{-- <b>Date Start:</b> <br>
                <b>Date End:</b> 2/22/2014<br>
                <b>Account:</b> 968-34567 --}}
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                  <tr>
                    <th>Qty</th>
                    <th>Package</th>
                    <th>Driver</th>
                    <th>Mitra</th>
                    <th>Address</th>
                    <th>Merk</th>
                    <th>Range</th>
                    <th>Time</th>
                    <th>Voucher</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php
                        $end = \Carbon\Carbon::createFromFormat('Y-m-d',$item->first()->end_date );
                        $start = \Carbon\Carbon::createFromFormat('Y-m-d',$item->first()->date );
                        $diff = $end->diffInDays($start);
                        if ($diff >= 8){
                          $week = (int)($diff / 7);
                          $selectedWeek =$week.' week more';
                        } else {
                          $selectedWeek = $diff.' day';
                        }

                        function rupiah($angka){
	
                          $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
                          return $hasil_rupiah;

                        }
                    @endphp
                  <tr>
                    <td>{{ Str::ucfirst($item->first()->qty) }}</td>
                    <td>{{ Str::ucfirst($item->first()->package->title) }} : {{ Str::ucfirst($item->first()->subpackage->deskripsi_title) }}</td>
                    <td>{{ Str::ucfirst($item->first()->driver->name) }}</td>
                    <td>{{ Str::ucfirst($item->first()->user_partner->name) }}</td>
                    <td>
                    @if ($item->first()->alamat_customer)
                      @if ($item->first()->alamat_customer->address)
                      {{ Str::ucfirst($item->first()->alamat_customer->address) }}
                      @else
                        Belum Ditentukan                          
                      @endif   
                    @else
                    Belum Ditentukan                          
                    @endif 
                    </td>
                    <td>{{ Str::ucfirst($item->first()->merk) }}</td>
                    <td>{{ $selectedWeek }}</td>
                    <td>{{ \Carbon\Carbon::create($item->first()->time)->format('H:i') }}</td>
                    <td>{{ $item->first()->voucher ? Str::ucfirst($item->first()->voucher->name) : '-' }}</td>
                    
                  </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row justify-content-end mt-4">
              <!-- accepted payments column -->
              {{-- <div class="col-6">
                <p class="lead">Payment Methods:</p>
                <img src="../../dist/img/credit/visa.png" alt="Visa">
                <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                <img src="../../dist/img/credit/american-express.png" alt="American Express">
                <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                  Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                  plugg
                  dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                </p>
              </div> --}}
              <!-- /.col -->
              <div class="col-6 ">
                {{-- <p class="lead">Amount Due {{\Carbon\Carbon::create(\Carbon\Carbon::now()->toDateTimeString())->format ('d F y')}}</p> --}}

                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th style="width:50%">Package:</th>
                      <td>{{ rupiah($packages_price = $item->first()->subpackage->price_dasar) }}</td>
                    </tr>
                    <tr>
                      <th>Driver:</th>
                      <td>{{ rupiah($driver_price = $item->first()->driver_personal->tarif) }}</td>
                    </tr>
                    <tr>
                      <th>Diskon Package:</th>
                      <td>{{ rupiah($diskon_packages_price = $item->first()->subpackage->price_diskon) }}</td>
                    </tr>
                    <tr>
                      <th>Voucher:</th>
                      <td>{{ rupiah($diskon_voucher_price = $item->first()->voucher ? $item->first()->voucher->price : 0) }}</td>
                    </tr>
                    <tr>
                      <th>Total:</th>
                      @php
                          $total = $packages_price + $driver_price - $diskon_packages_price - $diskon_voucher_price;
                          
                          
                      @endphp
                      <td>{{ rupiah($total) }}</td>
                    </tr>
                  </table>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            {{-- <div class="row no-print">
              <div class="col-12">
                <a href="{{route('print-customers',$item->first()->id)}}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                  Payment
                </button>
                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                  <i class="fas fa-download"></i> Generate PDF
                </button>
              </div>
            </div> --}}
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
@endsection
@push('addon-script')
    <!-- DataTables  & Plugins -->
    {{-- datable --}}
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
  
    {{-- <script>
        $(document).ready(function() {
          $('#example').DataTable();
      } );
</script> --}}

@endpush