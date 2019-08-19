<?php
namespace app\index\controller;

//use app\common\lib\Send;
use think\Controller;
use app\common\lib\Utiltool;
use app\common\lib\Commonvalidate;

class Sendsms extends Controller {

    public function send(){
        $postData = request()->post();
        $validateInfo = Commonvalidate::validateMobile($postData);
        if($validateInfo['code'] == 0){
            $swooleHttpServer = $postData['http_server'];
            $data = [
                'method' => 'sendSms',
                'mobilePhone' => $postData['mobilePhone']
            ];
            $swooleHttpServer->task($data);
            return Utiltool::showData(config('code.mobilePhonesuccess'),config('code.success'));
        }else{
            return Utiltool::showData(config('code.mobilePhoneerror'),config('code.mobilePhoneerrordes'));
        }
    }
}