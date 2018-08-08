<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Core\Validator\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Core\Validator\Factory;


use Core\Validator\NoObjectExists;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class NoObjectExistsFactory implements FactoryInterface
{

    /**
     * Create an no object exists validator object
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return NoObjectExists
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var EntityManager $entityManager */
        $entityManager      = $container->get(EntityManager::class);
        $entityRepostitory  = $entityManager->getRepository($options['object_repository']);

        $options['object_repository'] = $entityRepostitory;

        return new NoObjectExists($options);
    }
}