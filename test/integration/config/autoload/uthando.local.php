<?php

declare(strict_types=1);

return [
    'uthando' => [
        'mail' => [
            'transport' => [
                'default' => [
                    'class' => \Zend\Mail\Transport\File::class,
                    'options' => [
                        'path' => './data',
                    ],
                ],
            ],
            'addresses' => [
                'default' => [
                    'name' => 'Uthando Admin',
                    'address' => 'admin@example.co.uk',
                ],
            ],
            'charset' => 'utf-8',
            //'layout' => '',
            'generate_alternative_body' => false,
            'max_amount_to_send' => 5,
        ],
    ],
];
