<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',

	'name'=>'TrackStar',

	// id defaults to name if not specified
	'id'=>'TrackStar',

	'theme'=>'newtheme',

	// 'language'=>'rev',

	'homeUrl'=>'/trackstar/project',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.admin.models.*', // To enable access to admin module model from anywhere in the application, e.g., to display messages to users
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>false,
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'admin',
	),

	// application components
    // Need to specify table names because tbl_ prefix is used
	'components'=>array(
        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
            'itemTable'=>'tbl_auth_item',
            'itemChildTable'=>'tbl_auth_item_child',
            'assignmentTable'=>'tbl_auth_assignment',
        ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				// Feed for all projects
				// trackstar/commentFeed
				'commentFeed'=>array('comment/feed', 'urlSuffix'=>'.xml', 'caseSensitive'=>false),

				// Feed for one project
				// trackstar/1/commentFeed.xml
				'<pid:\d+>/commentFeed'=>array('comment/feed', 'urlSuffix'=>'.xml', 'caseSensitive'=>false),
				),

			// Prevent index.php from being included by createAbsoluteUrl()
			'showScriptName'=>false,

			// 'rules'=>array(
			// 	'<controller:\w+>/<id:\d+>'=>'<controller>/view',
			// 	'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
			// 	'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			// ),
		),
		'db'=>array(
			'connectionString' => 'mysql:host=127.0.0.1;dbname=trackstar',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);