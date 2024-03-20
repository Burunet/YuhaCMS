<?php
declare (strict_types=1);

namespace app\middleware;

use app\tool\JWTtoken;

class CheckToken
{
    use JWTtoken;

    /***
     * @param $request
     * @param \Closure $next
     * @return mixed|\think\response\Json
     */
    public function handle($request, \Closure $next)
    {
        // 获取token
        $token = $request->header('X-Token');
        // 验证是否存在token
        if (empty($token)) {
            return json(['message' => 'token为空', 'code' => '401']);
        }
        try {
            // token 合法
            $userInfo = $this->checkToken($token);
            $request->userInfo = $userInfo;
        } catch (\Exception $e) {
            return json(['code' => 440, 'msg' => $e->getMessage()]);
        }
        return $next($request); //返回请求数据本身
    }
}
