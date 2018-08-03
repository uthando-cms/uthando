<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   CoreTest\Doctrine\Types
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace CoreTest\Doctrine\Types;

use Core\Doctine\Types\W3cDateTimeType;
use Core\Stdlib\W3cDateTime;
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

    public function testConvertToPHPValue()
    {
        $dateTime = '2018-07-31T18:58:51+00:00';
        $this->assertInstanceOf(W3cDateTime::class, $this->type->convertToPHPValue($dateTime, $this->platform));
    }

    public function testObjectReturnConversionForPHPValue()
    {
        $this->assertInstanceOf(W3cDateTime::class, $this->type->convertToPHPValue(new W3cDateTime(), $this->platform));
    }

    public function testConvertToDatabaseValue()
    {
        $dateTime = new W3cDateTime('2018-07-31T18:58:51+00:00');
        $this->assertSame('2018-07-31T18:58:51+00:00', $this->type->convertToDatabaseValue($dateTime, $this->platform));
    }

    public function testNullConversionForDatabaseValue()
    {
        $this->assertInternalType('string', $this->type->convertToDatabaseValue(null, $this->platform));
    }

    /**
     * @expectedException \Doctrine\DBAL\Types\ConversionException
     */
    public function testInvalidUuidConversionForPHPValue()
    {
        $this->type->convertToPHPValue('abcdefg', $this->platform);
    }

    /**
     * @expectedException \Doctrine\DBAL\Types\ConversionException
     */
    public function testInvalidUuidConversionForDatabaseValue()
    {
        $this->type->convertToDatabaseValue('abcdefg', $this->platform);
    }

    public function testGetName()
    {
        $this->assertEquals('w3cdatetime', $this->type->getName());
    }

    public function testGetSQLDeclaration()
    {
        $this->assertEquals('DUMMYVARCHAR()', $this->type->getSqlDeclaration(array('length' => 25), $this->platform));
    }


}
