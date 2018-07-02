<?php
/**
 * Created by 七月
 * Author: 七月
 * Date: 2017/2/18
 * Time: 13:47
 */

namespace app\lib\exception;


class RegisterException extends BaseException
{
    public $code = 400;
    public $msg = '注册失败';
    public $errorCode = 50000;
}