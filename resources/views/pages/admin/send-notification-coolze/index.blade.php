@extends('layouts.admin')
@section('title','Notification')
@push('prepend-style')
  
@endpush
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Home Notification</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Notification</li>
            
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="card">
        @if ($errors->any()) {{-- jika ada permasalahan/error --}}
            <div class="alert alert-danger"> {{-- maka muncul div error --}}
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>                        
                    @endforeach
                </ul>
            </div>        
        @endif
        @if(session('error'))                    
                  <div class="alert alert-danger"> 
                  <ul>
                      <li>{{ session('error') }}</li>
                  </ul>
              </div> 
        @endif
        @if(session()->has('success'))
              <div class="alert alert-success">
                  <ul>
                      <li>{{ session()->get('success') }}</li>
                  </ul>
              </div>
        @endif
        <div class="card-header d-sm-flex align-items-center justify-content-between ">
          <h1 class="h3 mb-0 text-gray-800">Content</h1>
          <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-flat">Allow for Notification</button>         
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
  </section>
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
  appId: "1:284335827192:web:a28d295cc3fa3dd99c330d",
  measurementId: "G-YB2417FB56"
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