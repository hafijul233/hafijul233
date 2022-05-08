<?php

namespace App\Http\Requests\Backend\Resume;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @class SkillRequest
 * @package App\Http\Requests\Backend\Resume
 */
class SkillRequest extends FormRequest
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
            "client" => ["required", "string", "min:2", "max:255"],
            "feedback" => ["required", "string", "min:2"],
            "image" => ["nullable", "image"]
        ];
    }
}
