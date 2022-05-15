<?php

namespace App\Services\Backend\Portfolio;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Portfolio\ProjectExport;
use App\Models\Backend\Portfolio\Project;
use App\Repositories\Eloquent\Backend\Portfolio\ProjectRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
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
        DB::beginTransaction();
        try {
            $newProject = $this->projectRepository->create($inputs);
            if ($newProject instanceof Project) {
                if ($inputs['image'] instanceof UploadedFile) {
                    $newProject->addMedia($inputs['image'])->toMediaCollection('projects');
                }
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
     * Update Post Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateProject(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $project = $this->projectRepository->show($id);
            if ($project instanceof Project) {
                if ($this->projectRepository->update($inputs, $id)) {
                    if (isset($inputs['image']) && $inputs['image'] instanceof UploadedFile) {
                        $project->addMedia($inputs['image'])->toMediaCollection('projects');
                    }
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
