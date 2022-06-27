<?php

use App\Controllers\Auth\LogoutUserController;
use App\Controllers\Auth\SignInUserController;
use App\Controllers\Auth\SignUpUserController;
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

/*
 * Dashboard routes
 */
$routes->add('dashboard-posts', new Route('/dashboard/posts', [new DashboardPostController(), 'index'], [], [], '', [], ['GET']));
$routes->add('dashboard-posts-create', new Route('/dashboard/posts/create', [new DashboardPostController(), 'create'], [], [], '', [], ['GET']));
$routes->add('dashboard-posts-store', new Route('/dashboard/posts', [new DashboardPostController(), 'store'], [], [], '', [], ['POST']));
$routes->add('dashboard-posts-show', new Route('/dashboard/posts/{post}', [new DashboardPostController(), 'show'], [], [], '', [], ['GET']));
$routes->add('dashboard-posts-edit', new Route('/dashboard/posts/{post}/edit', [new DashboardPostController(), 'edit'], [], [], '', [], ['GET']));
$routes->add('dashboard-posts-update', new Route('/dashboard/posts/{post}', [new DashboardPostController(), 'update'], [], [], '', [], ['PUT', 'PATCH']));
$routes->add('dashboard-posts-destroy', new Route('/dashboard/posts/{post}', [new DashboardPostController(), 'destroy'], [], [], '', [], ['DELETE']));

$router = new Router();
$router($routes);