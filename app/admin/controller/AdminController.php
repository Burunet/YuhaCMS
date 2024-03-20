<?php

namespace app\admin\controller;

use app\admin\service\AdminService;
use app\BaseController;
use hg\apidoc\annotation as Apidoc;
use think\App;

/**
 * @Apidoc\Title("管理员管理")
 */
class AdminController extends BaseController
{
    public function __construct(App $app,AdminService $service)
    {
        $this->service = $service;
        parent::__construct($app);
    }
    /**
     * @Apidoc\Title("基础的接口演示")
     * @Apidoc\Tag("基础,示例")
     * @Apidoc\Method ("GET")
     * @Apidoc\Url ("/admin/adminlist")
     * @Apidoc\Query("name", type="string",require=true, desc="姓名",mock="@name")
     * @Apidoc\Query("phone", type="string",require=true, desc="手机号",mock="@phone")
     * @Apidoc\Query("state", type="string",require=true, desc="状态",mock="0")
     * @Apidoc\Query("pageNo", type="int",require=true, desc="页数",mock="1")
     * @Apidoc\Query("pageSize", type="int",require=true, desc="每页条数",mock="20")
     * @Apidoc\Returned("id", type="int", desc="Id")
     */
    public function getList(){
        $param = $this->request->param();
        return $this->service->getAdminList($param);
    }
}