<?php namespace Hostbrute\Uppy\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Orchestra\Foundation\Routing\AdminController;
use Orchestra\Support\Facades\Site;
use Orchestra\Support\Traits\ControllerResponseTrait;
use Redirect;

abstract class AbstractController extends AdminController {
	use ControllerResponseTrait;

	/**
	 * Current Resource.
	 *
	 * @var string
	 */
	protected $resource;

	/**
	 * Validation instance.
	 *
	 * @var object
	 */
	protected $validator;

	/**
	 * @var object
	 */
	protected $presenter;

	/**
	 * views prefix
	 * by default we get from views/backend/$plural/$view
	 *
	 * @var string
	 */
	public $prefix = 'backend';

	/**
	 * Setup content format type.
	 *
	 * @return void
	 */
	protected function setupFormat()
	{
	}

	protected function setupFilters()
	{
		$this->beforeFilter('orchestra.csrf', ['only' => ['update', 'store']]);
		$this->beforeFilter(function () {
			if (Auth::guest()) {
				return Redirect::to(handles('orchestra::/'));
			}
		});
	}
	/**
	 * Used for all official references, double check if this is correctly set!
	 *
	 * @return mixed
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * get plural of the subject
	 *
	 * @return mixed
	 */
	public function getPlural()
	{
		return $this->trans("subject.{$this->getType()}.subject");
	}

	/**
	 * @param $error
	 * @return $this|AbstractController|\Illuminate\Http\RedirectResponse|mixed
	 */
	public function handle($error)
	{
		return $this->showError($error);
	}
	/**
	 * get subject language key
	 *
	 * @param bool $plural
	 * @return mixed
	 */
	public function getSubject($plural = false)
	{
		$subjectString = ($plural ? 'plural' : 'singular');
		return $this->trans("subject.{$this->type}.{$subjectString}");
	}

	/**
	 * Redirect back with errors
	 *
	 * @param $errors
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function redirectBack($errors = null)
	{
		if(isset($errors))
		{
			return Redirect::back()->withErrors($errors)->withInput();
		}
		else
		{
			return Redirect::back()->withErrors($errors);
		}
	}

	/**
	 * @return mixed
	 * @throws \Exception
	 */
	protected function getPackage()
	{
		if(!isset($this->package))
		{
			throw new \Exception('package not defined for this controller');
		}
		return $this->package;
	}
	/**
	 * Show a general failed page
	 *
	 * @param $data
	 * @return \Orchestra\Support\Traits\Response
	 */
	public function failed($data)
	{
		return $this->redirectWithMessage($this->getLink('index'), 'Something went wrong but we don\'t know what');
	}
	/**
	 * Set title
	 *
	 * @param $title
	 * @param null $data
	 */
	public function setTitle($title, $data = null)
	{
		if(isset($data) && $data !== null)
		{
			Site::set('title', $this->trans($title, ['subject' => $data ]));
		}
		else
		{
			Site::set('title', $title);
		}
	}
	/**
	 * show error
	 *
	 * @param $error
	 * @return mixed
	 */
	public function showError($error)
	{
		return View::make('hostbrute/base::common.error', ['error' => $this->parseError($error) ]);
	}

	/**
	 * translate a line for this package
	 *
	 * @param $line
	 * @param array $data
	 * @return mixed
	 */
	public function trans($line, array $data = array())
	{
		return Lang::get($this->getPackage() . '::' . $line, $data);
	}

	/**
	 * Generate a view
	 *
	 * @param $view
	 * @param array $data
	 * @throws \Exception
	 * @return mixed
	 */
	public function view($view, $data = [])
	{
		if(in_array($view, ['index', 'editor']))
		{
			return View::make($this->getPackage() . '::' . $this->prefix . '.'. $this->plural . '.' . $view, $data);
		}
		else
		{
			return View::make($this->getPackage() . '::' . $view, $data);
		}
	}

	/**
	 * Handle any missing methods
	 *
	 * @param string $method
	 * @param array $parameters
	 * @return mixed|void
	 * @throws \BadMethodCallException
	 */
	public function __call($method, $parameters =[])
	{
		return Response::view('orchestra/foundation::dashboard.missing', $parameters, 404);
	}

	/**
	 * @param $type
	 * @param null $id
	 * @return mixed
	 */
	protected abstract function getLink($type, $id = null);
}
