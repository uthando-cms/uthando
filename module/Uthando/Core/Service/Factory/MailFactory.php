<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Uthando\Core\Service\Factory
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

declare(strict_types=1);

namespace Uthando\Core\Service\Factory;

use Interop\Container\ContainerInterface;
use Uthando\Core\Options\MailOptions;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\View\Renderer\PhpRenderer;
use Uthando\Core\Service\Mail;

/**
 * Class MailFactory
 *
 * @package Uthando\Core\Service\Factory
 */
class MailFactory implements FactoryInterface
{
    /**
     * Create mail service object.
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return Mail
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): Mail
    {
        $options = $container->get(MailOptions::class);
        $view    = $this->getRenderer($container);

        return new Mail($view, $options);
    }

    /**
     * @param ContainerInterface $container
     * @return array|object|PhpRenderer
     */
    protected function getRenderer(ContainerInterface $container)
    {
        // Check if a view renderer is available and return it
        if ($container->has('ViewRenderer')) {
            return $container->get('ViewRenderer');
        }

        // Create new PhpRenderer
        $renderer = new PhpRenderer();

        // Set the view script resolver if available
        if ($container->has('Zend\View\Resolver\AggregateResolver')) {
            $renderer->setResolver(
                $container->get('Zend\View\Resolver\AggregateResolver')
            );
        }

        // Set the view helper manager if available
        if ($container->has('ViewHelperManager')) {
            $renderer->setHelperPluginManager(
                $container->get('ViewHelperManager')
            );
        }

        // Return the new PhpRenderer
        return $renderer;
    }
}
