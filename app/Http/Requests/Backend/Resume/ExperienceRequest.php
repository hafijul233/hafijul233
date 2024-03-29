<?php

namespace App\Http\Requests\Backend\Resume;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @class ExperienceRequest
 * @package App\Http\Requests\Backend\Resume
 */
class ExperienceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title" => ["required", "string", "min:2", "max:255"],
            "type" => ["required", "string", "min:2", "max:255"],
            "organization" => ["required", "string", "min:2", "max:255"],
            "start_date" => ["required", "date"],
            "end_date" => ["nullable", "date"],
            "address" => ["nullable", "string", "min:2", "max:255"],
            "url" => ["nullable", "url", "min:2", "max:255"],
            "description" => ["nullable", "string", "min:2"],
            "image" => ["nullable", "image"]
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
}
