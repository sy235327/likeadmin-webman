<?php


namespace app\common\exception;

use RuntimeException;
use Throwable;

class HttpException extends RuntimeException
{
    protected ?\support\Response $response = null;

    public function __construct($message = "", $code = 200, $header=[],Throwable|null $previous = null)
    {
        $header = array_merge($header,['Content-Type'=>'application/json']);
        $this->response = response($message,$code,$header);
        parent::__construct($message, $code, $previous);
    }

    public function getResponse(): ?\support\Response
    {
        return $this->response;
    }
}