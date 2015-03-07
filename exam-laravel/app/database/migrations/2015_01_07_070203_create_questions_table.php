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
			$table->integer('index');
			$table->integer('subindex')->nullable()->default(0);
			$table->integer('questiontype_id')->unsigned();
			$table->integer('exam_id')->unsigned();
			$table->string('title')->nullable();
			$table->text('content')->nullable();
			$table->boolean('coding_qn')->default(0);
			$table->boolean('compiler_enable')->default(0);
			$table->boolean('randomizeOptions')->default(0);
			$table->string('marking_scheme')->nullable();
			$table->integer('full_marks')->default(0);
			$table->timestamps();
		});

		Schema::table('questions', function(Blueprint $table)
		{
			$table->foreign('exam_id')->references('id')->on('exams');
			$table->foreign('questiontype_id')->references('id')->on('questiontypes');
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
