<?php namespace Hostbrute\Uppy\Presenters;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\Site;

class PicturePresenter {

	private $views  =[
		'table'	=> 	'hostbrute/uppy::pictures.table',
		'form'	=> 'hostbrute/uppy::pictures.form',
		'edit'	=> 'hostbrute/uppy::pictures.edit',
		'index'	=> 'hostbrute/uppy::pictures.index'
	];

	public function index($pictures, $input)
	{
		$data = [
			'table'	=> $this->table($pictures, $input)
		];
		$this->setTitle('List of pictures');
		return $this->renderView('index', $data);
	}

	/**
	 * @param $picture
	 * @return string
	 * @throws \Exception
	 */
	public function edit($picture)
	{
		$data = [
			'form' => $this->form($picture),
		];
		return $this->renderView('edit', $data);
	}

	/**
	 * @param $pictures
	 * @param $input
	 * @throws \Exception
	 * @internal param $contents
	 * @return mixed
	 */
	protected function table($pictures, $input)
	{
		$data = [
			'pictures'	=> $pictures,
			'urls'		=> $this->getUrlClosures()
		];
		return $this->renderView('table', $data);
	}

	/**
	 * @param $picture
	 * @throws \Exception
	 * @internal param $album
	 * @return mixed
	 */
	private function form($picture)
	{
		list($url, $method) = $this->getFormAttributes($picture);
		$data = [
			'url'		=> $url,
			'method'	=> $method,
			'picture'	=> $picture,
		];
		return $this->renderView('form', $data);
	}
	/**
	 * @param $model
	 * @return array
	 */
	protected function getFormAttributes($model){
		if(isset($model->id))
		{
			$url = handles('admin/uppy/pictures/' . $model->id);
			$method =  'PUT' ;
		}
		else
		{
			$url = handles('admin/uppy/pictures/');
			$method =  'POST' ;
		}
		return [$url, $method];
	}

	/**
	 * @param $view
	 * @param $data
	 * @throws \Exception
	 * @return string
	 */
	protected function renderView($view, $data)
	{
		if(!array_key_exists($view, $this->views))
		{
			throw new \Exception($view  .'  is not in the allowed view array');
		}
		return \View::make($this->views[$view],$data)->render();
	}

	protected function setTitle($title)
	{
		\Orchestra\Site::set('title', $title);
	}

	/**
	 * @return array
	 */
	private function getUrlClosures()
	{
		$closures = [
			'edit'	=> function($id){
				return handles('admin/uppy/pictures/' . $id . '/edit');
			},
			'delete'	=> function($id){
				return handles('admin/uppy/pictures/' . $id .  '/delete', ['csrf' => true]);
			}
		];
		return $closures;
	}
}