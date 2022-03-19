<?php

namespace App\Services\Backend\Setting;


use App\Abstracts\Service\Service;
use App\Exports\Backend\Setting\CountryExport;
use App\Models\Setting\Permission;
use App\Repositories\Eloquent\Backend\Setting\PermissionRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Throwable;
use function __;


class PermissionService extends Service
{
    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    /**
     * PermissionService constructor.
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->permissionRepository->itemsPerPage = 10;
    }

    /**
     * Get All Permission models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllPermissions(array $filters = [], array $eagerRelations = [])
    {
        return $this->permissionRepository->getAllPermissionWith($filters, $eagerRelations, true);
    }

    /**
     * Create Permission Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function permissionPaginate(array $filters = [], array $eagerRelations = [])
    {
        return $this->permissionRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Permission Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getPermissionById($id, bool $purge = false)
    {
        return $this->permissionRepository->show($id, $purge);
    }

    /**
     * Save Permission Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storePermission(array $inputs): array
    {
        \DB::beginTransaction();
        try {
            $newPermission = $this->permissionRepository->create($inputs);
            if ($newPermission instanceof Permission) {
                \DB::commit();
                return ['status' => true, 'message' => __('New Permission Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                \DB::rollBack();
                return ['status' => false, 'message' => __('New Permission Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->permissionRepository->handleException($exception);
            \DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update Permission Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updatePermission(array $inputs, $id): array
    {
        \DB::beginTransaction();
        try {
            $permission = $this->permissionRepository->show($id);
            if ($permission instanceof Permission) {
                if ($this->permissionRepository->update($inputs, $id)) {
                    \DB::commit();
                    return ['status' => true, 'message' => __('Permission Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    \DB::rollBack();
                    return ['status' => false, 'message' => __('Permission Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Permission Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->permissionRepository->handleException($exception);
            \DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy Permission Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyPermission($id): array
    {
        \DB::beginTransaction();
        try {
            if ($this->permissionRepository->delete($id)) {
                \DB::commit();
                return ['status' => true, 'message' => __('Permission is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                \DB::rollBack();
                return ['status' => false, 'message' => __('Permission is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->permissionRepository->handleException($exception);
            \DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore Permission Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restorePermission($id): array
    {
        \DB::beginTransaction();
        try {
            if ($this->permissionRepository->restore($id)) {
                \DB::commit();
                return ['status' => true, 'message' => __('Permission is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                \DB::rollBack();
                return ['status' => false, 'message' => __('Permission is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->permissionRepository->handleException($exception);
            \DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return CountryExport
     * @throws Exception
     */
    public function exportPermission(array $filters = []): CountryExport
    {
        return (new CountryExport($this->permissionRepository->getAllPermissionWith($filters)));
    }
}
