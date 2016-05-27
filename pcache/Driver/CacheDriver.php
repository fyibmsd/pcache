<?php

namespace Pcache\Driver;

use Pcache\CacheInterface;
use Pcache\Handler\SingletonTrait;

abstract class CacheDriver implements CacheInterface
{
    protected $handler = null;
    
    use SingletonTrait;
}
