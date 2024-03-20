<?php

namespace app\command\initial;

use Symfony\Component\Process\Process;

class DefaultInitialModel implements InitialModel
{
    public function notice()
    {
        // TODO: Implement notice() method.
        //初始化数据库
        $this->initialSQL();
    }

    /***
     * @return string
     */
    public function initialSQL():string
    {
        $process = new Process(['php', 'think', 'migrate:run']);
        $errorBuffer = ''; // 用于收集错误信息
        $successBuffer = ''; // 用于收集执行信息
        $process->start(function ($type, $buffer) use (&$errorBuffer, &$successBuffer) {
            $errorBuffer ='';
            if (Process::ERR === $type) {
                $errorBuffer .= $buffer;
            } else {
                $successBuffer.= $buffer;
            }
        });
        // 等待进程结束
        $process->wait();
        if (!empty($errorBuffer)) {
            return $errorBuffer;
        }
        return $successBuffer;
    }
}