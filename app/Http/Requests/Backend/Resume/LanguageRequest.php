<?php

namespace App\Http\Requests\Backend\Resume;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @class LanguageRequest
 * @package App\Http\Requests\Backend\Resume
 */
class LanguageRequest extends FormRequest
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
            "name" => ["required", "string", "min:2", "max:255"],
            "level" => ["required", "string", "min:2"],
            "image" => ["nullable", "image"]
        ];
    }
}
