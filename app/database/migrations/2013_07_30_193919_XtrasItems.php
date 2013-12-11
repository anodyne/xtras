<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class XtrasItems extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('xtras', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('user_id')->unsigned();
			$table->integer('type_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->string('name');
			$table->text('desc')->nullable();
			$table->string('slug')->unique();
			$table->string('support')->nullable();
			$table->string('status_message')->nullable();
			$table->timestamps();
		});

		Schema::create('xtras_compatibility', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('xtras_id')->unsigned();
			$table->integer('product_id')->unsigned();
		});

		Schema::create('xtras_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
		});

		Schema::create('xtras_versions', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('xtras_id');
			$table->string('version');
			$table->text('download_url')->nullable();
			$table->text('external_download_url')->nullable();
			$table->text('instructions')->nullable();
			$table->text('changelog')->nullable();
			$table->text('preview_image')->nullable();
			$table->text('compatibility');
			$table->boolean('has_known_issues')->default((int) false);
			$table->timestamps();
		});

		Schema::create('comments', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('user_id')->unsigned();
			$table->bigInteger('xtras_id')->unsigned();
			$table->text('content');
			$table->timestamps();
		});

		Schema::create('ratings', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('xtras_id')->unsigned();
			$table->bigInteger('version_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('rating');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('xtras');
		Schema::drop('xtras_compatibility');
		Schema::drop('xtras_types');
		Schema::drop('xtras_versions');
		Schema::drop('comments');
		Schema::drop('ratings');
	}

}
