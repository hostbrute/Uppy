<?php namespace Hostbrute\Uppy\Repositories;

use Eloquent;
use Illuminate\Pagination\Paginator;

/**
 * Class BaseRepository
 * @package Hostbrute\Base\Repositories
 */
class BaseRepository
{

	/**
	 * @var array
	 */
	public $searchable = [];

	/**
	 * @var Eloquent
	 */
	public $model;

	/**
	 * return paginated model
	 *
	 * @param int $amount
	 * @return Paginator
	 */
	public function paginated($amount = 10)
	{
		return $this->model->paginate($amount);
	}

	/**
	 * Find a model with relationships
	 *
	 * @param $id
	 * @param array $with
	 * @return mixed
	 */
	public function find($id, $with = [])
	{
		$this->model;

		if ($this->checkWith($with)) {
			return $this->model->with($with)->find($id);
		}
		return $this->model->find($id);
	}

	/**
	 * Check if the $with parameter is properly formatted
	 *
	 * @param array $with
	 * @return bool
	 */
	protected function checkWith($with)
	{
		return (isset($with) && is_array($with) && count($with) > 0);
	}

	/**
	 * Find or fail on the model with relationships
	 *
	 * @param $id
	 * @param array $with
	 * @return mixed
	 */
	public function findOrFail($id, $with = [])
	{
		if ($this->checkWith($with)) {
			return $this->model->with($with)->findOrFail($id);
		}
		return $this->model->findOrFail($id);
	}

	/**
	 * Search like
	 *
	 * @param string $q
	 * @param array $columns
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function searchLike($q, $columns = [])
	{
		$model = $this->model;
		$columns = $columns == [] && isset($this->searchable) ? $this->searchable : $columns;
		$model = $this->setLikeColumns($columns, $model, $q);
		return $this->returnSearch($model);
	}

	/**
	 * @param $columns
	 * @param $model
	 * @param $q
	 */
	protected function setLikeColumns($columns, $model, $q)
	{
		foreach ($columns as $column) {
			$model = $model->where($column, 'LIKE', '%' . $q)
				->orWhere($column, 'LIKE', $q)
				->orWhere($column, 'LIKE', $q . '%');
		}
		return $model;
	}

	/**
	 * function to return search results, so it can be edited
	 *
	 * @param $model
	 * @return mixed
	 */
	protected function returnSearch($model)
	{
		return $model->get();
	}

	/**
	 * Generate new model
	 *
	 * @return mixed
	 */
	public function newModel()
	{
		$class = get_class($this->model);
		return new $class();
	}
}