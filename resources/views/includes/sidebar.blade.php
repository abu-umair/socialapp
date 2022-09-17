
<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html">Cuddl</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.html">St</a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li><a class="nav-link" href="blank.html"><i class="fas fa-home" aria-hidden="true"></i> <span>Home</span></a></li>
      <li class="menu-header">Appointments</li>
     {{-- <li><a class="nav-link" href="{{ route('appointments') }}"><i class="fas fa-calendar-check" aria-hidden="true"></i> <span>Daily Appointments</span></a></li> --}}
     <li class="nav-item dropdown">
      <a href="#" class="nav-link has-dropdown"><i class="fas fa-calendar-check"></i> <span>Bookings</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="{{ route('appointments') }}">Ongoing Bookings</a></li>
        <li><a class="nav-link" href="{{ route('appointments.history') }}">History Bookings</a></li>
      </ul>
    </li>

      {{-- <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="layout-default.html">Daily Appointments</a></li>
          <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
          <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
        </ul>
      </li> --}}
     {{-- <li><a class="nav-link" href="blank.html"><i cla ss="far fa-square"></i> <span>Blank Page</span></a></li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>Bootstrap</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="bootstrap-alert.html">Alert</a></li>
          <li><a class="nav-link" href="bootstrap-badge.html">Badge</a></li>
          <li><a class="nav-link" href="bootstrap-breadcrumb.html">Breadcrumb</a></li>
          <li><a class="nav-link" href="bootstrap-buttons.html">Buttons</a></li>
          <li><a class="nav-link" href="bootstrap-card.html">Card</a></li>
          <li><a class="nav-link" href="bootstrap-carousel.html">Carousel</a></li>
          <li><a class="nav-link" href="bootstrap-collapse.html">Collapse</a></li>
          <li><a class="nav-link" href="bootstrap-dropdown.html">Dropdown</a></li>
          <li><a class="nav-link" href="bootstrap-form.html">Form</a></li>
          <li><a class="nav-link" href="bootstrap-list-group.html">List Group</a></li>
          <li><a class="nav-link" href="bootstrap-media-object.html">Media Object</a></li>
          <li><a class="nav-link" href="bootstrap-modal.html">Modal</a></li>
          <li><a class="nav-link" href="bootstrap-nav.html">Nav</a></li>
          <li><a class="nav-link" href="bootstrap-navbar.html">Navbar</a></li>
          <li><a class="nav-link" href="bootstrap-pagination.html">Pagination</a></li>
          <li><a class="nav-link" href="bootstrap-popover.html">Popover</a></li>
          <li><a class="nav-link" href="bootstrap-progress.html">Progress</a></li>
          <li><a class="nav-link" href="bootstrap-table.html">Table</a></li>
          <li><a class="nav-link" href="bootstrap-tooltip.html">Tooltip</a></li>
          <li><a class="nav-link" href="bootstrap-typography.html">Typography</a></li>
        </ul>
      </li> --}}
      <li class="menu-header">Services</li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-user-md"></i> <span>Partners</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('services.doctors')}}">Doctors</a></li>
          <li><a class="nav-link" href="{{ route('services.groomers') }}">Groomers</a></li>
        </ul>
      </li>
      {{--<li><a class="nav-link" hr ef="blank.html"><i class="fas fa-user-md" aria-hidden="true"></i> <span>Doctors</span></a></li> --}}
      <li class="menu-header">Users</li>

      <li><a class="nav-link" href="{{ route('customers') }}"><i class="fas fa-users" aria-hidden="true"></i> <span>Customers</span></a></li>

      {{-- <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-map-marker-alt"></i> <span>Google Maps</span></a>
        <ul class="dropdown-menu">
          <li><a href="gmaps-advanced-route.html">Advanced Route</a></li>
          <li><a href="gmaps-draggable-marker.html">Draggable Marker</a></li>
          <li><a href="gmaps-geocoding.html">Geocoding</a></li>
          <li><a href="gmaps-geolocation.html">Geolocation</a></li>
          <li><a href="gmaps-marker.html">Marker</a></li>
          <li><a href="gmaps-multiple-marker.html">Multiple Marker</a></li>
          <li><a href="gmaps-route.html">Route</a></li>
          <li><a href="gmaps-simple.html">Simple</a></li>
        </ul>
      </li> --}} 
   {{--    <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-plug"></i> <span>Modules</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="modules-calendar.html">Calendar</a></li>
          <li><a class="nav-link" href="modules-chartjs.html">ChartJS</a></li>
          <li><a class="nav-link" href="modules-datatables.html">DataTables</a></li>
          <li><a class="nav-link" href="modules-flag.html">Flag</a></li>
          <li><a class="nav-link" href="modules-font-awesome.html">Font Awesome</a></li>
          <li><a class="nav-link" href="modules-ion-icons.html">Ion Icons</a></li>
          <li><a class="nav-link" href="modules-owl-carousel.html">Owl Carousel</a></li>
          <li><a class="nav-link" href="modules-sparkline.html">Sparkline</a></li>
          <li><a class="nav-link" href="modules-sweet-alert.html">Sweet Alert</a></li>
          <li><a class="nav-link" href="modules-toastr.html">Toastr</a></li>
          <li><a class="nav-link" href="modules-vector-map.html">Vector Map</a></li>
          <li><a class="nav-link" href="modules-weather-icon.html">Weather Icon</a></li>
        </ul>
      </li> --}}
      <li class="menu-header">Utilities</li>
      <li><a class="nav-link" href="credits.html"><i class="fas fa-pager"></i> <span>Banners</span></a></li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-paper-plane"></i> <span>Push Notifications</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="forms-advanced-form.html">Send Notification</a></li>
          <li><a class="nav-link" href="forms-editor.html">History</a></li>
        </ul>
      </li>
      <li><a class="nav-link" href="credits.html"><i class="fas fa-external-link-alt"></i> <span>Webview Links</span></a></li>

    </ul>

   {{--  <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
      <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
        <i class="fas fa-rocket"></i> Documentation
      </a>
    </div> --}}
  </aside>
</div>