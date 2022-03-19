{!! \Form::open(['route' => $route, 'method' => $method]) !!}
<div class="modal-body">
    <p class="mb-3 text-dark fw-bold text-center">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </p>
    @if(config('auth.credential_field') != \App\Supports\Constant::LOGIN_OTP)
        <div class="mb-3">
            {!! \Form::nPassword('password', 'Password', true,
                ['autofocus' => 'autofocus', 'minlength' => config('auth.minimum_password_length'), 'maxlength' => '250',
                 'size' => '250', 'placeholder' => 'Enter Password']) !!}
        </div>
    @endif
</div>
<div class="modal-footer d-flex justify-content-between">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-danger">Confirm Password</button>
</div>
{!! \Form::close() !!}

