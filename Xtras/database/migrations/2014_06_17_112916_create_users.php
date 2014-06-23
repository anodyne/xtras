<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('anodyneUsers')->create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('email');
			$table->string('password');
			$table->string('slug');
			$table->text('url')->nullable();
			$table->string('avatar')->nullable();
			$table->string('remember_token')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::connection('anodyneUsers')->create('roles', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('name')->unique();
			$table->timestamps();
		});

		Schema::connection('anodyneUsers')->create('assigned_roles', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('role_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users'); // assumes a users table
			$table->foreign('role_id')->references('id')->on('roles');
		});

		Schema::connection('anodyneUsers')->create('permissions', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('display_name');
			$table->timestamps();
		});

		Schema::connection('anodyneUsers')->create('permission_role', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('permission_id')->unsigned();
			$table->integer('role_id')->unsigned();
			$table->foreign('permission_id')->references('id')->on('permissions'); // assumes a users table
			$table->foreign('role_id')->references('id')->on('roles');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection('anodyneUsers')->table('assigned_roles', function(Blueprint $table)
		{
			$table->dropForeign('assigned_roles_user_id_foreign');
			$table->dropForeign('assigned_roles_role_id_foreign');
		});

		Schema::connection('anodyneUsers')->table('permission_role', function(Blueprint $table)
		{
			$table->dropForeign('permission_role_permission_id_foreign');
			$table->dropForeign('permission_role_role_id_foreign');
		});

		Schema::connection('anodyneUsers')->dropIfExists('assigned_roles');
		Schema::connection('anodyneUsers')->dropIfExists('permission_role');
		Schema::connection('anodyneUsers')->dropIfExists('roles');
		Schema::connection('anodyneUsers')->dropIfExists('permissions');
		Schema::connection('anodyneUsers')->dropIfExists('users');
	}

}
