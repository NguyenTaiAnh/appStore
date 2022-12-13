  @php
  $current_route=request()->route()->getName();
  @endphp
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{asset('admin-assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('admin-assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{auth()->user()->name}}</a>
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
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

           <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link {{$current_route=='dashboard'?'active':''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item {{$current_route=='users.index'?'menu-open':''}}">
            <a href="#" class="nav-link {{$current_route=='users.index'?'active':''}}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                User Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('users.index')}}" class="nav-link {{$current_route=='users.index'?'active':''}}">
                  <i class="far fas fa-user"></i>
                  <p>Users</p>
                </a>
              </li>

            </ul>
          </li>
          <li class="nav-item">
              <a href="{{route('author.index')}}" class="nav-link {{$current_route=='author.index'?'active':''}}">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                      Author
                  </p>
              </a>
          </li>
            <li class="nav-item">
              <a href="{{route('categories.index')}}" class="nav-link {{$current_route=='categories.index'?'active':''}}">
                  <i class="nav-icon fas fa-th"></i>
                  <p>
                      Categories
                  </p>
              </a>
          </li>
            <li class="nav-item">
              <a href="{{route('levels.index')}}" class="nav-link {{$current_route=='levels.index'?'active':''}}">
                  <i class="nav-icon fa fa-angle-double-up"></i>
                  <p>
                      Levels
                  </p>
              </a>
          </li>
            <li class="nav-item {{$current_route=='stories.index'?'menu-open':''}}">
                <a href="#" class="nav-link {{$current_route=='stories.index'?'active':''}}">
                    <i class="nav-icon fa fa-book"></i>
                    <p>
                        Stories Management
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('stories.index')}}" class="nav-link {{$current_route=='stories.index'?'active':''}}">
                            <i class="far fa-circle"></i>
                            <p>Story</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('stories.create')}}" class="nav-link {{$current_route=='stories.create'?'active':''}}">
                            <i class="far fa-circle"></i>
                            <p>Create Story</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{$current_route=='chapters.index'?'menu-open':''}}" >
                <a href="#" class="nav-link {{$current_route=='chapters.index'?'active':''}}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>
                        Chapters Management
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('chapters.index')}}" class="nav-link {{$current_route=='chapters.index'?'active':''}}">
                            <i class="far fa-circle"></i>
                            <p>Chapters</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('chapters.create')}}" class="nav-link {{$current_route=='chapters.create'?'active':''}}">
                            <i class="far fa-circle"></i>
                            <p>Create Chapter</p>
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
