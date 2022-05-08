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
            "title" => ["required", "string", "min:2", "max:255"],
            "organization" => ["required", "string", "min:2", "max:255"],
            "issue_date" => ["required", "date"],
            "expire_date" => ["nullable", "date"],
            "credential" => ["nullable", "string", "min:2", "max:255"],
            "verify_url" => ["nullable", "url", "min:2", "max:255"],
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
