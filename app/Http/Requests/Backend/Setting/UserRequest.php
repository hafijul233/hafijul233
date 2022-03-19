<?php

namespace App\Http\Requests\Backend\Setting;

use App\Rules\PhoneNumber;
use App\Rules\Username;
use App\Supports\Constant;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'photo' => ['nullable', 'image', 'max:10000'],
            'enabled' => ['nullable', 'string', 'min:2', 'max:3'],
            'role_id' => ['required', 'array', 'min:1', 'max:3'],
            'role_id.*' => ['required', 'integer', 'min:1', 'max:255'],
            'remarks' => ['nullable', 'string', 'min:3', 'max:255'],
            'username' => ['string', 'min:5', 'max:255', new Username, 'unique:users,username,' . $this->user],
            'email' => ['string', 'min:3', 'max:255', 'email', 'unique:users,email,' . $this->user],
            'mobile' => ['string', 'min:11', 'max:13', new PhoneNumber, 'unique:users,mobile,' . $this->user],
        ];


        //Credential Field
        if (config('auth.credential_field') == Constant::LOGIN_EMAIL
            || (config('auth.credential_field') == Constant::LOGIN_OTP
                && config('auth.credential_otp_field') == Constant::OTP_EMAIL)):
            array_push($rules['email'],'required');
        else :
            array_push($rules['email'],'nullable');
        endif;

        if (config('auth.credential_field') == Constant::LOGIN_MOBILE
            || (config('auth.credential_field') == Constant::LOGIN_OTP
                && config('auth.credential_otp_field') == Constant::OTP_MOBILE)) :
            array_push($rules['mobile'],'required');
        else :
            array_push($rules['mobile'],'nullable');
        endif;

        if (config('auth.credential_field') == Constant::LOGIN_USERNAME) :
            array_push($rules['username'],'required');
        else :
            array_push($rules['username'],'nullable');
        endif;

        return  $rules;
    }
}
