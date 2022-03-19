<?php

namespace App\Services\Backend\Setting;

use App\Abstracts\Service\Service;
use App\Exports\Backend\Setting\CountryExport;
use App\Models\Backend\Setting\Country;
use App\Repositories\Eloquent\Backend\Setting\CountryRepository;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @class CountryService
 * @package Modules\Country\Services\Setting
 */
class CountryService extends Service
{
    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * CountryService constructor.
     * @param CountryRepository $countryRepository
     */
    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
        $this->countryRepository->itemsPerPage = 10;
    }

    /**
     * Get All Country models as collection
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllCountries(array $filters = [], array $eagerRelations = [])
    {
        return $this->countryRepository->getAllCountryWith($filters, $eagerRelations, true);
    }

    /**
     * Create Country Model Pagination
     *
     * @param array $filters
     * @param array $eagerRelations
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function countryPaginate(array $filters = [], array $eagerRelations = []): LengthAwarePaginator
    {
        return $this->countryRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * Show Country Model
     *
     * @param int $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function getCountryById($id, bool $purge = false)
    {
        return $this->countryRepository->show($id, $purge);
    }

    /**
     * Save Country Model
     *
     * @param array $inputs
     * @return array
     * @throws Exception
     * @throws Throwable
     */
    public function storeCountry(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $newCountry = $this->countryRepository->create($inputs);
            if ($newCountry instanceof Country) {
                DB::commit();
                return ['status' => true, 'message' => __('New Country Created'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('New Country Creation Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->countryRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Update Country Model
     *
     * @param array $inputs
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function updateCountry(array $inputs, $id): array
    {
        DB::beginTransaction();
        try {
            $country = $this->countryRepository->show($id);
            if ($country instanceof Country) {
                if ($this->countryRepository->update($inputs, $id)) {
                    DB::commit();
                    return ['status' => true, 'message' => __('Country Info Updated'),
                        'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];
                } else {
                    DB::rollBack();
                    return ['status' => false, 'message' => __('Country Info Update Failed'),
                        'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => __('Country Model Not Found'),
                    'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->countryRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Destroy Country Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function destroyCountry($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->countryRepository->delete($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Country is Trashed'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Country is Delete Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->countryRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Restore Country Model
     *
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function restoreCountry($id): array
    {
        DB::beginTransaction();
        try {
            if ($this->countryRepository->restore($id)) {
                DB::commit();
                return ['status' => true, 'message' => __('Country is Restored'),
                    'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Notification!'];

            } else {
                DB::rollBack();
                return ['status' => false, 'message' => __('Country is Restoration Failed'),
                    'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Alert!'];
            }
        } catch (Exception $exception) {
            $this->countryRepository->handleException($exception);
            DB::rollBack();
            return ['status' => false, 'message' => $exception->getMessage(),
                'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Error!'];
        }
    }

    /**
     * Export Object for Export Download
     *
     * @param array $filters
     * @return CountryExport
     * @throws Exception
     */
    public function exportCountry(array $filters = []): CountryExport
    {
        return (new CountryExport($this->countryRepository->getAllCountryWith($filters)));
    }

    /**
     * @param array $filters
     * @return array
     * @throws Exception
     */
    public function getCountryDropdown(array $filters = []): array
    {
        $filters = array_merge([
            'enabled' => 'yes',
        ], $filters);

        $countries = $this->getAllCountries($filters);
        $countryArray = [];

        foreach ($countries as $country)
            $countryArray[$country->id] = "{$country->emoji} {$country->name} ({$country->iso3})";

        return $countryArray;
    }
}
