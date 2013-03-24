<?php
return array(


	/**
	 * Database configuration variables
	 * @see http://www.php.net/manual/en/pdo.construct.php
	 */
	'database_music' => array(
		'dns' => "mysql:host=127.0.0.1;dbname=music",
		'username' => 'root',
		'password' => '',
		'driver_options' => array(
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
		)
	),

	/**
	 * Controllers
	 */
	'controllers' => array(
		'invokables' => array(
			'Music\Controller\Index' => 'Music\Controller\IndexController',
		),
	),

	'router' => array(
		'routes' => array(

			/**
			 * ROOT
			 */
			'music-home' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/music',
					'defaults' => array(
						'controller' => 'Music\Controller\Index',
						'action' => 'index'
					)
				),
			),
			/**
			 *
			 */
			'music-profile' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/music/:name[/:type]',
					'constraints' => array(
						'type' => '(songs|albums|both)',
					),
					'defaults' => array(
						'controller' => 'Music\Controller\Index',
						'action' => 'profile'
					)
				),
			),
			/**
			 *
			 */
			'music-time-range' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/music/:from[/:to]',
					'constraints' => array(
						'from' => '[0-9]{4}',
						'to' => '[0-9]{4}',
					),
					'defaults' => array(
						'controller' => 'Music\Controller\Index',
						'action' => 'time-range'
					)
				),
			),
		),
	),


	'view_manager' => array(
		'template_path_stack' => array(
			'music' => __DIR__ . '/../view',
		),
		'strategies' => array(
			'ViewJsonStrategy',
		),
	),

);