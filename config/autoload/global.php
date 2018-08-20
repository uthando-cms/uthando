<?php

declare(strict_types=1);

return [
    'session_config' => [
        // Session cookie will expire in 1 hour.
        'cookie_lifetime'   => 60*60*1,
        // Session data will be stored on server maximum for 30 days.
        'gc_maxlifetime'    => 60*60*24*30,
        'save_path'         => './data/sessions',
    ],
];
