<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoTest\Framework
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace UthandoTest\Framework;


use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\Util\ModuleLoader;

class TestCase extends PHPUnitTestCase
{
    /**
     * @var ModuleLoader
     */
    protected $moduleLoader;

    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->moduleLoader = new ModuleLoader(ArrayUtils::merge(
            include __DIR__ . '/../../config/application.config.php',
            []
        ));
        parent::setUp();
    }
}