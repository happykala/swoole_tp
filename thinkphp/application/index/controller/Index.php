<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        return 'hello happykala';
    }

    public function test(){
        echo time()." test";
        return "hello test";
    }
}
