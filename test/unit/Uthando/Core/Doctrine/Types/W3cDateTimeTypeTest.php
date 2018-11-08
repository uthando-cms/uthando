<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   UthandoUnitTest\Core\Doctrine\Types
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace UthandoUnitTest\Core\Doctrine\Types;

use Uthando\Core\Doctine\Types\W3cDateTimeType;
use Uthando\Core\Stdlib\W3cDateTime;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;

class W3cDateTimeTypeTest extends TestCase
{
    /**
     * @var AbstractPlatform
     */
    private $platform;

    /**
     * @var W3cDateTimeType
     */
    private $type;

    public static function setUpBeforeClass()
    {
        if (class_exists('Doctrine\\DBAL\\Types\\Type')) {
            try {
                Type::addType('w3cdatetime', W3cDateTimeType::class);
            } catch (DBALException $e) {
                // dont register type if not there!
            }
        }
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function setUp()
    {
        $this->platform = $this->getPlatformMock();
        $this->platform->expects($this->any())
            ->method('getVarcharTypeDeclarationSQL')
            ->will($this->returnValue('DUMMYVARCHAR()'));
        $this->type = Type::getType('w3cdatetime');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getPlatformMock()
    {
        return $this->getMockBuilder(AbstractPlatform::class)
            ->setMethods(array('getVarcharTypeDeclarationSQL'))
            ->getMockForAbstractClass();
    }

    public function testCanConvertToPhpValue()
    {
        $dateTime = '2018-07-31T18:58:51+00:00';
        $this->assertInstanceOf(W3cDateTime::class, $this->type->convertToPHPValue($dateTime, $this->platform));
    }

    public function testCanConvertTorPhpValue()
    {
        $this->assertInstanceOf(W3cDateTime::class, $this->type->convertToPHPValue(new W3cDateTime(), $this->platform));
    }

    public function testCanConvertToDatabaseValue()
    {
        $dateTime = new W3cDateTime('2018-07-31T18:58:51+00:00');
        $this->assertSame('2018-07-31T18:58:51+00:00', $this->type->convertToDatabaseValue($dateTime, $this->platform));
    }

    public function testNullConversionForDatabaseValue()
    {
        $this->assertInternalType('null', $this->type->convertToDatabaseValue(null, $this->platform));
    }

    /**
     * @expectedException \Doctrine\DBAL\Types\ConversionException
     */
    public function testInvalidDateTimeThrowsException()
    {
        $this->type->convertToPHPValue('abcdefg', $this->platform);
    }

    /**
     * @expectedException \Doctrine\DBAL\Types\ConversionException
     */
    public function testInvalidDateThrowsException()
    {
        $this->type->convertToDatabaseValue('abcdefg', $this->platform);
    }

    public function testCanGetByName()
    {
        $this->assertEquals('w3cdatetime', $this->type->getName());
    }

    public function testCanGetSqlDeclaration()
    {
        $this->assertEquals('DUMMYVARCHAR()', $this->type->getSqlDeclaration(array('length' => 25), $this->platform));
    }


}
