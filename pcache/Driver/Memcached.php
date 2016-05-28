<?php

namespace Pcache\Driver;

use Pcache\Handler\MissingExtensionException;

class Memcached extends CacheDriver
{
    /**
     * @var bool Server Connection Status
     */
    protected $connected = false;

    /**
     * @var Memcached 单例
     */
    protected static $uniqueInstance;

    /**
     * @var \Memcached
     */
    protected $handler = null;

    protected function __construct()
    {
        $this->checkAvailable();

        $this->handler = new \Memcached('CachePool');
    }

    /**
     * 检验驱动是否可用
     * @return bool
     * @throws MissingExtensionException
     */
    public function checkAvailable()
    {
        if (!extension_loaded('memcache')) {
            throw new MissingExtensionException('The Memcached PHP extension is required');
        }

        return true;
    }

    public function setConfig(array $config)
    {
        $default = [
            'host' => '127.0.0.1',
            'port' => 11211
        ];

        $config = array_merge($default, $config);

        $this->connected = $this->handler->addServer($config['host'], $config['port']);


        if (!$this->connected) {
            throw new \RuntimeException('Connect Memcache Server Failed!');
        }
    }

    /**
     * 添加缓存
     * @param $key string 键
     * @param $value string 值
     * @return mixed
     */
    public function set($key, $value)
    {
        return $this->handler->add($key, $value);
    }

    /**
     * 获取缓存
     * @param $key string 键
     * @return mixed
     */
    public function get($key)
    {
        return $this->handler->get($key);
    }

    /**
     * @param $key string 键
     * @return mixed
     */
    public function exists($key)
    {
        return $this->get($key) ? true : false;
    }

    /**
     * @param $key string|array 键
     * @return mixed
     */
    public function delete($key)
    {
        return $this->handler->delete($key);
    }
}
