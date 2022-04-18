<div class="card-body pt-0">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container-fluid">
        {!! \Form::hText('name', __('enumerator.Name'), old('name', $enumerator->name ?? null), true, 3) !!}
        {!! \Form::hText('name_bd', __('enumerator.Name(Bangla)'), old('name_bd', $enumerator->name_bd ?? null), true, 3) !!}
        {!!  \Form::hRadio('gender_id', __('enumerator.Gender'), $genders, 1, true, 3) !!}
        {!! \Form::hDate('dob', __('enumerator.Date of Birth'), old('dob', $enumerator->dob ?? null), true, 3) !!}
        {!! \Form::hText('father', __('enumerator.Father Name'), old('father', $enumerator->father ?? null), true, 3) !!}
        {!! \Form::hText('mother', __('enumerator.Mother Name'), old('mother', $enumerator->mother ?? null), true, 3) !!}
        {!! \Form::hNumber('nid', __('enumerator.NID Number'), old('nid', $enumerator->nid ?? null), true, 3) !!}
        {!! \Form::hTextarea('present_address', __('enumerator.Present Address'), old('present_address', $enumerator->present_address ?? null), true, 3) !!}
        {!! \Form::hTextarea('permanent_address', __('enumerator.Permanent Address'), old('permanent_address', $enumerator->permanent_address ?? null), true, 3) !!}
        {!! \Form::hSelect('exam_level', __('enumerator.Highest Educational Qualification'),$exam_dropdown,
        old('exam_level', $enumerator->exam_level ?? 2), true, 3, ['placeholder' => __('enumerator.Please select highest educational qualification')]) !!}
        {!! \Form::hNumber('mobile_1', __('enumerator.Mobile 1'), old('mobile_1', $enumerator->mobile_1 ?? null), true, 3) !!}
        {!! \Form::hNumber('mobile_2', __('enumerator.Mobile 2'), old('mobile_2', $enumerator->mobile_2 ?? null), false, 3) !!}
        {!! \Form::hText('email', __('enumerator.Email'), old('email', $enumerator->email ?? null), true, 3) !!}
        {!! \Form::hNumber('whatsapp', __('enumerator.Whatsapp Number'), old('whatsapp', $enumerator->whatsapp ?? null), false, 3) !!}
        {!! \Form::hUrl('facebook', __('enumerator.Facebook ID'), old('facebook', $enumerator->facebook ?? null), false, 3) !!}
        {!! \Form::hCheckbox('survey_id', __('enumerator.Survey'), $surveys, old('survey_id', $enumerator->survey_id ?? []),
    true, 3, ['placeholder' => __("enumerator.Select a Survey Option")]) !!}
        <div class="row mt-3">
            <div class="col-12 justify-content-center d-flex">
                {!! \Form::nSubmit('submit', __('common.Save')) !!}
            </div>
        </div>
    </div>
</div>

