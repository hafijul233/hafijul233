<?php

namespace App\Http\Requests\Backend\Portfolio;

use App\Rules\MaxLength;
use App\Rules\MinLength;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @class EnumeratorRequest
 * @package App\Http\Requests\Backend\Portfolio
 */
class UpdateEnumeratorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "id" => ["required", "integer"],
            "dob" => ["required", "date"],
            "exam_level" => ["required", "integer", "min:1", "max:5"],
            "whatsapp" => ["nullable", "string", new PhoneNumber],
            "facebook" => ["nullable", "string", "url"],
            "survey_id" => ["array", "required"],
            "survey_id.*" => ["required", "integer", "min:1"],
            "name" => ["required", "string", "min:2", "max:255"],
            "name_bd" => ["required", "string", "min:2", "max:255"],
            "father" => ["required", "string", "min:2", "max:255"],
            "mother" => ["required", "string", "min:2", "max:255"],
            "nid" => ["required", "integer", new MinLength(10), new MaxLength(17),
                Rule::unique('enumerators', 'nid')->ignore($this->id)
            ],
            "mobile_1" => ["required", "string", new PhoneNumber],
            "mobile_2" => ["nullable", "string", new PhoneNumber],
            "email" => ["required", "string", "email:rfc,dns"],
            "present_address" => ["required", "string", "min:2", "max:255"],
            "permanent_address" => ["required", "string", "min:2", "max:255"],
            "gender_id" => ["required", "integer"],
            "is_employee" => ["required", "string", Rule::in(['yes', 'no'])],
            "designation" => ["nullable", "string"],
            "company" => ["nullable", "string"],
            "prev_post_state_id" => ["array", "nullable"],
            "prev_post_state_id.*" => ["required", "integer", "min:1"],
            "future_post_state_id" => ["array", "nullable", "max:3"],
            "future_post_state_id.*" => ["required", "integer", "min:1"],
        ];
    }

    /**
     * return label title array
     * @return array
     */
    public function attributes()
    {
        return [
            "dob" => __('certificate.Date of Birth'),
            "exam_level" => __('certificate.Highest Educational Qualification'),
            "whatsapp" => __('certificate.Whatsapp Number'),
            "facebook" => __('certificate.Facebook ID'),
            "survey_id" => __('certificate.Comment'),
            "survey_id.*" => __('certificate.Comment'),
            "name" => __('certificate.Name'),
            "name_bd" => __('certificate.Name(Bangla)'),
            "father" => __('certificate.Father Name'),
            "mother" => __('certificate.Mother Name'),
            "nid" => __('certificate.NID Number'),
            "mobile_1" => __('certificate.Mobile 1'),
            "mobile_2" => __('certificate.Mobile 2'),
            "email" => __('certificate.Email'),
            "present_address" => __('certificate.Present Address'),
            "permanent_address" => __('certificate.Permanent Address'),
            "gender_id" => __('certificate.Gender'),
            "is_employee" => __('certificate.Are you revenue staff of BBS?'),
            "designation" => __('certificate.Designation'),
            "company" => __('certificate.Company Name'),
            "prev_post_state_id" => __('certificate.Select the district(s) where you have worked earlier (it can be multiple)'),
            "future_post_state_id" => __('certificate.Select the district(s) where you want to work in future (maximum 3)')
        ];
    }
}
