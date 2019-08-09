<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/4
 * Time: 14:58
 */
class ws {

    const ip = "0.0.0.0";
    const port = "8812";
    public $ws = '';
    public function __construct()
    {
        $this->ws = new Swoole\WebSocket\Server(self::ip,self::port);
        $this->ws->set(array(
            "log_file" => "/home/happykala/demo/log.log",
            "task_worker_num" => 2,
            "worker_num" => 2
        ));
        $this->ws->on('open',array($this,'onOpen'));
        $this->ws->on('message',array($this,'onMessage'));
        $this->ws->on('close',array($this,'onClose'));
        $this->ws->on('task',array($this,'onTask'));
        $this->ws->on('finish',array($this,'onFinish'));
        $this->ws->start();
    }

    /**
     * message 回调函数实现
     * @param $server
     * @param $frame
     */
    public function onMessage($server,$frame){
        echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        $data = [
            "task_number" => 1,
            "work_number" => $frame->fd
        ];
        $server->task($data);
        $server->push($frame->fd, "this is server");
    }

    /**
     * task 任务执行
     * @param $server
     * @param $task_id
     * @param $src_work_id
     * @param $data
     */
    public function onTask($server,$task_id,$src_work_id,$data){
        print_r($data);
        sleep(10);
        return "on task finish";
    }

    /**
     * @param $server
     * @param $task_id
     * @param $data
     */
    public function onFinish($server,$task_id,$data){
        echo "task_id:{$task_id}\n";
        echo "tash_finish_success:{$data}";
    }

    /**
     * open 回调函数
     * @param $server
     * @param $request
     */
    public function onOpen($server,$request){
        echo "server: handshake success with fd{$request->fd}\n";
    }

    /**
     * close 回调函数
     * @param $server
     * @param $fd
     */
    public function onClose($server,$fd){
        echo "client {$fd} closed\n";
    }

}

$wsServer = new ws();