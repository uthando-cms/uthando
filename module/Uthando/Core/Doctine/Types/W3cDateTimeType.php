<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Doctine\Types
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\Core\Doctine\Types;


use Uthando\Core\Stdlib\W3cDateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

final class W3cDateTimeType extends Type
{
    /**
     * @var string
     */
    const NAME = 'w3cdatetime';

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * @param W3cDateTime|null $value
     * @param AbstractPlatform $platform
     * @return null|string
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if (null === $value) {
            $value = new W3cDateTime('now');
        }

        if ($value instanceof W3cDateTime) {
            return $value->toString();
        }

        throw ConversionException::conversionFailed($value, $this->getName());
    }

    /**
     * @param W3cDateTime|null $value
     * @param AbstractPlatform $platform
     * @return W3cDateTime|null|bool
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): W3cDateTime
    {
        if ($value instanceof W3cDateTime) {
            return $value;
        }

        try {
            $val = new W3cDateTime($value);
        } catch (\Exception $e) {
            $val = null;
        }

        if (!$val) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }

        return $val;
    }

    /**
     * Gets the name of this type.
     *
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }
}