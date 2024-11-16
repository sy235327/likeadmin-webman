<?php
namespace app\crontab;


use Workerman\Crontab\Crontab;

class Task
{
    public function onWorkerStart()
    {

        // 每秒钟执行一次
        new Crontab('*/1 * * * * *', function(){
            echo date('Y-m-d H:i:s')."\n";
        });

        // 每5秒执行一次
        new Crontab('*/5 * * * * *', function(){
            echo date('Y-m-d H:i:s')."\n";
        });

        // 每分钟执行一次
        new Crontab('0 */1 * * * *', function(){
            echo date('Y-m-d H:i:s')."\n";
        });

        // 每5分钟执行一次
        new Crontab('0 */5 * * * *', function(){
            echo date('Y-m-d H:i:s')."\n";
        });

        // 每分钟的第一秒执行
        new Crontab('1 * * * * *', function(){
            echo date('Y-m-d H:i:s')."\n";
        });

        // 每天的7点50执行，注意这里省略了秒位
        new Crontab('50 7 * * *', function(){
            echo date('Y-m-d H:i:s')."\n";
        });
        // 每天的2点30执行，注意这里省略了秒位
        new Crontab('30 2 * * *', function(){
            //todo 删除日志表日志
            \app\common\model\OperationLog::destroy(function ($query) {
                $query->where('create_time','<',strtotime("-15 day"));
            },true);
        });

    }
}