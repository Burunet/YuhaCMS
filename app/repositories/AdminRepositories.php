<?php

namespace app\repositories;

use app\model\Admin;
use hg\apidoc\annotation as Apidoc;
use think\Exception;

class AdminRepositories
{
    protected $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    /***
     * @param $data
     * @return \think\Paginator
     * @throws \think\db\exception\DbException
     */
    public function selectData($data)
    {
        $where = array_intersect_key($data, ['admin_id', 'admin_name', 'role_id', 'state', 'login_state']);
        $query = $this->model->where($where)->with(['roles'])
            ->order('create_time', 'desc')
            ->paginate([ 'list_rows' => $data['pageSize'], // 每页数量
                'page' => $data['pageNo'] ]);
        $query->hidden(['password']);
        $query->toArray();
        // 获取总记录数
        $count = $query->total();
        // 获取总页数
        $totalPages = $query->lastPage();

        return $query;
    }

    public function insterData($data)
    {

    }

    public function updateData($id, $data)
    {

    }

    public function deleteData($data)
    {

    }
}