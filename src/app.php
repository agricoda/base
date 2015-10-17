<?php
// example.com/src/app.php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

//
$routes = new Routing\RouteCollection();
$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', array(
  'year'        => null,
  '_controller' => 'Calendar\\Controller\\CalendarController::indexAction',
)));
$routes->add('test', new Routing\Route('/test/{name}', array(
  'name'        => 'bob',
  '_controller' => function ($name) {

    return Response::create('hey ' . $name[0]);
  },
)));


return $routes;

//use Routing\Route;

//var_dump($routes);
//$routes->add('\some_route', function ($params) {
//   return $params;
//});
//$routes->add('leap_year', new Symfony\Component\Routing\Route('/is_leap_year/{year}', array(
//  'year' => null,
//  '_controller' => 'Calendar\\Controller\\LeapYearController::indexAction',
//)));
////return $routes;