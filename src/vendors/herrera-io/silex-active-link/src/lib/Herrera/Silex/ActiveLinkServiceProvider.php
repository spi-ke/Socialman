<?php

namespace Herrera\Silex;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Twig_Environment;
use Twig_SimpleFunction;

/**
 * Makes it easy to check active links.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class ActiveLinkServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function boot(Application $app)
    {
        // empty
    }

    /**
     * {@inheritDoc}
     */
    public function register(Application $app)
    {
        $app->extend(
            'twig',
            function (Twig_Environment $twig) use ($app) {
                $twig->addFunction(
                    new Twig_SimpleFunction(
                        'active',
                        function ($name) use ($app) {
                            if ($name === $app['request']->get('_route')) {
                                if (isset($app['active_link.snippet'])) {
                                    return $app['active_link.snippet'];
                                } else {
                                    return ' class="active"';
                                }
                            }

                            return '';
                        },
                        array(
                            'is_safe' => array('html')
                        )
                    )
                );

                return $twig;
            }
        );
    }
}
