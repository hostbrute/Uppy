<?php

use Illuminate\Database\Migrations\Migration;
use Orchestra\Memory;
use Orchestra\Model\Role;
use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\App;

class HostbruteUppySeedAcl extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		$admin	= Role::admin();
		$member	= Role::member();
		$acl	= Acl::make('hostbrute/uppy');

		$acl->roles()->attach([$admin->name, $member->name]);

		//set up actions, php 5.4 style baby
		$adminActions = ['Manage Uppy'];

		$acl->actions()->attach($adminActions);

		$acl->allow($admin->name, $adminActions);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		App::memory()->forget('acl_hostbrute/uppy');
	}
}
