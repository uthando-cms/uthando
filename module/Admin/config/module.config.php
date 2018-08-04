<?php

namespace Admin;

use Admin\Service\Factory\NavigationDashboardFactory;
use Admin\Service\Factory\NavigationFactory;
use Zend\Router\Http\Literal;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'admin' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin',
                    'defaults' => [
                        'controller'    => Controller\AdminController::class,
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AdminController::class   => InvokableFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            NavigationFactory::class            => NavigationFactory::class,
            NavigationDashboardFactory::class   => NavigationDashboardFactory::class,
        ],
    ],
    'navigation' => [
        'default' => [
            'admin' => [
                'label' => 'Admin',
                'uri' => '#',
                'pages' => [
                    'admin' => [
                        'label' => 'Dashboard',
                        'route' => 'admin',
                        'action' => 'index',

                    ],
                ],
            ],
        ],
        'admin' => [
            'admin' => [
                'label' => 'Admin',
                'route' => 'admin',
                'action' => 'index',
                'pages' => [
                    'dashboard' => [
                        'label' => 'Dashboard',
                        'route' => 'admin',
                        'action' => 'index',

                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];

