<?php

namespace App\Services\Backend\Setting;

use App\Abstracts\Service\Service;
use App\Models\Backend\Setting\ExamTitle;
use App\Repositories\Eloquent\Backend\Setting\ExamGroupRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class ExamGroupService
 * @package App\Services\Backend\Setting
 */
class ExamGroupService extends Service
{
/**
     * @var ExamGroupRepository
     */
    private $examGroupRepository;

    /**
     * ExamGroupService constructor.
     * @param ExamGroupRepository $examGroupRepository
     */
    public function __construct(ExamGroupRepository $examGroupRepository)
    {
        $this->examGroupRepository = $examGroupRepository;
        $this->examGroupRepository->itemsPerPage = 10;
    }

    /**
     * Get All ExamTitle models as collection
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllExamGroups(array $filters = [], array $eagerRelations = [])
    {
        return $this->examGroupRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create ExamTitle Model Pagination
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function examGroupPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->examGroupRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show ExamTitle Model
     * 
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getExamGroupById($id, bool $purge = false)
    {
        return $this->examGroupRepository->show($id, $purge);
    }

    /**
     * Save ExamTitle Model
     * 
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeExamGroup(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newExamGroup = $this->examGroupRepository->create($inputs);
            if ($newExamGroup instanceof ExamTitle) {
                DB::commit();
                return ['status' => true, 'message' => __('New ExamTitle Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New ExamTitle Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->examGroupRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update ExamTitle Model
     * 
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateExamGroup(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $examGroup = $this->examGroupRepository->show($id);
            if ($examGroup instanceof ExamTitle) {
                if ($this->examGroupRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('ExamTitle Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('ExamTitle Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('ExamTitle Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->examGroupRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy ExamTitle Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyExamGroup($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->examGroupRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('ExamTitle is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('ExamTitle is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->examGroupRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore ExamTitle Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreExamGroup($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->examGroupRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('ExamTitle is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('ExamTitle is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->examGroupRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return ExamGroupExport
     * @throws Exception
     */
    public function exportExamGroup(array $filters = []): ExamGroupExport
    {
        return (new ExamGroupExport($this->examGroupRepository->getWith($filters)));
    }
}
