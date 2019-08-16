<?php
/**
 * Created by PhpStorm.
 * User: seemmo
 * Date: 2019/8/15
 * Time: 14:02
 */
namespace app\common\lib\memory;

use think\Exception;

/**
 * Class RedisBasic
 * @package app\common\lib\memory
 */
class RedisBasic extends \Redis
{
    /**
     * @var string
     */
    private $ip;
    /**
     * @var integer
     */
    private $port;
    /**
     * @var string
     */
    private $password;
    /**
     * @var integer
     */
    private $time_out;
    /**
     * @var array
     */
    private static $instance = [];

    /**
     * RedisBasic constructor.
     * @param array $redis_config
     * @param $index
     */
    public function __construct($redis_config = array(),$index)
    {
        if(count($redis_config) == 0){
            $this->ip =  config('redis.ip');
            $this->port = config('redis.port');
            $this->password = config('redis.password');
            $this->time_out = config('redis.time_out');
        }else{
            $this->ip = $redis_config['ip'];
            $this->port = $redis_config['port'];
            $this->password = $redis_config['password'];
            $this->time_out = $redis_config['time_out'];
        }

        if($this->connect($this->ip,$this->port,$this->time_out) == true){
            $this->auth($this->password);
        }
        $this->select($index);
    }

    /**
     * get redis operation object
     * @param array $redis_config
     * @param int $index
     * @param bool $doCheck
     * @return mixed
     */
    public static function getInstance($redis_config = array(),$index = 0,$doCheck = true){
        if(self::$instance === [] || !array_key_exists($index,self::$instance) ){
            self::$instance[$index] = new RedisBasic($redis_config,$index);
        }
        if($doCheck){
            try{
                self::$instance[$index]->ping();
            }catch (Exception $e){
                self::$instance[$index] = new RedisBasic($redis_config,$index);
            }
        }
        return self::$instance[$index];
    }

    /**
     * set key-value
     * @param $key
     * @param $value
     * @param int $time_out
     * @return bool
     */
    public function setValue($key,$value,$time_out = 0){
        if(!is_string($value)){
            $value = json_encode($value);
        }
        if($time_out == 0){
            $result = $this->set($key,$value);
        }else{
            $result = $this->setex($key,$value,$time_out);
        }
        return $result;
    }
}