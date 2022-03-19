<li class="nav-item dropdown user-menu">
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        <img src="{{ auth()->user()->getFirstMediaUrl('avatars') }}"
             class="user-image img-circle mr-0" alt="User Image">
        {{--        <span class="d-none d-md-inline text-capitalize">{{ auth()->user()->name }}</span>--}}
    </a>
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <!-- User image -->
        <li class="user-header bg-white">
            <img src="{{ auth()->user()->getFirstMediaUrl('avatars') }}"
                 class="img-circle elevation-2 mr-0"
                 alt="{{ auth()->user()->name }}">

            <p class="text-capitalize font-weight-bold">
                {{ auth()->user()->name }}
                @if(auth()->user()->roles->first() != null)
                    <br>
                    <small class="text-warning text-sm">{{ auth()->user()->roles->first()->name }}</small>
                @endif
            </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body border-bottom-0 border-top-0">
            <div class="row">
                {{--<div class="col-4 text-center">
                    <a href="#">Followers</a>
                </div>
                <div class="col-4 text-center">
                    <a href="#">Sales</a>
                </div>
                <div class="col-4 text-center">
                    <a href="#">Friends</a>
                </div>--}}
            </div>
            <!-- /.row -->
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <a href="{{ route('backend.settings.users.show', (auth()->user() != null) ? auth()->user()->id : 0) }}"
               class="btn btn-default btn-flat">Profile</a>
            <a href="#" data-toggle="modal" data-target="#exampleModal" class="btn btn-default btn-flat float-right">
                Sign out</a>
        </li>
    </ul>
</li>
