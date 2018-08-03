<?php

namespace Blog;


use Blog\Service\Factory\NavigationFactory;
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
                'type' => Segment::class,
                'options' => [
                    'route' => '/[tag/:tag/][page/:page]',
                    'constraints' => [
                        'page' => '\d+',
                        'tag'   => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                        'tag'   => '',
                        'page' => 1
                    ],
                ],
            ],
            'blog' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/blog[/tag/:tag][/][page/:page]',
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
            'admin' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin',
                    'defaults' => [
                        'controller'    => Controller\PostController::class,
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
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
            NavigationFactory::class    => NavigationFactory::class,
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
            [
                'label' => 'Home',
                'route' => 'home'
            ],
            [
                'label' => 'Blog',
                'route' => 'blog',
                'pages' => [
                    [
                        'label'     => 'Posts',
                        'route'     => 'blog/post',
                        'visible'   => false,
                    ],
                    [
                        'label'     => 'Posts',
                        'route'     => 'blog/tag-cloud',
                        'visible'   => false,
                    ],
                ],
            ],
            [
                'label' => 'Admin',
                'route' => 'admin/post',
            ],
        ],
        'admin' => [
            [
                'label' => 'Admin',
                'route' => 'admin/post',
                'pages' => [
                    [
                        'label' => 'Posts',
                        'route' => 'admin/post',
                        'pages' => [
                            [
                                'label' => 'New Post',
                                'route' => 'admin/post',
                                'action' => 'add',
                            ],
                            [
                                'label' => 'Edit Post',
                                'route' => 'admin/post',
                                'action' => 'edit',
                            ],
                        ],
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
            'application/index/index'   => __DIR__ . '/../view/application/index/index.phtml',
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
