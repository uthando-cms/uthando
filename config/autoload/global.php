<?php

return [
    'db' => [
        'driver'            => 'PDO_SQLITE',
        'database'          => './data/sample.db',
        'sqlite_contraints' => true,
    ],
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
	'cache' => [
	   'adapter' => [
            'name' => 'filesystem',
            'options' => [
                'ttl' => 60*60, // one hour
                'dirLevel' => 0,
                'cacheDir' => 'data/cache/db',
                'dirPermission' => 0700,
                'filePermission' => 0600,
                'namespaceSeparator' => '-db-'
            ],
        ],
        'plugins' => ['Serializer'],
    ],
	'php_settings' => [
		'display_startup_errors'  => false,
		'display_errors'          => true,
		'error_reporting'         => E_ALL,
		'max_execution_time'      => 60,
		'date.timezone'           => 'Europe/London',
	],
];
