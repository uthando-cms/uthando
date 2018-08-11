<?php declare(strict_types=1);

use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\Validator\HttpUserAgent;
use Zend\Session\Validator\RemoteAddr;

return [
    // Session configuration.
    'session_config' => [
        // Session cookie will expire in 1 hour.
        'cookie_lifetime'   => 60*60*1,
        // Session data will be stored on server maximum for 30 days.
        'gc_maxlifetime'    => 60*60*24*30,
        'save_path'         => './data/sessions'
    ],
    // Session manager configuration.
    'session_manager' => [
        // Session validators (used for security).
        'validators' => [
            RemoteAddr::class,
            HttpUserAgent::class,
        ]
    ],
    // Session storage configuration.
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ],
    'controllers' => [
        'factories' => [
            \Uthando\Core\Controller\CaptchaController::class => \Uthando\Core\Controller\Factory\CaptchaControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            'doctrine.cache.filesystem' => \Uthando\Core\Doctine\Cache\FilesystemFactory::class,
            \DoctrineORMModule\Form\Annotation\AnnotationBuilder::class => \Uthando\Core\Doctine\Annotation\FormAnnotationBuilderFactory::class,
        ],
    ],
    'form_elements' => [
        'aliases' => [
            'CoreCaptcha' => \Uthando\Core\Form\Element\Captcha::class,
            'corecaptcha' => \Uthando\Core\Form\Element\Captcha::class,
        ],
        'factories' => [
            \Uthando\Core\Form\Element\Captcha::class   => \Uthando\Core\Form\Element\Factory\CaptchaFactory::class,
        ],
    ],
    'filters' => [
        'aliases' => [
            'Seo' => \Uthando\Core\Filter\Seo::class,
            'seo' => \Uthando\Core\Filter\Seo::class,
        ],
        'factories' => [
            \Uthando\Core\Filter\Seo::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
    ],
    'validators' => [
        'aliases' => [
            'CoreNoObjectExists' => \Uthando\Core\Validator\NoObjectExists::class,
        ],
        'factories' => [
            \Uthando\Core\Validator\NoObjectExists::class => \Uthando\Core\Validator\Factory\NoObjectExistsFactory::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'navigation'    => \Uthando\Core\View\Helper\Navigation::class,
            'Navigation'    => \Uthando\Core\View\Helper\Navigation::class,
        ],
        'factories' => [
            \Uthando\Core\View\Helper\Navigation::class => \Uthando\Core\View\NavigationHelperFactory::class,
            'zendviewhelpernavigation'          => \Uthando\Core\View\NavigationHelperFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason'  => true,
        'display_exceptions'        => true,
        'doctype'                   => 'HTML5',
        'not_found_template'        => 'error/404',
        'exception_template'        => 'error/post',
        'template_map' => [
            'layout/layout' => './module/Uthando/view/layout/layout.phtml',
            'error/404'     => './module/Uthando/view/error/404.phtml',
            'error/post'    => './module/Uthando/view/error/index.phtml',
        ],
        'template_path_stack' => [
            './module/Uthando/view',
        ],
    ],
    'router' => [
        'routes' => [
            'captcha-form-generate' => [
                'type' => \Zend\Router\Http\Segment::class,
                'options' => [
                    'route' => '/captcha/[:id]',
                    'defaults' => [
                        'controller'    => \Uthando\Core\Controller\CaptchaController::class,
                        'action'        => 'generate',
                    ],
                ],
            ],
        ],
    ],
];
