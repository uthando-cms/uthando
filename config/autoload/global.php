<?php declare(strict_types=1);

use Core\Doctine\Types\W3cDateTimeType;
use Ramsey\Uuid\Doctrine\UuidType;

return [
    'doctrine' => [
        'migrations_configuration' => [
            'orm_default' => [
                'directory' => 'data/Migrations',
                'name'      => 'Doctrine Database Migrations',
                'namespace' => 'Migrations',
                'table'     => 'migrations',
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
    ],
    'controllers' => [
        'factories' => [
            \Core\Controller\CaptchaController::class => \Core\Controller\Factory\CaptchaControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            'doctrine.cache.filesystem' => \Core\Doctine\Cache\FilesystemFactory::class,
            \DoctrineORMModule\Form\Annotation\AnnotationBuilder::class => \Core\Doctine\Annotation\FormAnnotationBuilderFactory::class
        ],
    ],
    'form_elements' => [
        'aliases' => [
            'CoreCaptcha' => \Core\Form\Element\Captcha::class,
            'corecaptcha' => \Core\Form\Element\Captcha::class,
        ],
        'factories' => [
            \Core\Form\Element\Captcha::class   => \Core\Form\Element\Factory\CaptchaFactory::class,
        ],
    ],
    'filters' => [
        'aliases' => [
            'Seo' => \Core\Filter\Seo::class,
            'seo' => \Core\Filter\Seo::class,
        ],
        'factories' => [
            \Core\Filter\Seo::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
    ],
    'validators' => [
        'aliases' => [
            'CoreNoObjectExists' => \Core\Validator\NoObjectExists::class,
        ],
        'factories' => [
            \Core\Validator\NoObjectExists::class => \Core\Validator\Factory\NoObjectExistsFactory::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'navigation'    => \Core\View\Helper\Navigation::class,
            'Navigation'    => \Core\View\Helper\Navigation::class,
        ],
        'factories' => [
            \Core\View\Helper\Navigation::class => \Core\View\NavigationHelperFactory::class,
            'zendviewhelpernavigation'          => \Core\View\NavigationHelperFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason'  => true,
        'display_exceptions'        => true,
        'doctype'                   => 'HTML5',
        'not_found_template'        => 'error/404',
        'exception_template'        => 'error/post',
        'template_map' => [
            'layout/layout' => './module/Core/view/layout/layout.phtml',
            'error/404'     => './module/Core/view/error/404.phtml',
            'error/post'    => './module/Core/view/error/index.phtml',
        ],
        'template_path_stack' => [
            './module/Core/view',
        ],
    ],
    'router' => [
        'routes' => [
            'captcha-form-generate' => [
                'type' => \Zend\Router\Http\Segment::class,
                'options' => [
                    'route' => '/captcha/[:id]',
                    'defaults' => [
                        'controller'    => \Core\Controller\CaptchaController::class,
                        'action'        => 'generate',
                    ],
                ],
            ],
        ],
    ],
];
