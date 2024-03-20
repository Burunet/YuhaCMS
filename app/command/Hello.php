<?php
declare (strict_types = 1);

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\console\input\Argument;

class Hello extends Command
{
    protected function configure()
    {
        // 设置命令的名称、描述和参数
        $this->setName('hello')
            ->setDescription('这是一个示例命令')
            ->addArgument('name', Argument::OPTIONAL, "你的名字")
            ->addArgument('test', Argument::OPTIONAL, "test");
    }

    protected function execute(Input $input, Output $output)
    {
        // 获取参数
        $name = $input->getArgument('name') ?: '世界';
        $test = $input->getArgument('test') ?: 'test';
        // 向控制台输出结果
        $output->writeln("你好, {$name} $test!");
    }
}
