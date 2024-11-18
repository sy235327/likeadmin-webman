<?php
namespace app\common\service;

use app\common\logic\NoticeLogic;
use Exception;
use support\Log;

/**
 * 通知事件监听
 * Class NoticeService
 * @package app\listener
 */
class NoticeService
{
    public function handle($params): true|string
    {
        try {
            if (empty($params['scene_id'])) {
                throw new Exception('场景ID不能为空');
            }
            // 根据不同的场景发送通知
            $result = NoticeLogic::noticeByScene($params);
            if (false === $result) {
                throw new Exception(NoticeLogic::getError());
            }
            return true;
        } catch (Exception $e) {
            Log::info('通知发送失败:'.$e->getMessage());
            return $e->getMessage();
        }
    }
}