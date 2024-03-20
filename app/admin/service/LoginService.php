<?php

namespace app\admin\service;


use app\BaseService;
use app\model\Admin;
use app\tool\JWTtoken;
use think\Exception;

class LoginService extends BaseService
{
    use JWTtoken;

    protected $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    /***
     * 登录service
     * @param $data
     * @return \think\response\Json
     */
    public function toLogin($data)
    {
        try {
            $query = $this->model->where(['admin_name' => $data['name']])->find();
            //TODO 如果要判断数据集是否为空，不能直接使用empty判断，而必须使用数据集对象的isEmpty
            //isEmpty方法是用于select查询结果集的，而不是find  $query->isEmpty()
            //        当使用find方法时，如果没有结果，它将返回null
            if ($query === null) {
                throw new Exception('用户名错误');
            } else if (!password_verify($data['password'], $query['password'])) {
                /**
                 * password_hash('123456', PASSWORD_DEFAULT), // 使用password_hash函数进行密码加密
                 * password_verify($data['password'], $query['password']) 使用password_verify进行验证
                 */
                throw new Exception('密码错误');
            }
            //TODO 使用模型的hidden/visible/append/withAttr方法进行数据集的输出处理
            $query->hidden(['password']);
            $token = $this->signToken($query);
            return $this->ResResponse(['token' => $token], '登录成功');
        } catch (\Exception $e) {
            return $this->ErrResponse($e->getMessage());
        }
    }

    public function getTokenInfo($token)
    {
        try {
            if (empty($token)) {
                throw new Exception('token不能为空');
            }
            $tokenData = $this->checkToken($token);
            return $this->ResResponse($tokenData);
        } catch (\Exception $e) {
            return $this->ErrResponse($e->getMessage());
        }
    }


}