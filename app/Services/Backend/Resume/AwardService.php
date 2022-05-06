<?php

namespace App\Services\Backend\Resume;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Organization\AwardExport;
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
class AwardService extends Service
{
    /**
     * @var ServiceRepository
     */
    private $awardRepository;

    /**
     * PostService constructor.
     * @param ServiceRepository $awardRepository
     */
    public function __construct(ServiceRepository $awardRepository)
    {
        $this->awardRepository = $awardRepository;
        $this->awardRepository->itemsPerPage = 10;
    }

    /**
     * Get All Post models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllAwards(array $filters = [], array $eagerRelations = [])
    {
        return $this->awardRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Post Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function awardPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->awardRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Post Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getAwardById($id, bool $purge = false)
    {
        return $this->awardRepository->show($id, $purge);
    }

    /**
     * Save Post Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeAward(array $inputs): array
    {
        $newAwardInfo = $this->formatAwardInfo($inputs);
        DB::beginTransaction();
        try {
            $newAward = $this->awardRepository->create($newAwardInfo);
            if ($newAward instanceof Post) {
                //handling Comment List
                $newAward->surveys()->attach($inputs['survey_id']);
                $newAward->previousPostings()->attach($inputs['prev_post_state_id']);
                $newAward->futurePostings()->attach($inputs['future_post_state_id']);
                $newAward->save();

                DB::commit();
                return ['status' => true, 'message' => __('New Post Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Post Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->awardRepository->handleException($exception);
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
    private function formatAwardInfo(array $inputs)
    {
        $awardInfo = [];
        $awardInfo["survey_id"] = null;
        $awardInfo["gender_id"] = $inputs['gender_id'] ?? null;
        $awardInfo["dob"] = $inputs['dob'] ?? null;
        $awardInfo["name"] = $inputs["name"] ?? null;
        $awardInfo["name_bd"] = $inputs["name_bd"] ?? null;
        $awardInfo["father"] = $inputs["father"] ?? null;
        $awardInfo["father_bd"] = $inputs["father_bd"] ?? null;
        $awardInfo["mother"] = $inputs["mother"] ?? null;
        $awardInfo["mother_bd"] = $inputs["mother_bd"] ?? null;
        $awardInfo["nid"] = $inputs["nid"] ?? null;
        $awardInfo["mobile_1"] = $inputs["mobile_1"] ?? null;
        $awardInfo["mobile_2"] = $inputs["mobile_2"] ?? null;
        $awardInfo["email"] = $inputs["email"] ?? null;
        $awardInfo["present_address"] = $inputs["present_address"] ?? null;
        $awardInfo["present_address_bd"] = $inputs["present_address_bd"] ?? null;
        $awardInfo["permanent_address"] = $inputs["permanent_address"] ?? null;
        $awardInfo["permanent_address_bd"] = $inputs["permanent_address_bd"] ?? null;
        $awardInfo["exam_level"] = $inputs["exam_level"] ?? null;
        $awardInfo["whatsapp"] = $inputs["whatsapp"] ?? null;
        $awardInfo["facebook"] = $inputs["facebook"] ?? null;

        $awardInfo["is_employee"] = $inputs["is_employee"] ?? 'no';
        $awardInfo["designation"] = null;
        $awardInfo["company"] = null;

        if ($awardInfo["is_employee"] == 'yes') {
            $awardInfo["designation"] = $inputs['designation'] ?? null;
            $awardInfo["company"] = $inputs['company'] ?? null;
        }

        return $awardInfo;
    }

    /**
     * Update Post Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateAward(array $inputs, $id): array
    {
        $newAwardInfo = $this->formatAwardInfo($inputs);
        DB::beginTransaction();
        try {
            $award = $this->awardRepository->show($id);
            if ($award instanceof Post) {
                if ($this->awardRepository->update($newAwardInfo, $id)) {
                    //handling Comment List
                    $award->surveys()->sync($inputs['survey_id']);
                    $award->previousPostings()->sync($inputs['prev_post_state_id']);
                    $award->futurePostings()->sync($inputs['future_post_state_id']);
                    $award->save();
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
            $this->awardRepository->handleException($exception);
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
    public function destroyAward($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->awardRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Post is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Post is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->awardRepository->handleException($exception);
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
    public function restoreAward($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->awardRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Post is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Post is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->awardRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return AwardExport
     * @throws Exception
     */
    public function exportAward(array $filters = []): AwardExport
    {
        return (new AwardExport($this->awardRepository->getWith($filters)));
    }

    /**
     * Return formatted education qualification model collection
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     */
    private function formatEducationQualification(array $inputs): array
    {
        $examLevels = $this->examLevelRepository->getWith(['id' => $inputs['exam_level']]);

        $qualifications = [];

        foreach ($examLevels as $examLevel):
            $prefix = $examLevel->code;
            $qualifications[$examLevel->id]["exam_level_id"] = $inputs["{$prefix}_exam_level_id"] ?? null;
            $qualifications[$examLevel->id]["exam_title_id"] = $inputs["{$prefix}_exam_title_id"] ?? null;
            $qualifications[$examLevel->id]["exam_board_id"] = $inputs["{$prefix}_exam_board_id"] ?? null;
            $qualifications[$examLevel->id]["exam_group_id"] = $inputs["{$prefix}_exam_group_id"] ?? null;
            $qualifications[$examLevel->id]["institute_id"] = $inputs["{$prefix}_institute_id"] ?? null;
            $qualifications[$examLevel->id]["pass_year"] = $inputs["{$prefix}_pass_year"] ?? null;
            $qualifications[$examLevel->id]["roll_number"] = $inputs["{$prefix}_roll_number"] ?? null;
            $qualifications[$examLevel->id]["grade_type"] = $inputs["{$prefix}_grade_type"] ?? null;
            $qualifications[$examLevel->id]["grade_point"] = $inputs["{$prefix}_grade_point"] ?? null;
            $qualifications[$examLevel->id]["enabled"] = "yes";
        endforeach;

        return $qualifications;
    }

    /**
     * Return formatted work experience model collection
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     */
    private function formatWorkQualification(array $inputs): array
    {
        $qualifications = [];

        foreach ($inputs['job'] as $index => $input):
            $qualifications[$index]["company"] = $input["company"] ?? null;
            $qualifications[$index]["designation"] = $input["designation"] ?? null;
            $qualifications[$index]["start_date"] = $input["start_date"] ?? null;
            $qualifications[$index]["end_date"] = $input["end_date"] ?? null;
            $qualifications[$index]["responsibility"] = $input["responsibility"] ?? null;
            $qualifications[$index]["enabled"] = "yes";
        endforeach;

        return $qualifications;
    }
}
