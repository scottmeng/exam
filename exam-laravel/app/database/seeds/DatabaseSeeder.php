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
                DB::table('questions')->truncate();
                DB::table('courses')->truncate();
                DB::table('facilitators')->truncate();
                DB::table('students')->truncate();
                DB::statement('SET FOREIGN_KEY_CHECKS = 0'); 


                //seed users table
                $initUser1 = Facilitator::create(array(
                	'name' => 'Lingyi',
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


                $initUser3 = Student::create(array(
                        'name' => 'Scott',
                        'nus_id' => 'A0008888',
                        'comment' => 'test student'
                ));

                //seed courses table

                $initCourse1 = Course::create(array(
                	'nus_id' => 'CS1000',
                	'name' => 'Your First Programming Course',
                	'description' => 'test course',
                	'admin' => $initUser1->id
                ));

                $initCourse2 = Course::create(array(
                	'nus_id' => 'CS1010',
                	'name' => 'Your Second Programming Course',
                	'description' => 'test course',
                	'admin' => $initUser1->id
                ));

                //seed relations
                $initUser1->courses()->save($initCourse1);
                $initUser2->courses()->save($initCourse2);
                $initUser3->courses()->save($initCourse1);
                $initUser3->courses()->save($initCourse2);

	}

}
