<?php

use ApplicationTest\Framework\TestCase;
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\Loader\StandardAutoloader;

error_reporting(E_ALL | E_STRICT);
ini_set('date.timezone', 'Europe/London');

chdir(__DIR__);

$previousDir = '.';
while (!file_exists('config/application.config.php')) {
    $dir = dirname(getcwd());
    if ($previousDir === $dir) {
        throw new RuntimeException(
                'Unable to locate "config/application.config.php": ' .
                'is Uthando in a subdir of your application skeleton?'
        );
    }
    $previousDir = $dir;
    chdir($dir);
}

if (is_readable(__DIR__ . '/TestConfiguration.php')) {
    $configuration = include_once __DIR__ . '/TestConfiguration.php';
} else {
    $configuration = include_once __DIR__ . '/TestConfig.php.dist';
}

// Assumes PHP Composer autoloader w/compiled classmaps, etc.
require_once 'vendor/autoload.php';

// This namespace is not in classmap.
$loader = new StandardAutoloader([
    StandardAutoloader::LOAD_NS => [
        'ApplicationTest' => __DIR__ . '/ApplicationTest'
    ],
]);

$loader->register();

$serviceManager = new ServiceManager(new ServiceManagerConfig($configuration['service_manager']));
$serviceManager->setService('ApplicationConfig', $configuration);
$serviceManager->setAllowOverride(true);

$moduleManager = $serviceManager->get('ModuleManager');
$moduleManager->loadModules();

TestCase::setServiceManager($serviceManager);