<?php

use think\migration\Migrator;
use think\migration\db\Column;

class AdminRoleCreate extends Migrator
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
        $table = $this->table('admin_role',['id'=>false,'primary_key'=>['role_id'],'comment'=>'角色信息表']);
        $table ->addColumn('role_id','integer',['null'=>false,'identity'=>true,'comment'=>'角色id'])
            ->addColumn('role_name','char',['limit'=>60,'null'=>false,'default'=>'admin','comment'=>'角色名称'])
            ->addColumn('power','json',['comment'=>'权限列表json'])
            ->addColumn('state','char',['limit'=>60,'null'=>false,'default'=>'0','comment'=>'角色状态'])
            ->addColumn('create_man','char',['limit'=>60,'default'=>'system','comment'=>'创建人'])
            ->addColumn('update_man','char',['limit'=>60,'default'=>'system','comment'=>'更新人'])
            ->addColumn('create_time','datetime',['comment'=>'创建时间'])
            ->addColumn('update_time','datetime',['comment'=>'更新时间'])
            ->create();
    }
}
