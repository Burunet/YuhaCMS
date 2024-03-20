<?php

namespace app;

use http\Message;

abstract class BaseService
{
    protected $repository;

    public function ResResponse($data=[],$message='操作成功',$code=200): \think\response\Json
    {
        return json([
            'code'=>$code,
            'data'=>$data,
            'message'=>$message
        ]);
    }

    public function ErrResponse($message='操作失败',$code=400,$data=[]): \think\response\Json
    {
        return json([
            'code'=>$code,
            'data'=>$data,
            'message'=>$message
        ]);
    }

    /***
     * 把指定的key值换成对应的key
     * @param $originalArray=param
     * @param $keyMapping=[olekey=>newkey]
     * @return array
     */
    public function newKey($originalArray =[],$keyMapping =[]){
        $newArray = [];
        foreach ($originalArray as $key => $value) {
            // 检查当前键是否存在于映射关系中
            if (array_key_exists($key, $keyMapping)) {
                // 如果存在，使用新键
                $newArray[$keyMapping[$key]] = $value;
            } else {
                // 如果不存在，保留原键
                $newArray[$key] = $value;
            }
        }
        return $newArray;
    }
}