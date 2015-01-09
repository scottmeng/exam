<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('exams', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('course_id')->unsigned();
			$table->integer('examstate_id')->unsigned();
			$table->string('description')->nullable();
			$table->integer('duration_in_min');
			$table->integer('full_marks');
			$table->integer('total_qn');
			$table->dateTime('start_time');
			$table->timestamps();
		});

		Schema::table('exams', function(Blueprint $table)
		{
			$table->foreign('course_id')->references('id')->on('courses');
			$table->foreign('examstate_id')->references('id')->on('examstates');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('exams');
	}

}
