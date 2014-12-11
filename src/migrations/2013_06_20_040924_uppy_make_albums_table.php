<?php

use Hostbrute\Pages\Model\Content;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UppyMakeAlbumsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('uppy_albums')) {
			Schema::create('uppy_albums', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name');
				$table->string('description');
			});
		}
		if (!Schema::hasTable('uppy_album_pictures')) {
			Schema::create('uppy_album_pictures', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('album_id');
				$table->integer('picture_id');

				$table->unique(['album_id', 'picture_id']);
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('uppy_albums');
		Schema::drop('uppy_album_pictures');
	}
}
