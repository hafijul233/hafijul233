<div class="card-body">
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
        {!! \Form::hNumber('mobile_2', __('enumerator.Mobile 2'), old('mobile_2', $enumerator->mobile_2 ?? null), true, 3) !!}
        {!! \Form::hText('email', __('enumerator.Email'), old('email', $enumerator->email ?? null), true, 3) !!}
        {!! \Form::hNumber('whatsapp', __('enumerator.Whatsapp Number'), old('whatsapp', $enumerator->whatsapp ?? null), true, 3) !!}
        {!! \Form::hUrl('facebook', __('enumerator.Facebook ID'), old('facebook', $enumerator->facebook ?? null), true, 3) !!}
        {!! \Form::hCheckbox('survey_id', __('enumerator.Survey'), $surveys, old('survey_id', $enumerator->survey_id ?? []),
    true, 3, ['placeholder' => __("enumerator.Select a Survey Option")]) !!}
        <div class="row mt-3">
            <div class="col-12 justify-content-end d-flex">
                {!! \Form::nSubmit('submit', __('common.Save')) !!}
            </div>
        </div>
    </div>
</div>

@push('page-script')
    <script>
        $(document).ready(function () {
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
        });
    </script>
@endpush
