<?php

namespace Database\Seeders\Backend;

use App\Models\Backend\Setting\Role;
use App\Models\Backend\Setting\User;
use App\Repositories\Eloquent\Backend\Common\AddressBookRepository;
use App\Repositories\Eloquent\Backend\Setting\UserRepository;
use App\Services\Backend\Common\FileUploadService;
use App\Supports\Constant;
use App\Supports\Utility;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Throwable;

class SARegisterSeeder extends Seeder
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;
    /**
     * @var AddressBookRepository
     */
    private $addressBookRepository;


    /**
     * UserSeeder constructor.
     * @param UserRepository $userRepository
     * @param FileUploadService $fileUploadService
     * @param AddressBookRepository $addressBookRepository
     */
    public function __construct(UserRepository $userRepository,
                                FileUploadService $fileUploadService,
                                AddressBookRepository $addressBookRepository)
    {
        $this->userRepository = $userRepository;
        $this->fileUploadService = $fileUploadService;
        $this->addressBookRepository = $addressBookRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception|Throwable
     */
    public function run()
    {
        Model::unguard();
        //disable Observer
        $eventDispatcher = User::getEventDispatcher();
        User::unsetEventDispatcher();

        //Default User "Ami"

        try {
            $newUser = [
                'name' => 'Mohammad Hafijul Islam',
                'username' => 'hafijul233',
                'email' => 'hafijul233@gmail.com',
                'password' => Utility::hashPassword('Hafijul14_B'),
                'mobile' => '01710534092',
                'remarks' => 'Database Seeder',
                'enabled' => Constant::ENABLED_OPTION,
                'force_pass_reset' => false
            ];

            $newUser = $this->userRepository->create($newUser);
            if ($newUser instanceof User) {
                if (!$this->attachProfilePicture($newUser)) {
                    //throw new \RuntimeException("User Photo Create Failed");
                }

                if (!$this->attachUserRoles($newUser)) {
                    throw new \RuntimeException("User Role Assignment Failed");
                }

            } else {
                throw new \RuntimeException("Failed to Create  User Model");
            }
        } catch (Exception $exception) {
            $this->userRepository->handleException($exception);
        }

        //Enable observer
        User::setEventDispatcher($eventDispatcher);
    }

    /**
     * Attach Profile Image to User Model
     *
     * @param User $user
     * @return bool
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws Exception
     */
    protected function attachProfilePicture(User $user): bool
    {
        //add profile image
        $profileImagePath = $this->fileUploadService->createAvatarImageFromText($user->name);
        if (is_string($profileImagePath)) {
            return $user->addMedia($profileImagePath)->toMediaCollection('avatars')->save();
        }
        return false;
    }

    /**
     * Attach Role to user Model
     *
     * @param User $user
     * @return bool
     */
    protected function attachUserRoles(User $user): bool
    {

        $adminRole = Role::findByName(Constant::SUPER_ADMIN_ROLE);
        $this->userRepository->setModel($user);
        return $this->userRepository->manageRoles([$adminRole->id]);
    }

}
