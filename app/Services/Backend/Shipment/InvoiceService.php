<?php

namespace App\Services\Backend\Shipment;

use App\Abstracts\Service\Service;
use App\Models\Backend\Shipment\Invoice;
use App\Repositories\Eloquent\Backend\Shipment\InvoiceRepository;
use App\Services\Auth\AuthenticatedSessionService;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Core\Supports\Constant;
use Throwable;

/**
 * @class InvoiceService
 * @package App\Services\Backend\Shipment
 */
class InvoiceService extends Service
{
/**
     * @var InvoiceRepository
     */
    private $invoiceRepository;

    /**
     * InvoiceService constructor.
     * @param InvoiceRepository $invoiceRepository
     */
    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->invoiceRepository->itemsPerPage = 10;
    }

    /**
     * Get All Invoice models as collection
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllInvoices(array $filters = [], array $eagerRelations = [])
    {
        return $this->invoiceRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Invoice Model Pagination
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function invoicePaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        if (!AuthenticatedSessionService::isSuperAdmin()) {
            $filters['user_id'] = Auth::user()->id;
        }
        return $this->invoiceRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Invoice Model
     * 
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getInvoiceById($id, bool $purge = false)
    {
        return $this->invoiceRepository->show($id, $purge);
    }

    /**
     * Save Invoice Model
     * 
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeInvoice(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newInvoice = $this->invoiceRepository->create($inputs);
            if ($newInvoice instanceof Invoice) {
                DB::commit();
                return ['status' => true, 'message' => __('New Invoice Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Invoice Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->invoiceRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update Invoice Model
     * 
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateInvoice(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $invoice = $this->invoiceRepository->show($id);
            if ($invoice instanceof Invoice) {
                if ($this->invoiceRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('Invoice Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('Invoice Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Invoice Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->invoiceRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy Invoice Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyInvoice($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->invoiceRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Invoice is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Invoice is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->invoiceRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore Invoice Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreInvoice($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->invoiceRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Invoice is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Invoice is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->invoiceRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return InvoiceExport
     * @throws Exception
     */
    public function exportInvoice(array $filters = []): InvoiceExport
    {
        return (new InvoiceExport($this->invoiceRepository->getWith($filters)));
    }
}
