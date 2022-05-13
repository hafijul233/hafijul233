<?php

namespace App\Services\Backend\Resume;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Organization\SkillExport;
use App\Models\Backend\Resume\Skill;
use App\Repositories\Eloquent\Backend\Portfolio\ServiceRepository;
use App\Repositories\Eloquent\Backend\Resume\SkillRepository;
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
     * @var SkillRepository
     */
    private $skillRepository;

    /**
     * SkillService constructor.
     * @param SkillRepository $skillRepository
     */
    public function __construct(SkillRepository $skillRepository)
    {
        $this->skillRepository = $skillRepository;
        $this->skillRepository->itemsPerPage = 10;
    }

    /**
     * Get All Skill models as collection
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
     * Create Skill Model Pagination
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
     * Show Skill Model
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
     * Save Skill Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeSkill(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newSkill = $this->skillRepository->create($inputs);
            if ($newSkill instanceof Skill) {
                $newSkill->save();

                DB::commit();
                return ['status' => true, 'message' => __('New Skill Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Skill Creation Failed'),
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
     * Update Skill Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateSkill(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $skill = $this->skillRepository->show($id);
            if ($skill instanceof Skill) {
                if ($this->skillRepository->update($inputs, $id)) {
                    $skill->save();
                    DB::commit();
                    return ['status' => true, 'message' => __('Skill Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('Skill Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Skill Model Not Found'),
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
     * Destroy Skill Model
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
                return ['status' => true, 'message' => __('Skill is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Skill is Delete Failed'),
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
     * Restore Skill Model
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
                return ['status' => true, 'message' => __('Skill is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Skill is Restoration Failed'),
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
