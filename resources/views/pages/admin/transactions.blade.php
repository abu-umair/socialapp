@extends('layouts/master')
@section('title', 'Partners')
@section('content')

<div class="section-body">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Transactions</h4>
          <div class="card-header-action">
            <form>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search">
                <div class="input-group-btn">
                  <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-1">
              <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              <tr>
                <td>43434331</td>
                <td>
                  <a href="#" class="font-weight-600"><img src="../assets/img/avatar/avatar-1.png" alt="avatar" class="rounded-circle mr-1" width="35">  Bagus Dwi Cahya</a>
                </td>
                <td>2017-01-09</td>
                <td><strong>Rp. 200.000</td>
                <td><div class="badge badge-success">Active</div></td>
                <td><a href="#" class="btn btn-icon icon-left btn-primary"><i class="fas fa-print"></i> Invoice</a></td>
              </tr>
           <tr>
                <td>12343242</td>
                <td>
                  <a href="#" class="font-weight-600"><img src="../assets/img/avatar/avatar-1.png" alt="avatar" class="rounded-circle mr-1" width="35">  Bagus Dwi Cahya</a>
                </td>
                <td>2017-01-09</td>
                <td><strong>Rp. 200.000</td>
                <td><div class="badge badge-success">Active</div></td>
                <td><a href="#" class="btn btn-icon icon-left btn-primary"><i class="fas fa-print"></i> Invoice</a></td>
              </tr> <tr>
                <td>15412323</td>
                <td>
                  <a href="#" class="font-weight-600"><img src="../assets/img/avatar/avatar-1.png" alt="avatar" class="rounded-circle mr-1" width="35">  Bagus Dwi Cahya</a>
                </td>
                <td>2017-01-09</td>
                <td><strong>Rp. 200.000</td>
                <td><div class="badge badge-success">Active</div></td>
                <td><a href="#" class="btn btn-icon icon-left btn-primary"><i class="fas fa-print"></i> Invoice</a></td>
              </tr> <tr>
                <td>1664642</td>
                <td>
                  <a href="#" class="font-weight-600"><img src="../assets/img/avatar/avatar-1.png" alt="avatar" class="rounded-circle mr-1" width="35">  Bagus Dwi Cahya</a>
                </td>
                <td>2017-01-09</td>
                <td><strong>Rp. 200.000</td>
                <td><div class="badge badge-success">Active</div></td>
                <td><a href="#" class="btn btn-icon icon-left btn-primary"><i class="fas fa-print"></i> Invoice</a></td>
              </tr>

            </table>
          </div>
        </div>
        <div class="card-footer text-right">
          <nav class="d-inline-block">
            <ul class="pagination mb-0">
              <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
              </li>
              <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
              <li class="page-item">
                <a class="page-link" href="#">2</a>
              </li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item">
                <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('page-scripts')

@endpush  









