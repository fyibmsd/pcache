<?php

namespace Tests;

use Pcache\Driver\Ssdb;

class SsdbDriverTest extends CacheDriverBase
{
    protected $cacheDriver = Ssdb::class;

    protected $config = [
        'host' => '127.0.0.1',
        'port' => 10101
    ];
}
