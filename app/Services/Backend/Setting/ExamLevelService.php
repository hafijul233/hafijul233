<?php

namespace App\Services\Backend\Setting;

use App\Abstracts\Service\Service;
use App\Models\Backend\Setting\ExamLevel;
use App\Repositories\Eloquent\Backend\Setting\ExamLevelRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class ExamLevelService
 * @package App\Services\Backend\Setting
 */
class ExamLevelService extends Service
{
    /**
     * @var ExamLevelRepository
     */
    private $examLevelRepository;

    /**
     * ExamLevelService constructor.
     * @param ExamLevelRepository $examLevelRepository
     */
    public function __construct(ExamLevelRepository $examLevelRepository)
    {
        $this->examLevelRepository = $examLevelRepository;
        $this->examLevelRepository->itemsPerPage = 10;
    }

    /**
     * Get All ExamLevel models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllExamLevels(array $filters = [], array $eagerRelations = [])
    {
        return $this->examLevelRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create ExamLevel Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function barcodePaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->examLevelRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show ExamLevel Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getExamLevelById($id, bool $purge = false)
    {
        return $this->examLevelRepository->show($id, $purge);
    }

    /**
     * Save ExamLevel Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeExamLevel(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newExamLevel = $this->examLevelRepository->create($inputs);
            if ($newExamLevel instanceof ExamLevel) {
                DB::commit();
                return ['status' => true, 'message' => __('New ExamLevel Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New ExamLevel Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->examLevelRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update ExamLevel Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateExamLevel(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $barcode = $this->examLevelRepository->show($id);
            if ($barcode instanceof ExamLevel) {
                if ($this->examLevelRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('ExamLevel Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('ExamLevel Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('ExamLevel Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->examLevelRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy ExamLevel Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyExamLevel($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->examLevelRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('ExamLevel is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('ExamLevel is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->examLevelRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore ExamLevel Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreExamLevel($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->examLevelRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('ExamLevel is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('ExamLevel is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->examLevelRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return ExamLevelExport
     * @throws Exception
     */
    public function exportExamLevel(array $filters = []): ExamLevelExport
    {
        return (new ExamLevelExport($this->examLevelRepository->getWith($filters)));
    }

    /**
     * @param array $filters
     * @return array
     * @throws Exception
     */
    public function getExamLevelDropdown(array $filters = []): array
    {
        $filters = array_merge([
            'enabled' => 'yes',
        ], $filters);

        $examLevels = $this->getAllExamLevels($filters);
        $examArray = [];

        foreach ($examLevels as $exam) {
            $examArray[$exam->id] = $exam->name;
        }

        return $examArray;
    }
}
