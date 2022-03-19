<?php

namespace App\Services\Backend\Setting;

use App\Abstracts\Service\Service;
use App\Models\Backend\Setting\Institute;
use App\Repositories\Eloquent\Backend\Setting\InstituteRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class InstituteService
 * @package App\Services\Backend\Setting
 */
class InstituteService extends Service
{
/**
     * @var InstituteRepository
     */
    private $instituteRepository;

    /**
     * InstituteService constructor.
     * @param InstituteRepository $instituteRepository
     */
    public function __construct(InstituteRepository $instituteRepository)
    {
        $this->instituteRepository = $instituteRepository;
        $this->instituteRepository->itemsPerPage = 10;
    }

    /**
     * Get All Institute models as collection
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllInstitutes(array $filters = [], array $eagerRelations = [])
    {
        return $this->instituteRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Institute Model Pagination
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function institutePaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->instituteRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Institute Model
     * 
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getInstituteById($id, bool $purge = false)
    {
        return $this->instituteRepository->show($id, $purge);
    }

    /**
     * Save Institute Model
     * 
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeInstitute(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newInstitute = $this->instituteRepository->create($inputs);
            if ($newInstitute instanceof Institute) {
                DB::commit();
                return ['status' => true, 'message' => __('New Institute Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Institute Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->instituteRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update Institute Model
     * 
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateInstitute(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $institute = $this->instituteRepository->show($id);
            if ($institute instanceof Institute) {
                if ($this->instituteRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('Institute Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('Institute Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Institute Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->instituteRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy Institute Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyInstitute($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->instituteRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Institute is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Institute is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->instituteRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore Institute Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreInstitute($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->instituteRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Institute is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Institute is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->instituteRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return InstituteExport
     * @throws Exception
     */
    public function exportInstitute(array $filters = []): InstituteExport
    {
        return (new InstituteExport($this->instituteRepository->getWith($filters)));
    }

    public function getInstituteDropDown(array $filters):array
    {
        $institutes = $this->getAllInstitutes($filters);

        $instituteArray = [];

        foreach ($institutes as $institute):
            $instituteArray[$institute->id] = $institute->name;
        endforeach;

        return $instituteArray;
    }
}
