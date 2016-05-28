<?php

namespace Pcache\Driver;

use Pcache\Handler\MissingExtensionException;

class Memcache extends CacheDriver
{
    /**
     * @var bool Server Connection Status
     */
    protected $connected = false;

    /**
     * @var Memcache 单例
     */
    protected static $uniqueInstance;

    /**
     * @var \Memcache
     */
    protected $handler = null;

    protected function __construct()
    {
        $this->checkAvailable();

        $this->handler = new \Memcache();
    }

    /**
     * 检验驱动是否可用
     * @return bool
     * @throws MissingExtensionException
     */
    public function checkAvailable()
    {
        if (!extension_loaded('memcache')) {
            throw new MissingExtensionException('The Memcache PHP extension is required');
        }

        return true;
    }

    public function setConfig(array $config)
    {
        $default = [
            'host'       => '127.0.0.1',
            'port'       => 11211,
            'persistent' => true
        ];

        $config = array_merge($default, $config);

        $this->connected = $this->handler->addserver($config['host'], $config['port'], $config['persistent']);

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
        if ($this->get($key)) {
            return true;
        }

        return false;
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
