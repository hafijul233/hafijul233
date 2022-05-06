<?php

namespace App\Services\Backend\Resume;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Organization\EnumeratorExport;
use App\Models\Backend\Portfolio\Post;
use App\Models\Backend\Resume\Experience;
use App\Repositories\Eloquent\Backend\Resume\ExperienceRepository;
use App\Repositories\Eloquent\Backend\Setting\ExamLevelRepository;
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
class ExperienceService extends Service
{
    /**
     * @var ExperienceRepository
     */
    private $experienceRepository;

    /**
     * PostService constructor.
     * @param ExperienceRepository $experienceRepository
     */
    public function __construct(ExperienceRepository $experienceRepository)
    {
        $this->experienceRepository = $experienceRepository;
        $this->experienceRepository->itemsPerPage = 10;
    }

    /**
     * Get All Post models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllEnumerators(array $filters = [], array $eagerRelations = [])
    {
        return $this->experienceRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Post Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function experiencePaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->experienceRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Post Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getEnumeratorById($id, bool $purge = false)
    {
        return $this->experienceRepository->show($id, $purge);
    }

    /**
     * Save Post Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeEnumerator(array $inputs): array
    {
        $newEnumeratorInfo = $this->formatEnumeratorInfo($inputs);
        DB::beginTransaction();
        try {
            $newEnumerator = $this->experienceRepository->create($newEnumeratorInfo);
            if ($newEnumerator instanceof Experience) {
                //handling Comment List
                $newEnumerator->surveys()->attach($inputs['survey_id']);
                $newEnumerator->previousPostings()->attach($inputs['prev_post_state_id']);
                $newEnumerator->futurePostings()->attach($inputs['future_post_state_id']);
                $newEnumerator->save();

                DB::commit();
                return ['status' => true, 'message' => __('New Post Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Post Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->experienceRepository->handleException($exception);
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
    private function formatEnumeratorInfo(array $inputs)
    {
        $experienceInfo = [];
        $experienceInfo["survey_id"] = null;
        $experienceInfo["gender_id"] = $inputs['gender_id'] ?? null;
        $experienceInfo["dob"] = $inputs['dob'] ?? null;
        $experienceInfo["name"] = $inputs["name"] ?? null;
        $experienceInfo["name_bd"] = $inputs["name_bd"] ?? null;
        $experienceInfo["father"] = $inputs["father"] ?? null;
        $experienceInfo["father_bd"] = $inputs["father_bd"] ?? null;
        $experienceInfo["mother"] = $inputs["mother"] ?? null;
        $experienceInfo["mother_bd"] = $inputs["mother_bd"] ?? null;
        $experienceInfo["nid"] = $inputs["nid"] ?? null;
        $experienceInfo["mobile_1"] = $inputs["mobile_1"] ?? null;
        $experienceInfo["mobile_2"] = $inputs["mobile_2"] ?? null;
        $experienceInfo["email"] = $inputs["email"] ?? null;
        $experienceInfo["present_address"] = $inputs["present_address"] ?? null;
        $experienceInfo["present_address_bd"] = $inputs["present_address_bd"] ?? null;
        $experienceInfo["permanent_address"] = $inputs["permanent_address"] ?? null;
        $experienceInfo["permanent_address_bd"] = $inputs["permanent_address_bd"] ?? null;
        $experienceInfo["exam_level"] = $inputs["exam_level"] ?? null;
        $experienceInfo["whatsapp"] = $inputs["whatsapp"] ?? null;
        $experienceInfo["facebook"] = $inputs["facebook"] ?? null;

        $experienceInfo["is_employee"] = $inputs["is_employee"] ?? 'no';
        $experienceInfo["designation"] = null;
        $experienceInfo["company"] = null;

        if ($experienceInfo["is_employee"] == 'yes') {
            $experienceInfo["designation"] = $inputs['designation'] ?? null;
            $experienceInfo["company"] = $inputs['company'] ?? null;
        }

        return $experienceInfo;
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

    /**
     * Update Post Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateEnumerator(array $inputs, $id): array
    {
        $newEnumeratorInfo = $this->formatEnumeratorInfo($inputs);
        DB::beginTransaction();
        try {
            $experience = $this->experienceRepository->show($id);
            if ($experience instanceof Experience) {
                if ($this->experienceRepository->update($newEnumeratorInfo, $id)) {
                    //handling Comment List
                    $experience->surveys()->sync($inputs['survey_id']);
                    $experience->previousPostings()->sync($inputs['prev_post_state_id']);
                    $experience->futurePostings()->sync($inputs['future_post_state_id']);
                    $experience->save();
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
            $this->experienceRepository->handleException($exception);
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
    public function destroyEnumerator($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->experienceRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Post is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Post is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->experienceRepository->handleException($exception);
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
    public function restoreEnumerator($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->experienceRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Post is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Post is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->experienceRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return EnumeratorExport
     * @throws Exception
     */
    public function exportEnumerator(array $filters = []): EnumeratorExport
    {
        return (new EnumeratorExport($this->experienceRepository->getWith($filters)));
    }
}
