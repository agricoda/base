<?php namespace Test;

use Symfony\Component\HttpFoundation\Response;

class TestController
{

    public function indexAction()
    {
        return Response::create('hi dude');

        return 'some string';
    }
}