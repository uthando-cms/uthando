<?php

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => \Doctrine\DBAL\Driver\PDOSqlite\Driver::class,
                'params' => [
                    'path'     => __DIR__ . '/../../assets/uthando-cms.sqlite',

                ],
            ],
        ],
        'configuration' => [
            'orm_default' => [
                'query_cache'       => 'array',
                'result_cache'      => 'array',
                'metadata_cache'    => 'array',
                'hydration_cache'   => 'array',
                'second_level_cache' => [
                    'enabled' => false,
                ],
            ],
        ],
    ],
];
