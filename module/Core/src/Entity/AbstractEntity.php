<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Core\Entity
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Core\Entity;


use Core\Exception\InvalidPropertyException;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Zend\Form\Annotation as Form;

/**
 * Class AbstractEntity
 * @package Core\Entity
 * @property UuidInterface $id
 */
abstract class AbstractEntity
{
    /**
    * @ORM\Id
    * @ORM\Column(type="uuid", unique=true)
    * @ORM\GeneratedValue(strategy="CUSTOM")
    * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
    * @Form\Exclude()
    */
    protected $id;

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy(): array
    {
        return get_object_vars($this);
    }

    /**
     * @return string
     */
    final public function __toString(): string
    {
        return $this->id->toString();
    }

    /**
     * @param string $name
     * @return mixed
     * @throws InvalidPropertyException
     */
    final public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        throw new InvalidPropertyException(sprintf(
            '"%s" property does not exist in %s.',
            $name,
            get_class($this)
        ));
    }

    /**
     * @param $name
     * @param $value
     */
    final public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    final public function __call($name, $arguments)
    {
        $var = lcfirst(substr($name, 3));

        if (strncasecmp($name, "get", 3) === 0) {
            return $this->$var;
        }

        if (strncasecmp($name, "set", 3) === 0) {
            $this->$var = $arguments[0];
        }
    }
}