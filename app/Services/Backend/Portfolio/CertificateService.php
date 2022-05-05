<?php

namespace App\Services\Backend\Portfolio;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Organization\SurveyExport;
use App\Repositories\Eloquent\Backend\Portfolio\CertificateRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class CertificateService
 * @package App\Services\Backend\Portfolio
 */
class CertificateService extends Service
{
    /**
     * @var CertificateRepository
     */
    private $certificateRepository;

    /**
     * CommentService constructor.
     * @param CertificateRepository $certificateRepository
     */
    public function __construct(CertificateRepository $certificateRepository)
    {
        $this->certificateRepository = $certificateRepository;
        $this->certificateRepository->itemsPerPage = 10;
    }

    /**
     * Get All Comment models as collection
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllSurveys(array $filters = [], array $eagerRelations = [])
    {
        return $this->certificateRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Comment Model Pagination
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function certificatePaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->certificateRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Comment Model
     * 
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getSurveyById($id, bool $purge = false)
    {
        return $this->certificateRepository->show($id, $purge);
    }

    /**
     * Save Comment Model
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
            $newSurvey = $this->certificateRepository->create($inputs);
            if ($newSurvey instanceof Comment) {
                DB::commit();
                return ['status' => true, 'message' => __('New Comment Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Comment Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->certificateRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update Comment Model
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
            $certificate = $this->certificateRepository->show($id);
            if ($certificate instanceof Comment) {
                if ($this->certificateRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('Comment Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('Comment Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Comment Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->certificateRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy Comment Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroySurvey($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->certificateRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Comment is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Comment is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->certificateRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore Comment Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreSurvey($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->certificateRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Comment is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Comment is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->certificateRepository->handleException($exception);
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
        return (new SurveyExport($this->certificateRepository->getWith($filters)));
    }

    /**
     * Created Array Styled Comment List for dropdown
     *
     * @param array $filters
     * @return array
     * @throws Exception
     */
    public function getSurveyDropDown(array $filters = [])
    {
        $certificates = $this->getAllSurveys($filters);
        $certificateArray = [];
        foreach ($certificates as $certificate)
            $certificateArray[$certificate->id] = $certificate->name;

        return $certificateArray;
    }
}
