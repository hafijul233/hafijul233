@extends('layouts.guest')

@section('title', 'Login')

@push('meta')

@endpush


@push('page-style')

@endpush

@section('body-class', 'login-page')

@section('content')
    <div class="login-box">
        @include('layouts.includes.app-logo')
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                {!! \Form::open(['route' => 'auth.login', 'id' => 'login-form', 'method' => 'post']) !!}

                @if(config('auth.credential_field') == \App\Supports\Constant::LOGIN_EMAIL
                || (config('auth.credential_field') == \App\Supports\Constant::LOGIN_OTP
                    && config('auth.credential_otp_field') == \App\Supports\Constant::OTP_EMAIL))
                    {!! \Form::iEmail('email', __('Email'), null, true, "fas fa-envelope", "after",
                                        [ 'minlength' => '5', 'maxlength' => '250',
                                            'size' => '250', 'placeholder' => 'Enter Email Address']) !!}
                @endif

                @if(config('auth.credential_field') == \App\Supports\Constant::LOGIN_MOBILE
                || (config('auth.credential_field') == \App\Supports\Constant::LOGIN_OTP
                    && config('auth.credential_otp_field') == \App\Supports\Constant::OTP_MOBILE))
                    {!! \Form::iTel('mobile', __('Mobile'), null, true, "fas fa-mobile", "after",
                                        [ 'minlength' => '11', 'maxlength' => '11',
                                            'size' => '11', 'placeholder' => 'Enter Mobile Number']) !!}
                @endif

                @if(config('auth.credential_field') == \App\Supports\Constant::LOGIN_USERNAME)
                    {!! \Form::iText('username', __('Username'), null, true, "fas fa-user-shield", "after",
                                        [ 'minlength' => '5', 'maxlength' => '250',
                                            'size' => '250', 'placeholder' => 'Enter Username']) !!}
                @endif

                @if(config('auth.credential_field') != \App\Supports\Constant::LOGIN_OTP)
                    {!! \Form::iPassword('password', __('Password'), true, "fas fa-lock", "after",
                                        ["placeholder" => 'Enter Password', 'autocomplete' => "current-password",
                                         'minlength' => '5', 'maxlength' => '250', 'size' => '250']) !!}
                @endif
                <div class="row">
                    @if(config('auth.allow_remembering'))
                        <div class="col-8">
                            <div class="icheck-primary">
                                {!! \Form::checkbox('remember', 'yes', null, ['id' => 'remember_me']) !!}
                                <label for="remember_me">
                                    {{ __('Remember me') }}
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                    @endif
                    <div class="@if(!config('auth.allow_remembering')) offset-8 @endif col-4">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('Log in') }}</button>
                    </div>
                    <!-- /.col -->
                </div>
                {!! \Form::close() !!}

                {{--
                <div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>
                </div>
                --}}
            <!-- /.social-auth-links -->

                @if (Route::has('auth.password.request') && config('auth.allow_password_reset'))
                    <p class="mb-1">
                        <a href="{{ route('auth.password.request') }}">I forgot my password</a>
                    </p>
                @endif

                @if(Route::has('auth.register') && config('auth.allow_register'))
                    <p class="mb-0">
                        <a href="{{ route('auth.register') }}" class="text-center">Register a new membership</a>
                    </p>
                @endif
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
@endsection


@push('plugin-script')
    <!-- jquery validation -->
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
@endpush

@push('page-script')
    <script type="text/javascript">
        $(function () {
            $("#login-form").validate({
                rules: {
                    @if(config('auth.credential_field') == \App\Supports\Constant::LOGIN_EMAIL
                    || (config('auth.credential_field') == \App\Supports\Constant::LOGIN_OTP
                    && config('auth.credential_otp_field') == \App\Supports\Constant::OTP_EMAIL))
                    email: {
                        required: true,
                        minlength: 3,
                        maxlength: 255,
                        email: true
                    },
                    @endif

                        @if(config('auth.credential_field') == \App\Supports\Constant::LOGIN_MOBILE
                        || (config('auth.credential_field') == \App\Supports\Constant::LOGIN_OTP
                        && config('auth.credential_otp_field') == \App\Supports\Constant::OTP_MOBILE))
                    mobile: {
                        required: true,
                        minlength: 11,
                        maxlength: 11,
                        digits: true
                    },
                    @endif

                        @if(config('auth.credential_field') == \App\Supports\Constant::LOGIN_USERNAME)
                    username: {
                        required: true,
                        minlength: 5,
                        maxlength: 250
                    },
                    @endif

                        @if(config('auth.credential_field') != \App\Supports\Constant::LOGIN_OTP)
                    password: {
                        required: true,
                        minlength: {{ config('auth.minimum_password_length') }},
                        maxlength: 250
                    }
                    @endif
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-valid').addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                }
            });
        });
    </script>
@endpush
