<?php

declare (strict_types = 1);

namespace app;

use ReflectionClass;
use taoser\exception\ValidateException;
use taoser\Validate;
use \support\Request;
/**
 * 控制器基础类
 */
abstract class BaseController
{
    /**
     * Request实例
     */
    protected Request $request;

    /**
     * 是否批量验证
     */
    protected bool $batchValidate = false;

    /**
     * 构造方法
     * app.controller_reuse 配置为true 那么每次请求都会调用构造方法,否则进程只会调用一次该构造函数
     * @access public
     */
    public function __construct()
    {

    }

    /**
     * 请求对象注入
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * 每次请求在 EndMiddleware拦截器 中进行的初始化
     */
    // 初始化
    public function initialize(): void
    {
    }

    /**
     * 验证数据
     * @access protected
     * @param array $data 数据
     * @param array|string $validate 验证器名或者验证规则数组
     * @param array $message 提示信息
     * @param bool $batch 是否批量验证
     * @throws ValidateException
     * @throws \ReflectionException
     */
    protected function validate(array $data, array|string $validate, array $message = [], bool $batch = false): true|array|string
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                [$validate, $scene] = explode('.', $validate);
            }
            $class = new ReflectionClass($validate);
            // 验证器是否存在
            if (! $class->isInstantiable()) {
                throw new ValidateException('class not exists:' . $class->getName());
            }
            $v = $class->newInstance();
            if (! empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }
}
