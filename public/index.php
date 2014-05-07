<?php

// If we're running under `php -S` with PHP 5.4.0+
// Thanks to Stephan Sokolow
if (php_sapi_name() == 'cli-server') {

    // Replicate the effects of basic "index.php"-hiding mod_rewrite rules
    // Tested working under FatFreeFramework 2.0.6 through 2.0.12.
    $_SERVER['SCRIPT_NAME'] = str_replace(__DIR__, '', __FILE__);
    $_SERVER['SCRIPT_FILENAME'] = __FILE__;

    // Replicate the FatFree/WordPress/etc. .htaccess "serve existing files" bit
    $url_parts = parse_url($_SERVER["REQUEST_URI"]);

    $_req = rtrim($_SERVER['DOCUMENT_ROOT'] . $url_parts['path'], '/' . DIRECTORY_SEPARATOR);

    if (__FILE__ !== $_req && __DIR__ !== $_req && file_exists($_req)) {
        return false; // serve the requested resource as-is.
    }
}

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

define('APPLICATION_PATH', dirname(__DIR__));

// Setup autoloading
if (file_exists('vendor/autoload.php')) {
    $loader = include 'vendor/autoload.php';
}

if (!class_exists('Zend\Loader\AutoloaderFactory')) {
    throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.');
}

$config = require 'config/application.config.php';

// Use local config if availible
if (file_exists('config/application.config.local.php')) {
    $config = require 'config/application.config.local.php';
}

// Run the application!
Zend\Mvc\Application::init($config)->run();