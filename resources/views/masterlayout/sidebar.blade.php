<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <!--begin::Brand Link-->
    <a href="#" class="brand-link">
      <!--begin::Brand Image-->

      <img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
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
 <!--start::supplier Menu-->
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

 <!--end::supplier Menu-->

  <!--start::Customer Menu-->
         <li class="nav-item {{ request()->routeIs('customer.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('customer.*') ? 'active' : '' }}">
  <i class="nav-icon bi bi-people"></i>
            <p>
              Customer
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('customer.create') }}"
                class="nav-link {{ request()->routeIs('customer.create') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Add Customer</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('customer.index') }}"
                class="nav-link {{ request()->routeIs('customer.index') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>List Customer</p>
              </a>
            </li>

          </ul>
        </li>

 <!--end::custonmer Menu--> 
 
 

   <!--start::category Menu-->
                 <li class="nav-item {{ request()->routeIs('categories.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
  <i class="nav-icon bi bi-diagram-3  "></i>
            <p>
              Categories
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('categories.create') }}"
                class="nav-link {{ request()->routeIs('categories.create') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Add category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('categories.index') }}"
                class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>List category</p>
              </a>
            </li>

          </ul>
        </li>

        
 <!--end::category Menu--> 

      </ul>
      <!--end::Sidebar Menu-->
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->