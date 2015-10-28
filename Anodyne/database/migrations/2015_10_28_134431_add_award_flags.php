<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAwardFlags extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('items', function(Blueprint $table)
		{
			$table->boolean('award_creativity')->default((int) false);
			$table->boolean('award_presentation')->default((int) false);
			$table->boolean('award_technical')->default((int) false);
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
			$table->dropColumn(['award_creativity', 'award_presentation', 'award_technical']);
		});
	}

}
