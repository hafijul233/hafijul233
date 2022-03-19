<?php

namespace App\Http\Requests\Backend\Organization;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @class EnumeratorRequest
 * @package App\Http\Requests\Backend\Organization
 */
class EnumeratorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "survey_id" => ["required", "integer", "min:1"],
            "name" => ["required", "string", "min:2", "max:255"],
            "name_bd" => ["required", "string", "min:2", "max:255"],
            "father" => ["required", "string", "min:2", "max:255"],
            "father_bd" => ["required", "string", "min:2", "max:255"],
            "mother" => ["required", "string", "min:2", "max:255"],
            "mother_bd" => ["required", "string", "min:2", "max:255"],
            "nid" => ["required", "integer"],
            "mobile_1" => ["required", "string", new PhoneNumber ],
            "mobile_2" => ["required", "string", new PhoneNumber ],
            "email" => ["required", "string", "email:rfc,dns"],
            "present_address" => ["required", "string", "min:2", "max:255"],
            "present_address_bd" => ["required", "string", "min:2", "max:255"],
            "permanent_address" => ["required", "string", "min:2", "max:255"],
            "permanent_address_bd" => ["required", "string", "min:2", "max:255"],
            "gender_id" => ["required", "integer"],
            "ssc_exam_title_id" => ["required", "integer"],
            "ssc_exam_board_id" => ["required", "integer"],
            "ssc_exam_group_id" => ["required", "integer"],
            "ssc_pass_year" => ["required", "integer", "min:1900", "max:" . date("Y")],
            "ssc_roll_number" => ["required", "integer"],
            "ssc_grade_type" => ["required", "integer"],
            "ssc_grade_point" => ["required", "numeric"],
            "hsc_exam_title_id" => ["required", "integer"],
            "hsc_exam_board_id" => ["required", "integer"],
            "hsc_exam_group_id" => ["required", "integer"],
            "hsc_pass_year" => ["required", "integer", "min:1900", "max:" . date("Y")],
            "hsc_roll_number" => ["required", "integer"],
            "hsc_grade_type" => ["required", "integer"],
            "hsc_grade_point" => ["required", "numeric"],
            "gra_exam_title_id" => ["required", "integer"],
            "gra_institute_id" => ["required", "integer"],
            "gra_exam_group_id" => ["required", "integer"],
            "gra_pass_year" => ["required", "integer", "min:1900", "max:" . date("Y")],
            "gra_roll_number" => ["required", "integer"],
            "gra_grade_type" => ["required", "integer"],
            "gra_grade_point" => ["required", "numeric"],
            "mas_exam_title_id" => ["required", "integer"],
            "mas_institute_id" => ["required", "integer"],
            "mas_exam_group_id" => ["required", "integer"],
            "mas_pass_year" => ["required", "integer", "min:1900", "max:" . date("Y")],
            "mas_roll_number" => ["required", "integer"],
            "mas_grade_type" => ["required", "integer"],
            "mas_grade_point" => ["required", "numeric"],
            "job_company" => ["required", "string"],
            "job_designation" => ["required", "string"],
            "job_start_date" => ["required", "date"],
            "job_end_date" => ["required", "date"],
            "job_responsibility" => ["required", "string"],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            "survey_id" => "survey",
            "name_bd" => "name(bangla)",
            "father" => "father name",
            "father_bd" => "father name(bangla)",
            "mother" => "mother name",
            "mother_bd" => "mother name(bangla)",
            "nid" => "nid number",
            "mobile_1" => "mobile number 1",
            "mobile_2" => "mobile number 2",
            "email" => "email address",
            "present_address_bd" => "present address(bangla)",
            "permanent_address_bd" => "permanent address (bangla)",
            "gender_id" => "gender",
            "ssc_exam_title_id" => "examination",
            "ssc_exam_board_id" => "board",
            "ssc_exam_group_id" => "ssc group/subject",
            "ssc_pass_year" => "passing year",
            "ssc_roll_number" => "roll number",
            "ssc_grade_type" => "result",
            "ssc_grade_point" => "gpa point",
            "hsc_exam_title_id" => "examination",
            "hsc_exam_board_id" => "board",
            "hsc_exam_group_id" => "hsc group/subject",
            "hsc_pass_year" => "passing year",
            "hsc_roll_number" => "roll number",
            "hsc_grade_type" => "result",
            "hsc_grade_point" => "gpa point",
            "gra_exam_title_id" => "examination",
            "gra_institute_id" => "institute",
            "gra_exam_group_id" => "graduate subject/degree",
            "gra_pass_year" => "passing year",
            "gra_roll_number" => "roll number",
            "gra_grade_type" => "result",
            "gra_grade_point" => "gpa point",
            "mas_exam_title_id" => "examination",
            "mas_institute_id" => "institute",
            "mas_exam_group_id" => "post graduate subject/degree",
            "mas_pass_year" => "passing year",
            "mas_roll_number" => "roll number",
            "mas_grade_type" => "result",
            "mas_grade_point" => "gpa point",
            "job_company" => "company",
            "job_designation" => "designation",
            "job_start_date" => "start date",
            "job_end_date" => "end date",
            "job_responsibility" => "responsibility",
        ];
    }
}
