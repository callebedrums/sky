<?php

Sky::instance()->config(array(
	'appName' => 'MyApp',
//	'indexController' => 'Index',
//	'indexAction' => 'action',
//	'apiEndpoint' => 'api',
    'database' => array(
        'host' => 'localhost',
        'user' => 'username',
        'password' => 'password',
        'database' => 'database'
    )
));
