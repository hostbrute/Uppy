<?php
use Illuminate\Support\Facades\Event;
use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\App;

/*
|--------------------------------------------------------------------------
| Attach Memory to ACL
|--------------------------------------------------------------------------
*/

Acl::make('hostbrute/uppy')->attach(App::memory());

Event::listen('orchestra.started: admin', function () {
	$acl = \Orchestra\Acl::make('hostbrute/uppy');

	if ($acl->can('manage uppy')) {
		$menu = \Orchestra\App::menu();
		$menu->add('uppy')->icon('<i class="fa fa-comments-o"></i>')->title('Uppy')->link("#");
		$menu->add('albums', '^:uppy')->link(route('admin.uppy.albums.index'))->title('Albums');
		$menu->add('pictures', '^:uppy')->link(route('admin.uppy.pictures.index'))->title('Pictures');
	}
});