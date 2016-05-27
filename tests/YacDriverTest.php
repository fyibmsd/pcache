<?php

namespace Tests;

use Pcache\Driver\Yac;

class YacDriverTest extends CacheDriverBase
{
    protected $cacheDriver = Yac::class;

    public function setUp()
    {
        ini_set('yac.enable_cli', 1);

        parent::setUp();
    }
}
