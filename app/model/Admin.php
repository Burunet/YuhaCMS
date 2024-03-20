<?php

namespace app\model;

use think\Model;

class Admin extends Model
{
    protected $pk = 'admin_id';
    protected $table = 'admin';
    // 设置字段信息
    protected $schema = [
        'admin_id' => 'int',
        'admin_name' => 'string',
        'password' => 'string',
        'role_id' => 'int',
        'state' => 'int',
        'login_state' => 'int',
        'create_man' => 'string',
        'update_man' => 'string',
        'create_time' => 'datetime',
        'update_time' => 'datetime',
    ];

    /***
     * 自动写入创建和更新的时间戳字段（默认关闭）
     * @var bool
     */
//    protected $autoWriteTimestamp = true;
//一旦配置开启的话，会自动写入create_time和update_time两个字段的值，默认为整型（int），如果你的时间字段不是int类型的话，可以直接使用：
    protected $autoWriteTimestamp = 'datetime';

    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    /***
     * 一对一关联
     * @return \think\model\relation\BelongsTo
     */
    public function roles()
    {
        return $this->belongsTo(AdminRole::class, 'role_id', 'role_id');
    }

    //可以设置convertNameToCamel属性使得模型数据返回驼峰方式命名（前提也是数据表的字段命名必须规范，即小写+下划线）
    protected $convertNameToCamel = true;
}