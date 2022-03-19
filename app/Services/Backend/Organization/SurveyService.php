<?php

namespace App\Services\Backend\Organization;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Organization\SurveyExport;
use App\Models\Backend\Organization\Survey;
use App\Repositories\Eloquent\Backend\Organization\SurveyRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class SurveyService
 * @package App\Services\Backend\Organization
 */
class SurveyService extends Service
{
    /**
     * @var SurveyRepository 
     */
    private $surveyRepository;

    /**
     * SurveyService constructor.
     * @param SurveyRepository $surveyRepository
     */
    public function __construct(SurveyRepository $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
        $this->surveyRepository->itemsPerPage = 10;
    }

    /**
     * Get All Survey models as collection
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllSurveys(array $filters = [], array $eagerRelations = [])
    {
        return $this->surveyRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Survey Model Pagination
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function surveyPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->surveyRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Survey Model
     * 
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getSurveyById($id, bool $purge = false)
    {
        return $this->surveyRepository->show($id, $purge);
    }

    /**
     * Save Survey Model
     * 
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeSurvey(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newSurvey = $this->surveyRepository->create($inputs);
            if ($newSurvey instanceof Survey) {
                DB::commit();
                return ['status' => true, 'message' => __('New Survey Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Survey Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->surveyRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update Survey Model
     * 
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateSurvey(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $survey = $this->surveyRepository->show($id);
            if ($survey instanceof Survey) {
                if ($this->surveyRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('Survey Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('Survey Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Survey Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->surveyRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy Survey Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroySurvey($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->surveyRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Survey is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Survey is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->surveyRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore Survey Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreSurvey($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->surveyRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Survey is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Survey is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->surveyRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return SurveyExport
     * @throws Exception
     */
    public function exportSurvey(array $filters = []): SurveyExport
    {
        return (new SurveyExport($this->surveyRepository->getWith($filters)));
    }

    /**
     * Created Array Styled Survey List for dropdown
     *
     * @param array $filters
     * @return array
     * @throws Exception
     */
    public function getSurveyDropDown(array $filters = [])
    {
        $surveys = $this->getAllSurveys($filters);
        $surveyArray = [];
        foreach ($surveys as $survey)
            $surveyArray[$survey->id] = $survey->name;

        return $surveyArray;
    }
}
