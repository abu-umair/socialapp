<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{ route('dashboard-adfood') }}">{{ config('app.name') }}</a>
      {{-- <a href="{{ route('dashboard-adfood') }}">
        <img src="{{ url('backend/assets/img/adfood.png') }}" alt="logo" width="10" class="">
      </a> --}}
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ route('dashboard-adfood') }}"><span class="text-warning">A</span><span class="text-primary">F</span></a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="nav-item {{ (Request::segment(2) == '') ? 'active' : '' }}">
          <a href="{{ route('dashboard-adfood') }}" class=""><i class="fa-solid fa-house-chimney mx-auto"></i><span class="ml-3">Dashboard</span></a>
        </li>

        <li class="menu-header">reports</li>
        <li class="nav-item dropdown {{ (Request::segment(2) === 'reservations')||request()->is('admin/reservations/*/edit')||(Request::segment(2) === 'histories-reservation')||(Request::segment(2) === 'rate-reservation') ? 'active' : ''  }}">
          <a href="#" class="nav-link has-dropdown"><i class="fa-solid fa-book mx-auto"></i><span class="ml-3">Reservations</span></a>
          <ul class="dropdown-menu">
            <li class="{{ (Request::segment(2) === 'reservations')||request()->is('admin/reservations/*/edit') ? 'active' : ''  }}"><a href="{{ route('reservations.index')}}">Ongoing</a></li>
            <li class="{{ (Request::segment(2) === 'histories-reservation')||(Request::segment(2) === 'rate-reservation') ? 'active' : ''  }}"><a href="{{ route('reservations_history')}}">Histories</a></li>
          </ul>
        </li>
        <li class="{{ (Request::segment(2) === 'subscription-adfood')||request()->is('admin/subscription-adfood/*/edit') ? 'active' : ''  }}">
          <a href="{{ route('subscription-adfood.index') }}" class=""><i class="fa-solid fa-book-open-reader mx-auto"></i><span class="ml-3">Subscription Plans</span></a>
        </li>
        <li class="nav-item">
          <a href="#" class=""><i class="fa-solid fa-calculator mx-auto"></i><span class="ml-3">Earnings</span></a>
        </li>
        <li class="nav-item {{ (Request::segment(2) === 'vouchers_adfood')||request()->is('admin/vouchers_adfood/*/edit') ? 'active' : '' }}">
          <a href="{{ route('vouchers_adfood.index')}}" class=""><i class="fa fa-ticket mx-auto" aria-hidden="true"></i><span class="ml-3">Voucher</span></a>
        </li>
        
        <li class="menu-header">users</li>
        <li class="nav-item dropdown {{ (Request::segment(2) === 'customers')||request()->is('admin/customers/*/edit')||(Request::segment(2) === 'stripes-adfood')||request()->is('admin/stripes-adfood/*/edit') || (Request::segment(2) === 'category-adfood')||request()->is('admin/category-adfood/*/edit') ||(Request::segment(2) === 'layout-foods')||(Request::segment(2) === 'layout-merchants') ? 'active' : '' }}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa-solid fa-users mx-auto"></i><span class="ml-3">Customers</span></a>
          <ul class="dropdown-menu">
            <li class="{{ (Request::segment(2) === 'customers')||request()->is('admin/customers/*/edit') ? 'active' : ''  }}"><a class="nav-link" href="{{ route('customers.index')}}">Users</a></li>
            <li class="{{ (Request::segment(2) === 'stripes-adfood')||request()->is('admin/stripes-adfood/*/edit') ? 'active' : ''  }}"><a class="nav-link" href="{{ route('stripes-adfood.index')}}">Stripes</a></li>
            <li class="{{ (Request::segment(2) === 'layout-foods') ? 'active' : ''  }}"><a class="nav-link" href="{{ route('layout-foods.index')}}">Layouts Foods</a></li>
            <li class="{{ (Request::segment(2) === 'layout-merchants') ? 'active' : ''  }}"><a class="nav-link" href="{{ route('layout-merchants.index')}}">Layouts Restaurants</a></li>
            <li class="{{ (Request::segment(2) === 'category-adfood')||request()->is('admin/category-adfood/*/edit') ? 'active' : ''  }}"><a class="nav-link" href="{{ route('category-adfood.index')}}">Categories</a></li>
            
          </ul>
        </li>
        <li class="nav-item dropdown {{ (Request::segment(2) === 'merchants')||request()->is('admin/merchants/*/edit')||(Request::segment(2) === 'foods')||request()->is('admin/foods/*/edit')||(Request::segment(2) === 'orivouchers-adfood')||request()->is('admin/orivouchers-adfood/*/edit') ? 'active' : '' }}">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa-solid fa-user-tie mx-auto"></i><span class="ml-3">Merchants</span></a>
          <ul class="dropdown-menu">
            <li class="{{ (Request::segment(2) === 'merchants')||request()->is('admin/merchants/*/edit') ? 'active' : '' }}"><a class="nav-link" href="{{ route('merchants.index')}}">Users</a></li>
            <li class="{{ (Request::segment(2) === 'foods')||request()->is('admin/foods/*/edit') ? 'active' : '' }}"><a class="nav-link" href="{{ route('foods.index')}}">Foods</a></li>
            <li class="{{ (Request::segment(2) === 'orivouchers-adfood')||request()->is('admin/orivouchers-adfood/*/edit') ? 'active' : '' }}"><a class="nav-link" href="{{ route('orivouchers-adfood.index')}}">Promotions</a></li>
          </ul>
        </li>

        <li class="menu-header">UTILITIES</li>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-paper-plane"></i> <span>Push Notifications</span></a>
          <ul class="dropdown-menu">
            <li class="{{ (Request::segment(2) === 'send-notification') ? 'active' : '' }}">
              <a href="{{ route('send-notification') }}">Send Notification</a>
            </li>
            <li class="{{ (Request::segment(2) === 'historynotification') ? 'active' : '' }}">
              <a href="{{ route('historynotification') }}">History</a>
            </li>
          </ul>
        </li>
        <li class="{{ (Request::segment(2) === 'content')||request()->is('admin/content/*/edit') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('content.index')}}"><i class="fas fa-chalkboard"></i> <span>Contents</span></a>
        </li>
        <li class="{{ (Request::segment(2) === 'settings') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('settings.index')}}"><i class="fas fa-cog"></i> <span>Settings</span></a>
        </li>
      </ul>

      <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
        
      </div>
  </aside>
</div>