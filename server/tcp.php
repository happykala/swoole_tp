<?php
    //创建服务器
    $server = new Swoole\Server('127.0.0.1',9501);

    //set参数
    $server->set([
        "reactor_num" => 4,
        "worker_num" => 8,
        "max_conn" => 50,
        "log_file" => "/home/happykala/demo/log.log"
    ]);

    //监听客户端的连接时间
    $server->on("Connect",function($serve,$fd){
        echo "client:".$fd."Connect\n";
    });

    //监听接收事件
    $server->on("Receive",function($serve,$fd,$from_id,$data){
        $serve->send($fd,"server:".$data);
    });

    //监听连接关闭时间
    $server->on("Close",function($serve,$fd){
        echo "client ".$fd." close";
    });
    //启动服务器
    $server->start();

?>