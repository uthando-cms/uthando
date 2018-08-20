<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Validator\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\Core\Validator\Factory;


use Uthando\Core\Validator\NoObjectExists;
use DoctrineModule\Validator\Service\AbstractValidatorFactory;
use Interop\Container\ContainerInterface;

final class NoObjectExistsFactory extends AbstractValidatorFactory
{
    /**
     * Create an no object exists validator object
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return NoObjectExists
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): NoObjectExists
    {
        $container = $this->container($container);

        $repository = $this->getRepository($container, $options);

        $validator = new NoObjectExists($this->merge($options, [
            'object_repository' => $repository,
            'fields'            => $this->getFields($options)
        ]));

        return $validator;
    }
}