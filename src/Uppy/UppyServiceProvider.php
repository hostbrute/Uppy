<?php namespace Hostbrute\Uppy;

use Illuminate\Support\ServiceProvider;

class UppyServiceProvider extends ServiceProvider
{
	/**
	 * Register service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('uppy.repositories.album', 'Hostbrute\Media\Repositories\AlbumRepository');


	}

	/**
	 * Boot the service provider
	 *
	 * @return void
	 */
	public function boot()
	{
		$path = realpath(__DIR__ . '/../');
		$this->app->register('Codesleeve\LaravelStapler\LaravelStaplerServiceProvider');

		$this->package('hostbrute/uppy', 'hostbrute/uppy', $path);

		//include "{$path}/start/global.php";
		include "{$path}/start/events.php";
		include "{$path}/filters.php";
		include "{$path}/routes.php";
	}
}
