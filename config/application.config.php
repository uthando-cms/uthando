<?php

return [
	'modules' => [
		'Application',
		'UthandoCommon',
		'UthandoAdmin',
		'UthandoSessionManager',
		'UthandoThemeManager',
		'UthandoArticle',
		'UthandoNavigation',
		'UthandoUser',
		'UthandoContact',
	],
	'module_listener_options' => [
		'module_paths' => [
			'./module',
			'./devmodules',
			'./vendor',
		],
		'config_glob_paths' => [
			'config/autoload/{,*.}{global,local}.php',
		],
		'config_cache_enabled' => false,
		'config_cache_key' => 'config_cache',
		'module_map_cache_enabled' => false,
		'module_map_cache_key' => 'module_map_cache',
		'cache_dir' => './data/cache',
		'check_dependencies' => false,
	],
	'service_manager' => [
        'factories' => [
            //'Zend\Db\Adapter\Adapter'   => 'Zend\Db\Adapter\AdapterServiceFactory',
            'Navigation'                => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ],
	],
];