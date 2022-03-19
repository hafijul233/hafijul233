@push('plugin-style')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}" type="text/css">
@endpush

<div class="card-body">
    {!! \Form::hidden('home_page', \App\Supports\Constant::DASHBOARD_ROUTE) !!}
    {!! \Form::hidden('locale', \App\Supports\Constant::LOCALE) !!}

    <div class="row">
        <div class="col-md-6">
            {!! \Form::nText('name', __('common.Name'), old('name', $driver->name ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nText('username', 'Drivername', old('username', $driver->username ?? null),
                (config('auth.credential_field') == \App\Supports\Constant::LOGIN_USERNAME)) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nEmail('email', 'Email Address', old('email', $driver->email ?? null),
                (config('auth.credential_field') == \App\Supports\Constant::LOGIN_EMAIL
                || (config('auth.credential_field') == \App\Supports\Constant::LOGIN_OTP
                    && config('auth.credential_otp_field') == \App\Supports\Constant::OTP_EMAIL))) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nTel('mobile', __('common.Mobile'), old('mobile', $driver->mobile ?? null),
                (config('auth.credential_field') == \App\Supports\Constant::LOGIN_MOBILE
                || (config('auth.credential_field') == \App\Supports\Constant::LOGIN_OTP
                    && config('auth.credential_otp_field') == \App\Supports\Constant::OTP_MOBILE))) !!}
        </div>
    </div>
    @if(config('auth.credential_field') != \App\Supports\Constant::LOGIN_OTP)
        <div class="row">
            <div class="col-md-6">
                {!! \Form::nPassword('password', 'Password', empty($driver->password)) !!}
            </div>
            <div class="col-md-6">
                {!! \Form::nPassword('password_confirmation', 'Retype Password', empty($driver->password)) !!}
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nSelectMulti('role_id', 'Role', $roles,
    old('role_id.*', ($driver_roles ?? [\App\Supports\Constant::GUEST_ROLE_ID])), true,
    ['class' => 'form-control custom-select select2']) !!}

            {!! \Form::nSelect('enabled', __('common.Enabled'), \App\Supports\Constant::ENABLED_OPTIONS,
old('enabled', ($driver->enabled ?? \App\Supports\Constant::ENABLED_OPTION))) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nImage('photo', 'Photo', false,
                ['preview' => true, 'height' => '69',
                 'default' => (isset($driver))
                 ? $driver->getFirstMediaUrl('avatars')
                 : asset(\App\Supports\Constant::USER_PROFILE_IMAGE)]) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            {!! \Form::iCheckbox('address[type]', 'Address Type', config('contact.address_type'), ['bill', 'ship']) !!}
            <div class="mt-3">
                {!! \Form::nTel('address[phone]', 'Phone', old('mobile', $defaultAddress->phone ?? null), false) !!}

                {!! \Form::nTextarea('address[address]', 'Street Address',
old('address.address', $defaultAddress->address ?? null), false,
['style' => "height: 84px;"]) !!}
            </div>
        </div>
        <div class="col-md-6">
            {!! \Form::nSelect('address[state_id]', 'State',
        ($states ?? []), old('address.state_id', $defaultAddress->state_id ?? config('contact.default.state')), true,
         ['placeholder' => 'Please select a state', 'class' => 'form-control custom-select select2', 'id' => 'state_id']) !!}

            {!! \Form::nSelect('address[city_id]', 'City',[], old('address.city_id', $defaultAddress->city_id ?? config('contact.default.city')), true,
['placeholder' => 'Please select a city', 'class' => 'form-control custom-select select2', 'id' => 'city_id']) !!}

            {!! \Form::nText('address[post_code]', 'Post/Zip Code',
old('address.post_code', $defaultAddress->address ?? null), false) !!}
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            {!! \Form::nTextarea('remarks', 'Remarks', old('remarks', $driver->remarks ?? null)) !!}
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 justify-content-between d-flex">
            {!! \Form::nCancel(__('common.Cancel')) !!}
            {!! \Form::nSubmit('submit', __('common.Save')) !!}
        </div>
    </div>
</div>

@push('page-script')
    <script type="text/javascript" src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script>
        const state_ajax_route = '{{ route('backend.settings.states.ajax') }}';
        const city_ajax_route = '{{ route('backend.settings.cities.ajax') }}';
        var selected_state_id = '{{ old('address.state_id', $defaultAddress->state_id ?? config('contact.default.state')) }}';
        var selected_city_id = '{{ old('address.city_id', $defaultAddress->city_id ?? config('contact.default.city')) }}';

        $(document).ready(function () {
            //trigger select2
            $("#role_id").select2({
                placeholder: 'Select Role(s)',
                minimumResultsForSearch: Infinity,
                maximumSelectionLength: 3,
                allowClear: true,
                multiple: true,
                width: "100%"
            });

            $(".select2").select2({width: "100%"});

            $("#state_id").change(function () {
                var state_id = $(this).val();
                if (!isNaN(state_id)) {
                    populateDropdown(city_ajax_route, {
                        params: {"state": state_id, "enabled": "yes"},
                        target: $("#city_id"),
                        value: "id", text: "name",
                        selected: selected_city_id,
                        message: "Please select a city"
                    });
                }
            });

            if (selected_state_id.length > 0) {
                populateDropdown(city_ajax_route, {
                    params: {"state": selected_state_id, "enabled": "yes"},
                    target: $("#city_id"),
                    value: "id", text: "name",
                    selected: selected_city_id,
                    message: "Please select a city"
                });
            }

            $("#driver-form").validate({
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
                        required: {{ isset($driver) ? 'false' : 'true' }},
                        minlength: '{{ config('auth.minimum_password_length') }}',
                        maxlength: 255,
                        equalTo: "#password_confirmation"
                    },
                    password_confirmation: {
                        required: {{ isset($driver) ? 'false' : 'true' }},
                        minlength: '{{ config('auth.minimum_password_length') }}',
                        maxlength: 255,
                        equalTo: "#password"
                    }
                }
            });
        });
    </script>
@endpush
