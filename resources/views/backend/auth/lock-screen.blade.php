@extends('auth::Admin.Resources.views.layouts.auth')

@section('title', 'Register')

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')

@endpush

@push('inline-style')

@endpush

@push('head-script')

@endpush

@section('body-class', 'lockscreen')

@section('content')
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
        <div class="lockscreen-logo">
            <a href="../../index2.html"><b>Admin</b>LTE</a>
        </div>
        <!-- User name -->
        <div class="lockscreen-name">John Doe</div>

        <!-- START LOCK SCREEN ITEM -->
        <div class="lockscreen-item">
            <!-- lockscreen image -->
            <div class="lockscreen-image">
                <img src="../../dist/img/user1-128x128.jpg" alt="User Image">
            </div>
            <!-- /.lockscreen-image -->

            <!-- lockscreen credentials (contains the form) -->
            <form method="POST" action="{{ route('password.confirm') }}" class="lockscreen-credentials">
                @csrf
                <div class="input-group">
                    <input type="password" class="form-control" placeholder="password">

                    <div class="input-group-append">
                        <button type="button" class="btn">
                            <i class="fas fa-arrow-right text-muted"></i>
                        </button>
                    </div>
                </div>
            </form>
            <!-- /.lockscreen credentials -->

        </div>
        <!-- /.lockscreen-item -->
        <div class="help-block text-center">
            Enter your password to retrieve your session
        </div>
        <div class="text-center">
            <a href="login.html">Or sign in as a different user</a>
        </div>
    </div>
    <!-- /.center -->
@endsection


@push('plugin-script')

@endpush

@push('page-script')

@endpush
