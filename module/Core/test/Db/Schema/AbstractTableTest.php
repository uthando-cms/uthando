<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.name/)
 *
 * @package   CoreTest\Db\Schema
 * @author    Shaun Freeman
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.name)
 * @date      22/07/18
 * @license   see LICENSE
 */

namespace CoreTest\Db\Schema;


use Core\Db\Schema\AbstractTable;
use PHPUnit\Framework\TestCase;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Adapter\Platform\PlatformInterface;
use Zend\Db\Sql\Ddl\SqlInterface;

class AbstractTableTest extends TestCase
{
    protected function setUp()
    {
        $this->adapter = $this->prophesize(Adapter::class);
    }

    public function testCanSetAdapter()
    {
        $reflection     = new \ReflectionClass(AbstractTable::class);
        $adapter        = $reflection->getProperty('dbAdapter');
        $table          = $this->getMockForAbstractClass(AbstractTable::class,[$this->adapter->reveal()]);

        $adapter->setAccessible(true);

        $this->assertInstanceOf(Adapter::class, $adapter->getValue($table));
    }

    public function testQuery()
    {
        $adapter = $this->adapter;
        $adapter->query(null, Adapter::QUERY_MODE_EXECUTE)
            ->willReturn(
                $this->prophesize(ResultInterface::class)
                    ->reveal()
            );
       $adapter->getPlatform()
            ->willReturn(
                $this->prophesize(PlatformInterface::class)
                    ->reveal()
            );

        $table  = $this->getMockForAbstractClass(AbstractTable::class,[$adapter->reveal()]);
        $result = $table->query($this->prophesize(SqlInterface::class)->reveal());

        $this->assertInstanceOf(ResultInterface::class, $result);
    }
}
