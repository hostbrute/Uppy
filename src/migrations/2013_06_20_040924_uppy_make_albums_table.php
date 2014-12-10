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
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('uppy_albums');
	}
}
