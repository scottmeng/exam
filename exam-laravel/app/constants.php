<?php

// return [
//     'USERS' => [
//         'ADMIN' => 1,
//         'FACILITATOR' => 2,
//         'STUDENT'
// ]
define('ADMIN',  1);
define('FACILITATOR',2);
define('STUDENT',3);

define('DRAFT',1);
define('ACTIVE',2);
define('PUBLISHED',3);
define('EXPIRED',4);

define('SUBMITTED',1);
define('GRADING',2);
define('GRADED',3);

define('STATUS_DRAFT','draft');
define('STATUS_UNAVAILABLE','unavailable');
define('STATUS_NOT_STARTED','not_started');
define('STATUS_IN_EXAM','in_exam');
define('STATUS_FINISHED','finished');
define('STATUS_PUBLISHED','published');

define('MCQ',1);
define('MRQ',2);
define('SHORT_QN',3);
define('CODING_QN',4);