<?php

namespace App\Http\Requests\Backend\Portfolio;

use App\Rules\MaxLength;
use App\Rules\MinLength;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @class ProjectRequest
 * @package App\Http\Requests\Backend\Portfolio
 */
class ProjectRequest extends FormRequest
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
            "start_date" => ["required", "date"],
            "end_date" => ["nullable", "date"],
            "name" => ["required", "string", "min:2", "max:255"],
            "owner" => ["required", "string", "min:2", "max:255"],
            "url" => ["nullable", "url", "min:2"],
            "description" => ["nullable", "string"],
            "associate" => ["nullable", "string"],
            "image" => ["nullable", "image"]
        ];
    }
}
