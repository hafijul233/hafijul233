@push('plugin-style')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}" type="text/css">
@endpush

@push('plugin-script')
    <script type="text/javascript" src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
@endpush

<div class="container-fluid">
    {!! \Form::hText('name', __('enumerator.Name'), old('name', $enumerator->name ?? null), true, 3) !!}
    {!! \Form::hText('name_bd', __('enumerator.Name(Bangla)'), old('name_bd', $enumerator->name_bd ?? null), true, 3) !!}
    {!! \Form::hRadio('gender_id', __('enumerator.Gender'), $genders, 1, true, 3) !!}
    {!! \Form::hDate('dob', __('enumerator.Date of Birth'), old('dob', $enumerator->dob ?? null), true, 3) !!}
    {!! \Form::hText('mother', __('enumerator.Mother Name'), old('mother', $enumerator->mother ?? null), true, 3) !!}
    {!! \Form::hText('father', __('enumerator.Father Name'), old('father', $enumerator->father ?? null), true, 3) !!}
    {!! \Form::hNumber('nid', __('enumerator.NID Number'), old('nid', $enumerator->nid ?? null), true, 3) !!}
    {!! \Form::hTextarea('present_address', __('enumerator.Present Address'), old('present_address', $enumerator->present_address ?? null), true, 3) !!}
    {!! \Form::hTextarea('permanent_address', __('enumerator.Permanent Address'), old('permanent_address', $enumerator->permanent_address ?? null), true, 3) !!}
    {!! \Form::hSelect('exam_level', __('enumerator.Highest Educational Qualification'),$exam_dropdown, old('exam_level', $enumerator->exam_level ?? 2), true, 3) !!}
    {!! \Form::hNumber('mobile_1', __('enumerator.Mobile 1'), old('mobile_1', $enumerator->mobile_1 ?? null), true, 3) !!}
    {!! \Form::hNumber('mobile_2', __('enumerator.Mobile 2'), old('mobile_2', $enumerator->mobile_2 ?? null), false, 3) !!}
    {!! \Form::hText('email', __('enumerator.Email'), old('email', $enumerator->email ?? null), true, 3) !!}
    {!! \Form::hNumber('whatsapp', __('enumerator.Whatsapp Number'), old('whatsapp', $enumerator->whatsapp ?? null), false, 3) !!}
    {!! \Form::hUrl('facebook', __('enumerator.Facebook ID'), old('facebook', $enumerator->facebook ?? null), false, 3) !!}
    {!! \Form::hCheckbox('survey_id', __('enumerator.Survey'), $surveys, old('survey_id', $enumerator->survey_id ?? []),true, 3) !!}

    {!! \Form::hSelectMulti('prev_post_state_id', __('enumerator.Select the district(s) where you have worked earlier (it can be multiple)'),$states,
    old('prev_post_state_id', $enumerator->prev_post_state_id ?? null), false, 3) !!}

    {!! \Form::hSelectMulti('future_post_state_id', __('enumerator.Select the district(s) where you want to work in future (maximum 3)'),$states,
    old('future_post_state_id', $enumerator->prev_post_state_id ?? null), false, 3) !!}

    {!! \Form::hRadio('is_employee', __('enumerator.Are you revenue staff of BBS?'), $enables, old('is_employee', $enumerator->is_employee ?? 'no'), true, 3) !!}
    <div id="work_space">
        {!! \Form::hText('designation', __('enumerator.Designation'), old('designation', $enumerator->designation ?? null), false, 3) !!}
        {!! \Form::hText('company', __('enumerator.Company Name'), old('company', $enumerator->company ?? null), false, 3) !!}
    </div>
    <div class="row mt-3">
        <div class="col-12 justify-content-center d-flex">
            {!! \Form::nSubmit('submit', __('common.Save')) !!}
        </div>
    </div>
</div>

@push('page-script')
    <script>
        $(document).ready(function () {

            if ('yes' === '{{ old('is_employee', 'no') }}') {
                $("#work_space").show();
            }
            else {
                $("#work_space").hide();
            }

            $("#is_employee-radio-yes, #is_employee-radio-no").change(function () {
                var option = this;
                if (option.checked) {
                    if (option.value === 'yes') {
                        $("#work_space").show();
                    } else {
                        $("#work_space").hide();
                    }
                }
            });

            $("select#exam_level").select2({
                width: "100%",
                placeholder: '{!! __('enumerator.Please select highest educational qualification')  !!}',
                minimumResultsForSearch: Infinity
            });

            $("select#prev_post_state_id").select2({
                width: "100%",
                placeholder: "{{ __('enumerator.Select the district(s) where you have worked earlier (it can be multiple)') }}",
                multiple: true,
                allowClear: true,
                maximumSelectionLength: {{ count($states) }}
            });

            $("select#future_post_state_id").select2({
                width: "100%",
                placeholder: "{{ __('enumerator.Select the district(s) where you want to work in future (maximum 3)') }}",
                multiple: true,
                allowClear: true,
                maximumSelectionLength: 3
            });

            $("#enumerator-form").validate({
                rules: {
                    "survey_id": {
                        required: true,
                        digits: true
                    },
                    "name": {
                        required: true,
                        minlength: 2,
                        maxlength: 255,
                        nametitle: true
                    },
                    "name_bd": {
                        required: true,
                        minlength: 2,
                        maxlength: 255
                    },
                    "father": {
                        required: true,
                        minlength: 2,
                        maxlength: 255,
                        nametitle: true
                    },
                    "mother": {
                        required: true,
                        minlength: 2,
                        maxlength: 255,
                        nametitle: true
                    },
                    "nid": {
                        required: true,
                        digits: true
                    },
                    "mobile_1": {
                        required: true,
                        digits: true,
                        mobilenumber: true
                    },
                    "mobile_2": {
                        required: false,
                        digits: true,
                        mobilenumber: true
                    },
                    "email": {
                        required: true
                    },
                    "whatsapp": {
                        required: false,
                        digits: true,
                        mobilenumber: true
                    },

                    "present_address": {
                        required: true
                    },
                    "permanent_address": {
                        required: true
                    },
                    "gender_id": {
                        required: true,
                        digits: true
                    },
                    "exam_level": {
                        required: true,
                        digits: true
                    },
                    dob: {
                        required: true,
                        regex: "[0-9]{4}-[0-9]{2}-[0-9]{2}",
                        maxDate: function () {
                            return '{{ date('Y-m-d') }}';
                        },
                        minDate: function () {
                            return '{{ date('Y-m-d', strtotime('-65 years')) }}';
                        },

                    }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.siblings('span').append(error);
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