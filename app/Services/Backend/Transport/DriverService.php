<?php

namespace App\Services\Backend\Transport;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Transport\DriverExport;
use App\Models\Backend\Setting\User;
use App\Repositories\Eloquent\Backend\Setting\UserRepository;
use App\Services\Auth\AuthenticatedSessionService;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class DriverService
 * @package App\Services\Backend\Transport
 */
class DriverService extends Service
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * DriverService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->userRepository->itemsPerPage = 10;
    }

    /**
     * Get All Driver models as collection
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllDrivers(array $filters = [], array $eagerRelations = [])
    {
        $filters['role'] = [Constant::DRIVER_ROLE_ID, Constant::HELPER_ROLE_ID];

        if (!AuthenticatedSessionService::isSuperAdmin()) :
            $filters['parent_id'] = Auth::user()->id;
        endif;

        return $this->userRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Driver Model Pagination
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function driverPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        $filters['role'] = [Constant::DRIVER_ROLE_ID, Constant::HELPER_ROLE_ID];

        if (!AuthenticatedSessionService::isSuperAdmin()) :
            $filters['parent_id'] = Auth::user()->id;
        endif;

        return $this->userRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Driver Model
     * 
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getDriverById($id, bool $purge = false)
    {
        return $this->userRepository->show($id, $purge);
    }

    /**
     * Save Driver Model
     * 
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeDriver(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newDriver = $this->userRepository->create($inputs);
            if ($newDriver instanceof User) {
                DB::commit();
                return ['status' => true, 'message' => __('New Driver Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Driver Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->userRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update Driver Model
     * 
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateDriver(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $driver = $this->userRepository->show($id);
            if ($driver instanceof User) {
                if ($this->userRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('Driver Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('Driver Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Driver Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->userRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy Driver Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyDriver($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->userRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Driver is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Driver is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->userRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore Driver Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreDriver($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->userRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Driver is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Driver is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
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
     * @return DriverExport
     * @throws Exception
     */
    public function exportDriver(array $filters = []): DriverExport
    {
        return (new DriverExport($this->userRepository->getWith($filters)));
    }
}
