
  
 <!-- General CSS Files -->
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

 <!-- CSS Libraries -->
 <link rel="stylesheet" href="{{ url('backend/node_modules/jqvmap/dist/jqvmap.min.css') }}">
 <link rel="stylesheet" href="{{ url('backend/node_modules/summernote/dist/summernote-bs4.css') }}">
 <link rel="stylesheet" href="{{ url('backend/node_modules/owl.carousel/dist/assets/owl.carousel.min.css') }}">
 <link rel="stylesheet" href="{{ url('backend/node_modules/owl.carousel/dist/assets/owl.theme.default.min.css') }}">

 <!-- Template CSS -->
 <link rel="stylesheet" href="{{ url('backend/assets/css/style.css') }}">
 <link rel="stylesheet" href="{{ url('backend/assets/css/components.css') }}">
  
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
  </style>