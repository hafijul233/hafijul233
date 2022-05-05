<?php

namespace App\Services\Backend\Portfolio;

use App\Abstracts\Service\Service;
use App\Models\Backend\Portfolio\Service as ServiceModel;
use App\Exports\Backend\Organization\ServiceExport;
use App\Repositories\Eloquent\Backend\Portfolio\ServiceRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
                $newService->surveys()->attach($inputs['survey_id']);
                $newService->previousPostings()->attach($inputs['prev_post_state_id']);
                $newService->futurePostings()->attach($inputs['future_post_state_id']);
                $newService->save();

                DB::commit();
                return ['status' => true, 'message' => __('New Post Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Post Creation Failed'),
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
        $serviceInfo["survey_id"] = null;
        $serviceInfo["gender_id"] = $inputs['gender_id'] ?? null;
        $serviceInfo["dob"] = $inputs['dob'] ?? null;
        $serviceInfo["name"] = $inputs["name"] ?? null;
        $serviceInfo["name_bd"] = $inputs["name_bd"] ?? null;
        $serviceInfo["father"] = $inputs["father"] ?? null;
        $serviceInfo["father_bd"] = $inputs["father_bd"] ?? null;
        $serviceInfo["mother"] = $inputs["mother"] ?? null;
        $serviceInfo["mother_bd"] = $inputs["mother_bd"] ?? null;
        $serviceInfo["nid"] = $inputs["nid"] ?? null;
        $serviceInfo["mobile_1"] = $inputs["mobile_1"] ?? null;
        $serviceInfo["mobile_2"] = $inputs["mobile_2"] ?? null;
        $serviceInfo["email"] = $inputs["email"] ?? null;
        $serviceInfo["present_address"] = $inputs["present_address"] ?? null;
        $serviceInfo["present_address_bd"] = $inputs["present_address_bd"] ?? null;
        $serviceInfo["permanent_address"] = $inputs["permanent_address"] ?? null;
        $serviceInfo["permanent_address_bd"] = $inputs["permanent_address_bd"] ?? null;
        $serviceInfo["exam_level"] = $inputs["exam_level"] ?? null;
        $serviceInfo["whatsapp"] = $inputs["whatsapp"] ?? null;
        $serviceInfo["facebook"] = $inputs["facebook"] ?? null;

        $serviceInfo["is_employee"] = $inputs["is_employee"] ?? 'no';
        $serviceInfo["designation"] = null;
        $serviceInfo["company"] = null;

        if ($serviceInfo["is_employee"] == 'yes') {
            $serviceInfo["designation"] = $inputs['designation'] ?? null;
            $serviceInfo["company"] = $inputs['company'] ?? null;
        }

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
