<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

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
    'service_manager' => [
        'factories' => [
            'doctrine.cache.filesystem' => \Core\Doctine\Cache\FilesystemFactory::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'navigation'        => \Core\View\Helper\Navigation::class,
            'Navigation'        => \Core\View\Helper\Navigation::class,
        ],
        'factories' => [
            \Core\View\Helper\Navigation::class => \Core\View\NavigationHelperFactory::class,
            'zendviewhelpernavigation' => \Core\View\NavigationHelperFactory::class,
        ]
    ]
];
