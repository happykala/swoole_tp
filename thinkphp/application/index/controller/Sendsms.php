<?php
namespace app\index\controller;
use think\Controller;
use app\common\lib\ali\Sms;

class Sendsms extends Controller {
    public function send(){
        $return = Sms::sendSms('18963970962','1234');
        return 'testcode';
    }
}