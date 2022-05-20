<?php

namespace App\Http\Requests\Backend\Blog;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @class EnumeratorRequest
 * @package App\Http\Requests\Backend\Portfolio
 */
class NewsLetterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => ["required", "string", "min:2", "max:255"],
            "mobile" => ["required", "string", "min:2", "max:255"],
            "email" => ["required", "email"],
            "website" => ["nullable", "url", "min:2", "max:255"],
            "message" => ["nullable", "string", "min:2"]
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
