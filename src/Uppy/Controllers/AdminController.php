<?php
namespace Hostbrute\Uppy\Controllers;


abstract class AdminController extends AbstractController
{

	/**
	 * @param null $where
	 * @param null $identification
	 * @return string
	 * @throws InvalidArgumentException
	 */
	protected function getLink($where = null, $identification = null)
	{
		if (in_array($where, ['index', 'edit'])) {
			switch ($where) {
				case 'index':
					return route('admin.' . $this->getPackage() . '.index');
					break;
				case 'edit':
					if (!isset($identification)) {
						throw new InvalidArgumentException('Id should be set when $where is edit');
					}
					return route('admin.' . $this->getPackage() . '.index', [$identification]);
					break;
				default:
					return resources($this->getResource());
					break;
			}
		} else {
			return resources($this->getResource());
		}
	}
}
