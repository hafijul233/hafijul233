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
                @can('backend.dashboard')
                    <li class="nav-item">
                        <a href="{{ route('backend.dashboard') }}"
                           class="nav-link  @if(\Route::is('backend.dashboard')) active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>{!! __('menu-sidebar.Dashboard') !!}</p>
                        </a>
                    </li>
                @endcan

                @canany([
    'backend.portfolio.services.index',
    'backend.portfolio.certificates.index',
    'backend.portfolio.projects.index',
    'backend.portfolio.testimonials.index'])
                    <li class="nav-item @if(\Route::is('backend.portfolio.*')) menu-open @endif">
                        <a href="#" class="nav-link @if(\Route::is('backend.portfolio.*')) active @endif">
                            <i class="nav-icon fas fa-portrait"></i>
                            <p> {!! __('menu-sidebar.Portfolio') !!}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            @if(\Route::is('backend.portfolio.*')) style="display: block;" @endif>

                            @can('backend.portfolio.services.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.portfolio.services.index') }}"
                                       class="nav-link @if(\Route::is('backend.portfolio.services.*')) active @endif">
                                        <i class="fas fa-circle-notch nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Services') !!}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('backend.portfolio.certificates.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.portfolio.certificates.index') }}"
                                       class="nav-link @if(\Route::is('backend.portfolio.certificates.*')) active @endif">
                                        <i class="fas fa-circle-notch nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Certificates') !!}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('backend.portfolio.projects.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.portfolio.projects.index') }}"
                                       class="nav-link @if(\Route::is('backend.portfolio.projects.*')) active @endif">
                                        <i class="fas fa-circle-notch nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Projects') !!}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('backend.portfolio.testimonials.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.portfolio.testimonials.index') }}"
                                       class="nav-link @if(\Route::is('backend.portfolio.testimonials.*')) active @endif">
                                        <i class="fas fa-circle-notch nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Testimonials') !!}</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                @canany([
    'backend.resume.experiences.index',
    'backend.resume.educations.index',
    'backend.resume.awards.index',
    'backend.resume.skills.index',
    'backend.resume.languages.index'])
                    <li class="nav-item @if(\Route::is('backend.resume.*')) menu-open @endif">
                        <a href="#" class="nav-link @if(\Route::is('backend.resume.*')) active @endif">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p> {!! __('menu-sidebar.Resume') !!}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            @if(\Route::is('backend.resume.*')) style="display: block;" @endif>

                            @can('backend.resume.experiences.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.resume.experiences.index') }}"
                                       class="nav-link @if(\Route::is('backend.resume.experiences.*')) active @endif">
                                        <i class="fas fa-circle-notch nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Experiences') !!}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('backend.resume.educations.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.resume.educations.index') }}"
                                       class="nav-link @if(\Route::is('backend.resume.educations.*')) active @endif">
                                        <i class="fas fa-circle-notch nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Educations') !!}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('backend.resume.awards.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.resume.awards.index') }}"
                                       class="nav-link @if(\Route::is('backend.resume.awards.*')) active @endif">
                                        <i class="fas fa-circle-notch nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Awards') !!}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('backend.resume.skills.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.resume.skills.index') }}"
                                       class="nav-link @if(\Route::is('backend.resume.skills.*')) active @endif">
                                        <i class="fas fa-circle-notch nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Skills') !!}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('backend.resume.languages.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.resume.languages.index') }}"
                                       class="nav-link @if(\Route::is('backend.resume.languages.*')) active @endif">
                                        <i class="fas fa-circle-notch nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Languages') !!}</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                @canany([
    'backend.blog.posts.index',
    'backend.blog.comments.index',
    'backend.blog.newsletters.index'])
                    <li class="nav-item @if(\Route::is('backend.blog.*')) menu-open @endif">
                        <a href="#" class="nav-link @if(\Route::is('backend.blog.*')) active @endif">
                            <i class="nav-icon fas fa-blog"></i>
                            <p> {!! __('menu-sidebar.Blog') !!}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            @if(\Route::is('backend.blog.*')) style="display: block;" @endif>

                            @can('backend.blog.posts.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.blog.posts.index') }}"
                                       class="nav-link @if(\Route::is('backend.blog.posts.*')) active @endif">
                                        <i class="fas fa-circle-notch nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Posts') !!}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('backend.blog.comments.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.blog.comments.index') }}"
                                       class="nav-link @if(\Route::is('backend.blog.comments.*')) active @endif">
                                        <i class="fas fa-circle-notch nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Comments') !!}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('backend.blog.newsletters.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.blog.newsletters.index') }}"
                                       class="nav-link @if(\Route::is('backend.blog.newsletters.*')) active @endif">
                                        <i class="fas fa-circle-notch nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Newsletters') !!}</p>
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
    'backend.settings.states.index',
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
                                        <i class="fas fa-circle-notch nav-icon"></i>
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

                            @can('backend.settings.states.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.settings.states.index') }}"
                                       class="nav-link @if(\Route::is('backend.settings.states.*')) active @endif">
                                        <i class="fas fa-landmark nav-icon"></i>
                                        <p>{!! __('menu-sidebar.States') !!}</p>
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
