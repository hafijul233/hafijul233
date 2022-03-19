<?php

namespace App\Http\Requests\Backend\Organization;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @class EnumeratorRequest
 * @package App\Http\Requests\Backend\Organization
 */
class SurveyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'enabled' => 'required',
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
