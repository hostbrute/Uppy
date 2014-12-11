<?php namespace Hostbrute\Uppy;

use App;
use Hostbrute\Uppy\Exceptions\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\ServiceProvider;
use Log;
use Orchestra\Messages;
use Orchestra\Site;
use Redirect;
use Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use URL;
use View;

class ExceptionsServiceProvider extends ServiceProvider
{

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		/**
		 * ValidationException handler
		 *
		 * This catches ValidationException and Logs it, then returns the users back
		 *
		 */
		App::error(function (ValidationException $e, $code, $fromConsole) {
			Log::error('ValidationException - ' . $e->getMessage());
			return Redirect::back()->withInput()->withErrors($e->get());
		});
		App::error(function (QueryException $e, $code, $fromConsole) {
			Log::error('QueryException - ' . $e->getMessage());
			return $this->showError(3, $e);
		});
		/**
		 * TokenMismatchException handler
		 *
		 * Handle CSRF mismatches
		 */
		App::error(function (TokenMismatchException $e, $code, $fromConsole) {
			Log::error('TokenMismatchException: ip: ' . Request::ip());
			Site::set('title', 'Oops!');
			return $this->showError(2, $e);
		});

		/**
		 * ModelNotFoundException handler
		 *
		 * What happens if a specific model cant be found.
		 */
		App::error(function (ModelNotFoundException $e, $code, $fromConsole) {
			Messages::add('error', 'That Id is invalid');
			if (URL::previous() !== URL::to('')) {
				return Redirect::back();
			} else {
				return Redirect::to('admin');
			}

		});
	}


	/**
	 * @param $code
	 * @param $exception
	 * @return \Illuminate\View\View
	 */
	private function showError($code, $exception)
	{
		$debug = $this->app['config']->get('app.debug');
		return $exception;
	}

	private function log($message)
	{
		Log::error($message . ' ip: ' . Request::ip());
	}
}