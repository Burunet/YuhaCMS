<?php

namespace app\tool\system;

trait SystemDisabled
{
    /***
     * @param String $functionName
     * @return bool
     */
    public function disabledFunction(string $functionName): bool
    {
        // 获取被禁用的函数列表
        $disabled_functions = ini_get('disable_functions');
        // 检查system函数是否在该列表中
        return strpos($disabled_functions, $functionName);
    }

    /***
     * @param array $functionName
     * @return bool
     */
    public function disabledFunctions(array $functionName): bool
    {
        // 获取被禁用的函数列表
        $disabled_functions = ini_get('disable_functions');
        $endValue = false;
        foreach ($functionName as $value) {
            if (strpos($disabled_functions, $value)) {
                $endValue = true;
            }
        }
        return $endValue;
    }
}