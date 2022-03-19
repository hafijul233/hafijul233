<?php

namespace App\Services\Backend\Setting;

use App\Abstracts\Service\Service;
use App\Models\Backend\Setting\Institute;
use App\Repositories\Eloquent\Backend\Setting\ExamTitleRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class ExamTitleService
 * @package App\Services\Backend\Setting
 */
class ExamTitleService extends Service
{
    /**
     * @var ExamTitleRepository
     */
    private $examTitleRepository;

    /**
     * ExamTitleService constructor.
     * @param ExamTitleRepository $examTitleRepository
     */
    public function __construct(ExamTitleRepository $examTitleRepository)
    {
        $this->examTitleRepository = $examTitleRepository;
        $this->examTitleRepository->itemsPerPage = 10;
    }

    /**
     * Get All Institute models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllExamTitles(array $filters = [], array $eagerRelations = [])
    {
        return $this->examTitleRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Institute Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function examTitlePaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->examTitleRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Institute Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getExamTitleById($id, bool $purge = false)
    {
        return $this->examTitleRepository->show($id, $purge);
    }

    /**
     * Save Institute Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeExamTitle(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newExamTitle = $this->examTitleRepository->create($inputs);
            if ($newExamTitle instanceof Institute) {
                DB::commit();
                return ['status' => true, 'message' => __('New Institute Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Institute Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->examTitleRepository->handleException($exception);
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
    public function updateExamTitle(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $examTitle = $this->examTitleRepository->show($id);
            if ($examTitle instanceof Institute) {
                if ($this->examTitleRepository->update($inputs, $id)) {
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
            $this->examTitleRepository->handleException($exception);
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
    public function destroyExamTitle($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->examTitleRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Institute is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Institute is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->examTitleRepository->handleException($exception);
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
    public function restoreExamTitle($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->examTitleRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Institute is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Institute is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->examTitleRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return ExamTitleExport
     * @throws Exception
     */
    public function exportExamTitle(array $filters = []): ExamTitleExport
    {
        return (new ExamTitleExport($this->examTitleRepository->getWith($filters)));
    }

    /**
     * @param array $filters
     * @return array
     * @throws Exception
     */
    public function getExamTitleDropDown(array $filters = []): array
    {
        $titles = $this->getAllExamTitles($filters);
        $titleArray = [];

        foreach ($titles as $title):
            $titleArray[$title->id] = $title->name;
        endforeach;

        return $titleArray;
    }
}
