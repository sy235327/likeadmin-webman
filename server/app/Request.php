<?php


namespace app;


class Request extends \support\Request
{
    // 全局过滤规则
    protected array $filter = ['trim'];
}