<?php

namespace App\Http\Requests\Frontend\Organization;

use App\Rules\MaxLength;
use App\Rules\MinLength;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @class EnumeratorRequest
 * @package App\Http\Requests\Backend\Organization
 */
class ApplicantRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "dob" => ["required", "date"],
            "exam_level" => ["required", "integer", "min:1", "max:5"],
            "whatsapp" => ["required", "string", new PhoneNumber],
            "facebook" => ["required", "string", "url"],
            "survey_id" => ["array", "required"],
            "survey_id.*" => ["required", "integer", "min:1"],
            "name" => ["required", "string", "min:2", "max:255"],
            "name_bd" => ["required", "string", "min:2", "max:255"],
            "father" => ["required", "string", "min:2", "max:255"],
            "mother" => ["required", "string", "min:2", "max:255"],
            "nid" => ["required", "integer", new MinLength(10), new MaxLength(17)],
            "mobile_1" => ["required", "string", new PhoneNumber],
            "mobile_2" => ["required", "string", new PhoneNumber],
            "email" => ["required", "string", "email:rfc,dns"],
            "present_address" => ["required", "string", "min:2", "max:255"],
            "permanent_address" => ["required", "string", "min:2", "max:255"],
            "gender_id" => ["required", "integer"],
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
        ];
    }
}
