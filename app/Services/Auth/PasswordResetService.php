<?php

namespace App\Services\Auth;


use App\Models\Backend\Setting\User;
use App\Repositories\Eloquent\Backend\Setting\UserRepository;
use App\Supports\Constant;
use App\Supports\Utility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * create a new token to  reset user password
     *
     * @param array $credentials
     * @return array
     */
    public function createPasswordResetToken(array $credentials): array
    {
        if (config('auth.credential_field') === Constant::LOGIN_OTP) {
            return $this->otpBasedPasswordReset($credentials);
        }

        return $this->credentialBasedPasswordReset($credentials);
    }

    /**
     * @param array $credentials
     * @return array
     */
    public function updatePassword(array $credentials): array
    {
        $status = Password::reset(
            $credentials,
            function ($user) use ($credentials) {
                $confirmation = $this->userRepository->update([
                    'password' => Utility::hashPassword($credentials['password']),
                    'force_pass_reset' => 0,
                    'remember_token' => Str::random(60),
                ], $user->id);
                //event(new PasswordReset($user));
            }
        );

        switch ($status) {
            case Password::PASSWORD_RESET:
                $confirmation = ['status' => true,
                    'message' => __('passwords.reset'),
                    'level' => Constant::MSG_TOASTR_SUCCESS,
                    'title' => 'Notification!'];
                break;

            case Password::RESET_THROTTLED :
                $confirmation = ['status' => false,
                    'message' => __('auth.throttle', ['seconds' => config('auth.passwords.users.throttle')]),
                    'level' => Constant::MSG_TOASTR_ERROR,
                    'title' => 'Alert!'];
                break;

            case Password::INVALID_TOKEN:
                $confirmation = ['status' => false,
                    'message' => __('passwords.token'),
                    'level' => Constant::MSG_TOASTR_ERROR,
                    'title' => 'Alert!'];
                break;

            default:
                $confirmation = ['status' => false,
                    'message' => __('auth.login.failed'),
                    'level' => Constant::MSG_TOASTR_ERROR,
                    'title' => 'Alert!'];
                break;
        }

        return $confirmation;

    }

    /**
     * @param array $credentials
     * @return array
     */
    private function credentialBasedPasswordReset(array $credentials): array
    {
        $resetToken = null;

        $status = Password::sendResetLink($credentials, function (User $user, string $token) use (&$resetToken) {
            $resetToken = $token;
        });

        switch ($status) {
            case Password::RESET_LINK_SENT:
                $confirmation = ['status' => true,
                    'message' => __('auth.token', ['minutes' => config('auth.passwords.users.expire')]),
                    'level' => Constant::MSG_TOASTR_SUCCESS,
                    'title' => 'Notification!',
                    'token' => $resetToken];
                break;

            case Password::RESET_THROTTLED :
                $confirmation = ['status' => false,
                    'message' => __('auth.throttle', ['seconds' => config('auth.passwords.users.throttle')]),
                    'level' => Constant::MSG_TOASTR_ERROR,
                    'title' => 'Alert!'];
                break;

            default:
                $confirmation = ['status' => false,
                    'message' => __('auth.login.failed'),
                    'level' => Constant::MSG_TOASTR_ERROR,
                    'title' => 'Alert!'];
                break;
        }

        return $confirmation;
    }

    /**
     * @param array $credential
     * @return array
     */
    private function otpBasedPasswordReset(array $credential): array
    {
        $confirmation = ['status' => false, 'message' => __('auth.login.failed'), 'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];

        if (Auth::attempt($credential)) {
            $confirmation = ['status' => true, 'message' => __('auth.login.success'), 'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification'];
        }

        return $confirmation;
    }
}
