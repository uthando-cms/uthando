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
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use Ramsey\Uuid\Doctrine\UuidType;
use Zend\Authentication\AuthenticationService;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\Validator\HttpUserAgent;
use Zend\Session\Validator\RemoteAddr;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'controllers'       => $this->getControllerConfig(),
            'doctrine'          => $this->getDoctrineConfig(),
            'filters'           => $this->getFilterConfig(),
            'form_elements'     => $this->getFormElementConfig(),
            'navigation'        => $this->getNavigationConfig(),
            'router'            => $this->getRouteConfig(),
            'service_manager'   => $this->getServiceManagerConfig(),
            'session_config'    => $this->getSessionConfig(),
            'session_manager'   => $this->getSessionManagerConfig(),
            'session_storage'   => $this->getSessionStorageConfig(),
            'validators'        => $this->getValidatorConfig(),
            'view_helpers'      => $this->getViewHelperConfig(),
            'view_manager'      => $this->getViewManagerConfig(),
            'uthando'           => $this->getUthandoConfig(),
        ];
    }

    public function getDoctrineConfig(): array
    {
        return [
            'authentication' => [
                'orm_default' => [
                    'object_manager'        => EntityManager::class,
                    'identity_class'        => User\Entity\UserEntity::class,
                    'identity_property'     => 'email',
                    'credential_property'   => 'password',
                    'credential_callable'   => 'Uthando\User\Service\UserManager::verifyCredential',
                ],
            ],
            'configuration' => [
                'orm_default' => [
                    'query_cache'       => 'filesystem',
                    'result_cache'      => 'filesystem',
                    'metadata_cache'    => 'filesystem',
                    'hydration_cache'   => 'filesystem',
                    'second_level_cache' => [
                        'enabled'               => true,
                        'default_lifetime'      => 0,
                        'default_lock_lifetime' => 0,
                        'file_lock_region_directory' => './data/cache/doctrine',
                        'regions' => [
                            'uthando' => [
                                'lifetime'      => 0,
                                'lock_lifetime' => 0,
                            ],
                        ],
                    ],
                    'types' => [
                        Core\Doctine\Types\W3cDateTimeType::NAME    => Core\Doctine\Types\W3cDateTimeType::class,
                        UuidType::NAME                              => UuidType::class
                    ],
                ],
            ],
            'driver' => [
                __NAMESPACE__ . '_driver' => [
                    'class' => AnnotationDriver::class,
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

    public function getControllerConfig(): array
    {
        return [
            'factories' => [
                Admin\Controller\AdminController::class     => InvokableFactory::class,
                Blog\Controller\PostAdminController::class  => Blog\Controller\Factory\PostAdminControllerFactory::class,
                Blog\Controller\PostController::class       => Blog\Controller\Factory\PostControllerFactory::class,
                Core\Controller\CaptchaController::class    => Core\Controller\Factory\CaptchaControllerFactory::class,
                User\Controller\UserAdminController::class  => User\Controller\Factory\UserAdminControllerFactory::class,
                User\Controller\AuthController::class       => User\Controller\Factory\AuthControllerFactory::class,
                User\Controller\UserController::class       => User\Controller\Factory\UserControllerFactory::class,
            ],
        ];
    }

    public function getSessionConfig(): array
    {
        return [
            // Session cookie will expire in 1 hour.
            'cookie_lifetime'   => 60*60*1,
            // Session data will be stored on server maximum for 30 days.
            'gc_maxlifetime'    => 60*60*24*30,
            'save_path'         => './data/sessions',
        ];
    }

    public function getSessionManagerConfig(): array
    {
        return [
            'validators' => [
                RemoteAddr::class,
                HttpUserAgent::class,
            ],
        ];
    }

    public function getSessionStorageConfig(): array
    {
        return [
            'type' => SessionArrayStorage::class,
        ];
    }

    public function getServiceManagerConfig(): array
    {
        return [
            'aliases' => [
                AuthenticationService::class    => 'doctrine.authenticationservice.orm_default',
                'doctrine.cache.filesystem'     => Core\Doctine\Cache\FilesystemFactory::class,
            ],
            'factories' => [
                AnnotationBuilder::class                                => Core\Doctine\Annotation\FormAnnotationBuilderFactory::class,
                Admin\Service\Factory\NavigationFactory::class          => Admin\Service\Factory\NavigationFactory::class,
                Admin\Service\Factory\NavigationDashboardFactory::class => Admin\Service\Factory\NavigationDashboardFactory::class,
                Core\Doctine\Cache\FilesystemFactory::class             => Core\Doctine\Cache\FilesystemFactory::class,
                Blog\Service\PostManager::class                         => Blog\Service\Factory\PostManagerFactory::class,
                User\Service\AuthenticationManager::class               => User\Service\Factory\AuthenticationManagerFactory::class,
                User\Service\UserManager::class                         => User\Service\Factory\UserManagerFactory::class,
                User\Service\Factory\UserNavigationFactory::class       => User\Service\Factory\UserNavigationFactory::class,
            ],
        ];
    }

    public function getFormElementConfig(): array
    {
        return [
            'aliases' => [
                'CoreCaptcha' => Core\Form\Element\Captcha::class,
                'corecaptcha' => Core\Form\Element\Captcha::class,
            ],
            'factories' => [
                Core\Form\Element\Captcha::class   => Core\Form\Element\Factory\CaptchaFactory::class,
            ],
        ];
    }

    public function getFilterConfig(): array
    {
        return [
            'aliases' => [
                'Seo' => Core\Filter\Seo::class,
                'seo' => Core\Filter\Seo::class,
            ],
            'factories' => [
                Core\Filter\Seo::class => InvokableFactory::class,
            ],
        ];
    }

    public function getValidatorConfig(): array
    {
        return [
            'aliases' => [
                'CoreNoObjectExists' => Core\Validator\NoObjectExists::class,
            ],
            'factories' => [
                Core\Validator\NoObjectExists::class => Core\Validator\Factory\NoObjectExistsFactory::class,
            ],
        ];
    }

    public function getViewHelperConfig():array
    {
        return [
            'aliases' => [
                'commentCount'              => Blog\View\Helper\CommentCount::class,
                'navigation'                => Core\View\Helper\Navigation::class,
                'Navigation'                => Core\View\Helper\Navigation::class,
                'tagHelper'                 => Blog\View\Helper\TagHelper::class,
                'zendviewhelpernavigation'  => Core\View\NavigationHelperFactory::class,
            ],
            'factories' => [
                Blog\View\Helper\CommentCount::class        => InvokableFactory::class,
                Blog\View\Helper\TagHelper::class           => InvokableFactory::class,
                Core\View\Helper\Navigation::class          => Core\View\NavigationHelperFactory::class,
                Core\View\NavigationHelperFactory::class    => Core\View\NavigationHelperFactory::class,
            ],
        ];
    }

    public function getViewManagerConfig(): array
    {
        return [
            'display_not_found_reason'  => false,
            'display_exceptions'        => false,
            'doctype'                   => 'HTML5',
            'not_found_template'        => 'error/404',
            'exception_template'        => 'error/post',
            'template_map' => [
                'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
                'error/404'     => __DIR__ . '/../view/error/404.phtml',
                'error/post'    => __DIR__ . '/../view/error/index.phtml',
            ],
            'template_path_stack' => [
                __DIR__ . '/../view',
            ],
        ];
    }

    public function getNavigationConfig(): array
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

    public function getRouteConfig(): array
    {
        return [
            'routes' => [
                'home' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => '/',
                        'defaults' => [
                            'controller' => Blog\Controller\PostController::class,
                            'action' => 'index',
                        ],
                    ],
                ],
                'blog' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => '/blog',
                        'defaults' => [
                            'controller' => Blog\Controller\PostController::class,
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
                                    'controller' => Blog\Controller\PostController::class,
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
                                    'controller' => Blog\Controller\PostController::class,
                                    'action' => 'view',
                                ],
                            ],
                        ],
                    ],
                ],
                'captcha-form-generate' => [
                    'type' => Segment::class,
                    'options' => [
                        'route' => '/captcha/[:id]',
                        'defaults' => [
                            'controller'    => Core\Controller\CaptchaController::class,
                            'action'        => 'generate',
                        ],
                    ],
                ],
                'reset-password' => [
                    'type' => Literal::class,
                    'options' => [
                        'route'    => '/reset-password',
                        'defaults' => [
                            'controller' => User\Controller\UserController::class,
                            'action'     => 'reset-password',
                        ],
                    ],
                ],
                'login' => [
                    'type' => Literal::class,
                    'options' => [
                        'route'    => '/login',
                        'defaults' => [
                            'controller' => User\Controller\AuthController::class,
                            'action'     => 'login',
                        ],
                    ],
                ],
                'logout' => [
                    'type' => Literal::class,
                    'options' => [
                        'route'    => '/logout',
                        'defaults' => [
                            'controller' => User\Controller\AuthController::class,
                            'action'     => 'logout',
                        ],
                    ],
                ],
                'user' => [
                    'type' => Literal::class,
                    'options' => [
                        'route' => '/user',
                        'defaults' => [
                            'controller' => User\Controller\UserController::class,
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
                                    'controller' => User\Controller\UserController::class,
                                    'action'     => 'index',
                                ],
                            ],
                        ],
                        'set-password' => [
                            'type' => Literal::class,
                            'options' => [
                                'route'    => '/set-password',
                                'defaults' => [
                                    'controller' => User\Controller\UserController::class,
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
                            'controller'    => Admin\Controller\AdminController::class,
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
                                    'controller'    => Blog\Controller\PostAdminController::class,
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
                                    'controller'    => User\Controller\UserAdminController::class,
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

    public function getUthandoConfig(): array
    {
        return [
            'uthando_core' => [
                'captcha' => [
                    'class' => 'Image',
                    'options' => [
                        'imgDir' => './data/captcha',
                        'fontDir' => './data/fonts',
                        'font' => 'thorne_shaded.ttf',
                        'imgAlt' => 'CAPTCHA Image',
                        'suffix' => '.png',
                        'fsize' => 24,
                        'width' => 350,
                        'height' => 100,
                        'expiration' => 600,
                        'dotNoiseLevel' => 40,
                        'lineNoiseLevel' => 3
                    ],
                ],
            ],
        ];
    }
}