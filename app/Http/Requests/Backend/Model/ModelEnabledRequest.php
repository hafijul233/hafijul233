<?php
namespace App\Http\Requests\Backend\Model;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ModelEnabledRequest
 * @package App\Http\Requests\Backend\Common
 */
class ModelEnabledRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /*        return auth()->user()->can('permissions.store') ||
                    auth()->user()->can('permissions.update') ||
                    true;*/
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
