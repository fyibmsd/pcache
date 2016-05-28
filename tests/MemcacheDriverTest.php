<?php

namespace Tests;

use Pcache\Driver\Memcache;

class MemcacheDriverTest extends CacheDriverBase
{
    protected $cacheDriver = Memcache::class;
}
