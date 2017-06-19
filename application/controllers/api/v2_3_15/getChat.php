<?php
class getChat{
	public $redis;
	public $config;
	public function __construct()
	{
		include './application/config/redis.php';
		$this->config = $config;
		ini_set('default_socket_timeout', -1);
		set_time_limit(0);
		$this ->connectRedis();
	}
	/**
	 * @method 链接redis服务器
	 */
	public function connectRedis()
	{
		$this ->redis = new Redis();
		try
		{
			if ($this->config['socket_type'] === 'unix')
			{
				$success = $this->redis->connect($this->config['socket']);
			}
			else // tcp socket
			{
				$success = $this->redis->connect($this->config['host'], $this->config['port'], $this->config['timeout']);
			}
			if ( ! $success)
			{
				log_message('error', 'Cache: Redis connection failed. Check your configuration.');
			}
			if (isset($this->config['password']) && ! $this->redis->auth($this->config['password']))
			{
				log_message('error', 'Cache: Redis authentication failed.');
			}
		}
		catch (RedisException $e)
		{
			log_message('error', 'Cache: Redis connection refused ('.$e->getMessage().')');
		}
	}
	
	/**
	 * @method 获取直播聊天记录
	 * @author jkr
	 */
	public function getLiveChat()
	{
		$room_code = empty($_POST['room_code']) ? '' :$_POST['room_code'];
		$room_id = empty($_POST['room_id']) ? '' :$_POST['room_id'];
		if (empty($room_code) || empty($room_id))
		{
			$data = array(
					'code' =>'-3',
					'msg' =>'缺少必要参数',
					'data' =>array('row'=>''),
					'total'=>'0',
			);
			echo json_encode($data);
			exit;
		}
		function callback($redis ,$chan, $msg) {
			$msgArr = unserialize($msg);
			$data = array(
					'code' =>2000,
					'msg' =>'获取成功',
					'data' =>array('rows' =>$msgArr)
			);
			echo  json_encode($data);
			exit();
		}
		$this->redis ->subscribe(array('live_'.$room_code.$room_id) ,'callback');
	}
}



