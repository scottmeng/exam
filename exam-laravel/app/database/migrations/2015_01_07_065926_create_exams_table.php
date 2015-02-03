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
			$table->text('description')->nullable();
			$table->integer('examstate_id')->unsigned()->default(1);
			$table->integer('duration_in_min')->default(60);
			$table->integer('full_marks')->default(100);
			$table->integer('total_qn')->default(0);
			$table->dateTime('start_time')->nullable();
			$table->foreign('course_id')->references('id')->on('courses');
			$table->foreign('examstate_id')->references('id')->on('examstates');
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
		Schema::drop('exams');
	}

}
