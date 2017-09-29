<?php

return [
    'asset_manager' => [
        'resolver_configs' => [
            'collections' => [
                'js/uthando.js' => [
                    'js/prettify.js',
                    'js/site.js',
                ],
                'css/uthando.css' => [
                    'css/prettify.css',
                    'css/uthando-styles.css',
                    'css/print.css',
                ],
            ],
            'map' => [
                'css/prettify.css' => 'https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.css',
                'js/prettify.js' => 'https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.js',
            ],
            'paths' => [
                'Application' => __DIR__ . '/../public',
            ],
        ],
    ],
    'uthando_user' => [
        'acl' => [
            'roles' => [
                'guest' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                'Application\Controller\Index' => ['action' => ['index']],
                            ],
                        ]
                    ],
                ],
                'registered' => [
                    'privileges' => [
                        'allow' => [
                            'controllers' => [
                                'Application\Controller\Index' => ['action' => ['index']],
                            ],
                        ],
                    ],
                ],
            ],
            'resources' => [
                'Application\Controller\Index',
            ],
        ],
    ],
    'router'    => [
        'routes' => [
            'home' => [
                'type'      => 'Literal',
                'options'   => [
                    'route'     => '/',
                    'defaults'  => [
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                        'force-ssl'     => 'http'
                    ],
                ],
            ],
        ],
    ],
    'navigation' => [
        'default' => [
            'home' => [
                'label' => 'Home',
                'route' => 'home'
            ],
        ],
    ],
    'view_manager'  => [
        'display_not_found_reason'  => true,
        'display_exceptions'        => true,
        'doctype'                   => 'HTML5',
        'not_found_template'        => 'error/404',
        'exception_template'        => 'error/index',
        'template_map'              => include __DIR__ . '/../template_map.php'
    ],
];
