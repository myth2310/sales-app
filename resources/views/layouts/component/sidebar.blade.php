<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="./index.html" class="text-nowrap logo-img">
        <img src="{{ asset('assets/images/logos/elsLOGO.png') }}" width="180" alt="" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>

    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
            <span>
              <i class="ti ti-home"></i>
            </span>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>
        @if(Auth::user()->role == 'super admin' || Auth::user()->role == 'admin')
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('dashboard.customer') }}" aria-expanded="false">
            <span>
              <i class="ti ti-users"></i>
            </span>
            <span class="hide-menu">Pelanggan</span>
          </a>
        </li>
        @endif

        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('dashboard.product') }}" aria-expanded="false">
            <span>
              <i class="ti ti-package"></i>
            </span>
            <span class="hide-menu">Product</span>
          </a>
        </li>

        @if(Auth::user()->role == 'sales')
        <li class="sidebar-item">
          <a class="sidebar-link" href="/form-seles-order" aria-expanded="false">
            <span>
              <i class="ti ti-basket"></i>
            </span>
            <span class="hide-menu">Sales Order</span>
          </a>
        </li>
        @else
        <li class="sidebar-item">
          <a class="sidebar-link" href="/sales-order" aria-expanded="false">
            <span>
              <i class="ti ti-basket"></i>
            </span>
            <span class="hide-menu">Order</span>
          </a>
        </li>
        @endif

        <li class="sidebar-item">
          <a class="sidebar-link" href="/logout" aria-expanded="false">
            <span>
              <i class="fa-solid fa-right-from-bracket"></i>
            </span>
            <span class="hide-menu">Logout</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>