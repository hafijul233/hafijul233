<?php


namespace App\Interfaces;


use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * Get all instances of model
     *
     * @return Collection|Model[]
     */
    public function all();

    /**
     * create a new record in the database
     *
     * @param array $data
     * @return Model|null
     * @throws Exception
     */
    public function create(array $data): ?Model;

    /**
     * update record in the database
     *
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id): bool;

    /**
     * remove record from the database
     * @param $id
     * @return bool
     */
    public function delete($id): bool;

    /**
     * show the record with the given id
     * @param $id
     * @param bool $purge
     * @return mixed
     * @throws Exception
     */
    public function show($id, bool $purge = false);

    /**
     * Get the associated model
     * @return Model
     */
    public function getModel(): Model;

    /**
     * Associated Dynamically  model
     * @param Model $model
     * @return void
     */
    public function setModel(Model $model);

    /**
     * Eager load database relationships
     *
     * @param $relations
     * @return Builder
     */
    public function with($relations): Builder;

    /**
     * @return Builder
     */
    public function getQueryBuilder(): Builder;

    /**
     * Get the first Model meet this criteria
     *
     * @param string $column
     * @param string $operator
     * @param $value
     * @return Model|null
     * @throws Exception
     */
    public function findFirstWhere(string $column, string $operator, $value): ?Model;

    /**
     * Get the all Model meet this criteria
     *
     * @param string $column
     * @param string $operator
     * @param $value
     * @param array $with
     * @return Collection|null
     * @throws Exception
     */
    public function findAllWhere(string $column, string $operator, $value, array $with = []);

    /**
     * Get the all Model Columns Collection
     *
     * @param string $column
     * @return mixed
     * @throws Exception
     */
    public function findColumn(string $column);

    /**
     * Handle All catch Exceptions
     *
     * @param $exception
     * @throws Exception
     */
    public function handleException($exception);

    /**
     * @param array $filters
     * @param array $eagerRelations
     * @return mixed
     */
    public function paginateWith(array $filters = [], array $eagerRelations = []);

    /**
     * Restore any Soft-Deleted Table Row/Model
     * @param $id
     * @return mixed
     */
    public function restore($id): bool;
}
