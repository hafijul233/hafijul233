@push('plugin-style')
    <link rel="stylesheet" href="{{ asset('modules/admin/plugins/select2/css/select2.min.css') }}" type="text/css">
@endpush

<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nText('name', 'Name', old('name', $user->name ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nText('username', 'Username', old('username', $user->username ?? null),
                (config('auth.credential_field') == \Modules\Core\Supports\Constant::LOGIN_USERNAME)) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nEmail('email', 'Email Address', old('email', $user->email ?? null),
                (config('auth.credential_field') == \Modules\Core\Supports\Constant::LOGIN_EMAIL
                || (config('auth.credential_field') == \Modules\Core\Supports\Constant::LOGIN_OTP
                    && config('auth.credential_otp_field') == \Modules\Core\Supports\Constant::OTP_EMAIL))) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nTel('mobile', 'Mobile', old('mobile', $user->mobile ?? null),
                (config('auth.credential_field') == \Modules\Core\Supports\Constant::LOGIN_MOBILE
                || (config('auth.credential_field') == \Modules\Core\Supports\Constant::LOGIN_OTP
                    && config('auth.credential_otp_field') == \Modules\Core\Supports\Constant::OTP_MOBILE))) !!}
        </div>
    </div>
    @if(config('auth.credential_field') != \Modules\Core\Supports\Constant::LOGIN_OTP)
        <div class="row">
            <div class="col-md-6">
                {!! \Form::nPassword('password', 'Password', empty($user->password)) !!}
            </div>
            <div class="col-md-6">
                {!! \Form::nPassword('password_confirmation', 'Retype Password', empty($user->password)) !!}
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nSelectMulti('role_id', 'Role', $roles,
    old('role_id.*', ($user_roles ?? [\Modules\Core\Supports\Constant::GUEST_ROLE_ID])), true,
    ['class' => 'form-control custom-select select2']) !!}

            {!! \Form::nSelect('enabled', 'Enabled', \Modules\Core\Supports\Constant::ENABLED_OPTIONS,
old('enabled', ($user->enabled ?? \Modules\Core\Supports\Constant::ENABLED_OPTION))) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nImage('photo', 'Photo', false,
                ['preview' => true, 'height' => '69',
                 'default' => (isset($user))
                 ? $user->getFirstMediaUrl('avatars')
                 : asset(\Modules\Core\Supports\Constant::USER_PROFILE_IMAGE)]) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            {!! \Form::nTextarea('remarks', 'Remarks', old('remarks', $user->remarks ?? null)) !!}
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 justify-content-between d-flex">
            {!! \Form::nCancel('Cancel') !!}
            {!! \Form::nSubmit('submit', 'Save') !!}
        </div>
    </div>
</div>

@push('page-script')
    <script type="text/javascript" src="{{ asset('modules/admin/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            //trigger select2
            $("select.select2").select2({
                placeholder: 'Select Role(s)',
                minimumResultsForSearch: Infinity,
                maximumSelectionLength: 3,
                allowClear: true,
                multiple: true,
                width: "100%"
            });

            $("#user-form").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    username: {},
                    email: {
                        required: true,
                        email: true,
                        minlength: 2,
                        maxlength: 255
                    },
                    mobile: {
                        required: true,
                        digits: true,
                        minlength: 11,
                        maxlength: 11
                    },
                    password: {
                        required: {{ isset($user) ? 'false' : 'true' }},
                        minlength: '{{ config('auth.minimum_password_length') }}',
                        maxlength: 255,
                        equalTo: "#password_confirmation"
                    },
                    password_confirmation: {
                        required: {{ isset($user) ? 'false' : 'true' }},
                        minlength: '{{ config('auth.minimum_password_length') }}',
                        maxlength: 255,
                        equalTo: "#password"
                    }
                }
            });
        });
    </script>
@endpush
