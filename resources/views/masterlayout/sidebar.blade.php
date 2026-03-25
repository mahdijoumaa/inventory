<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <!--begin::Brand Link-->
    <a href="#" class="brand-link">
      <!--begin::Brand Image-->
      <img src="./assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
      <!--end::Brand Image-->
      <!--begin::Brand Text-->
      <span class="brand-text fw-light">Sphere 4</span>
      <!--end::Brand Text-->
    </a>
    <!--end::Brand Link-->
  </div>
  <!--end::Sidebar Brand-->
  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <!--begin::Sidebar Menu-->
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation"
        data-accordion="false" id="navigation">
        <li class="nav-item">
          <a href="{{ route('index') }}" class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item {{ request()->routeIs('supplier.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('supplier.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-truck"></i>
            <p>
              Supplier
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('supplier.create') }}"
                class="nav-link {{ request()->routeIs('supplier.create') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Add Supplier</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('supplier.index') }}"
                class="nav-link {{ request()->routeIs('supplier.index') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>List Supplier</p>
              </a>
            </li>

          </ul>
        </li>


      </ul>
      <!--end::Sidebar Menu-->
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->