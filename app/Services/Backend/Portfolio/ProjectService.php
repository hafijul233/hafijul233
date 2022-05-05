<?php

namespace App\Services\Backend\Portfolio;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Organization\ProjectExport;
use App\Models\Backend\Portfolio\Project;
use App\Repositories\Eloquent\Backend\Portfolio\ProjectRepository;
use App\Repositories\Eloquent\Backend\Setting\ExamLevelRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class ProjectService
 * @package App\Projects\Backend\Portfolio
 */
class ProjectService extends Service
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;
    
    /**
     * PostProject constructor.
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->projectRepository->itemsPerPage = 10;
    }

    /**
     * Get All Post models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllProjects(array $filters = [], array $eagerRelations = [])
    {
        return $this->projectRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Post Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function projectPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->projectRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Post Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getProjectById($id, bool $purge = false)
    {
        return $this->projectRepository->show($id, $purge);
    }

    /**
     * Save Post Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeProject(array $inputs): array
    {
        $newProjectInfo = $this->formatProjectInfo($inputs);
        DB::beginTransaction();
        try {
            $newProject = $this->projectRepository->create($newProjectInfo);
            if ($newProject instanceof Project) {
                //handling Comment List
                $newProject->surveys()->attach($inputs['survey_id']);
                $newProject->previousPostings()->attach($inputs['prev_post_state_id']);
                $newProject->futurePostings()->attach($inputs['future_post_state_id']);
                $newProject->save();

                DB::commit();
                return ['status' => true, 'message' => __('New Post Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Post Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->projectRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Return formatted applicant profile format array
     *
     * @param array $inputs
     * @return array
     */
    private function formatProjectInfo(array $inputs)
    {
        $projectInfo = [];
        $projectInfo["survey_id"] = null;
        $projectInfo["gender_id"] = $inputs['gender_id'] ?? null;
        $projectInfo["dob"] = $inputs['dob'] ?? null;
        $projectInfo["name"] = $inputs["name"] ?? null;
        $projectInfo["name_bd"] = $inputs["name_bd"] ?? null;
        $projectInfo["father"] = $inputs["father"] ?? null;
        $projectInfo["father_bd"] = $inputs["father_bd"] ?? null;
        $projectInfo["mother"] = $inputs["mother"] ?? null;
        $projectInfo["mother_bd"] = $inputs["mother_bd"] ?? null;
        $projectInfo["nid"] = $inputs["nid"] ?? null;
        $projectInfo["mobile_1"] = $inputs["mobile_1"] ?? null;
        $projectInfo["mobile_2"] = $inputs["mobile_2"] ?? null;
        $projectInfo["email"] = $inputs["email"] ?? null;
        $projectInfo["present_address"] = $inputs["present_address"] ?? null;
        $projectInfo["present_address_bd"] = $inputs["present_address_bd"] ?? null;
        $projectInfo["permanent_address"] = $inputs["permanent_address"] ?? null;
        $projectInfo["permanent_address_bd"] = $inputs["permanent_address_bd"] ?? null;
        $projectInfo["exam_level"] = $inputs["exam_level"] ?? null;
        $projectInfo["whatsapp"] = $inputs["whatsapp"] ?? null;
        $projectInfo["facebook"] = $inputs["facebook"] ?? null;

        $projectInfo["is_employee"] = $inputs["is_employee"] ?? 'no';
        $projectInfo["designation"] = null;
        $projectInfo["company"] = null;

        if ($projectInfo["is_employee"] == 'yes') {
            $projectInfo["designation"] = $inputs['designation'] ?? null;
            $projectInfo["company"] = $inputs['company'] ?? null;
        }

        return $projectInfo;
    }

    /**
     * Update Post Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateProject(array $inputs, $id): array
    {
        $newProjectInfo = $this->formatProjectInfo($inputs);
        DB::beginTransaction();
        try {
            $project = $this->projectRepository->show($id);
            if ($project instanceof Project) {
                if ($this->projectRepository->update($newProjectInfo, $id)) {
                    //handling Comment List
                    $project->surveys()->sync($inputs['survey_id']);
                    $project->previousPostings()->sync($inputs['prev_post_state_id']);
                    $project->futurePostings()->sync($inputs['future_post_state_id']);
                    $project->save();
                    DB::commit();
                    return ['status' => true, 'message' => __('Post Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('Post Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Post Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->projectRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy Post Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyProject($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->projectRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Post is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Post is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->projectRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore Post Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreProject($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->projectRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Post is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Post is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->projectRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return ProjectExport
     * @throws Exception
     */
    public function exportProject(array $filters = []): ProjectExport
    {
        return (new ProjectExport($this->projectRepository->getWith($filters)));
    }
}
