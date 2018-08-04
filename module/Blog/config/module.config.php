<?php

namespace Blog;


use Blog\Service\Factory\PostManagerFactory;
use Blog\Service\PostManager;
use Blog\View\Helper\CommentCount;
use Blog\View\Helper\TagHelper;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineORMModule\Service\FormAnnotationBuilderFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'blog' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/blog',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'list' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '[/tag/:tag][/][page/:page]',
                            'constraints' => [
                                'page' => '\d+',
                                'tag'   => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                                'action' => 'index',
                                'tag'   => '',
                                'page' => 1,
                            ],
                        ],
                    ],
                    'post' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/:id',
                            'constraints' => [
                                'id' => '[a-z0-9][a-z0-9-]*'
                            ],
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                                'action' => 'view',
                            ],
                        ],
                    ],
                ],
            ],

            'admin' => [
                'child_routes' => [
                    'post' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/posts[/page/:page][/:action[/:id]]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-z0-9][a-z0-9-]*',
                                'page' => '\d+',
                            ],
                            'defaults' => [
                                'controller'    => Controller\PostController::class,
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
            Controller\IndexController::class   => Controller\Factory\IndexControllerFactory::class,
            Controller\PostController::class    => Controller\Factory\PostControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            PostManager::class          => PostManagerFactory::class,
            AnnotationBuilder::class    => FormAnnotationBuilderFactory::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'commentCount'  => CommentCount::class,
            'tagHelper'     => TagHelper::class,
        ],
        'factories' => [
            CommentCount::class => InvokableFactory::class,
            TagHelper::class    => InvokableFactory::class
        ],
    ],
    'navigation' => [
        'default' => [
            'home' => [
                'label' => 'Home',
                'route' => 'home'
            ],
            'blog' => [
                'label' => 'Blog',
                'route' => 'blog/list',
                'action' => 'index',
            ],
            'admin' => [
                'pages' => [
                    'post' => [
                        'label' => 'Posts',
                        'route' => 'admin/post',
                        'action' => 'index',

                    ],
                ],
            ],
        ],
        'admin' => [
            'admin' => [
                'pages' => [
                    'post' => [
                        'label' => 'Posts',
                        'route' => 'admin/post',
                        'pages' => [
                            'add-post' => [
                                'label' => 'New Post',
                                'route' => 'admin/post',
                                'action' => 'add',
                            ],
                            'edit-post' => [
                                'label' => 'Edit Post',
                                'route' => 'admin/post',
                                'action' => 'edit',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'dashboard' => [
            'post' => [
                'label' => 'Posts',
                'route' => 'admin/post',
                'pages' => [
                    'list-post' => [
                        'label' => 'List Posts',
                        'route' => 'admin/post',
                        'action' => 'index',
                    ],
                    'add-post' => [
                        'label' => 'New Post',
                        'route' => 'admin/post',
                        'action' => 'add',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'display_not_found_reason'  => true,
        'display_exceptions'        => true,
        'doctype'                   => 'HTML5',
        'not_found_template'        => 'error/404',
        'exception_template'        => 'error/index',
        'template_map' => [
            'layout/layout'             => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'                 => __DIR__ . '/../view/error/404.phtml',
            'error/index'               => __DIR__ . '/../view/error/index.phtml',
        ],
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
