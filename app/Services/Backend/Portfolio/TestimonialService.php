<?php

namespace App\Services\Backend\Portfolio;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Organization\TestimonialExport;
use App\Models\Backend\Portfolio\Testimonial;
use App\Repositories\Eloquent\Backend\Portfolio\TestimonialRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class TestimonialService
 * @package App\Services\Backend\Portfolio
 */
class TestimonialService extends Service
{
    /**
     * @var TestimonialRepository
     */
    private $testimonialRepository;

    /**
     * TestimonialService constructor.
     * @param TestimonialRepository $testimonialRepository
     */
    public function __construct(TestimonialRepository $testimonialRepository)
    {
        $this->testimonialRepository = $testimonialRepository;
        $this->testimonialRepository->itemsPerPage = 10;
    }

    /**
     * Get All Testimonial models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllTestimonials(array $filters = [], array $eagerRelations = [])
    {
        return $this->testimonialRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Testimonial Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function testimonialPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->testimonialRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Testimonial Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getTestimonialById($id, bool $purge = false)
    {
        return $this->testimonialRepository->show($id, $purge);
    }

    /**
     * Save Testimonial Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeTestimonial(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newTestimonial = $this->testimonialRepository->create($inputs);
            if ($newTestimonial instanceof Testimonial) {
                DB::commit();
                return ['status' => true, 'message' => __('New Testimonial Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Testimonial Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->testimonialRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update Testimonial Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateTestimonial(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $testimonial = $this->testimonialRepository->show($id);
            if ($testimonial instanceof Testimonial) {
                if ($this->testimonialRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('Testimonial Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('Testimonial Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Testimonial Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->testimonialRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy Testimonial Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyTestimonial($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->testimonialRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Testimonial is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Testimonial is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->testimonialRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore Testimonial Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreTestimonial($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->testimonialRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Testimonial is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Testimonial is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->testimonialRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return TestimonialExport
     * @throws Exception
     */
    public function exportTestimonial(array $filters = []): TestimonialExport
    {
        return (new TestimonialExport($this->testimonialRepository->getWith($filters)));
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
