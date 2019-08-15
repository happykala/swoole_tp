<?php
namespace app\index\controller;
use think\Config;
use think\Controller;
use app\common\lib\ali\Sms;
use app\common\lib\memory\RedisBasic;
use app\common\lib\Utiltool;

class Sendsms extends Controller {

    public function send(){
        $postData = request()->post();
//        $return = Sms::sendSms('18963970962','1234');
//        return Utiltool::showData($return['code'],$return['message'],$postData);
        $objRedis = RedisBasic::getInstance();
        var_dump($objRedis);
    }
}