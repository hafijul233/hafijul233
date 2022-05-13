<?php

namespace App\Services\Backend\Resume;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Organization\SkillExport;
use App\Models\Backend\Portfolio\Post;
use App\Repositories\Eloquent\Backend\Portfolio\ServiceRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class SkillService
 * @package App\Services\Backend\Portfolio
 */
class SkillService extends Service
{
    /**
     * @var ServiceRepository
     */
    private $skillRepository;

    /**
     * PostService constructor.
     * @param ServiceRepository $skillRepository
     */
    public function __construct(ServiceRepository $skillRepository)
    {
        $this->skillRepository = $skillRepository;
        $this->skillRepository->itemsPerPage = 10;
    }

    /**
     * Get All Post models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllSkills(array $filters = [], array $eagerRelations = [])
    {
        return $this->skillRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Post Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function skillPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->skillRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Post Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getSkillById($id, bool $purge = false)
    {
        return $this->skillRepository->show($id, $purge);
    }

    /**
     * Save Post Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeSkill(array $inputs): array
    {
        $newSkillInfo = $this->formatSkillInfo($inputs);
        DB::beginTransaction();
        try {
            $newSkill = $this->skillRepository->create($newSkillInfo);
            if ($newSkill instanceof Post) {
                //handling Comment List
                $newSkill->surveys()->attach($inputs['survey_id']);
                $newSkill->previousPostings()->attach($inputs['prev_post_state_id']);
                $newSkill->futurePostings()->attach($inputs['future_post_state_id']);
                $newSkill->save();

                DB::commit();
                return ['status' => true, 'message' => __('New Post Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Post Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->skillRepository->handleException($exception);
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
    private function formatSkillInfo(array $inputs)
    {
        $skillInfo = [];
        $skillInfo["survey_id"] = null;
        $skillInfo["gender_id"] = $inputs['gender_id'] ?? null;
        $skillInfo["dob"] = $inputs['dob'] ?? null;
        $skillInfo["name"] = $inputs["name"] ?? null;
        $skillInfo["name_bd"] = $inputs["name_bd"] ?? null;
        $skillInfo["father"] = $inputs["father"] ?? null;
        $skillInfo["father_bd"] = $inputs["father_bd"] ?? null;
        $skillInfo["mother"] = $inputs["mother"] ?? null;
        $skillInfo["mother_bd"] = $inputs["mother_bd"] ?? null;
        $skillInfo["nid"] = $inputs["nid"] ?? null;
        $skillInfo["mobile_1"] = $inputs["mobile_1"] ?? null;
        $skillInfo["mobile_2"] = $inputs["mobile_2"] ?? null;
        $skillInfo["email"] = $inputs["email"] ?? null;
        $skillInfo["present_address"] = $inputs["present_address"] ?? null;
        $skillInfo["present_address_bd"] = $inputs["present_address_bd"] ?? null;
        $skillInfo["permanent_address"] = $inputs["permanent_address"] ?? null;
        $skillInfo["permanent_address_bd"] = $inputs["permanent_address_bd"] ?? null;
        $skillInfo["exam_level"] = $inputs["exam_level"] ?? null;
        $skillInfo["whatsapp"] = $inputs["whatsapp"] ?? null;
        $skillInfo["facebook"] = $inputs["facebook"] ?? null;

        $skillInfo["is_employee"] = $inputs["is_employee"] ?? 'no';
        $skillInfo["designation"] = null;
        $skillInfo["company"] = null;

        if ($skillInfo["is_employee"] == 'yes') {
            $skillInfo["designation"] = $inputs['designation'] ?? null;
            $skillInfo["company"] = $inputs['company'] ?? null;
        }

        return $skillInfo;
    }

    /**
     * Update Post Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateSkill(array $inputs, $id): array
    {
        $newSkillInfo = $this->formatSkillInfo($inputs);
        DB::beginTransaction();
        try {
            $skill = $this->skillRepository->show($id);
            if ($skill instanceof Post) {
                if ($this->skillRepository->update($newSkillInfo, $id)) {
                    //handling Comment List
                    $skill->surveys()->sync($inputs['survey_id']);
                    $skill->previousPostings()->sync($inputs['prev_post_state_id']);
                    $skill->futurePostings()->sync($inputs['future_post_state_id']);
                    $skill->save();
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
            $this->skillRepository->handleException($exception);
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
    public function destroySkill($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->skillRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Post is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Post is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->skillRepository->handleException($exception);
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
    public function restoreSkill($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->skillRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Post is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Post is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->skillRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return SkillExport
     * @throws Exception
     */
    public function exportSkill(array $filters = []): SkillExport
    {
        return (new SkillExport($this->skillRepository->getWith($filters)));
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
