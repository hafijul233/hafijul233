<?php

namespace App\Services\Backend\Transport;

use App\Abstracts\Service\Service;
use App\Models\Backend\Shipment\TruckLoad;
use App\Repositories\Eloquent\Backend\Transport\TruckLoadRepository;
use App\Services\Backend\Shipment\TrackLoadExport;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Core\Supports\Constant;
use Throwable;
use function __;

/**
 * @class TruckLoadService
 * @package App\Services\Backend\Shipment
 */
class TruckLoadService extends Service
{
/**
     * @var TruckLoadRepository
     */
    private $truckloadRepository;

    /**
     * TruckLoadService constructor.
     * @param TruckLoadRepository $truckloadRepository
     */
    public function __construct(TruckLoadRepository $truckloadRepository)
    {
        $this->truckloadRepository = $truckloadRepository;
        $this->truckloadRepository->itemsPerPage = 10;
    }

    /**
     * Get All TruckLoad models as collection
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllTrackLoads(array $filters = [], array $eagerRelations = [])
    {
        return $this->truckloadRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create TruckLoad Model Pagination
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function truckloadPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->truckloadRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show TruckLoad Model
     * 
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getTrackLoadById($id, bool $purge = false)
    {
        return $this->truckloadRepository->show($id, $purge);
    }

    /**
     * Save TruckLoad Model
     * 
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeTrackLoad(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newTrackLoad = $this->truckloadRepository->create($inputs);
            if ($newTrackLoad instanceof TruckLoad) {
                DB::commit();
                return ['status' => true, 'message' => __('New TruckLoad Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New TruckLoad Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->truckloadRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update TruckLoad Model
     * 
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateTrackLoad(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $truckload = $this->truckloadRepository->show($id);
            if ($truckload instanceof TruckLoad) {
                if ($this->truckloadRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('TruckLoad Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('TruckLoad Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('TruckLoad Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->truckloadRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy TruckLoad Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyTrackLoad($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->truckloadRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('TruckLoad is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('TruckLoad is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->truckloadRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore TruckLoad Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreTrackLoad($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->truckloadRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('TruckLoad is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('TruckLoad is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->truckloadRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return TrackLoadExport
     * @throws Exception
     */
    public function exportTrackLoad(array $filters = []): TrackLoadExport
    {
        return (new TrackLoadExport($this->truckloadRepository->getWith($filters)));
    }
}
