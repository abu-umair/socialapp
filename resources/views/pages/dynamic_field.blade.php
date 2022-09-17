@extends('layouts.admin')
@section('title','Services - Doctor')
@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Partners</h1>
      <div class="section-header-breadcrumb">
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a >Services</a></div>
            <div class="breadcrumb-item"><a >Doctors</a></div>
            
          </div>
      </div>
    </div>

    <div class="section-body">
      {{-- <h2 class="section-title">This is Example Page</h2>
      <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
      <div class="card">
        <div class="card-header d-sm-flex align-items-center justify-content-between ">
          <h1 class="h3 mb-0 text-gray-800">Doctors</h1>
          <a href="{{ route('services-doctor.create')}}"
           class="btn btn-sm btn-primary shadow-sm rounded">
           <i class="fas fa-plus fa-sm text-white-50"></i>
           Tamabah Doctor
            </a>          
        </div>
        
        <div class="card-body">
          <div class="table-responsive">
              {{-- <table class="table table-bordered" id="table_id" width="100%" collspacing="0">
              </table> --}}
              <form method="post" id="dynamic_form">
                <span id="result"></span>
                <table class="table table-bordered table-striped" id="user_table">
              <thead>
               <tr>
                   <th width="35%">First Name</th>
                   {{-- <th width="35%">Last Name</th> --}}
                   <th width="30%">Action</th>
               </tr>
              </thead>
              <tbody>

              </tbody>
              <tfoot>
               <tr>
                               <td colspan="2" align="right">&nbsp;</td>
                               <td>
                 @csrf
                 <input type="submit" name="save" id="save" class="btn btn-primary" value="Save" />
                </td>
               </tr>
              </tfoot>
          </table>
               </form>
          </div>
      </div> 
        <div class="card-footer bg-whitesmoke">
            <a href="{{ route('services.index')}}"
            class="btn btn-sm btn-primary shadow-sm rounded">
            <i class="fas fa-plus fa-sm text-white-50"></i>
            Layanan
             </a>    
        </div>
      </div>
    </div>
  </section>
  </div>
@endsection

@push('addon-script')
    {{-- dynamic input --}}
<script>
  $(document).ready(function(){
  
   var count = 1;
  
   dynamic_field(count);
  
   function dynamic_field(number)
   {
    html = '<tr>';
          html += '<td><input type="text" name="first_name[]" class="form-control" /></td>';
          // html += '<td><input type="text" name="last_name[]" class="form-control" /></td>';
          if(number > 1)
          {
              html += '<td><button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td></tr>';
              $('tbody').append(html);
          }
          else
          {   
              html += '<td><button type="button" name="add" id="add" class="btn btn-success">Add</button></td></tr>';
              $('tbody').html(html);
          }
   }
  
   $(document).on('click', '#add', function(){
    count++;
    dynamic_field(count);
   });
  
   $(document).on('click', '.remove', function(){
    count--;
    $(this).closest("tr").remove();
   });
   
  //proses submit  ke route dynamic-field.insert
   $('#dynamic_form').on('submit', function(event){
          event.preventDefault();
          $.ajax({
              url:'{{ route("dynamic-field.insert") }}',
              method:'post',
              data:$(this).serialize(),
              dataType:'json',
              beforeSend:function(){
                  $('#save').attr('disabled','disabled');
              },
              success:function(data)
              {
                  if(data.error)
                  {
                      var error_html = '';
                      for(var count = 0; count < data.error.length; count++)
                      {
                          error_html += '<p>'+data.error[count]+'</p>';
                      }
                      $('#result').html('<div class="alert alert-danger">'+error_html+'</div>');
                  }
                  else
                  {
                      dynamic_field(1);
                      $('#result').html('<div class="alert alert-success">'+data.success+'</div>');
                  }
                  $('#save').attr('disabled', false);
              }
          })
   });
  
  });
  </script>
@endpush

