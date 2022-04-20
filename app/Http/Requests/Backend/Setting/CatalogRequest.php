<?php

namespace App\Http\Requests\Backend\Setting;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @class CityRequest
 * @package App\Http\Requests\Backend\Setting
 */
class CatalogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "type" => "required|string",
            "name" => "required|string",
            "enabled" => "required|string",
            "remarks" => "nullable|string"
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
