<?php
/**
 * Created by PhpStorm.
 * User: seemmo
 * Date: 2019/8/8
 * Time: 17:56
 */

swoole_async_readfile(__DIR__.'/index.txt',function($filename,$content){
    echo "{$filename}: {$content}";
});