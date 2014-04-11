<?php

namespace Herrera\Service\Update;

use Herrera\Phar\Update\Manager;
use Herrera\Phar\Update\Manifest;
use Herrera\Service\Container;
use Herrera\Service\ProviderInterface;

/**
 * Registers the Phar Update library with the service container.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class UpdateServiceProvider implements ProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function register(Container $container)
    {
        $container['update'] = $container->many(function (
            $version,
            $major = true,
            $pre = false
        ) use (
            $container
        ){
            return $container['update.manager']->update($version, $major, $pre);
        });

        $container['update.manager'] = $container->once(function () use (
            $container
        ){
            return new Manager($container['update.manifest']);
        });

        $container['update.manifest'] = $container->once(function () use (
            $container
        ){
            return Manifest::loadFile($container['update.url']);
        });
    }
}