<?php

return [
	'session' => [
		'config' => [
			'class' => 'Zend\Session\Config\SessionConfig',
			'options' => [
				'name'          => 'uthando-cms',
				'save_handler'  => 'files',
				'save_path'     => APPLICATION_PATH . '/data/sessions',
			],
		],
		'storage' => 'Zend\Session\Storage\SessionArrayStorage',
		'validators' => [
			'Zend\Session\Validator\RemoteAddr',
			'Zend\Session\Validator\HttpUserAgent',
		],
	],
	'php_settings' => [
		'display_startup_errors'  => false,
		'display_errors'          => true,
		'error_reporting'         => E_ALL,
		'max_execution_time'      => 60,
		'date.timezone'           => 'Europe/London',
	],
];
