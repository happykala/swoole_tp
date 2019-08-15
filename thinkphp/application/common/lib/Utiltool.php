<?php
/**
 * Created by PhpStorm.
 * User: seemmo
 * Date: 2019/8/15
 * Time: 16:03
 */
namespace app\common\lib;
class Utiltool
{
    /**
     * 返回值封装函数
     * @param $code
     * @param $message
     * @param array $data
     */
    public static function showData($code,$message,$data = []){
        if(is_array($data) && count($data) > 0){
            $return = ['code' => $code, 'message' => $message, 'data' => $data];
        }else{
            $return = ['code' => $code, 'message' => $message];
        }
        echo json_encode($return);
    }
}