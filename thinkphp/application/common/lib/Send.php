<?php
/**
 * Created by PhpStorm.
 * User: seemmo
 * Date: 2019/8/19
 * Time: 13:40
 */

namespace app\common\lib;


use app\common\lib\ali\Sms;
use app\common\lib\memory\RedisBasic;

class Send
{

    /**
     * send and record sms code
     * @param $data
     * @return bool
     */
    public function sendSms($data){
        $randNumber = rand(1000,9999);
        $return = Sms::sendSms($data['mobilePhone'],$randNumber);
        $return['code'] = 'OK';
        $flag = false;
        if($return['code'] == 'OK'){
            $objRedis = RedisBasic::getInstance();
            $flag = $objRedis->setValue(Preredis::SmsKey().$data['mobilePhone'],$randNumber);
        }
        return $flag;
    }
}