<?php

namespace App\Services\Backend\Blog;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Organization\PostExport;
use App\Models\Backend\Blog\Post;
use App\Repositories\Eloquent\Backend\Blog\PostRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class PostService
 * @package App\Services\Backend\Blog
 */
class PostService extends Service
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * PostService constructor.
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
        $this->postRepository->itemsPerPage = 10;
    }

    /**
     * Get All Post models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllPosts(array $filters = [], array $eagerRelations = [])
    {
        return $this->postRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Post Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function postPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->postRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Post Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getPostById($id, bool $purge = false)
    {
        return $this->postRepository->show($id, $purge);
    }

    /**
     * Save Post Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storePost(array $inputs): array
    {
        $newPostInfo = $this->formatPostInfo($inputs);
        DB::beginTransaction();
        try {
            $newPost = $this->postRepository->create($newPostInfo);
            if ($newPost instanceof Post) {
                //handling Comment List
                $newPost->surveys()->attach($inputs['survey_id']);
                $newPost->previousPostings()->attach($inputs['prev_post_state_id']);
                $newPost->futurePostings()->attach($inputs['future_post_state_id']);
                $newPost->save();

                DB::commit();
                return ['status' => true, 'message' => __('New Post Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Post Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->postRepository->handleException($exception);
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
    private function formatPostInfo(array $inputs)
    {
        $postInfo = [];
        $postInfo["survey_id"] = null;
        $postInfo["gender_id"] = $inputs['gender_id'] ?? null;
        $postInfo["dob"] = $inputs['dob'] ?? null;
        $postInfo["name"] = $inputs["name"] ?? null;
        $postInfo["name_bd"] = $inputs["name_bd"] ?? null;
        $postInfo["father"] = $inputs["father"] ?? null;
        $postInfo["father_bd"] = $inputs["father_bd"] ?? null;
        $postInfo["mother"] = $inputs["mother"] ?? null;
        $postInfo["mother_bd"] = $inputs["mother_bd"] ?? null;
        $postInfo["nid"] = $inputs["nid"] ?? null;
        $postInfo["mobile_1"] = $inputs["mobile_1"] ?? null;
        $postInfo["mobile_2"] = $inputs["mobile_2"] ?? null;
        $postInfo["email"] = $inputs["email"] ?? null;
        $postInfo["present_address"] = $inputs["present_address"] ?? null;
        $postInfo["present_address_bd"] = $inputs["present_address_bd"] ?? null;
        $postInfo["permanent_address"] = $inputs["permanent_address"] ?? null;
        $postInfo["permanent_address_bd"] = $inputs["permanent_address_bd"] ?? null;
        $postInfo["exam_level"] = $inputs["exam_level"] ?? null;
        $postInfo["whatsapp"] = $inputs["whatsapp"] ?? null;
        $postInfo["facebook"] = $inputs["facebook"] ?? null;

        $postInfo["is_employee"] = $inputs["is_employee"] ?? 'no';
        $postInfo["designation"] = null;
        $postInfo["company"] = null;

        if ($postInfo["is_employee"] == 'yes') {
            $postInfo["designation"] = $inputs['designation'] ?? null;
            $postInfo["company"] = $inputs['company'] ?? null;
        }

        return $postInfo;
    }

    /**
     * Update Post Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updatePost(array $inputs, $id): array
    {
        $newPostInfo = $this->formatPostInfo($inputs);
        DB::beginTransaction();
        try {
            $post = $this->postRepository->show($id);
            if ($post instanceof Post) {
                if ($this->postRepository->update($newPostInfo, $id)) {
                    //handling Comment List
                    $post->surveys()->sync($inputs['survey_id']);
                    $post->previousPostings()->sync($inputs['prev_post_state_id']);
                    $post->futurePostings()->sync($inputs['future_post_state_id']);
                    $post->save();
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
            $this->postRepository->handleException($exception);
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
    public function destroyPost($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->postRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Post is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Post is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->postRepository->handleException($exception);
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
    public function restorePost($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->postRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Post is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Post is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->postRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return PostExport
     * @throws Exception
     */
    public function exportPost(array $filters = []): PostExport
    {
        return (new PostExport($this->postRepository->getWith($filters)));
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
