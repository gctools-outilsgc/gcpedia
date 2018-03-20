<?php

namespace League\OAuth2\Client\Test\Tool;

use League\OAuth2\Client\Tool\QueryBuilderTrait;
use PHPUnit_Framework_TestCase;

class QueryBuilderTraitTest extends PHPUnit_Framework_TestCase
{
    use QueryBuilderTrait;

    public function setUp()
    {
        ini_set('arg_separator.output', '&amp;');
    }

    public function testBuildQueryString()
    {
        $params = [
            'a' => 'foo',
            'b' => 'bar',
            'c' => '+',
        ];

        $query = $this->buildQueryString($params);

        $this->assertSame('a=foo&b=bar&c=%2B', $query);
    }
}
