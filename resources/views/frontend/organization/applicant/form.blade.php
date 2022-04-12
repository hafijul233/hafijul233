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
    {{--Basic Information--}}
    <fieldset>
        <legend class="border-bottom lead mb-3 py-2 ml-0 pxl-0 font-weight-bold">
            <i class="fas fa-user-check"></i> {!! __('enumerator.Basic Information') !!}
        </legend>
        {!! \Form::hText('name', __('enumerator.Name'), old('name', $enumerator->name ?? null), true, 2,
        ['style' => 'text-transform: uppercase']) !!}
        {!! \Form::hText('name_bd', __('enumerator.Name(Bangla)'), old('name_bd', $enumerator->name_bd ?? null), true) !!}
        {!!  \Form::hRadio('gender_id', __('enumerator.Gender'), $genders, 1, true) !!}

        {!! \Form::hText('father', __('enumerator.Father Name'), old('father', $enumerator->father ?? null), true) !!}
        {{--        {!! \Form::hText('father_bd', __('enumerator.Father Name(Bangla)'), old('father_bd', $enumerator->father_bd ?? null), true) !!}--}}

        {!! \Form::hText('mother', __('enumerator.Mother Name'), old('mother', $enumerator->mother ?? null), true) !!}
        {{--        {!! \Form::hText('mother_bd', __('enumerator.Mother Name(Bangla)'), old('mother_bd', $enumerator->mother_bd ?? null), true) !!}--}}

        {!! \Form::hNumber('nid', __('enumerator.NID Number'), old('nid', $enumerator->nid ?? null), true) !!}
        {!! \Form::hTextarea('present_address', __('enumerator.Present Address'), old('present_address', $enumerator->present_address ?? null), true) !!}
        {{--    {!! \Form::hTextarea('present_address_bd', __('enumerator.Present Address(Bangla)'), old('present_address_bd', $enumerator->present_address_bd ?? null), true) !!}--}}

        {!! \Form::hTextarea('permanent_address', __('enumerator.Permanent Address'), old('permanent_address', $enumerator->permanent_address ?? null), true) !!}
        {{--    {!! \Form::hTextarea('permanent_address_bd', __('enumerator.Permanent Address(Bangla)'), old('permanent_address_bd', $enumerator->permanent_address_bd ?? null), true) !!}--}}

        {!! \Form::hNumber('mobile_1', __('enumerator.Mobile 1'), old('mobile_1', $enumerator->mobile_1 ?? null), true) !!}
        {!! \Form::hNumber('mobile_2', __('enumerator.Mobile 2'), old('mobile_2', $enumerator->mobile_2 ?? null), true) !!}
        {!! \Form::hText('email', __('enumerator.Email'), old('email', $enumerator->email ?? null), true) !!}

        {!! \Form::hNumber('whatsapp', __('enumerator.Whatsapp Number'), old('whatsapp', $enumerator->whatsapp ?? null), true) !!}
        {!! \Form::hText('facebook', __('enumerator.Facebook ID'), old('facebook', $enumerator->facebook ?? null), true) !!}
        {!! \Form::hSelect('exam_level', __('enumerator.Highest Educational Qualification'), $exam_dropdown, old('exam_level', $enumerator->exam_level ?? null)) !!}
    </fieldset>
    <script>
        let examGroups = [];
    </script>
    {{-- Education Qualifications --}}
    @foreach( $exam_levels as $exam_level)
        @php
            $educationQualification = null;
                    if (isset($enumerator)) {
                        foreach ($enumerator->educationQualification as $tempEducationQualification) {
                            if($exam_level->id == $tempEducationQualification->exam_level_id) {
                                $educationQualification = $tempEducationQualification;
                            }
                        }
                    }
        @endphp
        <script>
            examGroups.push({
                exam_level_id: '{{ old($exam_level->code . '_exam_level_id', ($educationQualification->exam_level_id ?? $exam_level->id))}}',
                exam_title_id: '{{ old($exam_level->code . '_exam_title_id', ($educationQualification->exam_title_id ?? null)) }}',
                target_select: '{{$exam_level->code}}_exam_group_id',
                exam_group_id: '{{ old($exam_level->code . '_exam_group_id', ($educationQualification->exam_group_id?? null)) }}'
            });
        </script>
        <fieldset id="exam_level_{{ $exam_level->id }}" class="d-none exam_level">
            <legend class="border-bottom lead mb-3 py-2 ml-0 pxl-0 font-weight-bold">
                <i class="{!! $exam_level->icon ?? 'fas fa-school' !!}"></i>
                {!! __('enumerator.' . $exam_level->name) !!}
            </legend>
            {!! \Form::hidden($exam_level->code . '_exam_level_id', $exam_level->id) !!}
            {!! \Form::hSelect($exam_level->code . '_exam_title_id', __('enumerator.Examination'),
                \App\Supports\Utility::getExamTitleById($exam_level->id), old($exam_level->code . '_exam_title_id', $educationQualification->exam_title_id ?? null), true,2,
                 ['placeholder' => __('enumerator.Select a examination'),
                  'onchange' => 'getExamGroupDropdown(' . $exam_level->id .', this.value, "' . $exam_level->code .'_exam_group_id","' .($educationQualification->exam_group_id ?? null) .'")']) !!}

            @if(in_array($exam_level->code, ['ssc', 'hsc']))
                {!! \Form::hSelect($exam_level->code . '_exam_board_id', __('enumerator.Board'), $boards,
                old($exam_level->code . '_exam_board_id', $educationQualification->exam_board_id ?? null), true, 2,
                    ['placeholder' => __('enumerator.Please select a board')]) !!}

                {!! \Form::hSelect($exam_level->code . '_exam_group_id', __('enumerator.Group/Subject'), [],
                old($exam_level->code . '_exam_group_id', $educationQualification->exam_group_id ?? null), true, 2,
                 ['placeholder' => __('enumerator.Please select a examination first')]) !!}
            @else
                {!! \Form::hSelect($exam_level->code . '_institute_id', __('enumerator.Institute'), $universities,
                old($exam_level->code . '_institute_id', $educationQualification->institute_id ?? null), true, 2,
                ['placeholder' => __('enumerator.Please select a institute')]) !!}

                {!! \Form::hSelect($exam_level->code . '_exam_group_id', __('enumerator.Subject/Degree'), [],
                old($exam_level->code . '_exam_group_id', $educationQualification->group_id ?? null), true, 2,
                 ['placeholder' => __('enumerator.Please select a examination first')]) !!}
            @endif

            {!! \Form::hNumber($exam_level->code . '_pass_year', __('enumerator.Passing Year'),
            old($exam_level->code . '_pass_year', $educationQualification->pass_year ?? null), true, ) !!}
            {!! \Form::hNumber($exam_level->code . '_roll_number', __('enumerator.Roll Number'),
            old($exam_level->code . '_roll_number', $educationQualification->roll_number ?? null), true, ) !!}

            {!! \Form::hSelect($exam_level->code . '_grade_type', __('enumerator.Result'),
            \App\Supports\Constant::GPA_TYPE, old($exam_level->code . '_grade_type', $educationQualification->grade_type ?? null), true, 2,
                ['placeholder' => __('enumerator.Please select a result')]) !!}
            {!! \Form::hNumber($exam_level->code . '_grade_point', __('enumerator.GPA Point'),
            old($exam_level->code . '_grade_point', $educationQualification->grade_point ?? null), true) !!}
        </fieldset>
    @endforeach
    {{--Work Experience--}}
    <fieldset>
        <legend class="border-bottom lead mb-3 py-2 ml-0 pxl-0 font-weight-bold">
            <i class="fas fa-user-cog"></i> {!! __('enumerator.Work Experience') !!}
        </legend>
        {!! \Form::hCheckbox('survey_id', __('enumerator.Survey'), $surveys, old('survey_id', $enumerator->survey_id ?? []),
    true, 2, ['placeholder' => __("enumerator.Select a Survey Option")]) !!}
        {{--
                @php $index = count(old('job', [])); @endphp
                <input type="hidden" id="job_index" value="{{ $index+1 }}">
                <div id="work_experiences">
                    @if($index > 0 )
                        @foreach(old('job') as $index => $workQualification)
                            <div class="work_experience py-2 border-bottom">
                                {!! \Form::hText("job[{$index}][company]", __('enumerator.Company Name'),  ($workQualification['company'] ?? null), true) !!}
                                {!! \Form::hText("job[{$index}][designation]", __('enumerator.Designation'), ($workQualification['designation'] ?? null), true) !!}

                                {!! \Form::hDate("job[{$index}][start_date]", __('enumerator.Service Start Date'), ($workQualification['start_date'] ?? null), true) !!}
                                {!! \Form::hDate("job[{$index}][end_date]", __('enumerator.Service End Date'), ($workQualification['end_date'] ?? null), true) !!}

                                {!! \Form::hTextarea("job[{$index}][responsibility]", __('enumerator.Responsibility'), ($workQualification['responsibility'] ?? null), true) !!}
                            </div>
                        @endforeach
                    @else
                        <div class="work_experience  py-2 border-bottom">
                            {!! \Form::hText("job[{$index}][company]", __('enumerator.Company Name'),  ($workQualification['company'] ?? null), true) !!}
                            {!! \Form::hText("job[{$index}][designation]", __('enumerator.Designation'), ($workQualification['designation'] ?? null), true) !!}

                            {!! \Form::hDate("job[{$index}][start_date]", __('enumerator.Service Start Date'), ($workQualification['start_date'] ?? null), true) !!}
                            {!! \Form::hDate("job[{$index}][end_date]", __('enumerator.Service End Date'), ($workQualification['end_date'] ?? null), true) !!}

                            {!! \Form::hTextarea("job[{$index}][responsibility]", __('enumerator.Responsibility'), ($workQualification['responsibility'] ?? null), true) !!}
                        </div>
                    @endif
                </div>
                <div class="row mt-3">
                    <div class="col-12 justify-content-center d-flex">
                        <button class="btn btn-primary font-weight-bold" type="button"
                                onclick="addMoreWorkExperience(this); return false;">
                            <i class="fas fa-plus font-weight-bold"></i>&nbsp;&nbsp;{!! __('common.Add') !!}
                        </button>
                    </div>
                </div>
        --}}
    </fieldset>

    <div class="row mt-3">
        <div class="col-12 justify-content-end d-flex">
            {!! \Form::nSubmit('submit', __('common.Save')) !!}
        </div>
    </div>
