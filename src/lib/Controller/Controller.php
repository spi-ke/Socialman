<?php

namespace Socialman;

use Herrera\Silex\Application;
use Herrera\Silex\Form\Type\UneditableType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * A simple example controller.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Controller
{
    /**
     * Renders the large example form.
     *
     * @param Application $app     The application.
     * @param Request     $request The request.
     *
     * @return string The rendered view.
     */
    public static function indexView(Application $app, Request $request)
    {
        return $app->render(
            'index.html.twig',
            array(
            )
        );
    }

}
