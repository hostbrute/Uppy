<?php namespace Hostbrute\Uppy\Validators;
use Orchestra\Support\Validator;


class AlbumValidator extends Validator {
	/**
	 * Validation rules.
	 *
	 * @var array
	 */
	public $rules = array(
		'name'		=> ['required', 'max:255'],
	);

	/**
	 * Validation events
	 *
	 * @var array
	 */
	protected $events = [
		'uppy.albums: validation'
	];

	/**
	 * On create scenario
	 *
	 * @return void
	 */
	protected function onCreate()
	{
		$this->events[] = 'uppy.albums: validation.create';
	}

	/**
	 * On update scenario.
	 *
	 * @return void
	 */
	protected function onUpdate()
	{
		$this->events[] = 'uppy.albums: validation.update';
	}
} 