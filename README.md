## PCache 

#### 一款灵活高效的PHP缓存库
PCache是一款PHP编写的缓存工具库，提供多种驱动支持，包括Redis、Yac等。通过适配模式实现操作统一，方便使用，也可根据开发需求动态切换。

#### 环境要求

* PHP 5.4+
* Redis缓存需要 [Redis扩展](http://pecl.php.net/package/redis)
* Yac缓存需要 [Yac扩展](http://pecl.php.net/package/yac)

#### 文档

####Redis
---
```php
<?php
$config = [
	'host'       => '127.0.0.1',
	'port'       => 6379,
	'password'   => null,
	'database'   => null,
	'persistent' => true,
	'timeout'    => 30
];

$cache = Pcache\Pcache::create(Pcache\Driver\Redis::class, $config);

$cache->set('key', 'value');	// 添加缓存 返回true

$cache->get('key');			// 读取缓存 返回value
```

####Yac
---
```php
<?php
$config = [
	'prefix' => ''
];

$cache = Pcache\Pcache::create(Pcache\Driver\Yac::class, $config);

$cache->set('key', 'value');	// 添加缓存 返回true

$cache->get('key');			// 读取缓存 返回value
```