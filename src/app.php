<?php
// example.com/src/app.php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;


/**
 *
 *
 */
class LeapYearController
{

    public function indexAction($request)
    {
        if (is_leap_year($request->attributes->get('year'))) {
            return new Response('Yep, this a leap year!');
        }

        return new Response('Nah, not a leaper!');
    }
}


function is_leap_year($year = null)
{
    if (null === $year) {
        $year = date('Y');
    }

    return 0 == $year % 400 || (0 == $year % 4 && 0 != $year % 100);
}

$routes = new Routing\RouteCollection();
$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', array(
  'year'        => null,
  '_controller' => array(new LeapYearController(), 'indexAction'),
)));

return $routes;
