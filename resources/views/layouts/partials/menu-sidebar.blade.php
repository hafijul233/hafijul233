<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset(\App\Supports\Constant::USER_PROFILE_IMAGE) }}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">
            <strong>{{ config('backend.sidebar') }}</strong>
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 d-flex border-bottom-0">
            <div class="image">
                <img src="{{ \Auth::user()->getFirstMediaUrl('avatars') }}" class="img-circle elevation-2"
                     alt="{{ \Auth::user()->name }}">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ \Auth::user()->name }}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('backend.dashboard') }}"
                       class="nav-link  @if(\Route::is('backend.dashboard')) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{!! __('menu-sidebar.Dashboard') !!}</p>
                    </a>
                </li>

                {{--@can('backend.common.address-books.index')
                    <li class="nav-item">
                        <a href="{{ route('backend.common.address-books.index') }}"
                           class="nav-link @if(\Route::is('backend.common.address-books.*')) active @endif">
                            <i class="fas fa-address-book nav-icon"></i>
                            <p>{!! __('menu-sidebar.Address Book') !!}</p>
                        </a>
                    </li>
                @endcan--}}

                @canany(['backend.organization.surveys.index', 'backend.organization.enumerators.index'])
                    <li class="nav-item @if(\Route::is('backend.organization.*')) menu-open @endif">
                        <a href="#" class="nav-link @if(\Route::is('backend.organization.*')) active @endif">
                            <i class="nav-icon fas fa-building"></i>
                            <p> {!! __('menu-sidebar.Organization') !!}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            @if(\Route::is('backend.organization.*')) style="display: block;" @endif>

                            @can('backend.organization.surveys.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.organization.surveys.index') }}"
                                       class="nav-link @if(\Route::is('backend.organization.surveys.*')) active @endif">
                                        <i class="fas fa-address-card nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Surveys') !!}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('backend.organization.enumerators.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.organization.enumerators.index') }}"
                                       class="nav-link @if(\Route::is('backend.organization.enumerators.*')) active @endif">
                                        <i class="fas fa-address-card nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Enumerators') !!}</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                @canany([
    'backend.settings.users.index',
    'backend.settings.roles.index',
    'backend.settings.permissions.index',
    'backend.settings.catalogs.index'])
                    <li class="nav-item @if(\Route::is('backend.settings.*')) menu-open @endif">
                        <a href="#" class="nav-link @if(\Route::is('backend.settings.*')) active @endif">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>{!! __('menu-sidebar.Settings') !!}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            @if(\Route::is('backend.settings.*')) style="display: block;" @endif>
                            @can('backend.settings.users.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.settings.users.index') }}"
                                       class="nav-link @if(\Route::is('backend.settings.users.*')) active @endif">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Users') !!}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('backend.settings.roles.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.settings.roles.index') }}"
                                       class="nav-link @if(\Route::is('backend.settings.roles.*')) active @endif">
                                        <i class="fas fa-address-card nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Roles') !!}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('backend.settings.permissions.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.settings.permissions.index') }}"
                                       class="nav-link @if(\Route::is('backend.settings.permissions.*')) active @endif">
                                        <i class="fas fa-list-alt nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Permissions') !!}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('backend.settings.catalogs.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.settings.catalogs.index') }}"
                                       class="nav-link @if(\Route::is('backend.settings.catalogs.*')) active @endif">
                                        <i class="fas fa-list-alt nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Catalogs') !!}</p>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- /.main-sidebar -->
