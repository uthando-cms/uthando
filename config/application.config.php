<?php

return [
    'modules' => [
        'Application',
        'UthandoCommon',
        'UthandoUser',
        'AssetManager',
        'UthandoAdmin',
        'UthandoSessionManager',
        'UthandoThemeManager',
        'UthandoArticle',
        'UthandoNavigation',
        'UthandoContact',
        'UthandoFileManager',
        'UthandoMail',
        'TwbBundle',
    ],
    'module_listener_options' => [
        'module_paths' => [
            './vendor',
            './devmodules',
            './module',
        ],
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,local}.php'
        ],
        'config_cache_enabled' => false,
        'config_cache_key' => 'config_cache',
        'module_map_cache_enabled' => false,
        'module_map_cache_key' => 'module_map_cache',
        'cache_dir' => './data/cache',
        'check_dependencies' => false
    ],
    'service_manager' => [
        'invokables' => [
            'ModuleRouteListener' => 'Zend\Mvc\ModuleRouteListener',
        ],
        'factories' => [
            'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ],
    ],
];