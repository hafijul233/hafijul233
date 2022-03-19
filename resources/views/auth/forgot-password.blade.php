@extends('layouts.guest')

@section('title', 'Forgot Password')

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')

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
                <p class="login-box-msg">
                    {{ __('Forgot your password? Here you can easily retrieve a new password.') }}
                </p>

                {!! \Form::open(['route' => 'auth.password.email', 'id' => 'password-reset-form', 'method' => 'post']) !!}
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
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-warning btn-block">Request new Password</button>
                    </div>
                    <!-- /.col -->
                </div>
                {!! \Form::close() !!}

                @if(Route::has('auth.login'))
                    <p class="mb-0">
                        <a href="{{ route('auth.login') }}" class="text-center">I already have a membership? Login</a>
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
            $("#password-reset-form").validate({
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
