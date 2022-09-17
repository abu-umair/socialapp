@extends('layouts.admin')
@section('title','Messages Create')
@push('prepend-style')
 <link rel="stylesheet" href="{{url('css/app.css')}}">
 <style>
   .list-group{
     overflow: scroll;
     height: 200px;
   }
 </style>
@endpush
@section('content')

  <div class="container" >
    <div class="row" id="app">
      {{-- <div class="col"> --}}
        <div class="offset-4 col-4">
          <li class="list-group-item active bg-primary" aria-current="true">Chat Room</li>
          <ul class="list-group" v-chat-scroll>
            <message
            v-for="value,index in chat.message"
            :key =value.index
            {{-- color='success' --}}
            :color= chat.color[index]
            :user = chat.user[index]
            > 
              @{{ value }}
            </message>
          </ul>
          <input type="text" class="form-control" placeholder="Type your message" name=""   id="" v-model='message' @keyup.enter='send'>
        </div>
      {{-- </div> --}}
    </div>
  </div>

@endsection
@push('prepend-script')
  <script src="{{url('js/app.js')}}"></script>    
@endpush

@push('addon-script')
 
@endpush