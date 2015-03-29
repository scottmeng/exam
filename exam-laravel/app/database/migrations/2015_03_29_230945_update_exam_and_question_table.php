<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateExamAndQuestionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('exams', function(Blueprint $table)
		{
			$table->integer('grace_period')->default(15);
		});
		//add language type to questions table
		//temporarily stored as string
		//static table may be created in the future when more languages are supported
		Schema::table('questions', function(Blueprint $table)
		{
			$table->integer('language');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('exams', function(Blueprint $table)
		{
    		$table->dropColumn('grace_period');
		});
		Schema::table('questions', function(Blueprint $table)
		{
			$table->dropColumn('language');
		});
	}

}
