<?php

namespace Pcache\Driver;

use Pcache\Handler\MissingExtensionException;
use SSDB\Client;

class Ssdb extends CacheDriver
{
    /**
     * @var bool Server Connection Status
     */
    protected $connected = false;

    /**
     * @var Ssdb 单例
     */
    protected static $uniqueInstance;

    /**
     * @var Client
     */
    protected $handler = null;

    protected function __construct()
    {
        $this->checkAvailable();

    }

    /**
     * 检验驱动是否可用
     * @return bool
     * @throws MissingExtensionException
     */
    public function checkAvailable()
    {
        if (!class_exists('SSDB\\Client')) {
            throw new MissingExtensionException('class \'SSDB\\Client\' is not exists!');
        }

        return true;
    }

    public function setConfig(array $config)
    {
        $default = [
            'host'    => '127.0.0.1',
            'port'    => 8888,
            'timeout' => 2
        ];

        $config = array_merge($default, $config);

        $this->handler = new Client($config['host'], $config['port'], $config['timeout'] * 1000);

        if ($this->handler) {
            $this->connected = true;
        }

        if (!$this->connected) {
            throw new \RuntimeException('Connect Ssdb Server Failed!');
        }
    }

    /**
     * 添加缓存
     * @param $key string 键
     * @param $value string 值
     * @return bool
     */
    public function set($key, $value)
    {
        $result = $this->handler->set($key, $value);
        if ($result->code == 'ok') {
            return true;
        }

        return false;
    }

    /**
     * 获取缓存
     * @param $key string 键
     * @return mixed
     */
    public function get($key)
    {
        $result = $this->handler->get($key);
        if ($result->code == 'ok') {
            return $result->data;
        }

        return false;
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
        $result = $this->handler->del($key);
        if ($result->code == 'ok') {
            return true;
        }
        
        return false;
    }
}