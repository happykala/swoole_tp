<?php
/**
 * Created by PhpStorm.
 * User: seemmo
 * Date: 2019/8/16
 * Time: 11:26
 */

namespace app\common\lib;
use think\Validate;

/**
 * Class Commonvalidate 通用的数据校验类
 * @package app\common\lib
 */
class Commonvalidate
{
    /**
     * 校验手机号码
     * @param $data
     * @return array
     */
    public static function validateMobile($data){
        $return = Validate::make()
                    ->rule(['mobilePhone' => config('reger.mobilePhoneReger')])
                    ->check($data);
        if($return == true){
            return ['code' => config('code.mobilePhonesuccess'),'message' => 'success'];
        }else{
            return ['code' => config('code.mobilePhoneerror'),'message' => 'error'];
        }
    }
}