<?php

namespace App\Services\Backend\Transport;

use App\Abstracts\Service\Service;
use App\Models\Backend\Transport\Vehicle;
use App\Repositories\Eloquent\Backend\Transport\VehicleRepository;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Core\Supports\Constant;
use Throwable;

/**
 * @class VehicleService
 * @package App\Services\Backend\Transport
 */
class VehicleService extends Service
{
/**
     * @var VehicleRepository
     */
    private $vehicleRepository;

    /**
     * VehicleService constructor.
     * @param VehicleRepository $vehicleRepository
     */
    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->vehicleRepository->itemsPerPage = 10;
    }

    /**
     * Get All Vehicle models as collection
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllVehicles(array $filters = [], array $eagerRelations = [])
    {
        return $this->vehicleRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Vehicle Model Pagination
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function vehiclePaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->vehicleRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Vehicle Model
     * 
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getVehicleById($id, bool $purge = false)
    {
        return $this->vehicleRepository->show($id, $purge);
    }

    /**
     * Save Vehicle Model
     * 
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeVehicle(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newVehicle = $this->vehicleRepository->create($inputs);
            if ($newVehicle instanceof Vehicle) {
                DB::commit();
                return ['status' => true, 'message' => __('New Vehicle Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Vehicle Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->vehicleRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update Vehicle Model
     * 
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateVehicle(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $vehicle = $this->vehicleRepository->show($id);
            if ($vehicle instanceof Vehicle) {
                if ($this->vehicleRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('Vehicle Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('Vehicle Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Vehicle Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->vehicleRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy Vehicle Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyVehicle($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->vehicleRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Vehicle is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Vehicle is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->vehicleRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore Vehicle Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreVehicle($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->vehicleRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Vehicle is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Vehicle is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->vehicleRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return VehicleExport
     * @throws Exception
     */
    public function exportVehicle(array $filters = []): VehicleExport
    {
        return (new VehicleExport($this->vehicleRepository->getWith($filters)));
    }
}
