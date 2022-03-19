<?php


namespace App\Repositories\Eloquent\Backend\Setting;


use App\Abstracts\Repository\EloquentRepository;
use App\Models\Backend\Setting\Country;
use App\Services\Auth\AuthenticatedSessionService;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CountryRepository extends EloquentRepository
{
    /**
     * PermissionRepository constructor.
     */
    public function __construct()
    {
        /**
         * Set the model that will be used for repo
         */
        parent::__construct(new Country);
    }

    /**
     * Search Function for Permissions
     *
     * @param array $filters
     * @param bool $is_sortable
     * @return Builder
     */
    private function filterData(array $filters = [], bool $is_sortable = false): Builder
    {
        $query = $this->getQueryBuilder();
        if (!empty($filters['search'])) :
            $query->where('name', 'like', "%{$filters['search']}%")
                ->orWhere('display_name', 'like', "%{$filters['search']}%")
                ->orWhere('guard_name', 'like', "%{$filters['search']}%")
                ->orWhere('enabled', '=', "%{$filters['search']}%");
        endif;

        if (!empty($filters['enabled'])) :
            $query->where('enabled', '=', $filters['enabled']);
        endif;

        if (!empty($filters['sort']) && !empty($filters['direction'])) :
            $query->orderBy($filters['sort'], $filters['direction']);
        endif;

        if ($is_sortable == true) :
            $query->sortable();
        endif;

        if (AuthenticatedSessionService::isSuperAdmin()) :
            $query->withTrashed();
        endif;

        return $query;
    }

    /**
     * Pagination Generator
     * @param array $filters
     * @param array $eagerRelations
     * @param bool $is_sortable
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function paginateWith(array $filters = [], array $eagerRelations = [], bool $is_sortable = false): LengthAwarePaginator
    {
        try {
            $query = $this->filterData($filters, $is_sortable);
        } catch (Exception $exception) {
            $this->handleException($exception);
        } finally {
            return $query->with($eagerRelations)->paginate($this->itemsPerPage);
        }
    }

    /**
     * @param array $filters
     * @param array $eagerRelations
     * @param bool $is_sortable
     * @return Builder[]|Collection
     * @throws Exception
     */
    public function getAllCountryWith(array $filters = [], array $eagerRelations = [], bool $is_sortable = false)
    {
        try {
            $query = $this->filterData($filters, $is_sortable);
        } catch (Exception $exception) {
            $this->handleException($exception);
        } finally {
            return $query->with($eagerRelations)->get();
        }
    }


}
