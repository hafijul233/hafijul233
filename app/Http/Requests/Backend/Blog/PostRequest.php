<?php

namespace App\Http\Requests\Backend\Blog;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @class ServiceRequest
 * @package App\Http\Requests\Backend\Portfolio
 */
class PostRequest extends FormRequest
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
            "summary" => ["nullable", "string", "min:2"],
            "content" => ["required", "string", "min:2"],
            "image" => ["nullable", "image"]
        ];
    }
}
