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
                DB::table('course_user')->truncate();
                DB::table('exams')->truncate();
                DB::table('examstates')->truncate();
                DB::table('questions')->truncate();
                DB::table('questiontypes')->truncate();
                DB::table('courses')->truncate();
                DB::table('roles')->truncate();
                DB::table('users')->truncate();
                DB::table('examsubmissions')->truncate();
                DB::table('questionsubmissions')->truncate();
                DB::table('submissionstates')->truncate();
                DB::statement('SET FOREIGN_KEY_CHECKS = 1'); 


                //seed users table
                $initUser1 = User::create(array(
                	'name' => 'Lingyi',
                        'nus_id' => 'A0091628',
                ));

                $initUser2 = User::create(array(
                        'name' => 'Lingyi',
                        'nus_id' => 'A000',
                ));

                $initUser3 = User::create(array(
                        'name' => 'Lingyi',
                        'nus_id' => 'A123',
                ));

                $initUser4 = User::create(array(
                        'name' => 'Admin',
                        'nus_id' => 'admin',
                ));

                //seed courses table

                $initCourse1 = Course::create(array(
                        'nus_id' => 'CS1010J',
                        'name' => 'Programming Methodology',
                        'description' => 'Welcome to your first programming course!
                        Here you will learn algorithms, languages and other essential programming skills.
                        Plese take note of the following important dates: 
                        Assignment 1 due: March 3rd;
                        Final Exam: May 2nd(pm)'
                ));

                //seed question type table
                $initType1 = Questiontype::create(array(
                        'name' => 'MCQ',
                        'description' => 'Multiple Choice Questions'
                ));

                $initType3 = QuestionType::create(array(
                        'name' => 'MRQ',
                        'description' => 'Multiple Response Questions'
                ));

                $initType2 = Questiontype::create(array(
                        'name' => 'Short Answer Question',
                        'description' => 'short answer questions, can be coding or non-coding'
                ));

                $initType4 = QuestionType::create(array(
                        'name' => 'Coding Question',
                        'description' => 'Requires coding in student responses'
                ));

                $initExamState1 = ExamState::create(array(
                        'name' => 'draft',
                        'description' => 'draft state' 
                ));

                $initExamState2 = ExamState::create(array(
                        'name' => 'active',
                        'description' => 'active state' 
                ));

                $initExamState3 = ExamState::create(array(
                        'name' => 'published',
                        'description' => 'grading finished, published to students'
                ));

                $initExamState4 = ExamState::create(array(
                        'name' => 'expired',
                        'description' => 'archived, no longer accessible'
                ));

                $initSubmissionState1 = SubmissionState::create(array(
                        'name' => 'submitted',
                        'description' => 'grading not started'
                ));

                $initSubmissionState2 = SubmissionState::create(array(
                        'name' => 'grading',
                        'description' => 'grading in progress'
                ));


                $initSubmissionState3 = SubmissionState::create(array(
                        'name' => 'graded',
                        'description' => 'grading finished'
                ));

                $initRole1 = Role::create(array(
                        'name'=>'admin',
                        'description'=>'administrator of the course'
                ));


                $initRole2 = Role::create(array(
                        'name'=>'facilitator',
                        'description'=>'facilitator of the course'
                ));


                $initRole3 = Role::create(array(
                        'name'=>'student',
                        'description'=>'student of the course'
                ));

                //seed relations
                $initUser1->courses()->save($initCourse1,array('role_id'=>$initRole1->id));
                $initUser2->courses()->save($initCourse1,array('role_id'=>$initRole2->id));
                $initUser3->courses()->save($initCourse1,array('role_id'=>$initRole3->id));
                $initUser4->courses()->save($initCourse1,array('role_id'=>$initRole1->id));

	}

}
