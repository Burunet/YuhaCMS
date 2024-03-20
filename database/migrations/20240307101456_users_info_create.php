<?php

use think\migration\Migrator;
use think\migration\db\Column;

class UsersInfoCreate extends Migrator
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
        $table = $this->table('users_info',['id'=>false,'primary_key'=>['info_id'],'comment'=>'用户信息表']);
        $table ->addColumn('info_id','integer',['null'=>false,'identity'=>true,'comment'=>'id'])
            ->addColumn('user_last_request_ip','char',['limit'=>60,'comment'=>'用户最后请求ip'])
            ->addColumn('integral','integer',['limit'=>160,'null'=>false,'default'=>0,'comment'=>'积分'])
            ->addColumn('stream','char',['limit'=>160,'null'=>false,'default'=>'0','comment'=>'b流水/同等级高流水优先'])
            ->addColumn('sign_in','char',['limit'=>11,'null'=>false,'default'=>'1','comment'=>'是否可签到:1/0'])
            ->addColumn('create_man','char',['limit'=>60,'default'=>'system','comment'=>'创建人'])
            ->addColumn('update_man','char',['limit'=>60,'default'=>'system','comment'=>'更新人'])
            ->addColumn('create_time','datetime',['comment'=>'创建时间'])
            ->addColumn('update_time','datetime',['comment'=>'更新时间'])
            ->create();
        // 插入初始记录
        $defaultUserInfo = [
            'info_id'    => 1,
            'integral'     => 100,
            'stream' => '0',
            'sign_in' => '1',
            'create_man'  => 'system',
            'update_man'  => 'system',
            'create_time' => date('Y-m-d H:i:s'),
            'update_time' => date('Y-m-d H:i:s')
        ];

        $table->insert($defaultUserInfo);
        $table->saveData();
    }
}
