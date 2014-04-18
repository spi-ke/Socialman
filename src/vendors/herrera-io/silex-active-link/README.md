Active Link
===========

[![Build Status][]](https://travis-ci.org/herrera-io/php-silex-active-link)

A very simple Silex service provider for checking active links in Twig.

Example
-------

In PHP:

```php
use Herrera\Silex\ActiveLinkServiceProvider;
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;

$app = new Application();

$app->get(
    '/',
    function (Application $app) {
        return $app['twig']->render('test.html.twig');
    }
)->bind('home');

$app->get(
    '/page',
    function (Application $app) {
        return $app['twig']->render('test.html.twig');
    }
)->bind('page');

$app->register(
    new TwigServiceProvider(),
    array(
        'twig.path' => '/path/to/templates'
    )
);

$app->register(
    new ActiveLinkServiceProvider()
);

$app->run(
    Request::create('/page')
);
```

The Twig template:

```twig
<ul>
  <li{{ active("home") }}><a href="{{ path("home") }}">Home</a></li>
  <li{{ active("page") }}><a href="{{ path("page") }}">Page</a></li>
</ul>
```

The result when request `page`:

```html
<ul>
  <li><a href="/">Home</a></li>
  <li class="active"><a href="/page">Page</a></li>
</ul>
```

Installation
------------

Use Composer:

```
$ composer require "herrera-io/silex-active-link=~1.0"
```

Configuration
-------------

There is only one configuration parameter: `active_link.snippet`

The `active_link.snippet` is the result returned if a link is active. By
default, the result is ` class="active"` (note that the space is included).
Hopefully, this provides you with a far greater degree of flexibility in
how you can use the new `active` Twig function.

[Build Status]: https://travis-ci.org/herrera-io/php-silex-active-link.png?branch=master
