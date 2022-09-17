@extends('layouts.admin')
@section('title','Menu Restaurant Images')
@push('prepend-style')

@endpush
@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
        <h1>Menu Restaurant Images</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item "><a >Merchants</a></div>
              <div class="breadcrumb-item active"><a >Menu Restaurant</a></div>
            </div>
        </div>
      </div>
      <div class="section-body">
        <div class="card">
          <div class="card-header d-sm-flex align-items-center justify-content-between">
            <h4>Menu Restaurant Images</h4>
            {{-- <a href="{{ route('food images.create')}}"
           class="btn btn-sm btn-primary shadow-sm rounded">
           <i class="fas fa-plus fa-sm text-white-50"></i>
           User Merchant
            </a>         --}}
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class=""><code>Images Menu Restaurant</code></h4>
              </div>
              <div class="card-body">
                @forelse ($items->sortBy('urutan') as $item)
                {{-- <input type="text" id="stud-id-{{ $item->id }}" value="{{ $item->id }}" /> --}}
                  <div class="d-block">
                    <div class="d-inline">
                      <div class="form-inline">
                      <img src="{!! Storage::url($item->menus_restaurant) !!}" class=" mr-2 my-2 " width="100">
                      <input type="number" name="urutan" value="{{ $item->urutan }}" class="form-control" id="stud-id-{{ $item->id }}" required>
                      <button class="btn btn-info update_menus mx-2" type="button" data-id="{{ $item->id }}"> 
                        <i class="fa fa-pencil-alt"></i>
                      </button>

                      <form action="{{ route('menus_image_delete', $item->id) }}"
                        method="POST" class="d-inline" id="dataMenuRestaurant-{{ $item->id }}">
                        @csrf
                        @method('delete')
                      </form>
                      <button class="btn btn-danger" onclick="deleteRowMenuRestaurant( {{ $item->id }} )" > 
                        <i class="fa fa-trash"></i> 
                      </button>
                      </div>
                    </div>
                  </div>
                  @empty
                    <img src="{!! url('backend/assets/img/avatar/menus_restaurant.png') !!}" class=" mr-2 " width="300">
                  @endforelse
              </div>
            </div>
          </div>
            </div>
          </div>
          <div class="card-footer bg-whitesmoke">
            
          </div>
        </div>
      </div>
      
      
  </section>
</div>
@endsection

@push('prepend-script')
    
@endpush

@push('addon-script')
<script>
  $(document).on('click', '.update_menus', function (e) {
            e.preventDefault();
            $(this).text('Updating');
            const id = $(this).data('id') //utk mendapatkan IDnya
            const value = $(`#stud-id-${id}`).val() //utk mendapatkan valuenya input looping
            // alert(value);
            var data = {
                // 'urutan': $('#urutan').val(),
                'urutan': value,
            }
            // alert(data);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "PUT",
                url: "/admin/update-image-menus/" + id,
                data: data,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    // if (response.status == 400) {
                    //     $('#update_msgList').html("");
                    //     $('#update_msgList').addClass('alert alert-danger');
                    //     $.each(response.errors, function (key, err_value) {
                    //         $('#update_msgList').append('<li>' + err_value +
                    //             '</li>');
                    //     });
                    //     $('.update_student').text('Update');
                    // } else {
                    //     $('#update_msgList').html("");

                    //     $('#success_message').addClass('alert alert-success');
                    //     $('#success_message').text(response.message);
                        
                    //     $('.update_student').text('Update');
                    //     // fetchstudent();
                    // }
                }
            });

        });
</script>

{{-- Sweet Alert delete Menu Restaurant--}}
<script>
  function deleteRowMenuRestaurant(id)
         {
             swal({
               title: 'Are you sure ?',
                   text: "You Won't Be Able To Return It!",
                   type: 'warning',
                   showCancelButton: true,
                   confirmButtonColor: '#3abaf4',
                   cancelButtonColor: '#fc544b',
                   confirmButtonText: 'Yes, delete it!'
             }).then((result) => {
                 if (result.value) {                  
                   $('#dataMenuRestaurant-'+id).submit();
                 } else if (result.dismiss === Swal.DismissReason.cancel) {
                     Swal(
                     'Cancelled',
                     'Your imaginary file is safe :)',
                     'error'
                     );
                   }
               });
                 
       }
 </script>
{{-- Sweet Alert delete Menu Restaurant--}}

  
@endpush