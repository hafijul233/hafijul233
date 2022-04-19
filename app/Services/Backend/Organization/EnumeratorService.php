<?php

namespace App\Services\Backend\Organization;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Organization\EnumeratorExport;
use App\Models\Backend\Organization\Enumerator;
use App\Repositories\Eloquent\Backend\Organization\EnumeratorRepository;
use App\Repositories\Eloquent\Backend\Setting\ExamLevelRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class EnumeratorService
 * @package App\Services\Backend\Organization
 */
class EnumeratorService extends Service
{
    /**
     * @var EnumeratorRepository
     */
    private $enumeratorRepository;
    /**
     * @var ExamLevelRepository
     */
    private $examLevelRepository;

    /**
     * EnumeratorService constructor.
     * @param EnumeratorRepository $enumeratorRepository
     * @param ExamLevelRepository $examLevelRepository
     */
    public function __construct(EnumeratorRepository $enumeratorRepository,
                                ExamLevelRepository $examLevelRepository)
    {
        $this->enumeratorRepository = $enumeratorRepository;
        $this->enumeratorRepository->itemsPerPage = 10;
        $this->examLevelRepository = $examLevelRepository;
    }

    /**
     * Get All Enumerator models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllEnumerators(array $filters = [], array $eagerRelations = [])
    {
        return $this->enumeratorRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Enumerator Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function enumeratorPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->enumeratorRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Enumerator Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getEnumeratorById($id, bool $purge = false)
    {
        return $this->enumeratorRepository->show($id, $purge);
    }

    /**
     * Save Enumerator Model
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
            $newEnumerator = $this->enumeratorRepository->create($newEnumeratorInfo);
            if ($newEnumerator instanceof Enumerator) {
                //handling Survey List
                $newEnumerator->surveys()->attach($inputs['survey_id']);
                $newEnumerator->previousPostings()->attach($inputs['prev_post_state_id']);
                $newEnumerator->futurePostings()->attach($inputs['future_post_state_id']);
                $newEnumerator->save();

                DB::commit();
                return ['status' => true, 'message' => __('New Enumerator Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Enumerator Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->enumeratorRepository->handleException($exception);
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
        $enumeratorInfo = [];
        $enumeratorInfo["survey_id"] = null;
        $enumeratorInfo["gender_id"] = $inputs['gender_id'] ?? null;
        $enumeratorInfo["dob"] = $inputs['dob'] ?? null;
        $enumeratorInfo["name"] = $inputs["name"] ?? null;
        $enumeratorInfo["name_bd"] = $inputs["name_bd"] ?? null;
        $enumeratorInfo["father"] = $inputs["father"] ?? null;
        $enumeratorInfo["father_bd"] = $inputs["father_bd"] ?? null;
        $enumeratorInfo["mother"] = $inputs["mother"] ?? null;
        $enumeratorInfo["mother_bd"] = $inputs["mother_bd"] ?? null;
        $enumeratorInfo["nid"] = $inputs["nid"] ?? null;
        $enumeratorInfo["mobile_1"] = $inputs["mobile_1"] ?? null;
        $enumeratorInfo["mobile_2"] = $inputs["mobile_2"] ?? null;
        $enumeratorInfo["email"] = $inputs["email"] ?? null;
        $enumeratorInfo["present_address"] = $inputs["present_address"] ?? null;
        $enumeratorInfo["present_address_bd"] = $inputs["present_address_bd"] ?? null;
        $enumeratorInfo["permanent_address"] = $inputs["permanent_address"] ?? null;
        $enumeratorInfo["permanent_address_bd"] = $inputs["permanent_address_bd"] ?? null;
        $enumeratorInfo["exam_level"] = $inputs["exam_level"] ?? null;
        $enumeratorInfo["whatsapp"] = $inputs["whatsapp"] ?? null;
        $enumeratorInfo["facebook"] = $inputs["facebook"] ?? null;

        $enumeratorInfo["is_employee"] = $inputs["is_employee"] ?? 'no';
        $enumeratorInfo["designation"] = null;
        $enumeratorInfo["company"] = null;

        if ($enumeratorInfo["is_employee"] == 'yes') {
            $enumeratorInfo["designation"] = $inputs['designation'] ?? null;
            $enumeratorInfo["company"] = $inputs['company'] ?? null;
        }

        return $enumeratorInfo;
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
     * Update Enumerator Model
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
            $enumerator = $this->enumeratorRepository->show($id);
            if ($enumerator instanceof Enumerator) {
                if ($this->enumeratorRepository->update($newEnumeratorInfo, $id)) {
                    //handling Survey List
                    $enumerator->surveys()->sync($inputs['survey_id']);
                    $enumerator->previousPostings()->sync($inputs['prev_post_state_id']);
                    $enumerator->futurePostings()->sync($inputs['future_post_state_id']);
                    $enumerator->save();
                    DB::commit();
                    return ['status' => true, 'message' => __('Enumerator Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('Enumerator Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Enumerator Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->enumeratorRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy Enumerator Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyEnumerator($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->enumeratorRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Enumerator is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Enumerator is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->enumeratorRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore Enumerator Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreEnumerator($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->enumeratorRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Enumerator is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Enumerator is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->enumeratorRepository->handleException($exception);
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
        return (new EnumeratorExport($this->enumeratorRepository->getWith($filters)));
    }
}
