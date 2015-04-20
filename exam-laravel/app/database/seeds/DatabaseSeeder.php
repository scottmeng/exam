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

		//$this->call('CodeCrunchSeeder');
        $this->call('DemoSeeder');
	}

}

class DemoSeeder extends Seeder{
    public function run(){
        $this->call('UserSeeder');
        $this->call('ConstantSeeder');
        $this->call('ExamSeeder');
        $this->call('RelationSeeder');
    }
}

class UserSeeder extends Seeder{
    public function run(){
        DB::statement('SET FOREIGN_KEY_CHECKS = 0'); 
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1'); 
        DB::statement('INSERT INTO `users` (`name`,`nus_id`) VALUES ("Lingyi","A000"),("Scott","A1234567"),("Idola","Z5227052"),("Emily","T6887776"),("Nayda","J8330385"),("Ronan","P3228996"),("Leandra","N6273104"),("Chiquita","A0001234"),("Ahmed","A5997942"),("Deanna","K3116209");');
        DB::statement('INSERT INTO `users` (`name`,`nus_id`) VALUES ("Jolene","Q2184929"),("Hakeem","Y4379818"),("Drew","Q9031617"),("Dai","F9219556"),("David","S7065308"),("Francesca","G6212075"),("Blossom","E1550349"),("Kim","D3343836"),("Tarik","X0449702"),("Dane","X7908301");');
        DB::statement('INSERT INTO `users` (`name`,`nus_id`) VALUES ("Willa","V6125436"),("Hanae","F4381616"),("Dennis","W0411519"),("Britanney","J0176270"),("Emmanuel","Y0120262"),("Armando","Z7224521"),("Hayfa","X7316038"),("Wesley","L6374975"),("Sara","S0352486"),("Yardley","C6903709");');
        DB::statement('INSERT INTO `users` (`name`,`nus_id`) VALUES ("Nathaniel","J8527911"),("Germaine","O8199520"),("Ciara","N9485065"),("Giselle","X0692904"),("Regina","T3533662"),("Ryder","N8527801"),("Drake","G8809986"),("Geraldine","B4224835"),("Plato","H8042528"),("Geraldine","L1829030");');
        DB::statement('INSERT INTO `users` (`name`,`nus_id`) VALUES ("Uriel","C3040232"),("Rudyard","I1731841"),("Alvin","P7044310"),("Joel","B0912160"),("Zeph","Z8459276"),("Morgan","U4016411"),("Ralph","P0445880"),("Hu","X3497604"),("Winifred","T3100718"),("Noelle","I2009791");');   
    }
}

