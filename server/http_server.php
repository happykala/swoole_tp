<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/3
 * Time: 20:47
 */
$server = new Swoole\Http\Server('0.0.0.0',8811);

$server->set(array(
    "log_file" => "/home/happykala/log.log",
    "enable_static_handler" => true,
    "document_root" => "/home/happykala/data"
));

$server->on('request',function($request,$response){
    $data = $request->get;
    $response->end('data is '.json_encode($data));
});

$server->start();