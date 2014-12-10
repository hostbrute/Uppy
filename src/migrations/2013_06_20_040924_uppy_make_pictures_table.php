<?php

use Hostbrute\Pages\Model\Content;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UppyMakePicturesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('uppy_pictures')) {
			Schema::create('uppy_pictures', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name');
				$table->string('link')->nullable();
				$table->tinyInteger('order')->nullable();
				$table->string('file_file_name')->nullable();
				$table->integer('file_file_size')->nullable();
				$table->string('file_content_type')->nullable();
				$table->timestamp('file_updated_at')->nullable();
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
		Schema::drop('uppy_pictures');
	}
}
