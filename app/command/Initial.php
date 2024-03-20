<?php
declare (strict_types = 1);

namespace app\command;

use app\command\initial\DebugInitialModel;
use app\command\initial\DefaultInitialModel;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;
use think\Exception;
class Initial extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('initial')
            ->setDescription('the initial command')
            ->addArgument('model', Argument::OPTIONAL, "初始化模式");
    }

    protected function execute(Input $input, Output $output)
    {
        $output->writeln('YuHa-CMS 项目初始化开始...');

        try {
            // 获取参数
            $model = $input->getArgument('model') ?: 'default';
            switch ($model){
                case 'default':
                    $output->writeln('/默认的设置进行初始化.....');
                    $modelOption = app()->make(DefaultInitialModel::class);
                    $modelOption->notice();
                    break;
                case 'debug':
                    $output->writeln('/以调试模式进行初始化.....');
                    $modelOption = app()->make(DebugInitialModel::class);
                    $modelOption->notice();
                    break;
                default:
                    throw new Exception('初始化模式不存在--'.$model);
            }
            $output->writeln('数据库初始化成功');

            // 指令输出
            $output->writeln('项目初始化成功');
            $output->writeln('后台管理默认账号密码： admin  123456');
        }catch (\Exception $e){
            $output->writeln('[ERROR]-项目初始化错误');
            $output->writeln('[ERROR]-'.$e->getMessage());
        }

    }
}
