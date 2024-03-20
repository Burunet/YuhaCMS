<?php

namespace app\model;

use think\Model;

class AdminRole extends Model
{
    protected $pk = 'role_id';
    protected $table = 'admin_role';
    protected $autoWriteTimestamp = 'datetime';


}