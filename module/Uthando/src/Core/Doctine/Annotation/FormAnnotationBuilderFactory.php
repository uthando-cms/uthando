<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Doctine\Annotation
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2018 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Uthando\Core\Doctine\Annotation;


use Doctrine\ORM\EntityManager;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

final class FormAnnotationBuilderFactory implements FactoryInterface
{
    /**
     * Create an Annotation builder object
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return AnnotationBuilder
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): AnnotationBuilder
    {
        /** @var EntityManager $entityManager */
        $entityManager  = $container->get(EntityManager::class);
        $inputFilters   = $container->get('InputFilterManager');
        $builder        = new AnnotationBuilder($entityManager);
        $factory        = $builder->getFormFactory();

        $factory->setFormElementManager($container->get('FormElementManager'));
        $factory->getInputFilterFactory()->setInputFilterManager($inputFilters);

        return $builder;
    }
}