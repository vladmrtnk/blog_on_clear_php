<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
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
        session_start();
        $context = new RequestContext();
        $context->fromRequest(Request::createFromGlobals());

        $matcher = new UrlMatcher($routes, $context);
        try {
            $matcher = $matcher->match($_SERVER['REQUEST_URI']);

            // Cast params to int if numeric
            array_walk($matcher, function (&$param) {
                if (is_numeric($param)) {
                    $param = (int) $param;
                }
            });
            $route = explode('-', $matcher['_route']);
            if (!isset($_SESSION[AUTHENTICATED_USER]) || !$_SESSION[AUTHENTICATED_USER]){
                if ($route[0] == 'dashboard') {
                    header('Location: /sign-in');
                    exit;
                }
            }
            else {
                if ($route[0] == 'sign') {
                    header('Location: /');
                    exit;
                }
            }

            // Add routes as paramaters to the next class
//            $params = array_merge(array_slice($matcher, 2, -1), ['routes' => $routes]);

            call_user_func([$matcher[0], $matcher[1]]);

        } catch (MethodNotAllowedException $e) {
            echo 'Route method is not allowed.';
        } catch (ResourceNotFoundException $e) {
            echo 'Route does not exists.';
        }
    }
}