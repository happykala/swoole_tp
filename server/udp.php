<?php
/**
 * Created by PhpStorm.
 * User: seemmo
 * Date: 2019/8/5
 * Time: 16:33
 */

$server = new swoole_server("0.0.0.0",8812,SWOOLE_PROCESS,SWOOLE_SOCK_UDP);

$server->set([
    "log_file" => "/home/happykala/log.log"
]);

$server->on('packet',function($server,$data,$cliengInfo){
    $server->sendto($cliengInfo['address'],$cliengInfo['port'],"server data".$data);
    var_dump($cliengInfo);
});
$server->start();