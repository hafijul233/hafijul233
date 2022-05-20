<?php

namespace App\Services\Backend\Blog;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Portfolio\NewsLetterExport;
use App\Models\Backend\Blog\NewsLetter;
use App\Repositories\Eloquent\Backend\Blog\NewsLetterRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class NewsLetterService
 * @package App\Services\Backend\Blog
 */
class NewsLetterService extends Service
{
    /**
     * @var NewsLetterRepository
     */
    private $newsLetterRepository;

    /**
     * NewsLetterService constructor.
     * @param NewsLetterRepository $newsLetterRepository
     */
    public function __construct(NewsLetterRepository $newsLetterRepository)
    {
        $this->newsLetterRepository = $newsLetterRepository;
        $this->newsLetterRepository->itemsPerPage = 10;
    }

    /**
     * Create NewsLetter Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function newsLetterPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->newsLetterRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show NewsLetter Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getNewsLetterById($id, bool $purge = false)
    {
        return $this->newsLetterRepository->show($id, $purge);
    }

    /**
     * Save NewsLetter Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeNewsLetter(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newNewsLetter = $this->newsLetterRepository->create($inputs);
            if ($newNewsLetter instanceof NewsLetter) {
                DB::commit();
                return ['status' => true, 'message' => __('New NewsLetter Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New NewsLetter Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->newsLetterRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update NewsLetter Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateNewsLetter(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $newsLetter = $this->newsLetterRepository->show($id);
            if ($newsLetter instanceof NewsLetter) {
                if ($this->newsLetterRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('NewsLetter Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('NewsLetter Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('NewsLetter Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->newsLetterRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy NewsLetter Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyNewsLetter($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->newsLetterRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('NewsLetter is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('NewsLetter is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->newsLetterRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore NewsLetter Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreNewsLetter($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->newsLetterRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('NewsLetter is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('NewsLetter is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->newsLetterRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return NewsLetterExport
     * @throws Exception
     */
    public function exportNewsLetter(array $filters = []): NewsLetterExport
    {
        return (new NewsLetterExport($this->newsLetterRepository->getWith($filters)));
    }

    /**
     * Created Array Styled NewsLetter List for dropdown
     *
     * @param array $filters
     * @return array
     * @throws Exception
     */
    public function getNewsLetterDropDown(array $filters = [])
    {
        $newsLetters = $this->getAllNewsLetters($filters);
        $newsLetterArray = [];
        foreach ($newsLetters as $newsLetter) {
            $newsLetterArray[$newsLetter->id] = $newsLetter->name;
        }

        return $newsLetterArray;
    }

    /**
     * Get All NewsLetter models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllNewsLetters(array $filters = [], array $eagerRelations = [])
    {
        return $this->newsLetterRepository->getWith($filters, $eagerRelations, true);
    }
}
