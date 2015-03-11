<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatQuestionsubmissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questionsubmissions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('answer')->nullable();
			$table->integer('question_id')->unsigned();
			$table->foreign('question_id')->references('id')->on('questions');
			$table->integer('examsubmission_id')->unsigned();
			$table->foreign('examsubmission_id')->references('id')->on('examsubmissions');
			$table->integer('marks_obtained')->nullable();
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
		Schema::table('questionsubmissions', function(Blueprint $table)
		{
			Schema::drop('questionsubmissions');
		});
	}

}
