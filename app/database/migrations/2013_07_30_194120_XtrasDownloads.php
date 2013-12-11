<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class XtrasDownloads extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('downloads', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('item_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->integer('url');
			$table->string('version');
			$table->boolean('has_known_issues')->default((int) false);
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
		Schema::drop('downloads');
	}

}
