<?php

return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Каталог книг',
	'defaultController' => 'book',
	'language' => 'ru',

	'preload' => array('log'),

	'import' => array(
		'application.models.*',
		'application.components.*',
	),

	'components' => array(

		'user' => array(
			'allowAutoLogin' => true,
			'loginUrl' => array('/site/login'),
		),

		'urlManager' => array(
			'urlFormat' => 'path',
			'showScriptName' => false,
			'rules' => array(
				'books' => 'book/index',
				'book/create' => 'book/create',
				'book/<id:\d+>/update' => 'book/update',
				'book/<id:\d+>/delete' => 'book/delete',
				'book/<id:\d+>' => 'book/view',
				'authors' => 'author/index',
				'author/create' => 'author/create',
				'author/<id:\d+>/update' => 'author/update',
				'author/<id:\d+>/delete' => 'author/delete',
				'author/<id:\d+>/subscribe' => 'author/subscribe',
				'author/<id:\d+>' => 'author/view',
				'report' => 'report/index',
				'login' => 'site/login',
				'logout' => 'site/logout',
				'register' => 'site/register',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			),
		),

		'db' => require(dirname(__FILE__) . '/database.php'),

		'errorHandler' => array(
			'errorAction' => YII_DEBUG ? null : 'site/error',
		),

		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning, info',
				),
			),
		),
	),

	'params' => array(
		'smsPilotApiKey' => 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ',
	),
);
