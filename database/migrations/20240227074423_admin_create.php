<?php

use think\migration\Migrator;

class AdminCreate extends Migrator
{
    /***数据库迁移
     * php think migrate:create [you class name]
     * php think migrate:run
     * php think migrate:rollback
     * @return void
     */
    public function change()
    {
        $table = $this->table('admin',['id'=>false,'primary_key'=>['admin_id'],'comment'=>'管理员信息表']);
        $table ->addColumn('admin_id','integer',['null'=>false,'identity'=>true,'comment'=>'id'])
            ->addColumn('admin_name','char',['limit'=>60,'null'=>false,'default'=>'admin','comment'=>'管理员名称'])
            ->addColumn('password','char',['limit'=>160,'null'=>false,'comment'=>'管理员密码'])
            ->addColumn('role_id','char',['limit'=>11,'comment'=>'管理员角色id'])
            ->addColumn('state','char',['limit'=>60,'null'=>false,'default'=>'0','comment'=>'管理员状态'])
            ->addColumn('login_state','char',['limit'=>60,'null'=>false,'default'=>'0','comment'=>'管理员登录状态'])
            ->addColumn('create_man','char',['limit'=>60,'default'=>'system','comment'=>'创建人'])
            ->addColumn('update_man','char',['limit'=>60,'default'=>'system','comment'=>'更新人'])
            ->addColumn('create_time','datetime',['comment'=>'创建时间'])
            ->addColumn('update_time','datetime',['comment'=>'更新时间'])
            ->addIndex(['admin_name'],['unique'=>true])
            ->create();
        // 插入初始记录
        $defaultAdmin = [
            'admin_id'    => 1,
            'admin_name'  => 'admin',
            'password'    => password_hash('123456', PASSWORD_DEFAULT), // 使用password_hash函数进行密码加密
            'role_id'     => '1',
            'state'       => '1',
            'login_state' => '0',
            'create_man'  => 'system',
            'update_man'  => 'system',
            'create_time' => date('Y-m-d H:i:s'),
            'update_time' => date('Y-m-d H:i:s')
        ];

        $table->insert($defaultAdmin);
        $table->saveData();
    }
}
