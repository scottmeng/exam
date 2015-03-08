<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelectedOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('selected_options', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('option_id')->unsigned();
			$table->foreign('option_id')->references('id')->on('options');
			$table->integer('qnsubmission_id')->unsigned();
			$table->foreign('qnsubmission_id')->references('id')->on('questionsubmissions');
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
		Schema::drop('selected_options');
	}

}
