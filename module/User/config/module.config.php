<?php

namespace User;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use User\Controller\UserAdminController;
use User\Controller\UserController;
use User\Service\Factory\UserManagerFactory;
use User\Service\UserManager;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'user' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/user',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                ],
            ],

            'admin' => [
                'child_routes' => [
                    'user-admin' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/users[/page/:page][/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-z0-9][a-z0-9-]*',
                                'page' => '\d+',
                            ],
                            'defaults' => [
                                'controller'    => Controller\UserAdminController::class,
                                'action'        => 'index',
                                'page'          => 1,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            UserAdminController::class  => Controller\Factory\UserAdminControllerFactory::class,
            UserController::class       => Controller\Factory\UserControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            UserManager::class => UserManagerFactory::class,
        ],
    ],
    'navigation' => [
        'default' => [
            'admin' => [
                'pages' => [
                    'user-admin' => [
                        'label' => 'Users',
                        'route' => 'admin/user-admin',
                        'action' => 'index',

                    ],
                ],
            ],
        ],
        'admin' => [
            'admin' => [
                'pages' => [
                    'user-admin' => [
                        'label' => 'Users',
                        'route' => 'admin/user-admin',
                        'pages' => [
                            'add-user-admin' => [
                                'label' => 'New User',
                                'route' => 'admin/user-admin',
                                'action' => 'add',
                            ],
                            'edit-user-admin' => [
                                'label' => 'Edit User',
                                'route' => 'admin/user-admin',
                                'action' => 'edit',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'dashboard' => [
            'user-admin' => [
                'label' => 'Manage Users',
                'route' => 'admin/user-admin',
                'pages' => [
                    'list-user-admin' => [
                        'label' => 'List Users',
                        'route' => 'admin/user-admin',
                        'action' => 'index',
                    ],
                    'add-user-admin' => [
                        'label' => 'New User',
                        'route' => 'admin/user-admin',
                        'action' => 'add',
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
    // Doctrine config
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity'],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],
];

