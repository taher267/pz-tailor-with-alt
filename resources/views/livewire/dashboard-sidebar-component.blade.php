<aside class="main-sidebar sidebar-dark-primary elevation-4">
  @php
  $URL = config('app.url');
@endphp
    <!-- Brand Logo -->
    @auth
      @if (Auth::user()->role ===1)
        <a href="@if(Request::is('admin*')){{route('manage.dashboard')}}@else @if(Request::is('manage*')){{route('admin.dashboard')}}@endif @endif" class="brand-link">
          {{-- <img src="{{$URL.'/assets/alt/dist/img/AdminLTELogo.png'}}" alt="" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
          <i class="fa fa-dashboard ml-3"></i>
          <span class="brand-text font-weight-light">
            @if (Request::is('admin*'))
                Go Manage
                @else
                @if (Request::is('manage*'))
                Go Admin
            @endif
            @endif
          </span>
        </a>
        @endif
    @endauth
    

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{$URL.'/assets/alt/dist/img/user2-160x160.jpg'}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
           <!-- Order Area -->
           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                অর্ডার
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('orders.unaccomplished')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>অসম্পূর্ণ</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('orders','all')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>সকল অর্ডারসমূহ</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#ml" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inline</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('orders.items')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>সকল অর্ডার আইটেম</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- Customer Area -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-handshake"></i>
              <p>
                Customer
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('customers')}}" class="nav-link">
                  <i class="fas fa-users"></i>
                  All Customers
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('customers.new')}}" class="nav-link">
                  <i class="fas fa-user-plus"></i>
                  New Customer
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fa-solid fa-clock-rotate-left"></i>
                  Today's Customer
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
                UI Elements
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#pages/UI/general.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="##" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Forms
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#pages/forms/general.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General Elements</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="##" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Tables
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#pages/tables/simple.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Simple Tables</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header"><i class="fa-solid fa-user-gear"></i> ADMIN</li>
          {{-- ADMIN AREA END --}}
          @if (Auth::user()->role===1)
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fa-brands fa-product-hunt"></i>
                <p>Product(পণ্য)
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('admin.products')}}" class="nav-link">
                    <i class="fa-brands fa-react"></i>
                    <p>All Products</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('admin.product.design.group')}}" class="nav-link">
                    <i class="fa-solid fa-object-group"></i>
                    <p>Product Design Group</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('admin.product.design.items')}}" class="nav-link">
                    <i class="fa-solid fa-compass-drafting"></i>
                    <p>Design Items</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif
          {{-- ADMIN AREA END --}}
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Pages
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#pages/examples/invoice.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Invoice</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#pages/examples/profile.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profile</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#pages/examples/e-commerce.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>E-commerce</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#pages/examples/projects.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Projects</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#pages/examples/project-add.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Project Add</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#pages/examples/project-edit.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Project Edit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#pages/examples/project-detail.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Project Detail</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#pages/examples/contacts.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Contacts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#pages/examples/faq.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>FAQ</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#pages/examples/contact-us.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Contact us</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>