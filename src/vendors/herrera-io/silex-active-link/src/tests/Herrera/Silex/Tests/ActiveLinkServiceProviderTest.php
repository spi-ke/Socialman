<?php

namespace Herrera\Silex\Tests;

use Herrera\Silex\ActiveLinkServiceProvider;
use Herrera\PHPUnit\TestCase;
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class ActiveLinkServiceProviderTest extends TestCase
{
    /**
     * @var Application
     */
    private $app;

    public function getCases()
    {
        return array(
            array(
                Request::create('/'),
                <<<EXPECTED
<ul>
  <li class="active"><a href="/">Home</a></li>
  <li><a href="/page">Page</a></li>
</ul>
EXPECTED
            ),

            array(
                Request::create('/page'),
                <<<EXPECTED
<ul>
  <li><a href="/">Home</a></li>
  <li class="active"><a href="/page">Page</a></li>
</ul>
EXPECTED
            ),

            array(
                Request::create('/'),
                <<<EXPECTED
<ul>
  <li id="active"><a href="/">Home</a></li>
  <li><a href="/page">Page</a></li>
</ul>
EXPECTED
                ,
                ' id="active"'
            ),

            array(
                Request::create('/page'),
                <<<EXPECTED
<ul>
  <li><a href="/">Home</a></li>
  <li id="active"><a href="/page">Page</a></li>
</ul>
EXPECTED
                ,
                ' id="active"'
            ),
        );
    }

    /**
     * @dataProvider getCases
     */
    public function testActive($request, $expected, $snippet = null)
    {
        if ($snippet) {
            $this->app['active_link.snippet'] = $snippet;
        }

        $this->assertEquals(
            $expected,
            $this->app->handle($request)->getContent()
        );
    }

    protected function setUp()
    {
        $this->app = new Application(
            array(
                'debug' => true,
            )
        );

        $this->app->register(
            new UrlGeneratorServiceProvider()
        );

        $this->app->register(
            new TwigServiceProvider(),
            array(
                'twig.templates' => array(
                'test.twig' => <<<TEMPLATE
<ul>
  <li{{ active("home") }}><a href="{{ path("home") }}">Home</a></li>
  <li{{ active("page") }}><a href="{{ path("page") }}">Page</a></li>
</ul>
TEMPLATE
                )
            )
        );

        $this->app->register(
            new ActiveLinkServiceProvider()
        );

        $this->app->get(
            '/',
            function (Application $app) {
                return $app['twig']->render('test.twig');
            }
        )->bind('home');

        $this->app->get(
            '/page',
            function (Application $app) {
                return $app['twig']->render('test.twig');
            }
        )->bind('page');
    }
}
