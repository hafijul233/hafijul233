<?php

namespace App\Http\Requests\Backend\Setting;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @class StateRequest
 * @package App\Http\Requests\Backend\Setting
 */
class StateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "country_id" => "required|integer",
            "name" => "required|string",
            "native" => "required|string",
            "type" => "required|string",
            "latitude" => "nullable|numeric",
            "longitude" => "nullable|numeric",
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
