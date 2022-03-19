<?php

namespace App\Services\Backend\Setting;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Setting\CatalogExport;
use App\Models\Backend\Setting\Catalog;
use App\Repositories\Eloquent\Backend\Setting\CatalogRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class CatalogService
 * @package App\Services\Setting
 */
class CatalogService extends Service
{
    /**
     * @var CatalogRepository
     */
    private $catalogRepository;

    /**
     * CatalogService constructor.
     * @param CatalogRepository $catalogRepository
     */
    public function __construct(CatalogRepository $catalogRepository)
    {
        $this->catalogRepository = $catalogRepository;
        $this->catalogRepository->itemsPerPage = 10;
    }

    /**
     * Get All Catalog models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllCatalogs(array $filters = [], array $eagerRelations = [])
    {
        return $this->catalogRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Catalog Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function catalogPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->catalogRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Catalog Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getCatalogById($id, bool $purge = false)
    {
        return $this->catalogRepository->show($id, $purge);
    }

    /**
     * Save Catalog Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeCatalog(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newCatalog = $this->catalogRepository->create($inputs);
            if ($newCatalog instanceof Catalog) {
                DB::commit();
                return ['status' => true, 'message' => __('New Catalog Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Catalog Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->catalogRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update Catalog Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateCatalog(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $catalog = $this->catalogRepository->show($id);
            if ($catalog instanceof Catalog) {
                if ($this->catalogRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('Catalog Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('Catalog Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Catalog Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->catalogRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy Catalog Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyCatalog($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->catalogRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Catalog is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Catalog is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->catalogRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore Catalog Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreCatalog($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->catalogRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Catalog is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Catalog is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->catalogRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return CatalogExport
     * @throws Exception
     */
    public function exportCatalog(array $filters = []): CatalogExport
    {
        return (new CatalogExport($this->catalogRepository->getWith($filters)));
    }

    /**
     * Return catalog type list as array
     *
     * @return array
     * @throws Exception
     */
    public function getCatalogModelTypeArray(): array
    {
        $catalogs = $this->catalogRepository->all();
        $catalogArray = [];
        foreach ($catalogs as $catalog):
            $catalogArray[$catalog->model_type] = class_basename($catalog->model_type);
        endforeach;

        return $catalogArray;
    }

    /**
     * @param array $filters
     * @return array
     * @throws Exception
     */
    public function getCatalogDropdown(array $filters = [])
    {
        $catalogs = $this->getAllCatalogs($filters);
        $catalogArray = [];
        foreach ($catalogs as $catalog)
            $catalogArray[$catalog->id] = $catalog->name;

        return $catalogArray;
    }
}
