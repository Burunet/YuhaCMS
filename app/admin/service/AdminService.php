<?php

namespace app\admin\service;

use app\BaseService;
use app\repositories\AdminRepositories;

class AdminService extends BaseService
{
    public function __construct(AdminRepositories $repository){
        $this->repository = $repository;
    }
    public function getAdminList($data){
        try {
            // 使用 array_filter 和自定义回调函数去除空值但保留0
            $where = array_filter($data, function ($value) {
                // 保留值不是NULL，并且不是空字符串，除非值具体为0（整数0或字符串"0"）
                return $value !== '';
            });
            $keyMappy=['name'=>'admin_name'];
            $data['pageSize'] = $data['pageSize'] ?? 20;
            $data['pageNo'] = $data['pageNo'] ?? 1;
            return $this->ResResponse($this->repository->selectData($this->newKey($where,$keyMappy)));
        }catch (\Exception $e){
            return $this->ErrResponse($e->getMessage());
        }
    }
}