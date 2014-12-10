<?php namespace Hostbrute\Uppy\Controllers;

use Hostbrute\Uppy\Presenters\AlbumPresenter;
use Hostbrute\Uppy\Repositories\AlbumRepository;
use Illuminate\Support\Facades\Input;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Site;


class AlbumController extends AdminController
{
	public $package			= 'uppy.albums';


	public function __construct(AlbumPresenter $presenter, AlbumRepository $repository)
	{
		parent::__construct();
		$this->repository	= $repository;
		$this->presenter	= $presenter;
	}

	/**
	 * Create page for page
	 *
	 * @return mixed|\Orchestra\Support\Traits\Response
	 */
	public function create()
	{
		return $this->presenter->edit($this->repository->newModel());
	}
	public function store()
	{
		$this->repository->store(Input::all());
		return $this->redirectWithMessage($this->getLink('index') , 'Stored.');
	}
	/**
	 * index
	 *
	 * @return mixed
	 */
	public function index()
	{
		Site::set('header::add-button', true);

		$this->setTitle('View Albums');
		return  $this->presenter->index($this->repository->paginated(10), \Input::all());
	}
	public function delete($id)
	{
		$model  = $this->repository->findOrFail($id);
		$model->delete();
		return $this->redirectWithMessage($this->getLink('index') , 'Deleted.');
	}
	public function edit($id)
	{
		//fetch pageModel associated
		$model = $this->repository->findOrFail($id);

		//if there is some info available

		$this->setTitle('Edit album');
		return $this->presenter->edit($model);
	}
	public function update($id = null)
	{
		$this->repository->update($id, Input::all());

		return $this->redirectWithMessage($this->getLink('index'), 'Update successful');
	}

}
