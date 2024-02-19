<?php


namespace app\common\exception;

use Throwable;

class HttpException extends \RuntimeException
{
    protected $response = null;

    public function __construct($message = "", $code = 0, $header=[],Throwable $previous = null)
    {
        $this->response = json(json_decode($message,true));
        parent::__construct($message, $code, $previous);
    }

    public function getResponse(){
        return $this->response;
    }
}