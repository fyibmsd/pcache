<?php

namespace Pcache\Handler;

trait SingletonTrait
{
    /**
     * @var \Pcache\Driver\CacheDriver
    */
    protected static $uniqueInstance = null;

    protected function __construct()
    {
    }

    final private function __clone()
    {
    }

    final public static function getInstance(array $config)
    {
        if (static::$uniqueInstance == null) {
            static::$uniqueInstance = new static;
        }

        static::$uniqueInstance->setConfig($config);
        
        return static::$uniqueInstance;
    }
}