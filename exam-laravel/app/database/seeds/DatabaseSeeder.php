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
                        'name' => 'Admin Lingyi',
                        'nus_id' => 'admin',
                ));

                $initUser2 = User::create(array(
                        'name' => 'TA Lingyi',
                        'nus_id' => 'A000',
                ));

                $initUser3 = User::create(array(
                        'name' => 'Student Lingyi',
                        'nus_id' => 'A123',
                ));

                $initUser4 = User::create(array(
                         'name' => 'Lecturer Lingyi',
                        'nus_id' => 'A321',                       
                ));

                //seed courses table

                $initCourse1 = Course::create(array(
                        'nus_id' => 'CS1010J',
                        'name' => 'Programming Methodology',
                        'description' => '<b>Welcome to your first programming course!</b><br><br>
                        Here you will learn algorithms, languages and other essential programming skills.<br><br>
                        Plese take note of the following important dates: 
                        <li><mark><small>Assignment 1 due: March 3rd;</small></mark></li>
                        <li><mark><small>Final Exam: May 2nd(pm)</small></mark></li>'
                ));

                $initCourse2 = Course::create(array(
                        'nus_id' => 'CS2010',
                        'name' => 'Algorithms and Data Structure',
                        'description' => '<h3>Welcome!</h3><br>
                        Please be prepared for a lot of learnings and assignments too!' 
                ));

                //seed question type table
                $initType1 = Questiontype::create(array(
                        'name' => 'MCQ',
                        'description' => 'Multiple Choice Questions'
                ));

                $initType2 = QuestionType::create(array(
                        'name' => 'MRQ',
                        'description' => 'Multiple Response Questions'
                ));

                $initType3 = Questiontype::create(array(
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


                $initExam1 = Exam::create(array(
                        'title' => 'CS2010 Midterm Test',
                        'course_id' => $initCourse2->id,
                        'description' => '<p></p><p style="color: rgb(0, 0, 0);text-align: left;"><span><strong>Please read these instructions carefully.</strong><span class="Apple-converted-space"> </span>A candidate who breaches any of the Examination Regulations will be liable to disciplinary action<span class="Apple-converted-space"> </span></span><span>including (but not limited to) suspension or expulsion from the university.</span><u><span></span></u><span></span></p><p style="color: rgb(0, 0, 0);text-align: left;"><b><u><span>Timings</span></u></b><span></span></p><p style="color: rgb(0, 0, 0);text-align: left;"></p><ul><li><span>The examination hall will be open for admission <b>10</b> minutes before the time scheduled for the commencement of the examination. You are to find your allocated seat but </span><strong>do not </strong><span>turn over the question paper until instructed at the time of commencement of the examination.</span><br/></li></ul><p></p><p style="color: rgb(0, 0, 0);text-align: left;"><b><u><span>Personal Belongings</span></u></b></p><p style="color: rgb(0, 0, 0);text-align: left;"></p><ul><li><span>Photography is not allowed in the examination hall at all </span><span>times.</span><br/></li><li><span>The University will not be responsible for the loss of any belongings in or outside the examination hal</span><br/></li></ul><p></p><p></p>',
                        'examstate_id' => $initExamState1->id,
                        'totalqn' => 0
                ));

                $initQuestion1 = Question::create(array(
                        'index' => 1,
                        'title' => 'Data Structure',
                        'content' => '<p>Please specify the differences between the following pairs:</p><ul><li>Queue</li><li>Stack</li><li>Test</li></ul>',
                        'marking_scheme' => 'Know the concepts: 3 marks
                        Know the differences: 2 marks',
                        'full_marks' => 10
                ));

                $initQuestion2 = Question::create(array(
                        'index' => 2,
                        'title' => 'Tree',
                        'content' => '<p>How many child nodes does a parent node on <u>binary tree</u> have?</p>',
                        'full_marks' => 5
                ));

                $initQuestion3 = Question::create(array(
                        'index' => 3,
                        'title' => 'Java Test',
                        'content' => 'Please write a Hello World program in Java.',
                        'full_marks' => 20
                ));

                $initQuestion4 = Question::create(array(
                        'index' => 4,
                        'title' => 'MRQ Question',
                        'content' => 'Note that there may be multiple correct options!',
                        'full_marks' => 10
                ));

                //seed relations
                $initUser1->courses()->save($initCourse1,array('role_id'=>$initRole1->id));
                $initUser2->courses()->save($initCourse1,array('role_id'=>$initRole2->id));
                $initUser3->courses()->save($initCourse1,array('role_id'=>$initRole3->id));
                $initUser4->courses()->save($initCourse1,array('role_id'=>$initRole1->id));

                $initUser1->courses()->save($initCourse2,array('role_id'=>$initRole1->id));
                $initUser2->courses()->save($initCourse2,array('role_id'=>$initRole3->id));
                $initUser3->courses()->save($initCourse2,array('role_id'=>$initRole3->id));
                $initUser4->courses()->save($initCourse2,array('role_id'=>$initRole2->id));

                $initType1->questions()->save($initQuestion2);
                $initType2->questions()->save($initQuestion4);
                $initType3->quesitons()->save($initQuestion1);
                $initType4->questions()->save($initQuestion3);

	}

}
