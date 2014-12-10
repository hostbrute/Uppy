<?php
use Orchestra\Messages;

Route::when('admin/uppy/*', 'adminExceptions');
Route::filter('adminExceptions', function($route, $request){
	App::register('Hostbrute\Uppy\ExceptionsServiceProvider');
});
Form::macro('select2', function($name, $value, $options){
	$container = Asset::container('orchestra/foundation::footer');
	$container->style('select2-base', 'packages/hostbrute/uppy/vendor/select2/3.5.1/css/select2-bootstrap.css');
	$container->script('select2-base', 'packages/hostbrute/uppy/vendor/select2/3.5.1/js/select2.min.js', array('jquery'));
	$container->script('select2-field', 'packages/hostbrute/uppy/vendor/select2/3.5.1/js/field.js', array('jquery'));

	if(isset($options['sortable']) && $options['sortable'])
	{
		$container->script('jquery-ui-base', 'packages/hostbrute/uppy/vendor/jquery-ui/1.11.1/jquery-ui.min.js', array('jquery'));
		$container->style('jquery-ui-base', 'packages/hostbrute/uppy/vendor/jquery-ui/1.11.1/jquery-ui.css', array('jquery'));
	}

	if(is_array($value))
	{
		$options['data-value'] = json_encode($value);
		$value  = null;
	}
	else
	{
		$options['data-value'] = json_encode([]);
		$value = null;
	}
	$attributes = $options + ['class' => 'select2 form-control'];

	return Form::hidden($name, $value, $attributes);
});