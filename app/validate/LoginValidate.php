<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class LoginValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'name'          => 'require|max:25',
        'password'      =>  'require|min:6|max:12'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'name.require'          => '名称必须',
        'password.require'      =>  '请输入密码',
        'name.max'              => '名称最多不能超过25个字符',
        'password.min'          =>  '密码需介于6-12位',
        'password.max'          =>  '密码需介于6-12位',
    ];
}
