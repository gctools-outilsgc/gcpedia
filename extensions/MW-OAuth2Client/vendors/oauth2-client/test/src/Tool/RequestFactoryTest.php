<?php

namespace League\OAuth2\Client\Test\Tool;

use League\OAuth2\Client\Tool\RequestFactory;
use PHPUnit_Framework_TestCase as TestCase;
use Psr\Http\Message\RequestInterface;

class RequestFactoryTest extends TestCase
{
    public function setUp()
    {
        $this->factory = new RequestFactory;
    }

    public function testGetRequest()
    {
        $method  = 'get';
        $uri     = '/test';

        $request = $this->factory->getRequest($method, $uri);

        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertSame(strtoupper($method), $request->getMethod());
        $this->assertSame($uri, (string) $request->getUri());

        $headers         = ['X-Test' => 'Foo'];
        $body            = 'test body';
        $protocolVersion = '1.0';

        $request = $this->factory->getRequest($method, $uri, $headers, $body, $protocolVersion);

        $this->assertTrue($request->hasHeader('X-Test'));
        $this->assertSame($body, (string) $request->getBody());
        $this->assertSame($protocolVersion, $request->getProtocolVersion());
    }

    public function testGetRequestWithOptions()
    {
        $method  = 'head';
        $uri     = '/test/options';

        $request = $this->factory->getRequestWithOptions($method, $uri);

        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertSame(strtoupper($method), $request->getMethod());
        $this->assertSame($uri, (string) $request->getUri());

        $options = [
            'body'    => 'another=test&form=body',
            'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
        ];

        $request = $this->factory->getRequestWithOptions($method, $uri, $options);

        $this->assertContains($options['headers']['Content-Type'], $request->getHeader('Content-Type'));
        $this->assertSame($options['body'], (string) $request->getBody());
    }
}
