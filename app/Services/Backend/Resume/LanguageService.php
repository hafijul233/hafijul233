<?php

namespace App\Services\Backend\Resume;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Organization\LanguageExport;
use App\Models\Backend\Portfolio\Post;
use App\Repositories\Eloquent\Backend\Resume\LanguageRepository;
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
class LanguageService extends Service
{
    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * PostService constructor.
     * @param LanguageRepository $languageRepository
     */
    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
        $this->languageRepository->itemsPerPage = 10;
    }

    /**
     * Get All Post models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllLanguages(array $filters = [], array $eagerRelations = [])
    {
        return $this->languageRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Post Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function languagePaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->languageRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Post Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getLanguageById($id, bool $purge = false)
    {
        return $this->languageRepository->show($id, $purge);
    }

    /**
     * Save Post Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeLanguage(array $inputs): array
    {
        $newLanguageInfo = $this->formatLanguageInfo($inputs);
        DB::beginTransaction();
        try {
            $newLanguage = $this->languageRepository->create($newLanguageInfo);
            if ($newLanguage instanceof Post) {
                //handling Comment List
                $newLanguage->surveys()->attach($inputs['survey_id']);
                $newLanguage->previousPostings()->attach($inputs['prev_post_state_id']);
                $newLanguage->futurePostings()->attach($inputs['future_post_state_id']);
                $newLanguage->save();

                DB::commit();
                return ['status' => true, 'message' => __('New Post Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Post Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->languageRepository->handleException($exception);
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
    private function formatLanguageInfo(array $inputs)
    {
        $languageInfo = [];
        $languageInfo["survey_id"] = null;
        $languageInfo["gender_id"] = $inputs['gender_id'] ?? null;
        $languageInfo["dob"] = $inputs['dob'] ?? null;
        $languageInfo["name"] = $inputs["name"] ?? null;
        $languageInfo["name_bd"] = $inputs["name_bd"] ?? null;
        $languageInfo["father"] = $inputs["father"] ?? null;
        $languageInfo["father_bd"] = $inputs["father_bd"] ?? null;
        $languageInfo["mother"] = $inputs["mother"] ?? null;
        $languageInfo["mother_bd"] = $inputs["mother_bd"] ?? null;
        $languageInfo["nid"] = $inputs["nid"] ?? null;
        $languageInfo["mobile_1"] = $inputs["mobile_1"] ?? null;
        $languageInfo["mobile_2"] = $inputs["mobile_2"] ?? null;
        $languageInfo["email"] = $inputs["email"] ?? null;
        $languageInfo["present_address"] = $inputs["present_address"] ?? null;
        $languageInfo["present_address_bd"] = $inputs["present_address_bd"] ?? null;
        $languageInfo["permanent_address"] = $inputs["permanent_address"] ?? null;
        $languageInfo["permanent_address_bd"] = $inputs["permanent_address_bd"] ?? null;
        $languageInfo["exam_level"] = $inputs["exam_level"] ?? null;
        $languageInfo["whatsapp"] = $inputs["whatsapp"] ?? null;
        $languageInfo["facebook"] = $inputs["facebook"] ?? null;

        $languageInfo["is_employee"] = $inputs["is_employee"] ?? 'no';
        $languageInfo["designation"] = null;
        $languageInfo["company"] = null;

        if ($languageInfo["is_employee"] == 'yes') {
            $languageInfo["designation"] = $inputs['designation'] ?? null;
            $languageInfo["company"] = $inputs['company'] ?? null;
        }

        return $languageInfo;
    }

    /**
     * Update Post Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateLanguage(array $inputs, $id): array
    {
        $newLanguageInfo = $this->formatLanguageInfo($inputs);
        DB::beginTransaction();
        try {
            $language = $this->languageRepository->show($id);
            if ($language instanceof Post) {
                if ($this->languageRepository->update($newLanguageInfo, $id)) {
                    //handling Comment List
                    $language->surveys()->sync($inputs['survey_id']);
                    $language->previousPostings()->sync($inputs['prev_post_state_id']);
                    $language->futurePostings()->sync($inputs['future_post_state_id']);
                    $language->save();
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
            $this->languageRepository->handleException($exception);
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
    public function destroyLanguage($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->languageRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Post is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Post is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->languageRepository->handleException($exception);
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
    public function restoreLanguage($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->languageRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Post is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Post is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->languageRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return LanguageExport
     * @throws Exception
     */
    public function exportLanguage(array $filters = []): LanguageExport
    {
        return (new LanguageExport($this->languageRepository->getWith($filters)));
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
