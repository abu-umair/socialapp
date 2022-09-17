<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="{{ url('backend/assets/js/stisla.js') }}"></script>

<!-- JS Libraies -->
<script src="{{ url('backend/node_modules/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ url('backend/node_modules/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ url('backend/node_modules/owl.carousel/dist/owl.carousel.min.js') }}"></script>
<script src="{{ url('backend/node_modules/summernote/dist/summernote-bs4.js') }}"></script>
<script src="{{ url('backend/node_modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

<!-- Template JS File -->
<script src="{{ url('backend/assets/js/scripts.js') }}"></script>
<script src="{{ url('backend/assets/js/custom.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ url('backend/assets/js/page/index.js') }}"></script>

{{-- datepicker --}}
{{-- <script src="{{url('backend/plugins/datepicker/js/bootstrap-datepicker.min.js')}}"></script> --}}
{{-- Sweet Alert detele --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>


{{-- Sweet Alert delete --}}
<script>
    function deleteRow(id)
           {
               swal({
                 title: 'Apakah Anda Yakin?',
                     text: "Anda Tidak Akan Dapat Mengembalikannya!",
                     type: 'warning',
                     showCancelButton: true,
                     confirmButtonColor: '#3abaf4',
                     cancelButtonColor: '#fc544b',
                     confirmButtonText: 'Yes, delete it!'
               }).then((result) => {
                   if (result.value) {                  
                     $('#data-'+id).submit();
                   } else if (result.dismiss === Swal.DismissReason.cancel) {
                       Swal(
                       'Cancelled',
                       'Your imaginary file is safe :)',
                       'error'
                       )
                     }
                 })
                   
         }
   </script>

   {{-- my search navbar--}}
{{-- <script type="text/javascript">
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  })

  $('#inputSearch').on('keyup',function(){
      // alert("ok");
      $inputSearch = $(this).val();
      // alert($inputSearch);
      if($inputSearch ==''){
          $('#searchResult').html('');
          $('#searchResult').hide();
      }else{
          $.ajax({
              method:"post",
              url:"{{ route('searchnavbar') }}",
              data:JSON.stringify({
                  inputSearch:$inputSearch
              }),
              headers:{
                  'Accept':'application/json',
                  'Content-Type':'application/json'
              },
              success: function(data){
                  var searchResultAjax='';
                  data = JSON.parse(data);
                  console.log(data);
                  $('#searchResult').show();
                  var nodoct = 0;
                  var nogroom = 0;
                  var nocust = 0;
                  var noong = 0;
                  
                  for(let i=0; i<data.length;i++){
                      if (data[i].partners_id != null) {
                            var routes ="{{route('home')}}"+"/admin/profile-user/"+data[i].id;
                            // <a href="#" class="list-group-item list-group-item-action disabled" id="list-me"><small> Dapibus ac facilisis in</small></a>
                            if (nodoct == 0) {
                              searchResultAjax +='<a class="list-group-item list-group-item-action disabled" id="list-me"><small> Partner</small></a>'
                                // searchResultAjax +='<div class="search-header">Doctors</div>'
                                nodoct++;
                            }
                                searchResultAjax +='<a href="'+routes+'" class="list-group-item list-group-item-action">'+data[i].name+'</a>'
                                // searchResultAjax +='<div class="search-item"><a href="'+routes+'">'+data[i].name+'</a></div>'
                      } 
                    //   else if (data[i].partners_id != null) {
                    //         var routes ="{{route('home')}}"+"/admin/profile-groomer/"+data[i].id;
                    //         if (nogroom == 0) {
                    //           searchResultAjax +='<a class="list-group-item list-group-item-action disabled" id="list-me"><small> Partners</small></a>'
                    //             // searchResultAjax +='<div class="search-header">Groomers</div>'
                    //             nogroom++;
                    //         }
                    //         searchResultAjax +='<a href="'+routes+'" class="list-group-item list-group-item-action">'+data[i].name+'</a>'
                    //         // searchResultAjax +='<div class="search-item"><a href="'+routes+'">'+data[i].name+'</a></div>'
                    //   } 
                    //   else if(data[i].roolsearch == 'ongoing') {
                    //         var routes ="{{route('appointments-ongoing.index')}}"+"/"+data[i].id;
                    //         if (noong == 0) {
                    //           searchResultAjax +='<a class="list-group-item list-group-item-action disabled" id="list-me"><small> Ongoings</small></a>'
                    //             // searchResultAjax +='<div class="search-header">Ongoings / Histories</div>'
                    //             noong++;
                    //         }
                    //         searchResultAjax +='<a href="'+routes+'" class="list-group-item list-group-item-action">'+data[i].name+'</a>'
                    //         // searchResultAjax +='<div class="search-item"><a href="'+routes+'">'+data[i].id_unique+'</a></div>'
                    //   }
                      else if(data[i].customers_id != null){
                            var routes ="{{route('home')}}"+"/admin/profile-user/"+data[i].customers_id;
                            if (nocust == 0) {
                              searchResultAjax +='<a class="list-group-item list-group-item-action disabled" id="list-me"><small> Customers</small></a>'
                                // searchResultAjax +='<div class="search-header">Customers</div>'
                                nocust++;
                            }
                            searchResultAjax +='<a href="'+routes+'" class="list-group-item list-group-item-action">'+data[i].name+'</a>'
                            // searchResultAjax +='<div class="search-item"><a href="'+routes+'">'+data[i].name+'</a></div>'
                      }
                  }
                  $('#searchResult').html(searchResultAjax);
              }
          })
      }

  })
  </script> --}}
