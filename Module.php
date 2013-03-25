<?php

namespace Music;

use PDO;
use Music\Model\Music;

class Module{
	public function getAutoloaderConfig(){
		return array('Zend\Loader\StandardAutoloader' => array('namespaces' => array(
			__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
		)));
	}

	public function getConfig(){
		return include __DIR__ . '/config/module.config.php';
	}

	public function getServiceConfig(){
		return array(
			'factories' => array(
				'Music\Service\Music' => function($sm){
					$config = $sm->get('config');
					$pdo = new PDO(
						$config['database_music']['dns'],
						$config['database_music']['username'],
						$config['database_music']['password'],
						$config['database_music']['driver_options']
					);
					$service = new \Music\Service\Music($pdo);
					return $service;
				},
			)
		);
	}    	
}