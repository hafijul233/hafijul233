<?php

namespace App\Services\Backend\Portfolio;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Organization\ServiceExport;
use App\Models\Backend\Portfolio\Service as ServiceModel;
use App\Repositories\Eloquent\Backend\Portfolio\ServiceRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class PostService
 * @package App\Services\Backend\Portfolio
 */
class ServiceService extends Service
{
    /**
     * @var ServiceRepository
     */
    private $serviceRepository;

    /**
     * PostService constructor.
     * @param ServiceRepository $serviceRepository
     */
    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->serviceRepository->itemsPerPage = 10;
    }

    /**
     * Get All Post models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllServices(array $filters = [], array $eagerRelations = [])
    {
        return $this->serviceRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Post Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function servicePaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->serviceRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Post Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getServiceById($id, bool $purge = false)
    {
        return $this->serviceRepository->show($id, $purge);
    }

    /**
     * Save Post Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeService(array $inputs): array
    {
        $newServiceInfo = $this->formatServiceInfo($inputs);
        DB::beginTransaction();
        try {
            $newService = $this->serviceRepository->create($newServiceInfo);
            if ($newService instanceof ServiceModel) {
                //handling Comment List
                if ($inputs['image'] instanceof UploadedFile) {
                    $newService->addMedia($inputs['image'])->toMediaCollection('services');
                }
                $newService->save();

                DB::commit();
                return ['status' => true, 'message' => __('New Service Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Service Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->serviceRepository->handleException($exception);
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
    private function formatServiceInfo(array $inputs)
    {
        $serviceInfo = [];
        $serviceInfo["name"] = $inputs['name'] ?? null;
        $serviceInfo["summary"] = $inputs['summary'] ?? null;
        $serviceInfo["description"] = $inputs["description"] ?? null;

        return $serviceInfo;
    }

    /**
     * Update Post Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateService(array $inputs, $id): array
    {
        $newServiceInfo = $this->formatServiceInfo($inputs);
        DB::beginTransaction();
        try {
            $service = $this->serviceRepository->show($id);
            if ($service instanceof ServiceModel) {
                if ($this->serviceRepository->update($newServiceInfo, $id)) {
                    //handling Comment List
                    $service->surveys()->sync($inputs['survey_id']);
                    $service->previousPostings()->sync($inputs['prev_post_state_id']);
                    $service->futurePostings()->sync($inputs['future_post_state_id']);
                    $service->save();
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
            $this->serviceRepository->handleException($exception);
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
    public function destroyService($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->serviceRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Post is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Post is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->serviceRepository->handleException($exception);
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
    public function restoreService($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->serviceRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Post is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Post is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->serviceRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return ServiceExport
     * @throws Exception
     */
    public function exportService(array $filters = []): ServiceExport
    {
        return (new ServiceExport($this->serviceRepository->getWith($filters)));
    }
}
