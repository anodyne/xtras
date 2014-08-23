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
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('type_id')->references('id')->on('types');
			$table->foreign('product_id')->references('id')->on('products');
		});

		Schema::create('items_files', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedBigInteger('item_id');
			$table->string('filename');
			$table->string('version');
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('item_id')->references('id')->on('items');
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

			$table->foreign('item_id')->references('id')->on('items');
		});

		Schema::create('items_meta', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedBigInteger('item_id');
			$table->text('installation')->nullable();
			$table->text('history')->nullable();
			$table->string('image1')->nullable();
			$table->string('image2')->nullable();
			$table->string('image3')->nullable();
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('item_id')->references('id')->on('items');
		});

		Schema::create('items_ratings', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('item_id');
			$table->integer('rating');

			$table->foreign('item_id')->references('id')->on('items');
		});

		Schema::create('comments', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('item_id');
			$table->text('content');
			$table->timestamps();

			$table->foreign('item_id')->references('id')->on('items');
		});

		Schema::create('orders', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('item_id');
			$table->unsignedBigInteger('file_id');
			$table->boolean('notify')->default((int) true);
			$table->timestamps();

			$table->foreign('item_id')->references('id')->on('items');
			$table->foreign('file_id')->references('id')->on('items_files');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('items', function(Blueprint $table)
		{
			$table->dropForeign('items_type_id_foreign');
			$table->dropForeign('items_product_id_foreign');
		});

		Schema::table('items_files', function(Blueprint $table)
		{
			$table->dropForeign('items_files_item_id_foreign');
		});

		Schema::table('items_messages', function(Blueprint $table)
		{
			$table->dropForeign('items_messages_item_id_foreign');
		});

		Schema::table('items_meta', function(Blueprint $table)
		{
			$table->dropForeign('items_meta_item_id_foreign');
		});

		Schema::table('items_ratings', function(Blueprint $table)
		{
			$table->dropForeign('items_ratings_item_id_foreign');
		});

		Schema::table('comments', function(Blueprint $table)
		{
			$table->dropForeign('comments_item_id_foreign');
		});

		Schema::table('orders', function(Blueprint $table)
		{
			$table->dropForeign('orders_item_id_foreign');
			$table->dropForeign('orders_file_id_foreign');
		});
		
		Schema::dropIfExists('items');
		Schema::dropIfExists('types');
		Schema::dropIfExists('products');
		Schema::dropIfExists('items_files');
		Schema::dropIfExists('items_messages');
		Schema::dropIfExists('items_ratings');
		Schema::dropIfExists('items_meta');
		Schema::dropIfExists('comments');
		Schema::dropIfExists('orders');
	}

}