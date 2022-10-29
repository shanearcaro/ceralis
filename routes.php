<?php

require_once('router.php');

get('/',                        'views/index.php');
get('',                         'views/index.php');
get('/login',                   'views/index.php');

post('/authenticate',           'controller/request-model.php');
post('/login/request',          'controller/request-model.php');
post('/query',                  'model/query-database.php');

any('/404','views/404.php');
