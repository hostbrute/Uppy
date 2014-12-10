<?php namespace Hostbrute\Uppy\Controllers;

use Hostbrute\Uppy\Presenters\PicturePresenter;
use Hostbrute\Uppy\Repositories\PictureRepository;
use Illuminate\Support\Facades\Input;
use Orchestra\Support\Facades\App;
use Orchestra\Support\Facades\Site;


class PictureController extends AdminController
{
	public $package			= 'uppy.pictures';

	/**
	 * @param PicturePresenter $downloadPresenter
	 * @param PictureRepository $partnerRepository
	 */
	public function __construct(PicturePresenter $downloadPresenter, PictureRepository $partnerRepository)
	{
		parent::__construct();
		$this->repository = $partnerRepository;
		$this->presenter= $downloadPresenter;
	}
	public function ajax()
	{
		$data = $this->repository->searchLike( Input::get('q'));
		$returnData = [];
		foreach($data as $partner)
		{
			$returnData[] = ['id' => $partner->id, 'text' => $partner->name];
		}
		$return = [
			'results' => $returnData
		];
		return json_encode($return);
	}
	/**
	 * Create page for page
	 *
	 * @return mixed|\Orchestra\Support\Traits\Response
	 */
	public function create()
	{
		$form = $this->presenter->edit($this->repository->newModel());
		return $form;
	}
	public function store()
	{
		$this->repository->store(Input::all());
		return $this->redirectWithMessage($this->getLink('index') , 'Stored.');
	}
	public function delete($id)
	{
		$model  = $this->repository->findOrFail($id);
		$model->delete();
		return $this->redirectWithMessage($this->getLink('index') , 'Deleted.');
	}
	/**
	 * index
	 *
	 * @return mixed
	 */
	public function index()
	{

		Site::set('header::add-button', true);
		$this->setTitle('View Pictures');
		return $this->presenter->index($this->repository->paginated(10), \Input::all());

	}
	public function edit($id)
	{
		//fetch pageModel associated
		$model = $this->repository->findOrFail($id);

		$this->setTitle('Edit page');
		return $this->presenter->edit($model);
	}
	public function update($id = null)
	{
		$this->repository->update($id, Input::all());
		return $this->redirectWithMessage($this->getLink('index'), 'Update successful');
	}

}
