<?php

namespace App\Services\Backend\Shipment;

use App\Abstracts\Service\Service;
use App\Models\Backend\Shipment\Transaction;
use App\Repositories\Eloquent\Backend\Shipment\TransactionRepository;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Core\Supports\Constant;
use Throwable;

/**
 * @class TransactionService
 * @package App\Services\Backend\Shipment
 */
class TransactionService extends Service
{
/**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * TransactionService constructor.
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->transactionRepository->itemsPerPage = 10;
    }

    /**
     * Get All Transaction models as collection
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllTransactions(array $filters = [], array $eagerRelations = [])
    {
        return $this->transactionRepository->getWith($filters, $eagerRelations, true);
    }

    /**
     * Create Transaction Model Pagination
     * 
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function transactionPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->transactionRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Transaction Model
     * 
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getTransactionById($id, bool $purge = false)
    {
        return $this->transactionRepository->show($id, $purge);
    }

    /**
     * Save Transaction Model
     * 
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeTransaction(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newTransaction = $this->transactionRepository->create($inputs);
            if ($newTransaction instanceof Transaction) {
                DB::commit();
                return ['status' => true, 'message' => __('New Transaction Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Transaction Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->transactionRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update Transaction Model
     * 
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateTransaction(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $transaction = $this->transactionRepository->show($id);
            if ($transaction instanceof Transaction) {
                if ($this->transactionRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('Transaction Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('Transaction Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Transaction Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->transactionRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy Transaction Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyTransaction($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->transactionRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Transaction is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Transaction is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->transactionRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore Transaction Model
     * 
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreTransaction($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->transactionRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Transaction is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Transaction is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->transactionRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return TransactionExport
     * @throws Exception
     */
    public function exportTransaction(array $filters = []): TransactionExport
    {
        return (new TransactionExport($this->transactionRepository->getWith($filters)));
    }
}
