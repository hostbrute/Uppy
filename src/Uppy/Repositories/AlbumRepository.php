<?php namespace Hostbrute\Uppy\Repositories;


use Hostbrute\Uppy\Exceptions\ValidationException;
use Hostbrute\Uppy\Models\AlbumModel;
use Hostbrute\Uppy\Validators\AlbumValidator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class AlbumRepository extends BaseRepository
{

	/**
	 * @param AlbumModel $downloadModel
	 * @param AlbumValidator $validator
	 */
	public function __construct(AlbumModel $downloadModel, AlbumValidator $validator)
	{
		$this->model = $downloadModel;
		$this->validator = $validator;
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

	protected function save($album, $input = array(), $type = 'create')
	{
		$beforeEvent = ($type === 'create' ? 'creating' : 'updating');
		$afterEvent = ($type === 'create' ? 'created' : 'updated');

		$data = [
			'name' => $input['name']
		];

		$album->fill($data);
		$this->fireEvent($beforeEvent, [$album, $input]);
		$this->fireEvent('saving', [$album, $input]);

		$pictures = isset($input['pictures']) ? explode(',', $input['pictures']) : [];


		DB::transaction(function () use ($album, $pictures) {
			$album->save();
			$album->pictures()->sync($pictures);
			$album->save();
		});

		$this->fireEvent($afterEvent, [$album, $input]);
		$this->fireEvent('saved', [$album, $input]);

		return true;
	}

	/**
	 * @param $event
	 * @param $params
	 */
	protected function fireEvent($event, $params)
	{
		Event::fire('uppy.albums: ' . $event, $params);
	}

	/**
	 * @param $input
	 * @throws ValidationException
	 */
	public function store($input)
	{
		$picture = $this->model;

		$validator = $this->validator->on('create')->with($input);
		if ($validator->fails()) {
			throw new ValidationException($validator->errors());
		}
		$this->save($picture, $input, 'update');
	}
}