class ExamSeeder extends Seeder{
    public function run(){
        DB::statement('SET FOREIGN_KEY_CHECKS = 0'); 
        DB::table('courses')->truncate();
        DB::table('exams')->truncate();
        DB::table('questions')->truncate();
        DB::table('options')->truncate();
        DB::table('examsubmissions')->truncate();
        DB::table('questionsubmissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1'); 
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
                'description' => '<h4>Welcome!</h4><br>
                Please be prepared for a lot of learnings and assignments too!' 
        ));
        DB::statement("INSERT INTO `exams` VALUES (1,'CS2010 Midterm Test',2,'<p></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><span><strong>Please read these instructions carefully.</strong><span class=\"Apple-converted-space\"> </span>A candidate who breaches any of the Examination Regulations will be liable to disciplinary action<span class=\"Apple-converted-space\"> </span></span><span>including (but not limited to) suspension or expulsion from the university.</span><u><span></span></u><span></span></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><b><u><span>Timings</span></u></b><span></span></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"></p><ul><li><span>The examination hall will be open for admission <b>10</b> minutes before the time scheduled for the commencement of the examination. You are to find your allocated seat but </span><strong>do not </strong><span>turn over the question paper until instructed at the time of commencement of the examination.</span><br/></li></ul><p></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><b><u><span>Personal Belongings</span></u></b></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"></p><ul><li><span>Photography is not allowed in the examination hall at all </span><span>times.</span><br/></li><li><span>The University will not be responsible for the loss of any belongings in or outside the examination hal</span><br/></li></ul><p></p><p></p>',1,60,0,0,NULL,0,15,NULL,'2015-04-13 23:08:43','2015-04-19 16:06:02'),(2,'CS2010 Sit in Lab',2,'<p></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><span><strong>Please read these instructions carefully.</strong><span class=\"Apple-converted-space\"> </span>A candidate who breaches any of the Examination Regulations will be liable to disciplinary action<span class=\"Apple-converted-space\"> </span></span><span>including (but not limited to) suspension or expulsion from the university.</span><u><span></span></u><span></span></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><b><u><span>Timings</span></u></b><span></span></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"></p><ul><li><span>The examination hall will be open for admission <b>10</b> minutes before the time scheduled for the commencement of the examination. You are to find your allocated seat but </span><strong>do not </strong><span>turn over the question paper until instructed at the time of commencement of the examination.</span><br/></li></ul><p></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><b><u><span>Personal Belongings</span></u></b></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"></p><ul><li><span>Photography is not allowed in the examination hall at all </span><span>times.</span><br/></li><li><span>The University will not be responsible for the loss of any belongings in or outside the examination hal</span><br/></li></ul><p></p><p></p>',1,60,0,0,NULL,0,15,NULL,'2015-04-13 23:08:43','2015-04-19 16:06:02'),(3,'CS1010J Quiz 1',1,'<p></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><span><strong>Please read these instructions carefully.</strong><span class=\"Apple-converted-space\"> </span>A candidate who breaches any of the Examination Regulations will be liable to disciplinary action<span class=\"Apple-converted-space\"> </span></span><span>including (but not limited to) suspension or expulsion from the university.</span><u><span></span></u><span></span></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><b><u><span>Timings</span></u></b><span></span></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"></p><ul><li><span>The examination hall will be open for admission <b>10</b> minutes before the time scheduled for the commencement of the examination. You are to find your allocated seat but </span><strong>do not </strong><span>turn over the question paper until instructed at the time of commencement of the examination.</span><br/></li></ul><p></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><b><u><span>Personal Belongings</span></u></b></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"></p><ul><li><span>Photography is not allowed in the examination hall at all </span><span>times.</span><br/></li><li><span>The University will not be responsible for the loss of any belongings in or outside the examination hal</span><br/></li></ul><p></p><p></p>',2,60,50,5,'2015-04-15 14:00:00',0,15,NULL,'2015-04-13 23:08:43','2015-04-15 06:27:32'),(4,'CS1010J Quiz 2',1,'<p></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><span><strong>Please read these instructions carefully.</strong><span class=\"Apple-converted-space\"> </span>A candidate who breaches any of the Examination Regulations will be liable to disciplinary action<span class=\"Apple-converted-space\"> </span></span><span>including (but not limited to) suspension or expulsion from the university.</span><u><span></span></u><span></span></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><b><u><span>Timings</span></u></b><span></span></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"></p><ul><li><span>The examination hall will be open for admission <b>10</b> minutes before the time scheduled for the commencement of the examination. You are to find your allocated seat but </span><strong>do not </strong><span>turn over the question paper until instructed at the time of commencement of the examination.</span><br/></li></ul><p></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"><b><u><span>Personal Belongings</span></u></b></p><p style=\"color: rgb(0, 0, 0);text-align: left;\"></p><ul><li><span>Photography is not allowed in the examination hall at all </span><span>times.</span><br/></li><li><span>The University will not be responsible for the loss of any belongings in or outside the examination hal</span><br/></li></ul><p></p><p></p>',2,60,40,4,'2015-04-19 15:00:00',0,15,NULL,'2015-04-13 23:08:43','2015-04-19 16:23:36');");
        //seed questions
        DB::statement("INSERT INTO `questions` VALUES (4,1,1,'Java Syntax - Tracing','<p>What is the output of the following program?</p><p><br/></p><pre><code>public class HelloWorld {&#10;&#10;    public static void main(String[] args) {&#10;        System.out.println(&#34;Hello, World&#34;);&#10;    }&#10;&#10;}</code></pre><br/>',0,'c','',10,NULL,NULL,'2015-04-14 00:26:47','2015-04-14 23:50:45'),(13,4,1,'C Basics','<p>Please write your version of hello world in C.</p>',0,'c','Programs that fails compilation will lost half of the marks',10,NULL,NULL,'2015-04-14 23:54:25','2015-04-14 23:54:25'),(27,4,1,'Arrays','<p>Create a program that creates an array of five hard-coded floating-point values, then prints out just the second value.<br/></p>',0,'c',NULL,10,NULL,NULL,'2015-04-15 00:42:44','2015-04-15 00:42:44'),(28,1,1,'C Syntax - Detect Error','<p>Point out the error, if any in the program.</p><p><span id=\"selectionBoundary_1429096037107_8736632845830172\" class=\"rangySelectionBoundary\">&#65279;</span></p><pre><code>int main()&#10;{&#10;int a = 10;&#10;switch(a)&#10;{&#10;}&#10;printf(&#34;This is c program.&#34;);&#10;return 0;&#10;}</code></pre><br/><br/><p></p>',0,'c','MCQ auto graded',10,NULL,NULL,'2015-04-15 00:55:54','2015-04-15 03:27:32'),(29,1,1,'Pointers','<p>What will be the output of the following program?</p><p><br/></p><p></p><pre><code>int main()&#10;{&#10;    int x=30, *y, *z;&#10;    y=&amp;x; /* Assume address of x is 500 and integer is 4 byte size */&#10;    z=y;&#10;    *y++=*z++;&#10;    x++;&#10;    printf(&#34;x=%d, y=%d, z=%d\n&#34;, x, y, z);&#10;    return 0;&#10;}</code></pre><br/><br/><p></p>',0,'c',NULL,10,NULL,NULL,'2015-04-15 00:59:07','2015-04-19 16:23:33'),(30,2,1,'Array Concepts','<p>Which of the following statements are correct about an array? (You could select multiple answers)</p>',0,'c',NULL,15,NULL,NULL,'2015-04-15 01:02:58','2015-04-19 16:23:33'),(31,3,1,'C Concepts - Basic','<p>What is the keyword used to transfer control from a function back to the calling function?<br/></p>',0,'c','\'return\' gets full marks',5,NULL,NULL,'2015-04-15 01:04:40','2015-04-15 03:11:49');");
        //seed options
        DB::statement("INSERT INTO `options` VALUES (13,'Hello World',4,0,'2015-04-15 04:11:54','2015-04-15 04:35:49'),(14,'Hello',4,0,'2015-04-15 04:11:54','2015-04-15 04:35:49'),(15,'Hello World War',4,0,'2015-04-15 04:11:54','2015-04-15 04:35:49'),(16,'Compilation Error',4,1,'2015-04-15 04:11:54','2015-04-15 04:11:54'),(17,'Error: No case statement specified',28,0,'2015-04-15 08:55:54','2015-04-15 08:55:54'),(18,'Error: No default specified',28,1,'2015-04-15 08:55:54','2015-04-15 08:55:54'),(19,'No Error',28,0,'2015-04-15 08:55:54','2015-04-15 08:55:54'),(20,'Error: infinite loop occurs',28,0,'2015-04-15 08:55:54','2015-04-15 08:55:54'),(21,'x=31, y=502, z=502',29,0,'2015-04-15 08:59:07','2015-04-15 08:59:07'),(22,'x=31, y=500, z=500',29,1,'2015-04-15 08:59:07','2015-04-15 08:59:07'),(23,'x=31, y=498, z=498',29,0,'2015-04-15 08:59:07','2015-04-15 08:59:07'),(24,'x=31, y=504, z=504',29,0,'2015-04-15 08:59:07','2015-04-15 08:59:07'),(25,'The array int num[26]; can store 26 elements.',30,1,'2015-04-15 09:02:58','2015-04-15 09:02:58'),(26,'The expression num[1] designates the very first element in the array.',30,0,'2015-04-15 09:02:58','2015-04-15 09:02:58'),(27,'It is necessary to initialize the array at the time of declaration.',30,0,'2015-04-15 09:02:58','2015-04-15 09:02:58'),(28,'The declaration num[SIZE] is allowed if SIZE is a macro.',30,1,'2015-04-15 09:02:58','2015-04-15 09:02:58');");
        //seed exam_submissions
        DB::statement("INSERT INTO `examsubmissions` VALUES (1,3,3,NULL,19,3,NULL,'2015-04-15 06:28:11','2015-04-19 16:15:28'),(2,4,3,NULL,15,3,NULL,'2015-04-15 06:38:46','2015-04-19 16:21:46'),(3,5,3,NULL,29,3,NULL,'2015-04-15 06:40:55','2015-04-19 16:19:52'),(4,7,3,NULL,16,3,NULL,'2015-04-15 06:42:06','2015-04-19 16:14:01'),(5,8,3,NULL,27,3,NULL,'2015-04-15 06:42:55','2015-04-19 16:17:17'),(6,9,3,NULL,26,3,NULL,'2015-04-15 06:43:42','2015-04-19 16:14:54'),(7,10,3,NULL,35,3,NULL,'2015-04-15 06:47:22','2015-04-19 16:14:20'),(8,13,3,NULL,25,3,NULL,'2015-04-15 06:48:31','2015-04-19 16:19:31'),(9,14,3,NULL,25,3,NULL,'2015-04-15 06:49:54','2015-04-19 16:19:11'),(10,15,3,NULL,15,3,NULL,'2015-04-15 06:50:45','2015-04-19 16:15:55'),(11,16,3,NULL,22,3,NULL,'2015-04-15 06:51:40','2015-04-19 16:18:13'),(12,17,3,NULL,33,3,NULL,'2015-04-15 06:52:35','2015-04-19 16:12:12'),(13,18,3,NULL,13,3,NULL,'2015-04-15 06:53:08','2015-04-19 16:22:08'),(14,19,3,NULL,20,3,NULL,'2015-04-15 06:53:47','2015-04-19 16:13:31'),(15,20,3,NULL,20,3,NULL,'2015-04-15 06:55:00','2015-04-19 16:15:11'),(16,21,3,NULL,17,3,NULL,'2015-04-15 06:55:35','2015-04-19 16:20:12'),(17,22,3,NULL,25,3,NULL,'2015-04-15 06:56:21','2015-04-19 16:21:04'),(18,23,3,NULL,33,3,NULL,'2015-04-15 06:56:54','2015-04-19 16:18:38'),(19,24,3,NULL,12,3,NULL,'2015-04-15 06:57:30','2015-04-19 16:20:41'),(20,25,3,NULL,39,3,NULL,'2015-04-15 06:58:02','2015-04-19 16:14:35'),(21,26,3,NULL,23,3,NULL,'2015-04-15 06:58:36','2015-04-19 16:12:33'),(22,27,3,NULL,41,3,NULL,'2015-04-15 06:59:05','2015-04-19 16:13:14'),(23,28,3,NULL,33,3,NULL,'2015-04-15 06:59:32','2015-04-19 16:11:54'),(24,5,4,NULL,0,1,NULL,'2015-04-19 16:24:05','2015-04-19 16:24:05'),(25,6,4,NULL,0,1,NULL,'2015-04-19 16:25:06','2015-04-19 16:25:06'),(26,7,4,NULL,0,1,NULL,'2015-04-19 16:26:18','2015-04-19 16:26:18'),(27,8,4,NULL,0,1,NULL,'2015-04-19 16:27:16','2015-04-19 16:27:16'),(28,9,4,NULL,0,1,NULL,'2015-04-19 16:28:22','2015-04-19 16:28:22');");
        //seed question_submissions
        DB::statement("INSERT INTO `questionsubmissions` VALUES (1,'',4,1,0,3,'system automatic grading','2015-04-15 06:35:08','2015-04-19 16:11:25'),(2,'#include <std.io>\n\nint main(){\n    float * arr=[1.0,2.0,3.0,4.0,5.0];\n    printf(arr[1]);\n    return 0;\n}',27,1,2,3,NULL,'2015-04-15 06:37:41','2015-04-19 16:15:18'),(3,'',30,1,7,3,NULL,'2015-04-15 06:37:50','2015-04-19 16:15:24'),(4,'',28,1,10,3,'system automatic grading','2015-04-15 06:37:59','2015-04-19 16:11:25'),(5,'test',31,1,0,3,NULL,'2015-04-15 06:38:07','2015-04-19 16:15:28'),(6,'',4,2,0,3,'system automatic grading','2015-04-15 06:39:32','2015-04-19 16:11:25'),(7,'#include<stdio.h>\n\nmain()\n{\n    printf(\"The Second Value\");\n\n}',27,2,5,3,'Failed compilation','2015-04-15 06:40:16','2015-04-19 16:21:20'),(8,'',30,2,5,3,'One correct one wrong','2015-04-15 06:40:23','2015-04-19 16:21:40'),(9,'',28,2,0,3,'system automatic grading','2015-04-15 06:40:28','2015-04-19 16:11:25'),(10,'return',31,2,5,3,NULL,'2015-04-15 06:40:32','2015-04-19 16:21:46'),(11,NULL,4,3,10,3,'system automatic grading','2015-04-15 06:40:55','2015-04-19 16:11:25'),(12,'#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,3,7,3,NULL,'2015-04-15 06:40:55','2015-04-19 16:19:38'),(13,NULL,30,3,7,3,NULL,'2015-04-15 06:40:55','2015-04-19 16:19:48'),(14,NULL,28,3,0,3,'system automatic grading','2015-04-15 06:40:55','2015-04-19 16:11:25'),(15,'return',31,3,5,3,NULL,'2015-04-15 06:40:55','2015-04-19 16:19:52'),(16,NULL,4,4,10,3,'system automatic grading','2015-04-15 06:42:06','2015-04-19 16:11:25'),(17,'#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,4,6,3,NULL,'2015-04-15 06:42:06','2015-04-19 16:13:44'),(18,NULL,30,4,0,3,NULL,'2015-04-15 06:42:06','2015-04-19 16:13:56'),(19,NULL,28,4,0,3,'system automatic grading','2015-04-15 06:42:06','2015-04-19 16:11:25'),(20,'return',31,4,0,3,NULL,'2015-04-15 06:42:06','2015-04-19 16:14:01'),(21,NULL,4,5,0,3,'system automatic grading','2015-04-15 06:42:55','2015-04-19 16:11:25'),(22,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,5,5,3,'Failed Compilation','2015-04-15 06:42:55','2015-04-19 16:16:54'),(23,NULL,30,5,7,3,'One correct one wrong','2015-04-15 06:42:55','2015-04-19 16:17:08'),(24,NULL,28,5,0,3,'system automatic grading','2015-04-15 06:42:55','2015-04-19 16:11:25'),(25,'return',31,5,5,3,'correct!','2015-04-15 06:42:55','2015-04-19 16:17:17'),(26,NULL,4,6,0,3,'system automatic grading','2015-04-15 06:43:42','2015-04-19 16:11:25'),(27,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,6,6,3,NULL,'2015-04-15 06:43:42','2015-04-19 16:14:42'),(28,NULL,30,6,15,3,NULL,'2015-04-15 06:43:42','2015-04-19 16:14:48'),(29,NULL,28,6,0,3,'system automatic grading','2015-04-15 06:43:42','2015-04-19 16:11:25'),(30,'RETURN',31,6,5,3,NULL,'2015-04-15 06:43:42','2015-04-19 16:14:54'),(31,NULL,4,7,0,3,'system automatic grading','2015-04-15 06:47:22','2015-04-19 16:11:25'),(32,'#include<stdio.h>\n#include<conio.h>\nvoid main() {\n   int numArray[10];\n   int i, sum = 0;\n   int *ptr;\n \n   printf(\"\nEnter 10 elements : \");\n \n   for (i = 0; i < 10; i++)\n      scanf(\"%d\", &numArray[i]);\n \n   ptr = numArray; /* a=&a[0] */\n \n   for (i = 0; i < 10; i++) {\n      sum = sum + *ptr;\n      ptr++;\n   }\n \n   printf(\"The sum of array elements : %d\", sum);\n}',27,7,8,3,NULL,'2015-04-15 06:47:22','2015-04-19 16:14:08'),(33,NULL,30,7,12,3,NULL,'2015-04-15 06:47:22','2015-04-19 16:14:14'),(34,NULL,28,7,10,3,'system automatic grading','2015-04-15 06:47:22','2015-04-19 16:11:25'),(35,'return',31,7,5,3,NULL,'2015-04-15 06:47:22','2015-04-19 16:14:20'),(36,NULL,4,8,0,3,'system automatic grading','2015-04-15 06:48:31','2015-04-19 16:11:25'),(37,'\n2\n3\n4\n5\n6\n7\n8\n9\n10\n11\n12\n13\n14\n15\n16\n17\n18\n19\n20\n21\n#include<stdio.h>\n \nint main() {\n   int i, arr[50], num;\n \n   printf(\"\nEnter no of elements :\");\n   scanf(\"%d\", &num);\n \n   //Reading values into Array\n   printf(\"\nEnter the values :\");\n   for (i = 0; i < num; i++) {\n      scanf(\"%d\", &arr[i]);\n   }\n \n   //Printing of all elements of array\n   for (i = 0; i < num; i++) {\n      printf(\"\narr[%d] = %d\", i, arr[i]);\n   }\n \n   return (0);\n}',27,8,0,3,NULL,'2015-04-15 06:48:31','2015-04-19 16:19:21'),(38,NULL,30,8,10,3,NULL,'2015-04-15 06:48:31','2015-04-19 16:19:27'),(39,NULL,28,8,10,3,'system automatic grading','2015-04-15 06:48:31','2015-04-19 16:11:25'),(40,'RETURN',31,8,5,3,NULL,'2015-04-15 06:48:31','2015-04-19 16:19:31'),(41,NULL,4,9,0,3,'system automatic grading','2015-04-15 06:49:54','2015-04-19 16:11:25'),(42,'#include<stdio.h>\n \nint main() {\n   int i, arr[50], num;\n \n   printf(\"\nEnter no of elements :\");\n   scanf(\"%d\", &num);\n \n   //Reading values into Array\n   printf(\"\nEnter the values :\");\n   for (i = 0; i < num; i++) {\n      scanf(\"%d\", &arr[i]);\n   }\n \n   //Printing of all elements of array\n   for (i = 0; i < num; i++) {\n      printf(\"\narr[%d] = %d\", i, arr[i]);\n   }\n \n   return (0);\n}',27,9,10,3,NULL,'2015-04-15 06:49:54','2015-04-19 16:18:58'),(43,NULL,30,9,10,3,NULL,'2015-04-15 06:49:54','2015-04-19 16:19:06'),(44,NULL,28,9,0,3,'system automatic grading','2015-04-15 06:49:54','2015-04-19 16:11:25'),(45,'break',31,9,5,3,NULL,'2015-04-15 06:49:54','2015-04-19 16:19:11'),(46,NULL,4,10,0,3,'system automatic grading','2015-04-15 06:50:45','2015-04-19 16:11:25'),(47,'#include<stdio.h>\n \nint main() {\n   int i, arr[50], num;\n \n   printf(\"\nEnter no of elements :\");\n   scanf(\"%d\", &num);\n \n   //Reading values into Array\n   printf(\"\nEnter the values :\");\n   for (i = 0; i < num; i++) {\n      scanf(\"%d\", &arr[i]);\n   }\n \n   //Printing of all elements of array\n   for (i = 0; i < num; i++) {\n      printf(\"\narr[%d] = %d\", i, arr[i]);\n   }\n \n   return (0);\n}',27,10,5,3,NULL,'2015-04-15 06:50:45','2015-04-19 16:15:42'),(48,NULL,30,10,10,3,NULL,'2015-04-15 06:50:45','2015-04-19 16:15:49'),(49,NULL,28,10,0,3,'system automatic grading','2015-04-15 06:50:45','2015-04-19 16:11:25'),(50,'goto',31,10,0,3,NULL,'2015-04-15 06:50:45','2015-04-19 16:15:55'),(51,NULL,4,11,0,3,'system automatic grading','2015-04-15 06:51:40','2015-04-19 16:11:25'),(52,'#include<stdio.h>\n \nint main() {\n   int arr1[30], arr2[30], i, num;\n \n   printf(\"\nEnter no of elements :\");\n   scanf(\"%d\", &num);\n \n   //Accepting values into Array\n   printf(\"\nEnter the values :\");\n   for (i = 0; i < num; i++) {\n      scanf(\"%d\", &arr1[i]);\n   }\n \n   /* Copying data from array \'a\' to array \'b */\n   for (i = 0; i < num; i++) {\n      arr2[i] = arr1[i];\n   }\n \n   //Printing of all elements of array\n   printf(\"The copied array is :\");\n   for (i = 0; i < num; i++)\n      printf(\"\narr2[%d] = %d\", i, arr2[i]);\n \n   return (0);\n}',27,11,7,3,NULL,'2015-04-15 06:51:40','2015-04-19 16:17:57'),(53,NULL,30,11,10,3,'one missing','2015-04-15 06:51:40','2015-04-19 16:18:08'),(54,NULL,28,11,0,3,'system automatic grading','2015-04-15 06:51:40','2015-04-19 16:11:25'),(55,'Return;',31,11,5,3,NULL,'2015-04-15 06:51:40','2015-04-19 16:18:13'),(56,NULL,4,12,0,3,'system automatic grading','2015-04-15 06:52:35','2015-04-19 16:11:25'),(57,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,12,8,3,NULL,'2015-04-15 06:52:35','2015-04-19 16:12:12'),(58,NULL,30,12,10,3,NULL,'2015-04-15 06:52:35','2015-04-19 16:12:10'),(59,NULL,28,12,10,3,'system automatic grading','2015-04-15 06:52:35','2015-04-19 16:11:25'),(60,'rerturn',31,12,5,3,NULL,'2015-04-15 06:52:35','2015-04-19 16:12:08'),(61,NULL,4,13,0,3,'system automatic grading','2015-04-15 06:53:08','2015-04-19 16:11:25'),(62,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,13,0,3,NULL,'2015-04-15 06:53:08','2015-04-19 16:21:54'),(63,NULL,30,13,0,3,NULL,'2015-04-15 06:53:08','2015-04-19 16:21:59'),(64,NULL,28,13,10,3,'system automatic grading','2015-04-15 06:53:08','2015-04-19 16:11:25'),(65,'Returb',31,13,3,3,'spelling error','2015-04-15 06:53:08','2015-04-19 16:22:08'),(66,NULL,4,14,0,3,'system automatic grading','2015-04-15 06:53:47','2015-04-19 16:11:25'),(67,'#include<stdio.h>\n#include<stdlib.h>\n \nint main() {\n   int num;\n   char marks[3];\n \n   printf(\"Please Enter Marks : \");\n   scanf(\"%s\", marks);\n \n   num = atoi(marks);\n   printf(\"\nMarks : %d\", num);\n \n   return (0);\n}',27,14,6,3,NULL,'2015-04-15 06:53:47','2015-04-19 16:13:20'),(68,NULL,30,14,10,3,NULL,'2015-04-15 06:53:47','2015-04-19 16:13:27'),(69,NULL,28,14,0,3,'system automatic grading','2015-04-15 06:53:47','2015-04-19 16:11:25'),(70,'break',31,14,4,3,NULL,'2015-04-15 06:53:47','2015-04-19 16:13:31'),(71,NULL,4,15,0,3,'system automatic grading','2015-04-15 06:55:00','2015-04-19 16:11:25'),(72,'#include<stdio.h>\n#include<stdlib.h>\n \nint main() {\n   int num;\n   char marks[3];\n \n   printf(\"Please Enter Marks : \");\n   scanf(\"%s\", marks);\n \n   num = atoi(marks);\n   printf(\"\nMarks : %d\", num);\n \n   return (0);\n}',27,15,10,3,NULL,'2015-04-15 06:55:00','2015-04-19 16:15:01'),(73,NULL,30,15,5,3,NULL,'2015-04-15 06:55:00','2015-04-19 16:15:07'),(74,NULL,28,15,0,3,'system automatic grading','2015-04-15 06:55:00','2015-04-19 16:11:25'),(75,'return',31,15,5,3,NULL,'2015-04-15 06:55:00','2015-04-19 16:15:11'),(76,NULL,4,16,0,3,'system automatic grading','2015-04-15 06:55:35','2015-04-19 16:11:25'),(77,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,16,5,3,NULL,'2015-04-15 06:55:35','2015-04-19 16:20:03'),(78,NULL,30,16,12,3,NULL,'2015-04-15 06:55:35','2015-04-19 16:20:08'),(79,NULL,28,16,0,3,'system automatic grading','2015-04-15 06:55:35','2015-04-19 16:11:25'),(80,'switch',31,16,0,3,NULL,'2015-04-15 06:55:35','2015-04-19 16:20:12'),(81,NULL,4,17,0,3,'system automatic grading','2015-04-15 06:56:21','2015-04-19 16:11:25'),(82,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,17,5,3,NULL,'2015-04-15 06:56:21','2015-04-19 16:20:57'),(83,NULL,30,17,5,3,NULL,'2015-04-15 06:56:21','2015-04-19 16:21:00'),(84,NULL,28,17,10,3,'system automatic grading','2015-04-15 06:56:21','2015-04-19 16:11:25'),(85,'return',31,17,5,3,NULL,'2015-04-15 06:56:21','2015-04-19 16:21:04'),(86,NULL,4,18,0,3,'system automatic grading','2015-04-15 06:56:54','2015-04-19 16:11:25'),(87,'#include<stdio.h>\n#include<stdlib.h>\n \nint main() {\n   int num;\n   char marks[3];\n \n   printf(\"Please Enter Marks : \");\n   scanf(\"%s\", marks);\n \n   num = atoi(marks);\n   printf(\"\nMarks : %d\", num);\n \n   return (0);\n}',27,18,8,3,NULL,'2015-04-15 06:56:54','2015-04-19 16:18:27'),(88,NULL,30,18,10,3,NULL,'2015-04-15 06:56:54','2015-04-19 16:18:33'),(89,NULL,28,18,10,3,'system automatic grading','2015-04-15 06:56:54','2015-04-19 16:11:25'),(90,'test',31,18,5,3,NULL,'2015-04-15 06:56:54','2015-04-19 16:18:38'),(91,NULL,4,19,0,3,'system automatic grading','2015-04-15 06:57:30','2015-04-19 16:11:25'),(92,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,19,7,3,NULL,'2015-04-15 06:57:30','2015-04-19 16:20:24'),(93,NULL,30,19,0,3,NULL,'2015-04-15 06:57:30','2015-04-19 16:20:32'),(94,NULL,28,19,0,3,'system automatic grading','2015-04-15 06:57:30','2015-04-19 16:11:25'),(95,'return',31,19,5,3,NULL,'2015-04-15 06:57:30','2015-04-19 16:20:41'),(96,NULL,4,20,10,3,'system automatic grading','2015-04-15 06:58:02','2015-04-19 16:11:25'),(97,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,20,8,3,NULL,'2015-04-15 06:58:02','2015-04-19 16:14:26'),(98,NULL,30,20,8,3,NULL,'2015-04-15 06:58:02','2015-04-19 16:14:31'),(99,NULL,28,20,10,3,'system automatic grading','2015-04-15 06:58:02','2015-04-19 16:11:25'),(100,'return',31,20,3,3,NULL,'2015-04-15 06:58:02','2015-04-19 16:14:35'),(101,NULL,4,21,0,3,'system automatic grading','2015-04-15 06:58:36','2015-04-19 16:11:25'),(102,'#include<stdio.h>\n#include<stdlib.h>\n \nint main() {\n   int num;\n   char marks[3];\n \n   printf(\"Please Enter Marks : \");\n   scanf(\"%s\", marks);\n \n   num = atoi(marks);\n   printf(\"\nMarks : %d\", num);\n \n   return (0);\n}',27,21,10,3,NULL,'2015-04-15 06:58:36','2015-04-19 16:12:19'),(103,NULL,30,21,10,3,NULL,'2015-04-15 06:58:36','2015-04-19 16:12:26'),(104,NULL,28,21,0,3,'system automatic grading','2015-04-15 06:58:36','2015-04-19 16:11:25'),(105,'return',31,21,3,3,NULL,'2015-04-15 06:58:36','2015-04-19 16:12:33'),(106,NULL,4,22,10,3,'system automatic grading','2015-04-15 06:59:05','2015-04-19 16:11:25'),(107,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,22,10,3,NULL,'2015-04-15 06:59:05','2015-04-19 16:12:56'),(108,NULL,30,22,6,3,NULL,'2015-04-15 06:59:05','2015-04-19 16:13:06'),(109,NULL,28,22,10,3,'system automatic grading','2015-04-15 06:59:05','2015-04-19 16:11:25'),(110,'return',31,22,5,3,NULL,'2015-04-15 06:59:05','2015-04-19 16:13:14'),(111,NULL,4,23,10,3,'system automatic grading','2015-04-15 06:59:32','2015-04-19 16:11:25'),(112,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',27,23,10,3,NULL,'2015-04-15 06:59:32','2015-04-19 16:11:42'),(113,NULL,30,23,8,3,NULL,'2015-04-15 06:59:32','2015-04-19 16:11:49'),(114,NULL,28,23,0,3,'system automatic grading','2015-04-15 06:59:32','2015-04-19 16:11:25'),(115,'return',31,23,5,3,NULL,'2015-04-15 06:59:32','2015-04-19 16:11:54'),(116,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\")\n\n}',13,24,NULL,1,NULL,'2015-04-19 16:24:05','2015-04-19 16:24:32'),(117,NULL,29,24,NULL,1,NULL,'2015-04-19 16:24:05','2015-04-19 16:24:05'),(118,NULL,30,24,NULL,1,NULL,'2015-04-19 16:24:05','2015-04-19 16:24:05'),(119,'return',31,24,NULL,1,NULL,'2015-04-19 16:24:05','2015-04-19 16:24:55'),(120,'/* Hello World program */\n\n#include<stdio.h>\n\nmain()\n{\n    printf(\"Hello World\");\n\n}',13,25,NULL,1,NULL,'2015-04-19 16:25:06','2015-04-19 16:25:45'),(121,NULL,29,25,NULL,1,NULL,'2015-04-19 16:25:06','2015-04-19 16:25:06'),(122,NULL,30,25,NULL,1,NULL,'2015-04-19 16:25:06','2015-04-19 16:25:06'),(123,'switch',31,25,NULL,1,NULL,'2015-04-19 16:25:06','2015-04-19 16:26:01'),(124,'/* Hello World program */\n\n#include<stdio.h>\n\nint main()\n{\n    printf(\"Hello World\");\n\n}',13,26,NULL,1,NULL,'2015-04-19 16:26:18','2015-04-19 16:26:44'),(125,NULL,29,26,NULL,1,NULL,'2015-04-19 16:26:18','2015-04-19 16:26:18'),(126,NULL,30,26,NULL,1,NULL,'2015-04-19 16:26:18','2015-04-19 16:26:18'),(127,'return',31,26,NULL,1,NULL,'2015-04-19 16:26:18','2015-04-19 16:26:56'),(128,'/* Hello World program */\n\n#include<stdio.h>\n\nint main()\n{\n    printf(\"Hello World\")\n\n}',13,27,NULL,1,NULL,'2015-04-19 16:27:16','2015-04-19 16:27:46'),(129,NULL,29,27,NULL,1,NULL,'2015-04-19 16:27:16','2015-04-19 16:27:16'),(130,NULL,30,27,NULL,1,NULL,'2015-04-19 16:27:16','2015-04-19 16:27:16'),(131,'return',31,27,NULL,1,NULL,'2015-04-19 16:27:16','2015-04-19 16:27:58'),(132,'/* Hello World program */\n\n#include<stdio.h>\n\nint main()\n{\n    printf(\"Hello World War\");\n\n}',13,28,NULL,1,NULL,'2015-04-19 16:28:22','2015-04-19 16:28:52'),(133,NULL,29,28,NULL,1,NULL,'2015-04-19 16:28:22','2015-04-19 16:28:22'),(134,NULL,30,28,NULL,1,NULL,'2015-04-19 16:28:22','2015-04-19 16:28:22'),(135,'goto',31,28,NULL,1,NULL,'2015-04-19 16:28:22','2015-04-19 16:29:05');");
    }
}

