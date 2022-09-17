<div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <div class="search-element">
            <input class="form-control" id="inputSearch" placeholder="Search" aria-label="Search" data-width="250">
            {{-- <button class="btn" type="submit"><i class="fas fa-search"></i></button> --}}
            <input type="submit" class="btn fas fa-search" value="&#xf002;">
            <div class="search-backdrop"></div>
            <div class="search-result" id="searchResult" style="display: none;">
              
            </div>
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          {{-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Messages
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-message">
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="{{ url('backend/assets/img/avatar/avatar-1.png') }}" class="rounded-circle">
                    <div class="is-online"></div>
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Kusnaedi</b>
                    <p>Hello, Bro!</p>
                    <div class="time">10 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="{{ url('backend/assets/img/avatar/avatar-2.png') }}" class="rounded-circle">
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Dedik Sugiharto</b>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                    <div class="time">12 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="{{ url('backend/assets/img/avatar/avatar-3.png') }}" class="rounded-circle">
                    <div class="is-online"></div>
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Agung Ardiansyah</b>
                    <p>Sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <div class="time">12 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="{{ url('backend/assets/img/avatar/avatar-4.png') }}" class="rounded-circle">
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Ardian Rahardiansyah</b>
                    <p>Duis aute irure dolor in reprehenderit in voluptate velit ess</p>
                    <div class="time">16 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="{{ url('backend/assets/img/avatar/avatar-5.png') }}" class="rounded-circle">
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Alfa Zulkarnain</b>
                    <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                    <div class="time">Yesterday</div>
                  </div>
                </a>
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li> --}}
          {{-- kirim notifications table --}}
          @php
              $notifications_all = App\Notification::orderBy('created_at', 'desc')->get();
              $notifications = $notifications_all->take(15);
          @endphp
          <li class="dropdown dropdown-list-toggle">
            <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg click-hide beep">
              <i class="far fa-bell"></i>
              {{-- <small><span class="badge badge-warning align-top">{{ $notifications->where('read_at',null)->count() }}</span></small> --}}
              {{-- <div class="hide-count">
              </div> --}}
              {{-- <div class="show-count">
                <small><span class="badge badge-warning align-top">0</span></small>
              </div> --}}
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Notifications
                <div class="float-right">
                  {{-- <a href="#">Mark All As Read</a> --}}
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-icons">
                @foreach ($notifications as $notification)
                  <a href="#" class="dropdown-item dropdown-item-unread">
                    <div class="dropdown-item-icon bg-primary text-white">
                      <i class="fas fa-code"></i>
                    </div>
                    <div class="dropdown-item-desc">
                      {{ json_decode($notification['data'],true)['description'] }} {{ json_decode($notification['data'],true)['from'] }}
                      {{-- Template update is available now! --}}
                      <div class="time text-primary">{{ $notification->created_at ? $notification->created_at->diffForHumans() : '-' }}</div>
                    </div>
                  </a>
                @endforeach
              </div>
              <div class="dropdown-footer text-center">
                <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg" id="modalLink">View All <i class="fas fa-chevron-right"></i></a>
              </div>

            </div>
          </li>
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ url('backend/assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">{{ Auth::user()->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              {{-- <div class="dropdown-title">Logged in 5 min ago</div> --}}
              {{-- <a href="features-profile.html" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a> --}}
              {{-- <a href="features-activities.html" class="dropdown-item has-icon">
                <i class="fas fa-bolt"></i> Activities
              </a>
              <a href="features-settings.html" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a> --}}
              <div class="dropdown-divider"></div>
              <form action="{{ url('logout') }}" method="POST" class="form-inline">
                @csrf
                <button class="dropdown-item submit-logout" type="submit">
                  <a><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
                </button>
              {{-- <a href="#" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a> --}}
            </form> 
            </div>
          </li>
        </ul>
      </nav>
{{-- modal --}}
      <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Notifications</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="border-bottom"></div>
              <div class="container-fluid mt-3">
                @forelse ($notifications_all as $notifmodal)
                <span>
                  <div class="row">
                    <div class="col-auto mr-auto">{{ json_decode($notification['data'],true)['description'] }} {{ json_decode($notification['data'],true)['from'] }}</div>
                    <div class="col-auto ml-auto">
                      <div class="time text-primary">{{ $notifmodal->created_at ? $notifmodal->created_at->diffForHumans() : '-' }}</div>                 
                    </div>
                  </div>
                  <div class="dropdown-divider"></div>
                </span>
                @empty
                    Null
                @endforelse
              </div>
            </div>
          </div>
        </div>
      </div>
{{-- modal --}}
      @push('addon-script')
      {{-- modal --}}
      <script>
        $('a[href$="#modalLink"]').on( "click", function() {
           $('.bd-example-modal-lg').modal('show');
        });
      </script>
      {{-- modal --}}

  {{-- hide show count notification --}}
  {{-- <script type="text/javascript">

      var rules_now = {!! json_encode($rules_now) !!};
    $(document).ready(function() {
      $('.show-count').hide();

      $('.click-hide').click(function(){
        $('.hide-count').hide();
        $('.show-count').show();
      });
    });

    $(document).on('click', '.click-hide', function (e) {
      e.preventDefault();
      // var stud_id = $(this).val();
      // alert(stud_id);
      
      $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
      $.ajax({
          type: "PUT",
          url: "/updatenotification/" + rules_now,
          dataType: "json",
          success: function (response) {
              console.log(response);
          }
      });
    });
  </script> --}}
  {{-- hide show count notification --}}
  @endpush