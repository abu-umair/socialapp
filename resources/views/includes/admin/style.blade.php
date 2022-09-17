
  
 <!-- General CSS Files -->
 {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
 <link rel="stylesheet" href="{{ url('backend/node_modules/bootstrap/dist/css/bootstrap.css') }}" type="text/css">
 {{-- font awesome --}}
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
 <script src="https://kit.fontawesome.com/dc29e510c5.js" crossorigin="anonymous"></script>
 {{-- font awesome --}}
 
 {{-- Favicon --}}
{{-- <link rel="shortcut icon" href="{{ url('backend/assets/img/favicon.ico')}}" type="image/x-icon"> --}}
<link rel="icon" type="image/png" href="{{ url('backend/assets/img/adfood.png')}}">
{{-- dataTable --}}
 <link rel="stylesheet" href="{{ url('backend/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
 
 <!-- CSS Libraries -->
 <link rel="stylesheet" href="{{ url('backend/node_modules/jqvmap/dist/jqvmap.min.css') }}">
 <link rel="stylesheet" href="{{ url('backend/node_modules/summernote/dist/summernote-bs4.css') }}">
 <link rel="stylesheet" href="{{ url('backend/node_modules/owl.carousel/dist/assets/owl.carousel.min.css') }}">
 <link rel="stylesheet" href="{{ url('backend/node_modules/owl.carousel/dist/assets/owl.theme.default.min.css') }}">

 
 {{-- sweet alert delete --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css" rel="stylesheet"></link>

 <!-- Template CSS -->
 <link rel="stylesheet" href="{{ url('backend/assets/css/style.css') }}">
 <link rel="stylesheet" href="{{ url('backend/assets/css/components.css') }}">

 {{-- meratakan text sejajar di table index--}}
<style>
  .rataCust{
    padding-top: 19px;
  }
</style>

  {{-- style search navbar --}}
  <style>
    .list-group{
    max-height: 300px;
    margin-bottom: 10px;
    overflow:scroll;
    -webkit-overflow-scrolling: touch;
  }
    .style-search-me > a{
    /* background-color:#212529; */
    color: #ced4da;
  }
    .style-search-me > a:hover{
    background-color:#212529;
    color: whitesmoke;
  }
  .style-search-me > #list-me {
    background-color:#ced4da;
    color: #6c757d;
    padding: 2px 10px;
  }
/* nitification scroll */
  .notif-scroll{
    max-height: 300px;
    margin-bottom: 10px;
    overflow:scroll;
    -webkit-overflow-scrolling: touch;
  }

/* custom scrollbar */
::-webkit-scrollbar {
  width: 15px;
}

::-webkit-scrollbar-track {
  background-color: transparent;
}

::-webkit-scrollbar-thumb {
  background-color: #d6dee1;
  border-radius: 20px;
  border: 6px solid transparent;
  background-clip: content-box;
}

::-webkit-scrollbar-thumb:hover {
  background-color: #a8bbbf;
}

/* Blink for Webkit and others
(Chrome, Safari, Firefox, IE, ...)
*/

@-webkit-keyframes blinker {
  from {opacity: 1.0;}
  to {opacity: 0.0;}
}
.blink{
  color: red;
	text-decoration: blink;
	-webkit-animation-name: blinker;
	-webkit-animation-duration: 0.7s;
	-webkit-animation-iteration-count:infinite;
	-webkit-animation-timing-function:ease-in-out;
	-webkit-animation-direction: alternate;
}

/* menghapus garis focus buttons logout click  */
.submit-logout:focus {
  outline: none;
  box-shadow: none;
}
</style>