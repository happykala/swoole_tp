<?php
$client = new Swoole\Client(SWOOLE_SOCK_TCP);

if(!$client->connect('127.0.0.1',9501,0.5)){
    die("connect failed");
}

$client->send('hello world');

$data = $client->recv();
if(!$data){
    die('receive data failed');
}else{
    echo $data.'\n';
}

$client->close();

