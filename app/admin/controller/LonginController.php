<?php

namespace app\admin\controller;

use app\admin\service\LoginService;
use app\BaseController;
use think\App;
//引入apidoc
use hg\apidoc\annotation as Apidoc;
use think\exception\ValidateException;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use think\facade\Log;

//设置在apidoc控制器分组名称
/**
 * @Apidoc\Title("管理员登录")
 */
class LonginController extends BaseController
{
    protected $service;

    //继承thinkphp 的BaseController
    public function __construct(App $app,LoginService $service)
    {
        $this->service = $service;
        parent::__construct($app);
    }
    //编写一个
    /**
     * @Apidoc\Title("登录")
     * @Apidoc\Tag("基础,示例,登录")
     * @Apidoc\Method ("POST")
     * @Apidoc\Url ("/admin/Login")
     * @Apidoc\Query("name", type="string",require=true, desc="姓名",mock="admin")
     * @Apidoc\Query("password", type="string",require=true, desc="密码",mock="123456")
     * @Apidoc\Returned("token", type="string", desc="token")
     */
    public function Login(){
        try {
            $param = $this->request->param(['name','password']);
            Log::channel('login')->info(json_encode($param));
            $this->validate($param, [
                'name'          => 'require|max:25',
                'password'      =>  'require|min:6|max:12'
            ],
                [ 'name.require'          => '名称必须',
                    'password.require'      =>  '请输入密码',
                    'name.max'              => '名称最多不能超过25个字符',
                    'password.min'          =>  '密码需介于6-12位',
                    'password.max'          =>  '密码需介于6-12位', ]);

            return $this->service->toLogin($param);
        }catch (ValidateException|\Exception $e){
            //捕获验证器异常并以标准api格式返回
            return $this->service->ErrResponse($e->getMessage());
        }

    }

    /**
     * @Apidoc\Title("取得用户信息")
     * @Apidoc\Tag("基础,示例,登录")
     * @Apidoc\Method ("get")
     * @Apidoc\Url ("/admin/info")
     * @Apidoc\Query("token", type="string",require=true, desc="token",mock="admin")
     * @Apidoc\Returned("token", type="string", desc="token")
     */
    public function getInfo(){
        $param = $this->request->param('token');
        return $this->service->getTokenInfo($param);
    }
    /**
     * @Apidoc\Title("用户登出")
     * @Apidoc\Tag("基础,示例,登录")
     * @Apidoc\Method ("post")
     * @Apidoc\Url ("/admin/LoginOut")
     */
    public function LoginOut(){
        $userInfo = $this->request->userInfo;
        $redis = cache()->store('redis')->handler();
        // 切换到数据库 1
        $redis->select(1);
        cache('token:'.$userInfo['adminName'],null);

        return $this->service->ResResponse();
    }

    /**
     * @Apidoc\Title("生成xlsx文件")
     * @Apidoc\Tag("基础,示例,生成文件")2
     * @Apidoc\Method ("get")
     * @Apidoc\Url ("/admin/tojson")
     * @Apidoc\Query("name", type="string",require=true, desc="要生成的文件名称",mock="testFileName")
     * @Apidoc\Query("data", type="string",require=true, desc="数据[{},{}]",mock="")
     * @Apidoc\Returned("string", type="string", desc="生成的文件名称与路径")
     */
    public function tojson(){

// 你的数据
        $param = $this->request->param();
        $param['data'] = str_replace(' ', '', $param['data']);
        $data = json_decode($param['data'],true);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

// 设置表头
        $sheet->setCellValue('A1', '汇总日期');
        $sheet->setCellValue('B1', '新增人数');
        $sheet->setCellValue('C1', '投注人数');
        $sheet->setCellValue('D1', '投注单数');

// 填充数据
        $row = 2; // 从第二行开始填充数据
        foreach ($data as $datum) {
            $sheet->setCellValue('A' . $row, $datum["summary_date"]);
            $sheet->setCellValue('B' . $row, $datum["新增人数"]);
            $sheet->setCellValue('C' . $row, $datum["投注人数"]);
            $sheet->setCellValue('D' . $row, $datum["投注单数"]);
            $row++;
        }

// 生成Excel文件
        $writer = new Xlsx($spreadsheet);

        // 指定文件保存位置
        $savePath = 'exports/'; // 确保这个目录存在且可写
        if (!file_exists($savePath)) {
            mkdir($savePath, 0777, true);
        }
// 保存文件到服务器
        $fileName = $savePath . $param['name'] . ".xlsx";
        $writer->save($fileName);
        return json($fileName);
    }

}