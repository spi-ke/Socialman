<?php

namespace Controller;

use Herrera\Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @author Ales Zavadsky <zavadskya@gmail.com>
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
