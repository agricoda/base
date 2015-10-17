<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing;

//function render_template($request)
//{
//    extract($request->attributes->all(), EXTR_SKIP);
//    ob_start();
//    include sprintf(__DIR__ . '/../src/pages/%s.php', $_route);
//
//    return new Response(ob_get_clean());
//}
//
//$request = Request::createFromGlobals();
//$routes = include __DIR__ . '/../src/app.php';
//
//$response = call_user_func($controller, $arguments);
//
//$context = new Routing\RequestContext();
//$context->fromRequest($request);
//$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
//$resolver = new ControllerResolver();
//
//try {
//    $request->attributes->add($matcher->match($request->getPathInfo()));
//
//    $controller = $resolver->getController($request);
//    $arguments = $resolver->getArguments($request, $controller);
//
//} catch (Routing\Exception\ResourceNotFoundException $ex) {
//    $response = new Response('Not Found', 404);
//} catch (Exception $ex) {
//    $response = new Response('Something went wrong', 500);
//}
//
//$response->send();

$request = Request::createFromGlobals();
$routes = include __DIR__ . '/../src/app.php';

$context = new Routing\RequestContext();
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$resolver = new ControllerResolver();

$framework = new Agricoda\Base($matcher, $resolver);
$response = $framework->handle($request);

$response->send();