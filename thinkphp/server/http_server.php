<?php
/**
 * Created by PhpStorm.
 * User: seemmo
 * Date: 2019/8/9
 * Time: 9:39
 */
class Http_Server{
    //服务ip
    public $ip = '';
    //端口
    public $port = '';
    //配置
    public $set = array();
    //服务对象
    public $server;
    /**
     * Http_Server constructor.
     * @param $_ip
     * @param $_port
     * @param $_set
     */
    public function __construct($_ip,$_port,$_set)
    {
        $this->ip = $_ip;
        $this->port = $_port;
        $this->set = $_set;
        $this->server = new swoole_http_server($_ip,$_port);
        $this->server->set($_set);
        $this->server->on('WorkerStart',array($this,'onWorkerStart'));
        $this->server->on('Request',array($this,'onRequest'));
        $this->server->on('task',array($this,'onTask'));
        $this->server->on('finish',array($this,'onFinish'));
        $this->server->start();
    }

    /**
     * @abstract workerstart的回调函数
     * @param swoole_server $server
     * @param $work_id
     */
    public function onWorkerStart(swoole_server $server,$work_id){
        //启动进程的时候将需要的基础类库文件加载进来,不做实际的请求操作，请求操作在request的回调函数中处理
        // 定义应用目录
        define('APP_PATH', __DIR__ . '/../application/');
        // 加载基础文件
        require __DIR__ . '/../thinkphp/start.php';
    }

    /**
     * @abstract request的回调函数
     * @param $request
     * @param $response
     */
    public function onRequest($request,$response){
        $this->tanslateRequestParams($request);
        $_POST['http_server'] = $this->server;
        think\App::run()->send();//执行实际的应用请求
    }

    /**
     * @param swoole_server $server
     * @param $task_id
     * @param $from_id
     * @param $data
     */
    public function onTask(swoole_server $server,$task_id,$from_id,$data){
        $objSend = new app\common\lib\Send();
        $method = $data['method'];
        $flag = $objSend->$method($data);
        if($flag){
            echo 'send success';
        }else{
            echo 'send failed';
        }
        $this->server->finish($data);
    }

    /**
     * @param swoole_server $server
     * @param $task_id
     * @param $data
     */
    public function onFinish(swoole_server $server,$task_id,$data){
        echo 'task finish';
    }


    /**
     * @abstract 转换swoole请求中获取的server header cookie post和get等数据信息
     * @param $request
     * @return array
     */
    public function tanslateRequestParams($request){
        $_SERVER = [];
        if(isset($request->server)){
            foreach ($request->server as $key=>$value){
                $_SERVER[strtoupper($key)] = $value;
            }
        }
        if(isset($request->header)){
            foreach ($request->header as $key=>$value){
                $_SERVER[strtoupper($key)] = $value;
            }
        }
        $_GET = [];
        if(isset($request->get)){
            foreach ($request->get as $key=>$value){
                $_GET[$key] = $value;
            }
        }
        $_POST = [];
        if(isset($request->post)){
            foreach ($request->post as $key=>$value){
                $_POST[$key] = $value;
            }
        }
    }
}


$ip = '0.0.0.0';
$port = 8811;
$set = [
    "log_file" => "/home/happykala/log.log",
    "enable_static_handler" => true,
    "document_root" => "/home/happykala/thinkphp/static/live",
    "worker_num" => 5,
    "task_worker_num" => 10
];
$httpServer = new Http_Server($ip,$port,$set);

