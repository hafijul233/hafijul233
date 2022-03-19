<?php

namespace App\Services\Backend\Shipment;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Shipment\CustomerExport;
use App\Models\Backend\Setting\User;
use App\Repositories\Eloquent\Backend\Common\AddressBookRepository;
use App\Repositories\Eloquent\Backend\Setting\UserRepository;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Common\FileUploadService;
use App\Supports\Constant;
use App\Supports\Utility;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Throwable;

/**
 * @class CustomerService
 * @package App\Services\Backend\Shipment
 */
class CustomerService extends Service
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
     * CustomerService constructor.
     * @param UserRepository $userRepository
     * @param FileUploadService $fileUploadService
     * @param AddressBookRepository $addressBookRepository
     */
    public function __construct(UserRepository        $userRepository,
                                FileUploadService     $fileUploadService,
                                AddressBookRepository $addressBookRepository)
    {
        $this->userRepository = $userRepository;
        $this->userRepository->itemsPerPage = 10;
        $this->fileUploadService = $fileUploadService;
        $this->addressBookRepository = $addressBookRepository;
    }

    /**
     * Get All Customer models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllCustomers(array $filters = [], array $eagerRelations = [])
    {
        $filters['role'] = [Constant::SENDER_ROLE_ID, Constant::RECEIVER_ROLE_ID];

        if (!AuthenticatedSessionService::isSuperAdmin()) :
        $filters['parent_id'] = Auth::user()->id;
        endif;

        return $this->userRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Customer Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function customerPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        $filters['role'] = [Constant::SENDER_ROLE_ID, Constant::RECEIVER_ROLE_ID];

        if (!AuthenticatedSessionService::isSuperAdmin()) :
            $filters['parent_id'] = Auth::user()->id;
        endif;

        return $this->userRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Customer Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getCustomerById($id, bool $purge = false)
    {
        return $this->userRepository->show($id, $purge);
    }

    /**
     * Save Customer Model
     *
     * @param array $requestData
     * @param UploadedFile|null $photo
     * @return array
     * @throws Exception
     */
    public function storeCustomer(array $requestData, UploadedFile $photo = null): array
    {
        $roleId = [Constant::SENDER_ROLE_ID];

        //extract role id
        if (!empty($requestData['role_id'])) {
            $roleId = $requestData['role_id'];
            unset($requestData['role_id']);
        }

        //hash user password
        $requestData['password'] = Utility::hashPassword(($requestData['password'] ?? Constant::PASSWORD));

        //force password reset
        $requestData['force_pass_reset'] = true;

        DB::beginTransaction();
        try {
            if ($newCustomer = $this->userRepository->create($requestData)) {
                if (($newCustomer instanceof User) &&
                    $this->userRepository->manageRoles($roleId) &&
                    $this->attachAvatarImage($newCustomer, $photo) &&
                $this->storeCustomerAddress($newCustomer, $requestData)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('New Customer Created'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                }

                DB::rollBack();
                return ['status' => false, 'message' => __('Role or Avatar image Failed'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Warning!'];
            }

            DB::rollBack();
            return ['status' => false, 'message' => __('New Customer Creation Failed'),
                'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
        } catch (Exception $exception) {
            DB::rollBack();
            $this->userRepository->handleException($exception);
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }


    /**
     * @param User $customer
     * @param array $requestData
     * @return bool
     * @throws Exception
     */
    public function storeCustomerAddress(User $customer, array $requestData): bool
    {
        foreach ($requestData['address']['type'] as $type):
            try {
                $address = [
                    'user_id' => $customer->id,
                    'type' => $type,
                    'phone' => $requestData['address']['phone'] ?? null,
                    'name' => $requestData['name'] ?? null,
                    'address' => $requestData['address']['address'] ?? null,
                    'post_code' => $requestData['address']['post_code'] ?? null,
                    'remark' => $requestData['remarks'] ?? null,
                    'enabled' => Constant::ENABLED_OPTION,
                    'city_id' => $requestData['address']['city_id'] ?? config('contact.default.city'),
                    'state_id' => $requestData['address']['state_id'] ?? config('contact.default.state'),
                    'country_id' => $requestData['address']['country_id'] ?? config('contact.default.country')
                ];

                if (!$this->addressBookRepository->create($address)):
                    return false;
                endif;

            } catch (Exception $exception) {
                $this->userRepository->handleException($exception);
                return false;
            }
        endforeach;

        return true;
    }

    /**
     * Update Customer Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateCustomer(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->show($id);
            if ($user instanceof User) {
                if ($this->userRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('Customer Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                }

                DB::rollBack();
                return ['status' => false, 'message' => __('Customer Info Update Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }

            return ['status' => false, 'message' => __('Customer Model Not Found'),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];

        } catch (Exception $exception) {
            $this->userRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Attach avatar image to model
     *
     * @param User $user
     * @param UploadedFile|null $photo
     * @param bool $replace
     * @return bool
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws Exception
     */
    protected function attachAvatarImage(User $user, UploadedFile $photo = null, bool $replace = false): bool
    {
        if ($photo == null && $replace == true)
            return true;
        else {
            $profileImagePath = ($photo != null)
                ? $this->fileUploadService->createAvatarImageFromInput($photo)
                : $this->fileUploadService->createAvatarImageFromText($user->name);
            return (bool)$user->addMedia($profileImagePath)->toMediaCollection('avatars');
        }
    }

    /**
     * Destroy Customer Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyCustomer($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->userRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Customer is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            }

            DB::rollBack();
            return ['status' => false, 'message' => __('Customer is Delete Failed'),
                'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];

        } catch (Exception $exception) {
            $this->userRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore Customer Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreCustomer($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->userRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Customer is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            }

            DB::rollBack();
            return ['status' => false, 'message' => __('Customer is Restoration Failed'),
                'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];

        } catch (Exception $exception) {
            $this->userRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return CustomerExport
     * @throws Exception
     */
    public function exportCustomer(array $filters = []): CustomerExport
    {
        return (new CustomerExport($this->userRepository->getWith($filters)));
    }
}
