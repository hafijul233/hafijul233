<?php

namespace App\Services\Backend\Resume;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Organization\AwardExport;
use App\Models\Backend\Resume\Award;
use App\Repositories\Eloquent\Backend\Portfolio\ServiceRepository;
use App\Repositories\Eloquent\Backend\Resume\AwardRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class AwardService
 * @package App\Services\Backend\Portfolio
 */
class AwardService extends Service
{
    /**
     * @var AwardRepository
     */
    private $awardRepository;

    /**
     * AwardService constructor.
     * @param AwardRepository $awardRepository
     */
    public function __construct(AwardRepository $awardRepository)
    {
        $this->awardRepository = $awardRepository;
        $this->awardRepository->itemsPerPage = 10;
    }

    /**
     * Get All Award models as collection
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
     * Create Award Model Pagination
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
     * Show Award Model
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
     * Save Award Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeAward(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newAward = $this->awardRepository->create($inputs);
            if ($newAward instanceof Award) {
                $newAward->save();
                DB::commit();
                return ['status' => true, 'message' => __('New Award Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Award Creation Failed'),
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
     * Update Award Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateAward(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $award = $this->awardRepository->show($id);
            if ($award instanceof Award) {
                if ($this->awardRepository->update($inputs, $id)) {
                    //handling Comment List
                    $award->surveys()->sync($inputs['survey_id']);
                    $award->previousAwardings()->sync($inputs['prev_post_state_id']);
                    $award->futureAwardings()->sync($inputs['future_post_state_id']);
                    $award->save();
                    DB::commit();
                    return ['status' => true, 'message' => __('Award Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('Award Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Award Model Not Found'),
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
     * Destroy Award Model
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
                return ['status' => true, 'message' => __('Award is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Award is Delete Failed'),
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
     * Restore Award Model
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
                return ['status' => true, 'message' => __('Award is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Award is Restoration Failed'),
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
