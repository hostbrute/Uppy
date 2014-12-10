<?php namespace Hostbrute\Uppy\Exceptions;


use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;
use Laravel\Messages;


class ValidationException extends \Exception {

	/**
	 * Errors object.
	 *
	 * @var Laravel\Messages
	 */
	private $errors;

	/**
	 * Create a new validate exception instance.
	 *
	 * @param  Validator|Messages|MessageBag $container
	 * @return \Hostbrute\Uppy\Exceptions\ValidationException
	 */
	public function __construct($container)
	{

		if(is_a($container, 'Illuminate\Support\MessageBag'))
		{
			$this->errors = $container;
		}
		elseif(is_a($container, 'Orchestra\Support\Validator') || is_a($container, 'Illuminate\Validation\Validator'))
		{
			$this->errors = $container->errors();
		}
		else
		{
			$this->errors = ($container instanceof Validator) ? $container->errors : $container;
		}
		parent::__construct(null);
	}

	/**
	 * Gets the errors object.
	 *
	 * @return \Laravel\Messages
	 */
	public function get()
	{
		return $this->errors;
	}

}