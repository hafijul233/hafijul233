@push('plugin-style')
    <link rel="stylesheet" href="{{ asset('modules/admin/plugins/select2/css/select2.min.css') }}" type="text/css">
@endpush

<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nText('name', 'Name', old('name', $user->name ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nSelect('country_id', 'Country', $countries,old('country_id', $user->countrty_id ?? null), true) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        </div>
        <div class="col-md-6">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nSelect('enabled', 'Enabled', \App\Supports\Constant::ENABLED_OPTIONS,
old('enabled', ($user->enabled ?? \App\Supports\Constant::ENABLED_OPTION))) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nImage('photo', 'Photo', false,
                ['preview' => true, 'height' => '69',
                 'default' => (isset($user))
                 ? $user->getFirstMediaUrl('avatars')
                 : asset(\App\Supports\Constant::USER_PROFILE_IMAGE)]) !!}
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