@push('page-script')
    <script>

        /*function getExamGroupDropdown(examLevelId, examTitleId, targetIdString, preSelected = '') {
            if (!isNaN(examTitleId)) {
                $.ajax({
                    method: 'GET',
                    url: '{{ route('backend.settings.exam-groups.ajax') }}',
                    data: {exam_level_id: examLevelId, exam_title_id: examTitleId},
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    cache: false,
                    dataType: 'json',
                    success: function (response) {
                        var targetSelect = $("#" + targetIdString);
                        targetSelect.empty();
                        if (response.status === true) {
                            if (response.data.length > 0) {
                                targetSelect.append($('<option></option>').val("").text("Please Select a Option"));
                                $.each(response.data, function (index, element) {
                                    var option = $('<option></option>').val(element.id).text(element.name);

                                    if (preSelected.length > 0 && element.id === parseInt(preSelected)) {
                                        option.prop('selected', (preSelected.length > 0));
                                    }

                                    targetSelect.append(option);
                                });
                            } else {
                                targetSelect.append($('<option></option>').val("").text("No Data Found"));
                            }
                        } else {
                            targetSelect.append($('<option></option>').val("").text("No Data Found"));
                            notify('No Data Found', 'warning', 'Ajax Response');
                        }
                    },
                    error: function (xhr) {
                        notify(xhr.responseText, 'error', 'Alert!');
                    }
                });
            }
        }

        function addMoreWorkExperience(event) {
            alert("triggered");
            var index = parseInt($("#job_index").val());

            $("#work_experiences").append(
                '<div class="work_experience  py-3 border-bottom">\n' +
                '                <div class="form-group row">\n' +
                '    <label for="job[' + index + '][company]" class="col-form-label col-sm-2">{{ __('enumerator.Company Name') }}<span style="color: #dc3545; font-weight:700">*</span></label>\n' +
                '\n' +
                '        <div class="col-sm-10">\n' +
                '        <input class="form-control" required="required" name="job[' + index + '][company]" type="text" id="job[' + index + '][company]">\n' +
                '\n' +
                '        <span id="job[' + index + '][company]-error" class="invalid-feedback"></span>\n' +
                '    </div>\n' +
                '</div>\n' +
                '\n' +
                '                <div class="form-group row">\n' +
                '    <label for="job[' + index + '][designation]" class="col-form-label col-sm-2">{{ __('enumerator.Designation') }}<span style="color: #dc3545; font-weight:700">*</span></label>\n' +
                '\n' +
                '        <div class="col-sm-10">\n' +
                '        <input class="form-control" required="required" name="job[' + index + '][designation]" type="text" id="job[' + index + '][designation]">\n' +
                '\n' +
                '        <span id="job[' + index + '][designation]-error" class="invalid-feedback"></span>\n' +
                '    </div>\n' +
                '</div>\n' +
                '\n' +
                '\n' +
                '                <div class="form-group row">\n' +
                '    <label for="job[' + index + '][start_date]" class="col-form-label col-sm-2">{{ __('enumerator.Service Start Date') }}<span style="color: #dc3545; font-weight:700">*</span></label>\n' +
                '\n' +
                '        <div class="col-sm-10">\n' +
                '        <input class="form-control" required="required" name="job[' + index + '][start_date]" type="date" id="job[' + index + '][start_date]">\n' +
                '\n' +
                '        <span id="job[' + index + '][start_date]-error" class="invalid-feedback"></span>\n' +
                '    </div>\n' +
                '</div>\n' +
                '\n' +
                '                <div class="form-group row">\n' +
                '    <label for="job[' + index + '][end_date]" class="col-form-label col-sm-2">{{ __('enumerator.Service End Date') }}<span style="color: #dc3545; font-weight:700">*</span></label>\n' +
                '\n' +
                '        <div class="col-sm-10">\n' +
                '        <input class="form-control" required="required" name="job[' + index + '][end_date]" type="date" id="job[' + index + '][end_date]">\n' +
                '\n' +
                '        <span id="job[' + index + '][end_date]-error" class="invalid-feedback"></span>\n' +
                '    </div>\n' +
                '</div>\n' +
                '\n' +
                '\n' +
                '                <div class="form-group row">\n' +
                '    <label for="job[' + index + '][responsibility]" class="col-form-label col-sm-2">{{ __('enumerator.Responsibility') }}<span style="color: #dc3545; font-weight:700">*</span></label>\n' +
                '\n' +
                '        <div class="col-sm-10">\n' +
                '        <textarea class="form-control" rows="3" required="required" name="job[' + index + '][responsibility]" cols="50" id="job[' + index + '][responsibility]"></textarea>\n' +
                '\n' +
                '        <span id="job[' + index + '][responsibility]-error" class="invalid-feedback"></span>\n' +
                '    </div>\n' +
                '</div>\n' +
                '\n' +
                '</div>\n');

            $("#job_index").val(++index);
        }

        function toggleEducationPanel(value) {
            if (!isNaN(value)) {
                $(".exam_level").each(function () {
                    $(this).removeClass('d-none').removeClass('d-block').addClass('d-none');
                });
                $("#exam_level_" + value).addClass("d-block");
            }
        }

        $(document).ready(function () {

            examGroups.forEach(function (item) {
                getExamGroupDropdown(item.exam_level_id, item.exam_title_id, item.target_select, item.exam_group_id);
            });
                        $("#exam_level").on('change', function () {
                            var value = $(this).val();
                            toggleEducationPanel(value);
                        });

                        if ($("#exam_level").val().length > 0) {
                            toggleEducationPanel($("#exam_level").val());
                        }
        });
        */
        $(document).ready(function () {
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
                        required: true,
                        digits: true,
                        mobilenumber: true
                    },
                    "email": {
                        required: true
                    },
                    "whatsapp": {
                        required: true,
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
                    dob : {
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
