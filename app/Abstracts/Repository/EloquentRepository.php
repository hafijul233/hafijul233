<?php


namespace App\Abstracts\Repository;


use App\Interfaces\RepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PDOException;

/**
 * Class EloquentRepository
 * @package Modules\Backend\Repositories
 */
abstract class EloquentRepository implements RepositoryInterface
{
    /**
     * @var Model $model eloquent Model Object
     */
    public $model;

    /**
     * @var int $itemsPerPage number of items will be on pagination
     */
    public $itemsPerPage = 10;

    /**
     * Repository constructor.
     * Constructor to bind model to repo
     * @param Model $model
     * @param int $itemsPerPage
     */
    public function __construct(Model $model, int $itemsPerPage = 10)
    {
        $this->model = $model;
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * Get all instances of model
     *
     * @return Collection|Model[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * create a new record in the database
     *
     * @param array $data
     * @return Model
     * @throws Exception
     */
    public function create(array $data): ?Model
    {
        try {
            $newModel = $this->model->create($data);
            $this->setModel($newModel);
            return $this->getModel();
        } catch (Exception $exception) {
            $this->handleException($exception);
            return null;
        }
    }

    /**
     * update record in the database
     *
     * @param array $data
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function update(array $data, $id): bool
    {
        try {
            $recordModel = $this->model->findOrFail($id);
            $this->setModel($recordModel);
            return $this->model->update($data);
        } catch (Exception $exception) {
            $this->handleException($exception);
            return false;
        }

    }

    /**
     * remove record from the database
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        return (bool)$this->model->destroy($id);
    }

    /**
     * show the record with the given id
     * @param $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function show($id, bool $purge = false)
    {
        $newModel = null;
        try {
            if ($purge === true)
                $newModel = $this->model->withTrashed()->findOrFail($id);
            else
                $newModel = $this->model->findOrFail($id);

        } catch (ModelNotFoundException $exception) {
            $this->handleException($exception);
        } finally {
            return $newModel;
        }
    }

    /**
     * remove record from the database
     * @param $id
     * @return bool
     */
    public function restore($id): bool
    {
        return (bool)$this->model->withTrashed()->find($id)->restore($id);
    }

    /**
     * Get the associated model
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Associated Dynamically  model
     * @param Model $model
     * @return void
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Eager load database relationships
     *
     * @param $relations
     * @return Builder
     */
    public function with($relations): Builder
    {
        return $this->model->with($relations);
    }

    /**
     * @return Builder
     */
    public function getQueryBuilder(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * Get the first Model meet this criteria
     *
     * @param string $column
     * @param string $operator
     * @param $value
     * @return Model|null
     * @throws Exception
     */

    public function findFirstWhere(string $column, string $operator, $value): ?Model
    {
        $freshModel = null;
        try {
            $freshModel = $this->model->where($column, $operator, $value)->first();
        } catch (PDOException $exception) {
            $this->handleException($exception);
        } finally {
            return $freshModel;
        }
    }

    /**
     * Get the all Model meet this criteria
     *
     * @param string $column
     * @param string $operator
     * @param $value
     * @param array $with
     * @return mixed
     * @throws Exception
     */

    public function findAllWhere(string $column, string $operator, $value, array $with = [])
    {
        $collection = [];

        try {
            $collection = $this->model->where($column, $operator, $value)->with($with)->get();
        } catch (PDOException $exception) {
            $this->handleException($exception);
        } finally {
            return $collection;
        }
    }


    /**
     * Get the all Model Columns Collection
     *
     * @param string $column
     * @return mixed
     * @throws Exception
     */
    public function findColumn(string $column)
    {
        $column = null;
        try {
            $column = $this->model->all()->pluck($column);
        } catch (PDOException $exception) {
            $this->handleException($exception);
        } finally {
            return $column;
        }
    }

    /**
     * Handle All catch Exceptions
     *
     * @param $exception
     * @throws Exception
     */
    public function handleException($exception)
    {
        \Log::error("Query Exception: ");
        \Log::error($exception->getMessage());
        //if application is on production keep silent
        if (\App::environment('production'))
            \Log::error($exception->getMessage());

        //Eloquent Model Exception
        else if ($exception instanceof ModelNotFoundException)
            throw new ModelNotFoundException($exception->getMessage());

        //DB Error
        else if ($exception instanceof PDOException)
            throw new PDOException($exception->getMessage());

        else if ($exception instanceof \BadMethodCallException)
            throw new \BadMethodCallException($exception->getMessage());

        //Through general Exception
        else
            throw new Exception($exception->getMessage());

    }

    /**
     * @param array $filters
     * @param array $eagerRelations
     * @param bool $is_sortable
     * @return mixed
     * @throws Exception
     */
    public function paginateWith(array $filters = [], array $eagerRelations = [], bool $is_sortable = false)
    {
        try {
            //if Sorting is available for this column
            if ($is_sortable)
                $this->model->sortable();

            if (isset($filters['sort']) && isset($filters['direction'])) {
                /*                $this->model->orderBy($filters['sort'], $filters['direction']);*/
                unset($filters['sort'], $filters['direction']);
            }

        } catch (BadMethodCallException $exception) {
            $this->handleException($exception);
        } finally {
            return $this->model->where($filters)->with($eagerRelations)->paginate($this->itemsPerPage);
        }
    }
}
