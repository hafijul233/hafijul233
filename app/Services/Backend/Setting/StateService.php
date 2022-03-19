<?php

namespace App\Services\Backend\Setting;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Setting\StateExport;
use App\Models\Backend\Setting\State;
use App\Repositories\Eloquent\Backend\Setting\StateRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class StateService
 * @package Modules\State\Services\Setting
 */
class StateService extends Service
{
/**
     * @var StateRepository
     */
    private $stateRepository;

    /**
     * StateService constructor.
     * @param StateRepository $stateRepository
     */
    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
        $this->stateRepository->itemsPerPage = 10;
    }

    /**
     * Get All State models as collection
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllStates(array $filters = [], array $eagerRelations = [])
    {
        return $this->stateRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create State Model Pagination
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function statePaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->stateRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show State Model
     * 
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getStateById($id, bool $purge = false)
    {
        return $this->stateRepository->show($id, $purge);
    }

    /**
     * Save State Model
     * 
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeState(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newState = $this->stateRepository->create($inputs);
            if ($newState instanceof State) {
                DB::commit();
                return ['status' => true, 'message' => __('New State Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New State Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->stateRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update State Model
     * 
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateState(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $state = $this->stateRepository->show($id);
            if ($state instanceof State) {
                if ($this->stateRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('State Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('State Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('State Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->stateRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy State Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyState($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->stateRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('State is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('State is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->stateRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore State Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreState($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->stateRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('State is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('State is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->stateRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return StateExport
     * @throws Exception
     */
    public function exportState(array $filters = []): StateExport
    {
        return (new StateExport($this->stateRepository->getWith($filters)));
    }

    /**
     * @param array $filters
     * @return array
     * @throws Exception
     */
    public function getStateDropdown(array $filters = []): array
    {
        $filters = array_merge([
            'enabled' => 'yes',
        ], $filters);

        $states = $this->getAllStates($filters);
        $stateArray = [];

        foreach ($states as $state)
            $stateArray[$state->id] = $state->name;

        return $stateArray;
    }
}
