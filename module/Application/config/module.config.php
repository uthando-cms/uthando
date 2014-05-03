<?php

return [
    'userAcl' => [
        'userRoles' => [
            'guest' => [
                'privileges' => [
                    'allow' => [
                        ['controller' => 'Application\Controller\Index', 'action' => ['index']],
                    ]
                ],
            ],
            'registered' => [
                'privileges' => [
                    'allow' => [
                        ['controller' => 'Application\Controller\Index', 'action' => ['index']],
                    ],
                ],
            ],
        ],
        'userResources' => [
            'Application\Controller\Index',
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
