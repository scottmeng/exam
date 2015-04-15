<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('questiontype_id')->unsigned();
			$table->foreign('questiontype_id')->references('id')->on('questiontypes');
			$table->integer('course_id')->unsigned();
			$table->foreign('course_id')->references('id')->on('courses');
			$table->string('title')->nullable();
			$table->text('content')->nullable();
			$table->boolean('compiler_enable')->default(0);//not used for now
			$table->string('language')->default('c');
			$table->text('marking_scheme')->nullable();
			$table->integer('full_marks')->default(0);
			$table->text('suggested_answer')->nullable();
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
		Schema::drop('questions');
	}

}
