<?php
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

// Add local config if availible
if (file_exists('config/application.config.local.php')) {
    $localConfig = require 'config/application.config.local.php';
    $config = array_merge_recursive($config, $localConfig);
}

// Run the application!
Zend\Mvc\Application::init($config)->run();