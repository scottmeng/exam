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
			$table->string('title');
			$table->integer('course_id')->unsigned();
			$table->foreign('course_id')->references('id')->on('courses');
			$table->text('description')->nullable();
			$table->integer('examstate_id')->unsigned()->default(1);
			$table->foreign('examstate_id')->references('id')->on('examstates');
			$table->integer('duration')->default(60);
			$table->integer('fullmarks')->default(100);
			$table->integer('totalqn')->default(0);
			$table->dateTime('starttime')->nullable();
			$table->boolean('randomizeQuestions')->default(0);
			$table->integer('grace_period')->default(15);
			$table->text('general_feedback')->nullable();
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
