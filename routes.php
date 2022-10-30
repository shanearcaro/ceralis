<?php

require_once('router.php');

// Login routes
get('',                         'views/index.php');
get('/',                        'views/index.php');
get('/login',                   'views/index.php');

// Login requests
post('/login/request',          'controller/request-model.php');
post('/login/query',            'model/query-database.php');

// Student routes
get('/student',                 '/views/student/student.php');

// Student requests
// TODO

// Teacher routes
get('/teacher',                 '/views/teacher/teacher.php');

// Teacher requests
// TODO

// Unknown request or page
any('/404',                     'views/404.php');
