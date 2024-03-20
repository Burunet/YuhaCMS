<?php

namespace app\command\initial;
use app\tool\system\SystemDisabled;
use think\console\Output;
use think\Exception;

class DebugInitialModel implements InitialModel
{
    use SystemDisabled;
    protected $output;
    public function __construct(Output $Output)
    {
        $this->output = $Output;
    }

    public function notice()
    {
        // TODO: Implement notice() method.
        try {
            if ($this->disabledFunction('system')){
                throw new Exception('system函数被禁用');
            }
            $this->initialSQL();

        }catch (\Exception $e){
            $this->output->writeln('[ERROR]'.$e->getMessage());
        }

    }
    public function initialSQL(){
        $this->output->writeln('数据库初始化开始......');
        //初始化数据库
        $dataBaseMessage = system('php think migrate:run', $return_var);
        $this->output->writeln($dataBaseMessage);
        $this->output->writeln('数据库初始化结束--end');
        return $return_var;
    }
}