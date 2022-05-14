<?php

namespace App\Services\Backend\Blog;

use App\Abstracts\Service\Service;
use App\Models\Backend\Blog\Post;
use App\Repositories\Eloquent\Backend\Blog\PostRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
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
        DB::beginTransaction();
        try {
            $newPost = $this->postRepository->create($inputs);
            if ($newPost instanceof Post) {
                if ($inputs['image'] instanceof UploadedFile) {
                    $newPost->addMedia($inputs['image'])->toMediaCollection('posts');
                }
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
     * Update Post Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updatePost(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $post = $this->postRepository->show($id);
            if ($post instanceof Post) {
                if ($this->postRepository->update($inputs, $id)) {
                    if (isset($inputs['image']) && $inputs['image'] instanceof UploadedFile) {
                        $post->addMedia($inputs['image'])->toMediaCollection('services');
                    }
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
