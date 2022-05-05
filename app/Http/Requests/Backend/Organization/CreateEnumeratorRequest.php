<?php

namespace App\Http\Requests\Backend\Organization;

use App\Rules\MaxLength;
use App\Rules\MinLength;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @class EnumeratorRequest
 * @package App\Http\Requests\Backend\Portfolio
 */
class CreateEnumeratorRequest extends FormRequest
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
            "id" => ["nullable", "integer"],
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
                'unique:App\Models\Backend\Organization\Enumerator,nid'
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
            "dob" => __('enumerator.Date of Birth'),
            "exam_level" => __('enumerator.Highest Educational Qualification'),
            "whatsapp" => __('enumerator.Whatsapp Number'),
            "facebook" => __('enumerator.Facebook ID'),
            "survey_id" => __('enumerator.Survey'),
            "survey_id.*" => __('enumerator.Survey'),
            "name" => __('enumerator.Name'),
            "name_bd" => __('enumerator.Name(Bangla)'),
            "father" => __('enumerator.Father Name'),
            "mother" => __('enumerator.Mother Name'),
            "nid" => __('enumerator.NID Number'),
            "mobile_1" => __('enumerator.Mobile 1'),
            "mobile_2" => __('enumerator.Mobile 2'),
            "email" => __('enumerator.Email'),
            "present_address" => __('enumerator.Present Address'),
            "permanent_address" => __('enumerator.Permanent Address'),
            "gender_id" => __('enumerator.Gender'),
            "is_employee" => __('enumerator.Are you revenue staff of BBS?'),
            "designation" => __('enumerator.Designation'),
            "company" => __('enumerator.Company Name'),
            "prev_post_state_id" => __('enumerator.Select the district(s) where you have worked earlier (it can be multiple)'),
            "future_post_state_id" => __('enumerator.Select the district(s) where you want to work in future (maximum 3)')
        ];
    }
}
