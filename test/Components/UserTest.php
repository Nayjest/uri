<?php

namespace League\Uri\Test\Components;

use InvalidArgumentException;
use League\Uri\Components\User;
use PHPUnit_Framework_TestCase;

/**
 * @group user
 */
class UserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider validUserProvider
     * @param $raw
     * @param $parsed
     */
    public function testGetUriComponent($raw, $parsed)
    {
        $user = new User($raw);
        $this->assertSame($parsed, $user->getUriComponent());
        eval('$var = '.var_export($user, true).';');
        $this->assertEquals($var, $user);
    }

    public function validUserProvider()
    {
        return [
            ['toto', 'toto'],
            ['bar---', 'bar---'],
            ['', '', ''],
            ['"bad"', '%22bad%22'],
            ['<not good>', '%3Cnot%20good%3E'],
            ['{broken}', '%7Bbroken%7D'],
            ['`oops`', '%60oops%60'],
            ['\\slashy', '%5Cslashy'],
        ];
    }

    /**
     * @param $raw
     * @dataProvider invalidDataProvider
     * @expectedException InvalidArgumentException
     */
    public function testFailedConstructor($raw)
    {
        new User($raw);
    }

    public function invalidDataProvider()
    {
        return [
            'invalid @ character' => ['to@to'],
            'invalid : character' => ['to:to'],
            'invalid / character' => ['to/to'],
            'invalid ? character' => ['to?to'],
            'invalid # character' => ['to#to'],
            'array' => [['coucou']],
            'bool'      => [true],
            'Std Class' => [(object) 'foo'],
            'float'     => [1.2],
        ];
    }
}
