<?php

namespace League\Uri\Test\Components;

use League\Uri\Components\Port;
use PHPUnit_Framework_TestCase;

/**
 * @group port
 */
class PortTest extends PHPUnit_Framework_TestCase
{
    public function testPortSetter()
    {
        $port = new Port(new Port(443));
        $this->assertSame('443', $port->__toString());
        eval('$var = '.var_export($port, true).';');
        $this->assertEquals($var, $port);
    }

    /**
     * @param  $input
     * @param  $expected
     * @dataProvider getToIntProvider
     */
    public function testToInt($input, $expected)
    {
        $this->assertSame($expected, (new Port($input))->toInt());
    }

    public function getToIntProvider()
    {
        return [
            ['443', 443],
            [null, null],
            [23, 23],
        ];
    }

    public function invalidPortProvider()
    {
        return [
            'empty string'                 => [''],
            'string'                       => ['toto'],
            'invalid port number too low'  => ['-23'],
            'invalid port number too high' => ['10000000'],
            'invalid port number'          => ['0'],
            'bool'                         => [true],
            'Std Class'                    => [(object) 'foo'],
            'float'                        => [1.2],
            'array'                        => [['foo']],
        ];
    }

    /**
     * @param $port
     *
     * @dataProvider invalidPortProvider
     *
     * @expectedException \InvalidArgumentException
     */
    public function testFailedPort($port)
    {
        new Port($port);
    }

    /**
     * @param  $input
     * @param  $expected
     * @dataProvider getUriComponentProvider
     */
    public function testGetUriComponent($input, $expected)
    {
        $this->assertSame($expected, (new Port($input))->getUriComponent());
    }

    public function getUriComponentProvider()
    {
        return [
            ['443', ':443'],
            [null, ''],
            [23, ':23'],
        ];
    }
}
