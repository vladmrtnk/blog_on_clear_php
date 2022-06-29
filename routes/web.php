<?php

use App\Controllers\Auth\LogoutUserController;
use App\Controllers\Auth\SignInUserController;
use App\Controllers\Auth\SignUpUserController;
use App\Controllers\Blog\Dashboard\TagController;
use App\Controllers\Blog\HomeController;
use App\Controllers\Blog\PostController;
use \App\Controllers\Blog\Dashboard\PostController as DashboardPostController;
use App\Router;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();
/*
 * User registration and authentication routes
 */
$routes->add('sign-in', new Route('/sign-in', [new SignInUserController(), 'index'], [], [], '', [], ['GET']));
$routes->add('sign-in-store', new Route('/sign-in', [new SignInUserController(), 'store'], [], [], '', [], ['POST']));
$routes->add('sign-up', new Route('/sign-up', [new SignUpUserController(), 'index'], [], [], '', [], ['GET']));
$routes->add('sign-up-store', new Route('/sign-up', [new SignUpUserController(), 'store'], [], [], '', [], ['POST']));
$routes->add('logout', new Route('/logout', [new LogoutUserController(), 'index']));

/*
 * Routes in menu
 */
$routes->add('home', new Route('/', [new HomeController(), 'index']));
$routes->add('posts', new Route('/posts', [new PostController(), 'index']));
$routes->add('posts-show', new Route('/posts/{post}', [new PostController(), 'show']));

/*
 * Dashboard routes
 */
$routes->add('dashboard-posts', new Route('/dashboard/posts', [new DashboardPostController(), 'index'], [], [], '', [], ['GET']));
$routes->add('dashboard-posts-create', new Route('/dashboard/posts/create', [new DashboardPostController(), 'create'], [], [], '', [], ['GET']));
$routes->add('dashboard-posts-store', new Route('/dashboard/posts', [new DashboardPostController(), 'store'], [], [], '', [], ['POST']));
$routes->add('dashboard-posts-destroy', new Route('/dashboard/posts/{post}/destroy', [new DashboardPostController(), 'destroy']));

$routes->add('dashboard-tags-create', new Route('/dashboard/tags/create', [new TagController(), 'create'], [], [], '', [], ['GET']));
$routes->add('dashboard-tags-store', new Route('/dashboard/tags', [new TagController(), 'store'], [], [], '', [], ['POST']));

$router = new Router();
$router($routes);