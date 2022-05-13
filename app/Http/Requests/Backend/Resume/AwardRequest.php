<?php

namespace App\Http\Requests\Backend\Resume;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @class AwardRequest
 * @package App\Http\Requests\Backend\Resume
 */
class AwardRequest extends FormRequest
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
            "title" => ["required", "string", "min:2", "max:255"],
            "associate" => ["nullable", "string", "min:2"],
            "issuer" => ["required", "string", "min:2"],
            "issue_date" => ["required", "date"],
            "url" => ["nullable", "url"],
            "description" => ["nullable", "string", "min:2"],
            "image" => ["nullable", "image"]
        ];
    }
}
