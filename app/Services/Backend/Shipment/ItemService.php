<?php

namespace App\Services\Backend\Shipment;

use App\Abstracts\Service\Service;
use App\Models\Backend\Shipment\Item;
use App\Repositories\Eloquent\Backend\Shipment\ItemRepository;
use App\Services\Auth\AuthenticatedSessionService;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class ItemService
 * @package App\Services\Backend\Shipment
 */
class ItemService extends Service
{
/**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * ItemService constructor.
     * @param ItemRepository $itemRepository
     */
    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->itemRepository->itemsPerPage = 10;
    }

    /**
     * Get All Item models as collection
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllItems(array $filters = [], array $eagerRelations = [])
    {
        return $this->itemRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Item Model Pagination
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function itemPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        if (!AuthenticatedSessionService::isSuperAdmin()):
            $filters['user_id'] = Auth::user()->id;
        endif;

        return $this->itemRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Item Model
     * 
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getItemById($id, bool $purge = false)
    {
        return $this->itemRepository->show($id, $purge);
    }

    /**
     * Save Item Model
     * 
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeItem(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newItem = $this->itemRepository->create($inputs);
            if ($newItem instanceof Item) {
                DB::commit();
                return ['status' => true, 'message' => __('New Item Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Item Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->itemRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update Item Model
     * 
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateItem(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $item = $this->itemRepository->show($id);
            if ($item instanceof Item) {
                if ($this->itemRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('Item Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('Item Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Item Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->itemRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy Item Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyItem($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->itemRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Item is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Item is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->itemRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore Item Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreItem($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->itemRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Item is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Item is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->itemRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return ItemExport
     * @throws Exception
     */
    public function exportItem(array $filters = []): ItemExport
    {
        return (new ItemExport($this->itemRepository->getWith($filters)));
    }
}
