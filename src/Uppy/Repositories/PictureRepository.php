<?php namespace Hostbrute\Uppy\Repositories;

use Hostbrute\Uppy\Models\PictureModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class PictureRepository extends BaseRepository
{

	public $searchable = ['name'];

	/**
	 * @param PictureModel $model
	 */
	public function __construct(PictureModel $model)
	{
		$this->model = $model;
	}

	/**
	 * @param int $amount
	 * @return mixed
	 */
	public function paginated($amount = 10)
	{
		return $this->model->paginate($amount);
	}

	/**
	 * @param $id
	 * @param $input
	 */
	public function update($id, $input)
	{
		$post = $this->findOrFail($id);
		$this->save($post, $input, 'update');
	}

	/**
	 * @param $picture
	 * @param array $input
	 * @param string $type
	 * @return bool
	 */
	protected function save($picture, $input = array(), $type = 'create')
	{
		$beforeEvent = ($type === 'create' ? 'creating' : 'updating');
		$afterEvent = ($type === 'create' ? 'created' : 'updated');

		$data = [
			'file' => $input['file'],
			'name' => $input['name']
		];

		$picture->fill($data);
		$this->fireEvent($beforeEvent, [$picture, $input]);
		$this->fireEvent('saving', [$picture, $input]);

		$categories = isset($input['categories']) ? explode(',', $input['categories'][0]) : [];
		DB::transaction(function () use ($picture, $input, $data, $categories) {
			$picture->save();
		});

		$this->fireEvent($afterEvent, [$picture, $input]);
		$this->fireEvent('saved', [$picture, $input]);

		return true;
	}

	/**
	 * @param $event
	 * @param $params
	 */
	protected function fireEvent($event, $params)
	{
		Event::fire('uppy.pictures: ' . $event, $params);
	}

	/**
	 * @param $input
	 */
	public function store($input)
	{
		$picture = $this->model;
		$this->save($picture, $input, 'update');
	}
}