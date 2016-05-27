<?php

namespace Tests;

use Pcache\Driver\Redis;

class RedisDriverTest extends CacheDriverBase
{
    protected $cacheDriver = Redis::class;
}
