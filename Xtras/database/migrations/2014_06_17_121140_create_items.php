<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItems extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('items', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('user_id')->unsigned();
			$table->integer('type_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->string('name');
			$table->string('slug')->nullable();
			$table->text('desc')->nullable();
			$table->string('support')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('items_messages', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('item_id')->unsigned();
			$table->string('type')->default('info');
			$table->text('content');
			$table->datetime('expires')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('items_meta', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('item_id');
			$table->text('installation')->nullable();
			$table->string('image1')->nullable();
			$table->string('image2')->nullable();
			$table->string('image3')->nullable();
			$table->string('file')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('items_ratings', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('user_id');
			$table->bigInteger('item_id');
			$table->integer('rating');
		});

		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->text('desc');
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('comments', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('user_id');
			$table->bigInteger('item_id');
			$table->text('content');
			$table->timestamps();
		});

		Schema::create('orders', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('user_id');
			$table->bigInteger('item_id');
			$table->boolean('notify')->default((int) true);
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
		Schema::drop('items');
		Schema::drop('types');
		Schema::drop('products');
		Schema::drop('items_messages');
		Schema::drop('items_ratings');
		Schema::drop('items_meta');
		Schema::drop('comments');
		Schema::drop('orders');
	}

}