</div>

@push('page-script')
    <script>

        function getExamGroupDropdown(examLevelId, examTitleId, targetIdString, preSelected = '') {
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

        $(document).ready(function () {
            examGroups.forEach(function (item) {
                getExamGroupDropdown(item.exam_level_id, item.exam_title_id, item.target_select, item.exam_group_id);
            });

            $("#enumerator-form").validate({
                rules: {
                    "survey_id": {
                        required: true,
                        digits: true
                    },
                    "name": {
                        required: true,
                        minLength: 2,
                        maxLength: 255,
                        nametitle: true
                    },
                    "name_bd":
                        {
                            required: true,
                            minLength: 2,
                            maxLength: 255

                        },
                    "father":
                        {
                            required: true
                        },
                    "father_bd":
                        {
                            required: true
                        },
                    "mother":
                        {
                            required: true
                        },
                    "mother_bd":
                        {
                            required: true
                        },
                    "nid":
                        {
                            required: true,
                        },
                    "mobile_1":
                        {
                            required: true,
                        },
                    "mobile_2":
                        {
                            required: true,
                        },
                    "email":
                        {
                            required: true,
                        },
                    "present_address":
                        {
                            required: true
                        },
                    "present_address_bd":
                        {
                            required: true
                        },
                    "permanent_address":
                        {
                            required: true
                        },
                    "permanent_address_bd":
                        {
                            required: true
                        },
                    "gender_id":
                        {
                            required: true,
                        },
                    "ssc_exam_title_id":
                        {
                            required: true,
                        },
                    "ssc_board_id":
                        {
                            required: true,
                        },
                    "ssc_group_id":
                        {
                            required: true,
                        },
                    "ssc_pass_year":
                        {
                            required: true,
                        },
                    "ssc_roll_number":
                        {
                            required: true,
                        },
                    "ssc_grade_type":
                        {
                            required: true,
                        },
                    "ssc_grade_point":
                        {
                            required: true
                        },
                    "hsc_exam_title_id":
                        {
                            required: true,
                        },
                    "hsc_board_id":
                        {
                            required: true,
                        },
                    "hsc_group_id":
                        {
                            required: true,
                        },
                    "hsc_pass_year":
                        {
                            required: true,
                        },
                    "hsc_roll_number":
                        {
                            required: true,
                        }
                    ,
                    "hsc_grade_type":
                        {
                            required: true,
                        },
                    "hsc_grade_point":
                        {
                            required: true
                        },
                    "gra_exam_title_id":
                        {
                            required: true,
                        },
                    "gra_institute_id":
                        {
                            required: true,
                        },
                    "gra_group_id":
                        {
                            required: true,
                        },
                    "gra_pass_year":
                        {
                            required: true,
                        },
                    "gra_roll_number":
                        {
                            required: true,
                        },
                    "gra_grade_type":
                        {
                            required: true,
                        },
                    "gra_grade_point":
                        {
                            required: true
                        },
                    "mas_exam_title_id":
                        {
                            required: true,
                        },
                    "mas_institute_id":
                        {
                            required: true,
                        },
                    "mas_group_id":
                        {
                            required: true,
                        },
                    "mas_pass_year":
                        {
                            required: true,
                        },
                    "mas_roll_number":
                        {
                            required: true,
                        },
                    "mas_grade_type":
                        {
                            required: true,
                        },
                    "mas_grade_point":
                        {
                            required: true
                        },
                    "job_company_name":
                        {
                            required: true
                        },
                    "job_designation":
                        {
                            required: true
                        },
                    "job_start_date":
                        {
                            required: true
                        },
                    "job_end_date":
                        {
                            required: true
                        },
                    "job_responsibility":
                        {
                            required: true
                        }
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

            $("#exam_level").on('change', function () {
                var value = $(this).val();
                $(".exam_level").each(function () {
                    $(this).hide();
                });

                $("#exam_level_" + value).addClass("d-block");
            });
        });
    </script>
@endpush
