<?php
/**
 * Created by PhpStorm.
 * User: seemmo
 * Date: 2019/8/9
 * Time: 9:39
 */
$server = new swoole_http_server("0.0.0.0",8811);

$server->set([
    "log_file" => "/home/happykala/log.log",
    "enable_static_handler" => true,
    "document_root" => "/home/happykala/thinkphp/static/live",
    "worker_num" => 5
]);

$server->on('workerstart',function(swoole_server $server,$woker_id){
    //启动进程的时候将需要的基础类库文件加载进来,不做实际的请求操作，请求操作在request的回调函数中处理
    // 定义应用目录
    define('APP_PATH', __DIR__ . '/../application/');
    // 加载基础文件
    require __DIR__ . '/../thinkphp/base.php';
});

$server->on('request',function($request,$response){
    var_dump($response->server);
    ob_start();
    think\App::run()->send();//执行实际的应用请求
    $content = ob_get_contents();
    $response->end($content);
    ob_clean();
});

$server->start();