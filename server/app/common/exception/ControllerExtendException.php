<?php


namespace app\common\exception;


class ControllerExtendException extends \Exception
{
    public function __construct(string $message, string $model = '', array $config = [])
    {
        $this->message = '控制器需要继承模块的基础控制器：' . $message;
        $this->model = $model;
    }
}