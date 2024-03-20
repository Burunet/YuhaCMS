<?php

namespace app\tool;

use Exception;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;


trait JWTtoken
{


    /**
     * 生成验签
     * @param $data
     * @return mixed
     */
    public function signToken($data)
    {
        $jwtConfig = config('app.JWT');
        $token = array(
            "iss" => $jwtConfig['iss'],        //签发者 可以为空
            "aud" => $jwtConfig['aud'],          //面象的用户，可以为空
            "iat" => time(),      //签发时间
            "nbf" => time(),      //在什么时候jwt开始生效
            "exp" => time() + 3600,  //token 过期时间
            "data" => $data           //记录的信息
        );
//        return json($data);
        $jwt = JWT::encode($token, $jwtConfig['key'], "HS256");  //生成了 token

        $redis = cache()->store('redis')->handler();
        // 切换到数据库 1
        $redis->select(1);
        cache('token:'.$data['adminName'],$jwt,3600);
//        $redis->select(0);
        return $jwt;
    }

    /**
     * 验证token
     * @param $token
     * @return array|int[]
     */
    public function checkToken($token)
    {
        $jwtConfig = config('app.JWT');
        try {
            JWT::$leeway    = 60;//当前时间减去60，把时间留点余地
            $decoded        = JWT::decode($token, new Key($jwtConfig['key'], 'HS256')); //HS256方式，这里要和签发的时候对应
            $data            = (array)$decoded;
            $keyName = (array)$data['data'];
            $redis = cache()->store('redis')->handler();
            // 切换到数据库 1
            $redis->select(1);
            $token = cache('token:'.$keyName['adminName']) == $token;
//            $redis->select(0);
            if ($token){
                return $keyName;
            }else{
                throw new \think\Exception('token无效');
            }
        } catch (SignatureInvalidException $e) { //签名不正确
            throw new \think\Exception('签名不正确');
        } catch (BeforeValidException $e) { // 签名在某个时间点之后才能用
            throw new \think\Exception('token无效');
        } catch (ExpiredException $e) { // token过期
            throw new \think\Exception('token过期');
        } catch (Exception $e) { //其他错误
            throw new \think\Exception('token 解析错误');
        }
    }
}