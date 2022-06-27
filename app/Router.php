<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\NoConfigurationException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class Router
{
    /**
     * @param  RouteCollection  $routes
     *
     * @return void
     */
    public function __invoke(RouteCollection $routes): void
    {
        $context = new RequestContext();
        $context->fromRequest(Request::createFromGlobals());

        $matcher = new UrlMatcher($routes, $context);
        try {
            $matcher = $matcher->match($_SERVER['REQUEST_URI']);

            call_user_func([$matcher[0], $matcher[1]]);

        } catch (MethodNotAllowedException $e) {
            echo 'Route method is not allowed.';
        } catch (ResourceNotFoundException $e) {
            echo 'Route does not exists.';
        }
    }
}