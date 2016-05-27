<?php

namespace Pcache\Driver;

use Pcache\Handler\MissingExtensionException;

class Redis extends CacheDriver
{
    protected $connected = false;

    /**
     * Redis constructor.
     */
    protected function __construct()
    {
        $this->checkAvailable();

        $this->handler = new \Redis();
    }

    /**
     * 检验驱动是否可用
     * @return bool
     * @throws MissingExtensionException
     * @codeCoverageIgnore
     */
    public function checkAvailable()
    {
        if (!extension_loaded('redis')) {
            throw new MissingExtensionException('The Redis PHP extension is required');
        }

        return true;
    }

    /**
     * @codeCoverageIgnore
     */
    public function setConfig(array $config)
    {
        $default = [
            'host'       => '127.0.0.1',
            'port'       => 6379,
            'password'   => null,
            'database'   => null,
            'persistent' => true,
            'timeout'    => 30
        ];

        $config = array_merge($default, $config);

        if ($config['persistent']) {
            $this->connected = $this->handler->pconnect($config['host'], $config['port'], $config['timeout']);
        } else {
            $this->connected = $this->handler->connect($config['host'], $config['port'], $config['timeout']);
        }

        if (!empty($config['password'])) {
            $this->handler->auth($config['password']);
        }

        if (!empty($config['database'])) {
            $this->handler->select($config['database']);
        }

        if (!$this->connected) {
            throw new \RuntimeException('Connect Redis Server Failed!');
        }
    }

    /**
     * 添加缓存
     * @return mixed
     */
    public function set($key, $value)
    {
        return $this->handler->set($key, $value);
    }

    /**
     * 获取缓存
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
        return $this->handler->exists($key);
    }

    /**
     * @param $keys string|array 键
     * @return bool
     */
    public function delete($keys)
    {
        if ($this->handler->del($keys)) {
            return true;
        }

        return false;
    }
}
