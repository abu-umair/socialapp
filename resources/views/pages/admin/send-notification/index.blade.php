@extends('layouts.admin')
@section('title','Notification')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Partners</h1>
        <div class="section-header-breadcrumb">
          <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a >Services</a></div>
              <div class="breadcrumb-item"><a >Content</a></div>
              
            </div>
        </div>
      </div>
  
      <div class="section-body">
        {{-- <h2 class="section-title">This is Example Page</h2>
        <p class="section-lead">This page is just an example for you to create your own page.</p> --}}
        <div class="card">
          <div class="card-header d-sm-flex align-items-center justify-content-between ">
            <h1 class="h3 mb-0 text-gray-800">Content</h1>
            <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>         
          </div>
          
          <div class="card-body">
            <div class="table-responsive">
        </div> 
          <div class="card-footer bg-whitesmoke">
            @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('send.notification') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Body</label>
                            <textarea class="form-control d-block w-100 h-100 form-control" rows="10" name="body"></textarea>
                          </div>
                        <button type="submit" class="btn btn-primary">Send Notification</button>
                    </form>

          </div>
        </div>
      </div>
    </section>
    </div>
  
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <center>
                <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>
            </center>
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection
@push('addon-script')
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
{{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> --}}
<script>

    var firebaseConfig = {
        apiKey: "AIzaSyBcTC8tM4gzchNVly5107U0v1Bj6D_JdAQ",
        authDomain: "push-notification-040809.firebaseapp.com",
        projectId: "push-notification-040809",
        storageBucket: "push-notification-040809.appspot.com",
        messagingSenderId: "284335827192",
        appId: "1:284335827192:web:fea1ded64917cbf99c330d",
        measurementId: "G-EYMQ6FPX5B"
    };

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    function initFirebaseMessagingRegistration() {
            messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function(token) {
                console.log(token);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ route("save-token") }}',
                    type: 'POST',
                    data: {
                        token: token
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        alert('Token saved successfully.');
                    },
                    error: function (err) {
                        console.log('User Chat Token Error'+ err);
                    },
                });

            }).catch(function (err) {
                console.log('User Chat Token Error'+ err);
            });
     }

    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(noteTitle, noteOptions);
    });

</script>
@endpush

