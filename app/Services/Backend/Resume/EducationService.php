<?php

namespace App\Services\Backend\Resume;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Organization\EducationExport;
use App\Models\Backend\Resume\Education;
use App\Repositories\Eloquent\Backend\Resume\EducationRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class EducationService
 * @package App\Services\Backend\Portfolio
 */
class EducationService extends Service
{
    /**
     * @var EducationRepository
     */
    private $educationRepository;

    /**
     * CommentService constructor.
     * @param EducationRepository $educationRepository
     */
    public function __construct(EducationRepository $educationRepository)
    {
        $this->educationRepository = $educationRepository;
        $this->educationRepository->itemsPerPage = 10;
    }

    /**
     * Create Comment Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function educationPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->educationRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Comment Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getEducationById($id, bool $purge = false)
    {
        return $this->educationRepository->show($id, $purge);
    }

    /**
     * Save Comment Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeEducation(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newEducation = $this->educationRepository->create($inputs);
            if ($newEducation instanceof Education) {
                DB::commit();
                return ['status' => true, 'message' => __('New Comment Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Comment Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->educationRepository->handleException($exception);
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
    public function updateEducation(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $education = $this->educationRepository->show($id);
            if ($education instanceof Education) {
                if ($this->educationRepository->update($inputs, $id)) {
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
            $this->educationRepository->handleException($exception);
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
    public function destroyEducation($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->educationRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Comment is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Comment is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->educationRepository->handleException($exception);
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
    public function restoreEducation($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->educationRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Comment is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Comment is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->educationRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return EducationExport
     * @throws Exception
     */
    public function exportEducation(array $filters = []): EducationExport
    {
        return (new EducationExport($this->educationRepository->getWith($filters)));
    }

    /**
     * Created Array Styled Comment List for dropdown
     *
     * @param array $filters
     * @return array
     * @throws Exception
     */
    public function getEducationDropDown(array $filters = [])
    {
        $educations = $this->getAllEducations($filters);
        $educationArray = [];
        foreach ($educations as $education) {
            $educationArray[$education->id] = $education->name;
        }

        return $educationArray;
    }

    /**
     * Get All Comment models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllEducations(array $filters = [], array $eagerRelations = [])
    {
        return $this->educationRepository->getWith($filters, $eagerRelations, true);
    }
}