class RelationSeeder extends Seeder{
    public function run(){
        DB::statement('SET FOREIGN_KEY_CHECKS = 0'); 
        DB::table('course_user')->truncate();
        DB::table('exam_question')->truncate();
        DB::table('selected_options')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1'); 
        //enrol users
        $user1 = User::where('name','like','Lingyi')->first();
        $user2 = User::where('name','like','Scott')->first();
        $user3 = User::where('name','like','Emily')->first();
        $user4 = User::where('name','like','Idola')->first();
        $students = User::whereNotIn('id',[$user1->id, $user2->id, $user3->id, $user4->id])->get();
        //$initCourse1 = Course::where('id','=','1')->first();
        //$initCourse2 = Course::where('id','=','2')->first();
        $user1->courses()->attach(1,array('role_id'=>1));
        $user1->courses()->attach(2,array('role_id'=>1));
        $user2->courses()->attach(1,array('role_id'=>2));
        $user2->courses()->attach(2,array('role_id'=>3));
        $user3->courses()->attach(1,array('role_id'=>2));
        $user4->courses()->attach(1,array('role_id'=>2));
        foreach($students as $student){
            $student->courses()->attach(1,array('role_id'=>3));

        }
        //link exam with questions
        DB::statement("INSERT INTO `exam_question` VALUES (22,3,4,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(31,3,27,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(32,3,30,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(36,3,28,4,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(37,3,31,5,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(38,4,13,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(39,4,29,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(40,4,30,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(41,4,31,4,'0000-00-00 00:00:00','0000-00-00 00:00:00');");
        //seed selected_options
        DB::statement("INSERT INTO `selected_options` VALUES (2,25,3,'2015-04-15 06:37:50','2015-04-15 06:37:50'),(3,26,3,'2015-04-15 06:37:50','2015-04-15 06:37:50'),(4,18,4,'2015-04-15 06:37:59','2015-04-15 06:37:59'),(5,14,1,'2015-04-15 06:38:17','2015-04-15 06:38:17'),(7,26,8,'2015-04-15 06:40:23','2015-04-15 06:40:23'),(8,27,8,'2015-04-15 06:40:23','2015-04-15 06:40:23'),(9,28,8,'2015-04-15 06:40:23','2015-04-15 06:40:23'),(10,19,9,'2015-04-15 06:40:28','2015-04-15 06:40:28'),(11,15,6,'2015-04-15 06:40:41','2015-04-15 06:40:41'),(12,16,11,'2015-04-15 06:41:00','2015-04-15 06:41:00'),(13,25,13,'2015-04-15 06:41:31','2015-04-15 06:41:31'),(14,27,13,'2015-04-15 06:41:31','2015-04-15 06:41:31'),(15,17,14,'2015-04-15 06:41:35','2015-04-15 06:41:35'),(17,26,18,'2015-04-15 06:42:25','2015-04-15 06:42:25'),(18,25,18,'2015-04-15 06:42:25','2015-04-15 06:42:25'),(19,27,18,'2015-04-15 06:42:25','2015-04-15 06:42:25'),(20,28,18,'2015-04-15 06:42:25','2015-04-15 06:42:25'),(21,19,19,'2015-04-15 06:42:29','2015-04-15 06:42:29'),(22,16,16,'2015-04-15 06:42:40','2015-04-15 06:42:40'),(23,16,21,'2015-04-15 06:43:07','2015-04-15 06:43:07'),(24,26,23,'2015-04-15 06:43:22','2015-04-15 06:43:22'),(25,28,23,'2015-04-15 06:43:22','2015-04-15 06:43:22'),(26,17,24,'2015-04-15 06:43:25','2015-04-15 06:43:25'),(27,13,26,'2015-04-15 06:45:36','2015-04-15 06:45:36'),(28,25,28,'2015-04-15 06:45:46','2015-04-15 06:45:46'),(29,26,28,'2015-04-15 06:45:46','2015-04-15 06:45:46'),(30,19,29,'2015-04-15 06:45:49','2015-04-15 06:45:49'),(31,14,31,'2015-04-15 06:47:27','2015-04-15 06:47:27'),(32,25,33,'2015-04-15 06:48:09','2015-04-15 06:48:09'),(33,27,33,'2015-04-15 06:48:09','2015-04-15 06:48:09'),(34,18,34,'2015-04-15 06:48:12','2015-04-15 06:48:12'),(35,13,36,'2015-04-15 06:48:36','2015-04-15 06:48:36'),(36,25,38,'2015-04-15 06:49:36','2015-04-15 06:49:36'),(37,18,39,'2015-04-15 06:49:39','2015-04-15 06:49:39'),(38,13,41,'2015-04-15 06:50:00','2015-04-15 06:50:00'),(39,25,43,'2015-04-15 06:50:26','2015-04-15 06:50:26'),(40,27,43,'2015-04-15 06:50:26','2015-04-15 06:50:26'),(41,19,44,'2015-04-15 06:50:28','2015-04-15 06:50:28'),(42,13,46,'2015-04-15 06:50:49','2015-04-15 06:50:49'),(43,25,48,'2015-04-15 06:51:14','2015-04-15 06:51:14'),(44,17,49,'2015-04-15 06:51:19','2015-04-15 06:51:19'),(45,13,51,'2015-04-15 06:51:43','2015-04-15 06:51:43'),(46,25,53,'2015-04-15 06:52:14','2015-04-15 06:52:14'),(47,20,54,'2015-04-15 06:52:18','2015-04-15 06:52:18'),(48,13,56,'2015-04-15 06:52:38','2015-04-15 06:52:38'),(49,25,58,'2015-04-15 06:52:48','2015-04-15 06:52:48'),(50,18,59,'2015-04-15 06:52:51','2015-04-15 06:52:51'),(51,13,61,'2015-04-15 06:53:12','2015-04-15 06:53:12'),(52,26,63,'2015-04-15 06:53:20','2015-04-15 06:53:20'),(53,18,64,'2015-04-15 06:53:24','2015-04-15 06:53:24'),(54,13,66,'2015-04-15 06:53:54','2015-04-15 06:53:54'),(55,26,68,'2015-04-15 06:54:34','2015-04-15 06:54:34'),(56,17,69,'2015-04-15 06:54:37','2015-04-15 06:54:37'),(57,14,71,'2015-04-15 06:55:05','2015-04-15 06:55:05'),(58,27,73,'2015-04-15 06:55:14','2015-04-15 06:55:14'),(59,28,73,'2015-04-15 06:55:14','2015-04-15 06:55:14'),(60,19,74,'2015-04-15 06:55:17','2015-04-15 06:55:17'),(62,27,78,'2015-04-15 06:55:49','2015-04-15 06:55:49'),(63,17,79,'2015-04-15 06:55:55','2015-04-15 06:55:55'),(64,13,76,'2015-04-15 06:56:10','2015-04-15 06:56:10'),(65,13,81,'2015-04-15 06:56:24','2015-04-15 06:56:24'),(66,25,83,'2015-04-15 06:56:33','2015-04-15 06:56:33'),(67,18,84,'2015-04-15 06:56:37','2015-04-15 06:56:37'),(68,14,86,'2015-04-15 06:56:58','2015-04-15 06:56:58'),(69,26,88,'2015-04-15 06:57:08','2015-04-15 06:57:08'),(70,18,89,'2015-04-15 06:57:11','2015-04-15 06:57:11'),(71,13,91,'2015-04-15 06:57:33','2015-04-15 06:57:33'),(72,26,93,'2015-04-15 06:57:43','2015-04-15 06:57:43'),(73,27,93,'2015-04-15 06:57:43','2015-04-15 06:57:43'),(74,17,94,'2015-04-15 06:57:48','2015-04-15 06:57:48'),(75,16,96,'2015-04-15 06:58:06','2015-04-15 06:58:06'),(76,26,98,'2015-04-15 06:58:16','2015-04-15 06:58:16'),(77,18,99,'2015-04-15 06:58:20','2015-04-15 06:58:20'),(78,14,101,'2015-04-15 06:58:42','2015-04-15 06:58:42'),(79,26,103,'2015-04-15 06:58:49','2015-04-15 06:58:49'),(80,19,104,'2015-04-15 06:58:52','2015-04-15 06:58:52'),(81,16,106,'2015-04-15 06:59:09','2015-04-15 06:59:09'),(82,25,108,'2015-04-15 06:59:16','2015-04-15 06:59:16'),(83,18,109,'2015-04-15 06:59:20','2015-04-15 06:59:20'),(84,16,111,'2015-04-15 06:59:37','2015-04-15 06:59:37'),(85,27,113,'2015-04-15 06:59:46','2015-04-15 06:59:46'),(86,19,114,'2015-04-15 06:59:49','2015-04-15 06:59:49'),(87,22,117,'2015-04-19 16:24:44','2015-04-19 16:24:44'),(88,25,118,'2015-04-19 16:24:49','2015-04-19 16:24:49'),(89,27,118,'2015-04-19 16:24:49','2015-04-19 16:24:49'),(90,22,121,'2015-04-19 16:25:48','2015-04-19 16:25:48'),(92,26,122,'2015-04-19 16:26:02','2015-04-19 16:26:02'),(93,22,125,'2015-04-19 16:26:47','2015-04-19 16:26:47'),(94,25,126,'2015-04-19 16:26:52','2015-04-19 16:26:52'),(95,27,126,'2015-04-19 16:26:52','2015-04-19 16:26:52'),(96,21,129,'2015-04-19 16:27:49','2015-04-19 16:27:49'),(99,26,130,'2015-04-19 16:28:00','2015-04-19 16:28:00'),(100,28,130,'2015-04-19 16:28:00','2015-04-19 16:28:00'),(101,21,133,'2015-04-19 16:28:56','2015-04-19 16:28:56'),(102,27,134,'2015-04-19 16:28:59','2015-04-19 16:28:59'),(103,28,134,'2015-04-19 16:28:59','2015-04-19 16:28:59');");
    }
}

class ConstantSeeder extends Seeder{
    public function run(){
        DB::statement('SET FOREIGN_KEY_CHECKS = 0'); 
        DB::table('questiontypes')->truncate();
        DB::table('examstates')->truncate();
        DB::table('submissionstates')->truncate();
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');  
 
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
                DB::table('exam_question')->truncate();
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
