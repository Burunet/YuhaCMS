<?php

use think\migration\Migrator;
use think\migration\db\Column;

class UsersCreate extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('users',['id'=>false,'primary_key'=>['user_id'],'comment'=>'用户表']);
        $table ->addColumn('user_id','integer',['null'=>false,'identity'=>true,'comment'=>'id'])
            ->addColumn('user_name','char',['limit'=>60,'null'=>false,'default'=>'admin','comment'=>'用户名称'])
            ->addColumn('password','char',['limit'=>160,'null'=>false,'comment'=>'密码'])
            ->addColumn('grade_id','char',['limit'=>11,'comment'=>'用户角色/等级id'])
            ->addColumn('info_id','char',['limit'=>11,'comment'=>'用户角色/等级id'])
            ->addColumn('state','char',['limit'=>60,'null'=>false,'default'=>'0','comment'=>'用户状态:1:启用，0：关闭'])
            ->addColumn('login_state','char',['limit'=>60,'null'=>false,'default'=>'0','comment'=>'用户登录状态 1:登录，0：未登录'])
            ->addColumn('create_man','char',['limit'=>60,'default'=>'system','comment'=>'创建人'])
            ->addColumn('update_man','char',['limit'=>60,'default'=>'system','comment'=>'更新人'])
            ->addColumn('create_time','datetime',['comment'=>'创建时间'])
            ->addColumn('update_time','datetime',['comment'=>'更新时间'])
            ->addIndex(['user_name'],['unique'=>true])
            ->create();
        // 插入初始记录
        $defaultUser = [
            'user_id'    => 1,
            'user_name'  => 'admin',
            'password'    => password_hash('123456', PASSWORD_DEFAULT), // 使用password_hash函数进行密码加密
            'grade_id'     => '1',
            'state'       => '1',
            'info_id' => '0',
            'login_state' => '0',
            'create_man'  => 'system',
            'update_man'  => 'system',
            'create_time' => date('Y-m-d H:i:s'),
            'update_time' => date('Y-m-d H:i:s')
        ];

        $table->insert($defaultUser);
        $table->saveData();
    }
}
