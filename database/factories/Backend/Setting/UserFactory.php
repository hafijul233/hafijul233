<?php

namespace Database\Factories\Backend\Setting;

use App\Models\Backend\Setting\User;
use App\Services\Backend\Common\FileUploadService;
use App\Supports\Constant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{

    /**
     * @var User $model
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'username' => $this->faker->unique()->userName(),
            'mobile' => str_replace('+', '0', $this->faker->unique()->e164PhoneNumber()),
            'force_pass_reset' => false,
            'remarks' => $this->faker->paragraph(2),
            'enabled' => Constant::ENABLED_OPTION,
            'email_verified_at' => now(),
            'locale' => Constant::LOCALE,
            'home_page' => Constant::DASHBOARD_ROUTE,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): UserFactory
    {
        $fileUploadService = new FileUploadService();

        return $this->afterCreating(function (User $user) use ($fileUploadService) {
            //add profile image
            $profileImagePath = $fileUploadService->createAvatarImageFromText($user->name);
            if (is_string($profileImagePath)) {
                $user->addMedia($profileImagePath)->toMediaCollection('avatars')->save();
            }
        });
    }

    /**
     * @return UserFactory
     * Admins, Manager, Operator, Accountant ...
     */
    public function asUser()
    {
        return $this->afterCreating(function (User $user) {
            //attach role
            $user->roles()->attach(mt_rand(2, 5));
        });

    }
}
