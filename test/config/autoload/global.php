<?php

declare(strict_types=1);

$global = [
    'session_config'    => [],
    'view_manager'      => [
        'display_not_found_reason'  => true,
        'display_exceptions'        => true,
    ],
];

if (phpversion() < 7.2) $global['session_config']['use_cookies'] = false;

return $global;
