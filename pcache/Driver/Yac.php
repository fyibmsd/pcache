<?php

namespace Pcache\Driver;

use Pcache\Handler\MissingExtensionException;

class Yac extends CacheDriver
{
    /**
     * @var \Yac
     */
    protected $handler;

    /**
     * @var Yac 单例
     */
    protected static $uniqueInstance;

    /**
     * 检验驱动是否可用
     * @return bool
     * @throws MissingExtensionException
     */
    public function checkAvailable()
    {
        if (!extension_loaded('yac')) {
            throw new MissingExtensionException('The Yac PHP extension is required');
        }

        if (!ini_get('yac.enable')) {
            throw new MissingExtensionException('The Yac Cache is not available!');
        }

        return true;
    }

    public function setConfig(array $config)
    {
        $default = [
            'prefix' => ''
        ];

        $config = array_merge($default, $config);

        $this->handler = new \Yac($config['prefix']);
    }

    /**
     * 添加缓存
     * @param $key string 键
     * @param $value string 值
     * @return mixed
     */
    public function set($key, $value)
    {
        return $this->handler->set($key, $value);
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