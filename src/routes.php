<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Orchestra\Support\Facades\Resources;

/**
 * ajax routing
 */
Route::group(['namespace' => 'Hostbrute\Uppy\Controllers', 'before' => 'orchestra.auth'], function(){
	Route::post('admin/ajax/picture-select', ['as' => 'picture-select', 'uses' => 'PictureController@ajax']);
});
Route::group(\Orchestra\App::group('orchestra/uppy', 'admin'), function () {

	// Route to account/profile.
	Route::group(['prefix' => 'uppy'], function(){
		Route::resource('albums', 'Hostbrute\Uppy\Controllers\AlbumController', ['except' => 'show']);
		Route::get('albums/{id}/delete', ['uses' => 'Hostbrute\Uppy\Controllers\AlbumController@delete', 'as' => 'admin.uppy.albums.delete']);
		Route::resource('pictures', 'Hostbrute\Uppy\Controllers\PictureController', ['except' => 'show']);
		Route::get('pictures/{id}/delete', ['uses' => 'Hostbrute\Uppy\Controllers\PictureController@delete', 'as' => 'admin.uppy.pictures.delete']);
	});
});

