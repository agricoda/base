<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 17/10/15
 * Time: 10:07 PM
 */

namespace Base\Tests;

use Base\Framework;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class FrameworkTest extends \PHPUnit_Framework_TestCase
{

    public function testNotFoundHandling()
    {
        $framework = $this->getFrameworkForException(new ResourceNotFoundException());
        $response = $framework->handle(new Request());
        $this->assertEquals(404, $response->getStatusCode());
    }

    protected function getFrameworkForException($exception)
    {
        $matcher = $this->getMock('Symfony\Component\Routing\Matcher\UrlMatcherInterface');
        $matcher->expects($this->once())
                ->method('match')
                ->will($this->throwException($exception));
        $matcher->expects($this->once())
                ->method('getContext')
                ->will($this->returnValue($this->getMock('Symfony\Component\Routing\RequestContext')));
        $resolver = $this->getMock('Symfony\Component\HttpKernel\Controller\ControllerResolverInterface');

        return new Framework($matcher, $resolver);
    }

    public function testErrorHandling()
    {
        $framework = $this->getFrameworkForException(new \RuntimeException());
        $response = $framework->handle(new Request());
        $this->assertEquals(500, $response->getStatusCode());
    }

    public function testControllerResponse()
    {
        $matcher = $this->getMock('Symfony\Component\Routing\Matcher\UrlMatcherInterface');
        $matcher->expects($this->once())
                ->method('match')
                ->will($this->returnValue(array(
                  '_route'      => 'foo',
                  'name'        => 'Fabian',
                  '_controller' => function ($name) {
                      return new Response('Hello ' . $name[0]);
                  },
                )));
        $matcher->expects($this->once())
                ->method('getContext')
                ->will($this->returnValue($this->getMock('Symfony\Component\Routing\RequestContext')));

        $resolver = new ControllerResolver();

        $framework = new Framework($matcher, $resolver);

        $response = $framework->handle(new Request());

        $this->assertEquals(200, $response->getStatusCode(), 'The status code was incorrect');
        $this->assertContains('Hello Fabian', $response->getContent());
    }
}
