<?php namespace Hostbrute\Uppy\Presenters;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\Site;

class AlbumPresenter {

	private $views  =[
		'table'	=> 	'hostbrute/uppy::albums.table',
		'form'	=> 'hostbrute/uppy::albums.form',
		'edit'	=> 'hostbrute/uppy::albums.edit',
		'index'	=> 'hostbrute/uppy::albums.index'
	];

	public function index($albums, $input)
	{
		$data = [
			'table'	=> $this->table($albums,$input)
		];
		return $this->renderView('index', $data);
	}

	/**
	 * @param $album
	 * @return string
	 * @throws \Exception
	 */
	public function edit($album)
	{
		$data = [
			'form' => $this->form($album),
		];
		$this->setTitle('Album Form');
		return $this->renderView('edit', $data);
	}

	/**
	 * @param $albums
	 * @param $input
	 * @throws \Exception
	 * @return mixed
	 */
	public function table($albums, $input)
	{
		$data = [
			'albums'	=> $albums,
			'urls'		=> $this->getUrlClosures()
		];
		return $this->renderView('table', $data);
	}

	/**
	 * @param $album
	 * @throws \Exception
	 * @return mixed
	 */
	protected function form($album)
	{
		$pictures = $this->parsePictures($album->pictures()->get());
		list($url, $method) = $this->getFormAttributes($album);
		$data = [
			'url'		=> $url,
			'method'	=> $method,
			'album'		=> $album,
			'pictures'	=> $pictures
		];
		return $this->renderView('form', $data);
	}
	/**
	 * @param $pictures
	 * @return array
	 */
	private function parsePictures($pictures){
		$temp = [];
		foreach($pictures as $picture)
		{
			$temp[] = ['id' => $picture->id, 'text' => $picture->name];
		}
		return $temp;
	}
	/**
	 * @param $model
	 * @return array
	 */
	protected function getFormAttributes($model){
		if(isset($model->id))
		{
			$url = handles('admin/uppy/albums/' . $model->id);
			$method =  'PUT' ;
		}
		else
		{
			$url = handles('admin/uppy/albums/');
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
		return View::make($this->views[$view],$data)->render();
	}
	protected function setTitle($title)
	{
		Site::set('title', $title);
	}

	/**
	 * @return array
	 */
	private function getUrlClosures()
	{
		$closures = [
			'edit'	=> function($id){
				return handles('admin/uppy/albums/' . $id . '/edit');
			},
			'delete'	=> function($id){
				return handles('admin/uppy/albums/' . $id .  '/delete', ['csrf' => true]);
			}
		];
		return $closures;
	}
}