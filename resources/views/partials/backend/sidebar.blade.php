<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    @if (Auth::user()->hasAnyPermission(['read roles', 'read permissions']))
        <!-- Heading -->
        <div class="sidebar-heading">
        Roles & Permissions
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        @can('read roles')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.roles') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Roles</span></a>
            </li>
        @endcan

        @can('read permissions')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.permissions') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Permissions</span></a>
            </li>
        @endcan
        <!-- Divider -->
        <hr class="sidebar-divider">
    @endif





    <!-- Nav Item -  -->
    @can('read users')
        <!-- Heading -->
        <div class="sidebar-heading">
            {{ trans('Users') }}
        </div>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.users') }}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>{{ trans('Users') }}</span></a>
        </li>
        <hr class="sidebar-divider">
    @endcan


    <!-- Heading -->
    @can('create cruds')
        <div class="sidebar-heading">
            {{ trans('Crud Generator') }}
        </div>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.generate_crud.view') }}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>{{ trans('Create a Crud') }}</span></a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
    @endcan



    <!-- Sidebar Toggler (Sidebar) -->

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
