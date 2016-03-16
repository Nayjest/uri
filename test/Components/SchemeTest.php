<?php

namespace League\Uri\Test\Components;

use League\Uri\Components\Scheme;
use PHPUnit_Framework_TestCase;

/**
 * @group scheme
 */
class SchemeTest extends PHPUnit_Framework_TestCase
{
    public function testWithValue()
    {
        $scheme = new Scheme('ftp');
        $http_scheme = $scheme->modify('HTTP');
        $this->assertSame('http', $http_scheme->__toString());
        $this->assertSame('http:', $http_scheme->getUriComponent());
        eval('$var = '.var_export($scheme, true).';');
        $this->assertEquals($var, $scheme);
    }

    public function testEmptyScheme()
    {
        $this->assertEmpty((new Scheme())->__toString());
    }

    /**
     * @dataProvider validSchemeProvider
     * @param $scheme
     * @param $toString
     */
    public function testValidScheme($scheme, $toString)
    {
        $this->assertSame($toString, (new Scheme($scheme))->__toString());
    }

    public function validSchemeProvider()
    {
        return [
            [null, ''],
            ['a', 'a'],
            ['ftp', 'ftp'],
            ['HtTps', 'https'],
            ['wSs', 'wss'],
            ['telnEt', 'telnet'],
        ];
    }

    /**
     * @param  $scheme
     * @dataProvider invalidSchemeProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidScheme($scheme)
    {
        new Scheme($scheme);
    }

    public function invalidSchemeProvider()
    {
        return [
            'empty string'         => [''],
            'invalid char'         => ['in,valid'],
            'integer like string'  => ['123'],
            'bool'                 => [true],
            'Std Class'            => [(object) 'foo'],
            'float'                => [1.2],
            'array'                => [['foo']],
        ];
    }

    public function testSameValueAs()
    {
        $scheme  = new Scheme();
        $scheme1 = new Scheme('https');
        $this->assertFalse($scheme->sameValueAs($scheme1));
        $newscheme = $scheme1->modify(null);
        $this->assertTrue($scheme->sameValueAs($newscheme));
        $this->assertSame('', $newscheme->getUriComponent());
    }
}
