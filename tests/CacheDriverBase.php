<?php

namespace Tests;

use Pcache\Pcache;
use PHPUnit_Framework_TestCase;

class CacheDriverBase extends PHPUnit_Framework_TestCase
{
    protected $cacheDriver = null;

    protected $config = [];

    /**
     * @var \Pcache\Driver\CacheDriver
     */
    protected $handler;

    public function provider()
    {
        return [
            [
                'key'   => 'A',
                'value' => 'This is first string'
            ],
            [
                'key'   => 'B',
                'value' => 'This is second string'
            ]
        ];
    }

    public function setUp()
    {
        $this->handler = Pcache::create($this->cacheDriver, $this->config);
    }

    /**
     * @dataProvider provider
     * @param $key
     * @param $value
     */
    public function testSet($key, $value)
    {
        $this->assertTrue($this->handler->set($key, $value));
    }

    /**
     * @dataProvider provider
     * @param $key
     * @param $value
     */
    public function testGet($key, $value)
    {
        $this->assertEquals($value, $this->handler->get($key));
    }

    /**
     * @dataProvider provider
     * @param $key
     */
    public function testExistsAndDelete($key)
    {
        $this->assertTrue($this->handler->exists($key));

        $this->assertTrue($this->handler->delete($key));

        $this->assertFalse($this->handler->exists($key));
    }
}
