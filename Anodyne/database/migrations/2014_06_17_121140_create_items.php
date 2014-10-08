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
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->text('desc');
			$table->boolean('display')->default((int) true);
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->boolean('display')->default((int) true);
			$table->timestamps();
			$table->softDeletes();
		});
		
		Schema::create('items', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedBigInteger('user_id');
			$table->unsignedInteger('type_id');
			$table->unsignedInteger('product_id');
			$table->string('name');
			$table->string('version');
			$table->string('slug')->nullable();
			$table->text('desc')->nullable();
			$table->string('support')->nullable();
			$table->float('rating')->default(0);
			$table->boolean('status')->default((int) true);
			$table->boolean('admin_status')->default((int) true);
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('items_files', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedBigInteger('item_id');
			$table->string('filename');
			$table->string('version');
			$table->unsignedBigInteger('size');
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('items_messages', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedBigInteger('item_id');
			$table->string('type')->default('info');
			$table->text('content');
			$table->datetime('expires')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('items_metadata', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedBigInteger('item_id');
			$table->text('installation')->nullable();
			$table->text('history')->nullable();
			$table->string('image1')->nullable();
			$table->string('image2')->nullable();
			$table->string('image3')->nullable();
			$table->string('thumbnail1')->nullable();
			$table->string('thumbnail2')->nullable();
			$table->string('thumbnail3')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('items_ratings', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('item_id');
			$table->integer('rating');
		});

		Schema::create('comments', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('item_id');
			$table->text('content');
			$table->timestamps();
		});

		Schema::create('orders', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('item_id');
			$table->unsignedBigInteger('file_id');
			$table->timestamps();
		});

		Schema::create('notifications', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('item_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('items');
		Schema::dropIfExists('types');
		Schema::dropIfExists('products');
		Schema::dropIfExists('items_files');
		Schema::dropIfExists('items_messages');
		Schema::dropIfExists('items_ratings');
		Schema::dropIfExists('items_metadata');
		Schema::dropIfExists('comments');
		Schema::dropIfExists('orders');
		Schema::dropIfExists('notifications');
	}

}