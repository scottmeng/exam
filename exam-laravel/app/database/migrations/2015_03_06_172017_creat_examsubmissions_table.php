<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatExamsubmissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('examsubmissions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('exam_id')->unsigned();
			$table->foreign('exam_id')->references('id')->on('exams');
			$table->integer('grader_id')->unsigned()->nullable();
			$table->foreign('grader_id')->references('id')->on('users');
			$table->integer('total_marks')->default(0);
			$table->integer('submissionstate_id')->unsigned()->default(1);
			$table->foreign('submissionstate_id')->references('id')->on('submissionstates');
			$table->text('comment')->nullable();
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
		Schema::table('examsubmissions', function(Blueprint $table)
		{
			Schema::drop('examsubmissions');
		});
	}

}
