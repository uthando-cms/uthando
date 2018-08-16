<?php declare(strict_types=1);
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 19/09/17 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Uthando\Event;

use Assetic\Filter\CssMinFilter;
use Assetic\Filter\JSMinFilter;
use AssetManager\Cache\FilePathCache;
use Zend\ModuleManager\ModuleEvent;
use Zend\Stdlib\ArrayUtils;

class ConfigListener
{
    public static function onMergeConfig(ModuleEvent $event): bool
    {
        $configListener     = $event->getConfigListener();
        $config             = $configListener->getMergedConfig(false);
        $options            = $config['uthando']['theme_options'] ?? [];
        $assetManager       = [];

        if (isset($options['cache'])) {
            $assetManager['asset_manager']['caching']['default'] = [
                'cache' => FilePathCache::class,
                'options' => [
                    'dir' => $options['public_dir'],
                ],
            ];
        }

        if (isset($options['compress_css'])) {
            $assetManager['asset_manager']['filters']['css'][] = [
                'filter' => CssMinFilter::class,
            ];
        }

        if (isset($options['compress_js'])) {
            $assetManager['asset_manager']['filters']['js'][] = [
                'filter' => JSMinFilter::class,
            ];
        }

        if (isset($options['theme_path'])) {
            $assetManager['asset_manager']['resolver_configs']['paths']['ThemeManager'] = $options['theme_path'];
        }

        $config = ArrayUtils::merge($config, $assetManager);

        $configListener->setMergedConfig($config);

        return true;
    }
}
