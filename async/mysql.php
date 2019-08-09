<?php
/**
 * Created by PhpStorm.
 * User: seemmo
 * Date: 2019/8/6
 * Time: 16:37
 */
$db = new Swoole\Coroutine\MySQL();

$server = array(
    'host' => '127.0.0.1',
    'port' => '3306',
    'user' => 'happykala',
    'password' => '123456',
    'database' => 'test',
    'charset' => 'utf8',
    'timeout' => 2
);

$db->connect($server);

$sql = 'show tables';

$result = $db->query($sql);

if($result == false){
    die('hello');
}

var_dump($result);


