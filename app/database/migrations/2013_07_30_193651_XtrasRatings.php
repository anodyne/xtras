<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class XtrasRatings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ratings', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('item_id')->unsigned();
			$table->bigInteger('download_id')->unsigned();
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
		Schema::drop('ratings');
	}

}
