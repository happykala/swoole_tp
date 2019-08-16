<?php
namespace app\index\controller;
use think\Config;
use think\Controller;
use app\common\lib\ali\Sms;
use app\common\lib\memory\RedisBasic;
use app\common\lib\Utiltool;
use app\common\lib\Preredis;
use app\common\lib\Commonvalidate;

class Sendsms extends Controller {

    public function send(){
        $postData = request()->post();
        $validateInfo = Commonvalidate::validateMobile($postData);
        if($validateInfo['code'] == 0){
            $randNumber = rand(1000,9999);
            $return = Sms::sendSms($postData['mobilePhone'],$randNumber);
            $return['code'] = 'OK';
            if($return['code'] == 'OK'){
                $objRedis = RedisBasic::getInstance();
                $objRedis->setValue(Preredis::SmsKey().$postData['mobilePhone'],$randNumber,120);
            }
            return Utiltool::showData($return['code'],$return['message']);
        }else{
            return Utiltool::showData(config('code.mobilePhoneerror'),config('code.mobilePhoneerrordes'));
        }
    }
}