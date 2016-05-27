<?php

namespace Pcache;

interface CacheInterface
{
    /**
     * 检验驱动是否可用
     * @return bool
     */
    public function checkAvailable();

    public function setConfig(array $config);

    /**
     * 添加缓存
     * @param $key string 键
     * @param $value string 值
     * @return mixed
     */
    public function set($key, $value);

    /**
     * 获取缓存
     * @param $key string 键
     * @return mixed
     */
    public function get($key);

    /**
     * @param $key string 键
     * @return mixed
     */
    public function exists($key);

    /**
     * @param $key string|array 键
     * @return mixed
     */
    public function delete($key);
}
