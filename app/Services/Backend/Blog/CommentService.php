<?php

namespace App\Services\Backend\Blog;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Portfolio\CommentExport;
use App\Models\Backend\Blog\Comment;
use App\Repositories\Eloquent\Backend\Blog\CommentRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class CommentService
 * @package App\Services\Backend\Blog
 */
class CommentService extends Service
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * CommentService constructor.
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->commentRepository->itemsPerPage = 10;
    }

    /**
     * Create Comment Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function commentPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->commentRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Comment Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getCommentById($id, bool $purge = false)
    {
        return $this->commentRepository->show($id, $purge);
    }

    /**
     * Save Comment Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeComment(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newComment = $this->commentRepository->create($inputs);
            if ($newComment instanceof Comment) {
                DB::commit();
                return ['status' => true, 'message' => __('New Comment Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Comment Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->commentRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update Comment Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateComment(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $comment = $this->commentRepository->show($id);
            if ($comment instanceof Comment) {
                if ($this->commentRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('Comment Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('Comment Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Comment Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->commentRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy Comment Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyComment($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->commentRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Comment is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Comment is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->commentRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore Comment Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreComment($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->commentRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Comment is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Comment is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->commentRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return CommentExport
     * @throws Exception
     */
    public function exportComment(array $filters = []): CommentExport
    {
        return (new CommentExport($this->commentRepository->getWith($filters)));
    }

    /**
     * Created Array Styled Comment List for dropdown
     *
     * @param array $filters
     * @return array
     * @throws Exception
     */
    public function getCommentDropDown(array $filters = [])
    {
        $comments = $this->getAllComments($filters);
        $commentArray = [];
        foreach ($comments as $comment) {
            $commentArray[$comment->id] = $comment->name;
        }

        return $commentArray;
    }

    /**
     * Get All Comment models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllComments(array $filters = [], array $eagerRelations = [])
    {
        return $this->commentRepository->getWith($filters, $eagerRelations, true);
    }
}
