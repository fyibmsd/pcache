<?php

namespace Pcache;

class Pcache
{
    /**
     * @param \Pcache\Driver\CacheDriver $driver
     * @param array $config 配置
     * @return mixed
     */
    public static function create($driver, array $config)
    {
        return $driver::getInstance($config);
    }
}
