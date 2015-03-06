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
		Schema::table('questionsubmissions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('answer')->nullable();
			$table->integer('question_id')->unsigned();
			$table->foreign('question_id')->references('id')->on('questions');
			$table->integer('examsubmission_id')->unsigned();
			$table->foreign('examsubmission_id')->references('id')->on('examsubmissions');
			$table->integer('choice')->unsigned()->nullable();
			$table->integer('choice')->references('id')->on('options');
			$table->integer('marks_obtained')->default(0);
			$table->string('comment')->nullable();
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
