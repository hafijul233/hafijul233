<?php

namespace App\Services\Backend\Transport;

use App\Abstracts\Service\Service;
use App\Models\Backend\Transport\CheckPoint;
use App\Repositories\Eloquent\Backend\Transport\CheckPointRepository;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Core\Supports\Constant;
use Throwable;

/**
 * @class CheckPointService
 * @package App\Services\Backend\Transport
 */
class CheckPointService extends Service
{
/**
     * @var CheckPointRepository
     */
    private $checkpointRepository;

    /**
     * CheckPointService constructor.
     * @param CheckPointRepository $checkpointRepository
     */
    public function __construct(CheckPointRepository $checkpointRepository)
    {
        $this->checkpointRepository = $checkpointRepository;
        $this->checkpointRepository->itemsPerPage = 10;
    }

    /**
     * Get All CheckPoint models as collection
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllCheckPoints(array $filters = [], array $eagerRelations = [])
    {
        return $this->checkpointRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create CheckPoint Model Pagination
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function checkpointPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->checkpointRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show CheckPoint Model
     * 
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getCheckPointById($id, bool $purge = false)
    {
        return $this->checkpointRepository->show($id, $purge);
    }

    /**
     * Save CheckPoint Model
     * 
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeCheckPoint(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newCheckPoint = $this->checkpointRepository->create($inputs);
            if ($newCheckPoint instanceof CheckPoint) {
                DB::commit();
                return ['status' => true, 'message' => __('New CheckPoint Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New CheckPoint Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->checkpointRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update CheckPoint Model
     * 
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateCheckPoint(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $checkpoint = $this->checkpointRepository->show($id);
            if ($checkpoint instanceof CheckPoint) {
                if ($this->checkpointRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('CheckPoint Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('CheckPoint Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('CheckPoint Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->checkpointRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy CheckPoint Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyCheckPoint($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->checkpointRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('CheckPoint is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('CheckPoint is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->checkpointRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore CheckPoint Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreCheckPoint($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->checkpointRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('CheckPoint is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('CheckPoint is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->checkpointRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return CheckPointExport
     * @throws Exception
     */
    public function exportCheckPoint(array $filters = []): CheckPointExport
    {
        return (new CheckPointExport($this->checkpointRepository->getWith($filters)));
    }
}
