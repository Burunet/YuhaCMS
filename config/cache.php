<?php

// +----------------------------------------------------------------------
// | 缓存设置
// +----------------------------------------------------------------------

return [
    // 默认缓存驱动
    'default' => env('cache.driver', 'redis'),

    // 缓存连接方式配置
    'stores'  => [
        // redis缓存连接
        'redis' => [
            // 驱动方式
            'type'     => 'redis',
            // 服务器地址
            'host'     =>  env('REDIS.REDIS_HOST','127.0.0.1'),
            // 端口
            'port'     => env('REDIS.REDIS_PORT',6379),
            // 密码
            'password' => env('REDIS.REDIS_PASSWORD',null),
            // 选择的数据库
            'select'   =>  env('REDIS.REDIS_DATABASE',0),
            // 连接超时时间（秒）
            'timeout'  => 0,
            // 是否长连接
            'persistent' => false,
            // 缓存前缀
            'prefix'   => '',
            // 缓存有效期 0表示永久缓存
            'expire'   => 0,
        ],
        'file' => [
            // 驱动方式
            'type'       => 'File',
            // 缓存保存目录
            'path'       => '',
            // 缓存前缀
            'prefix'     => '',
            // 缓存有效期 0表示永久缓存
            'expire'     => 0,
            // 缓存标签前缀
            'tag_prefix' => 'tag:',
            // 序列化机制 例如 ['serialize', 'unserialize']
            'serialize'  => [],
        ],
        // 更多的缓存连接
    ],
];
