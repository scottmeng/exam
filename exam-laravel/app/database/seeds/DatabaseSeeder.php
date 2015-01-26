<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('CodeCrunchSeeder');
	}

}

class CodeCrunchSeeder extends Seeder {

        public function run()
	{
                DB::statement('SET FOREIGN_KEY_CHECKS = 0'); 
                DB::table('options')->truncate();
                DB::table('enrolusers')->truncate();
                DB::table('exams')->truncate();
                DB::table('examstates')->truncate();
                DB::table('questions')->truncate();
                DB::table('questiontypes')->truncate();
                DB::table('courses')->truncate();
                DB::table('facilitators')->truncate();
                DB::table('students')->truncate();
                DB::statement('SET FOREIGN_KEY_CHECKS = 0'); 


                //seed users table
                $initUser1 = Facilitator::create(array(
                	'name' => 'Richard',
                        'nus_id' => 'U0001234',
                	'comment' => 'test facilitator'
                ));

                $initUser2 = Facilitator::create(array(
                        'name' => 'Molly',
                        'nus_id' => 'U7654321',
                        'comment' => 'test facilitator'
                ));

                $initUser3 = Student::create(array(
                	'name' => 'Livia',
                        'nus_id' => 'A0101111',
                	'comment' => 'test student'
                ));


                $initUser4 = Student::create(array(
                        'name' => 'Scott',
                        'nus_id' => 'A0008888',
                        'comment' => 'test student'
                ));

                $initUser5 = Student::create(array(
                        'name' => 'Du Lingyi',
                        'nus_id' => 'A0091628',
                        'comment' => 'test student'
                ));

                //seed courses table

                $initCourse1 = Course::create(array(
                	'nus_id' => 'CS1000',
                	'name' => 'Your First Programming Course',
                	'description' => 'test course'
                ));

                $initCourse2 = Course::create(array(
                	'nus_id' => 'CS1010',
                	'name' => 'Your Second Programming Course',
                	'description' => 'test course'
                ));

                $initCourse3 = Course::create(array(
                        'nus_id' => 'CS1010J',
                        'name' => 'Programming Methodology',
                        'description' => 'test course'
                ));

                //seed question type table
                $initType1 = Questiontype::create(array(
                        'name' => 'MCQ',
                        'description' => 'Multiple Choice Questions'
                ));

                $initType2 = Questiontype::create(array(
                        'name' => 'short question',
                        'description' => 'short answer questions, can be coding or non-coding'
                ));

                $initState1 = ExamState::create(array(
                        'name' => 'draft',
                        'description' => 'draft state' 
                ));

                $initState1 = ExamState::create(array(
                        'name' => 'active',
                        'description' => 'active state' 
                ));

                //seed relations
                $initUser1->courses()->save($initCourse1);
                $initUser2->courses()->save($initCourse2);
                $initUser3->courses()->save($initCourse1);
                $initUser3->courses()->save($initCourse2);
                $initUser5->courses()->save($initCourse2);

	}

}
