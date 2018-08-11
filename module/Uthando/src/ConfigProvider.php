<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Ramsey\Uuid\Doctrine\UuidType;
use Uthando\Admin\Controller\AdminController;
use Uthando\Admin\Service\Factory\NavigationDashboardFactory;
use Uthando\Admin\Service\Factory\NavigationFactory;
use Uthando\Blog\Controller\Factory\PostAdminControllerFactory;
use Uthando\Blog\Controller\Factory\PostControllerFactory;
use Uthando\Blog\Controller\PostAdminController;
use Uthando\Blog\Controller\PostController;
use Uthando\Blog\Service\Factory\PostManagerFactory;
use Uthando\Blog\Service\PostManager;
use Uthando\Blog\View\Helper\CommentCount;
use Uthando\Blog\View\Helper\TagHelper;
use Uthando\Core\Doctine\Types\W3cDateTimeType;
use Uthando\User\Controller\AuthController;
use Uthando\User\Controller\Factory\AuthControllerFactory;
use Uthando\User\Controller\Factory\UserAdminControllerFactory;
use Uthando\User\Controller\Factory\UserControllerFactory;
use Uthando\User\Controller\UserAdminController;
use Uthando\User\Controller\UserController;
use Uthando\User\Entity\UserEntity;
use Uthando\User\Service\AuthenticationManager;
use Uthando\User\Service\Factory\AuthenticationManagerFactory;
use Uthando\User\Service\Factory\UserManagerFactory;
use Uthando\User\Service\Factory\UserNavigationFactory;
use Uthando\User\Service\UserManager;
use Zend\Authentication\AuthenticationService;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'controllers'  => $this->getControllerConfig(),
            'dependencies' => $this->getDependencyConfig(),
            'doctrine'     => $this->getDoctrineConfig(),
            'navigation'   => $this->getNavigationConfig(),
            'router'       => $this->getRouteConfig(),
            'view_helpers' => $this->getViewHelperConfig(),
        ];
    }

    public function getDoctrineConfig()
    {
        return [
            'authentication' => [
                'orm_default' => [
                    'object_manager'        => EntityManager::class,
                    'identity_class'        => UserEntity::class,
                    'identity_property'     => 'email',
                    'credential_property'   => 'password',
                    'credential_callable'   => 'Uthando\User\Service\UserManager::verifyCredential',
                ],
            ],
            'configuration' => [
                'orm_default' => [
                    'types' => [
                        UuidType::NAME          => UuidType::class,
                        W3cDateTimeType::NAME   => W3cDateTimeType::class,
                    ],
                ],
            ],
            'driver' => [
                __NAMESPACE__ . '_driver' => [
                    'class' => AnnotationDriver::class,
                    'cache' => 'array',
                    'paths' => [
                        __DIR__ . '/Blog/Entity',
                        __DIR__ . '/User/Entity',
                    ],
                ],
                'orm_default' => [
                    'drivers' => [
                        __NAMESPACE__ . '\Blog\Entity' => __NAMESPACE__ . '_driver',
                        __NAMESPACE__ . '\User\Entity' => __NAMESPACE__ . '_driver',
                    ],
                ],
            ],
            'migrations_configuration' => [
                'orm_default' => [
                    'directory' => 'data/Migrations',
                    'name'      => 'Doctrine Database Migrations',
                    'namespace' => 'Migrations',
                    'table'     => 'migrations',
                ],
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                AdminController::class      => InvokableFactory::class,
                AuthController::class       => AuthControllerFactory::class,
                PostController::class       => PostControllerFactory::class,
                PostAdminController::class  => PostAdminControllerFactory::class,
                UserAdminController::class  => UserAdminControllerFactory::class,
                UserController::class       => UserControllerFactory::class,
            ],
        ];
    }

    public function getDependencyConfig()
    {
        return [
            'aliases' => [
                AuthenticationService::class => 'doctrine.authenticationservice.orm_default',
            ],
            'factories' => [
                AuthenticationManagerFactory::class => AuthenticationManager::class,
                NavigationFactory::class            => NavigationFactory::class,
                NavigationDashboardFactory::class   => NavigationDashboardFactory::class,
                PostManager::class                  => PostManagerFactory::class,
                UserManager::class                  => UserManagerFactory::class,
                UserNavigationFactory::class        => UserNavigationFactory::class,
            ],
        ];
    }

    public function getNavigationConfig()
    {
        return [
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
                    'label' => 'Admin',
                    'uri' => '#',
                    'pages' => [
                        'admin' => [
                            'label' => 'Dashboard',
                            'route' => 'admin',
                            'action' => 'index',

                        ],
                        'post-admin' => [
                            'label' => 'Posts',
                            'route' => 'admin/post-admin',
                            'action' => 'index',

                        ],
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
                    'label' => 'Admin',
                    'route' => 'admin',
                    'action' => 'index',
                    'pages' => [
                        'dashboard' => [
                            'label' => 'Dashboard',
                            'route' => 'admin',
                            'action' => 'index',

                        ],
                        'post-admin' => [
                            'label' => 'Posts',
                            'route' => 'admin/post-admin',
                            'pages' => [
                                'add-post-admin' => [
                                    'label' => 'New Post',
                                    'route' => 'admin/post-admin',
                                    'action' => 'add',
                                ],
                                'edit-post-admin' => [
                                    'label' => 'Edit Post',
                                    'route' => 'admin/post-admin',
                                    'action' => 'edit',
                                ],
                            ],
                        ],
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
                'post-admin' => [
                    'label' => 'Manage Posts',
                    'route' => 'admin/post-admin',
                    'pages' => [
                        'list-post-admin' => [
                            'label' => 'List Posts',
                            'route' => 'admin/post-admin',
                            'action' => 'index',
                        ],
                        'add-post-admin' => [
                            'label' => 'New Post',
                            'route' => 'admin/post-admin',
                            'action' => 'add',
                        ],
                    ],
                ],
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
            'user' => [
                'user-setiings' => [
                    'label' => 'Settings',
                    'route' => 'user',
                    'pages' => [
                        'view-profile' => [
                            'label' => 'Profile',
                            'route' => 'user/view',
                        ],
                        'set-password' => [
                            'label' => 'Change Password',
                            'route' => 'user/set-password',
                        ],
                    ],
                ],
            ],
        ];
    }

    public function getRouteConfig()
    {
        return [
            'routes' => [
                'home' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => '/',
                        'defaults' => [
                            'controller' => PostController::class,
                            'action' => 'index',
                        ],
                    ],
                ],
                'blog' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => '/blog',
                        'defaults' => [
                            'controller' => PostController::class,
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
                                    'controller' => PostController::class,
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
                                    'controller' => PostController::class,
                                    'action' => 'view',
                                ],
                            ],
                        ],
                    ],
                ],
                'reset-password' => [
                    'type' => Literal::class,
                    'options' => [
                        'route'    => '/reset-password',
                        'defaults' => [
                            'controller' => UserController::class,
                            'action'     => 'reset-password',
                        ],
                    ],
                ],
                'login' => [
                    'type' => Literal::class,
                    'options' => [
                        'route'    => '/login',
                        'defaults' => [
                            'controller' => AuthController::class,
                            'action'     => 'login',
                        ],
                    ],
                ],
                'logout' => [
                    'type' => Literal::class,
                    'options' => [
                        'route'    => '/logout',
                        'defaults' => [
                            'controller' => AuthController::class,
                            'action'     => 'logout',
                        ],
                    ],
                ],
                'user' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => '/user',
                        'defaults' => [
                            'controller' => UserController::class,
                            'action' => 'index',
                        ],
                    ],
                    'may_terminate' => true,
                    'child_routes' => [
                        'view' => [
                            'type' => Literal::class,
                            'options' => [
                                'route'    => '/view',
                                'defaults' => [
                                    'controller' => UserController::class,
                                    'action'     => 'index',
                                ],
                            ],
                        ],
                        'set-password' => [
                            'type' => Literal::class,
                            'options' => [
                                'route'    => '/set-password',
                                'defaults' => [
                                    'controller' => UserController::class,
                                    'action'     => 'set-password',
                                ],
                            ],
                        ],
                    ],
                ],
                'admin' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => '/admin',
                        'defaults' => [
                            'controller'    => AdminController::class,
                            'action'        => 'index',
                        ],
                    ],
                    'may_terminate' => true,
                    'child_routes' => [
                        'post-admin' => [
                            'type' => Segment::class,
                            'options' => [
                                'route' => '/posts[/page/:page][/:action[/:id]]',
                                'constraints' => [
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'id' => '[a-z0-9][a-z0-9-]*',
                                    'page' => '\d+',
                                ],
                                'defaults' => [
                                    'controller'    => PostAdminController::class,
                                    'action'        => 'index',
                                    'page'          => 1,
                                ],
                            ],
                        ],
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
                                    'controller'    => UserAdminController::class,
                                    'action'        => 'index',
                                    'page'          => 1,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function getViewHelperConfig()
    {
        return [
            'aliases' => [
                'commentCount'  => CommentCount::class,
                'tagHelper'     => TagHelper::class,
            ],
            'factories' => [
                CommentCount::class => InvokableFactory::class,
                TagHelper::class    => InvokableFactory::class
            ],
        ];
    }
}