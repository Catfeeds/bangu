<?php
/**
 *   @name:APP接口 => C端
 * 	 @author: 温文斌
 *   @time: 2016.03.28
 *   
 *	 @abstract:
 *
 *      1、	 __outmsg()、__data()是输出格式化数据模式，
 *      	 __null()是输出空，
 *      	 __errormsg()是输出错误模式
 *        
 *      2、数据传递方式： POST
 * 		
 *      3、返回结果状态码:  2000是成功，4001是空null，-3是错误信息
 */


if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

//继承APP_Controller类
class Z extends APP_Controller {
	public $urate = 10;//人民币兑换U币的倍率
	public $redis ;
	public function __construct() {
		parent::__construct ();
		$this->load->driver('cache');
	}
	
	public function redis() {
		$s = $this ->cache->redis ->set('name' ,'rong');
		echo $this ->cache->redis->get('name');
	}
	
	/**
	 * @method 用户发起支付写入数据
	 * @author jkr
	 */
	public function user_pay()
	{
		$user_id = intval($this ->input ->post('user_id'));
		$money = floatval($this ->input ->post('money'));
		$user_id = 1;
		$money = 2;
		$this ->load_model('live/live_recharge_model' ,'rechargeModel');
		$dataArr = array(
				'user_id' =>$user_id,
				'money' =>$money,
				'status' =>0,
				'addtime' =>date('Y-m-d H:i:s' ,time())
		);
		$id = $this ->rechargeModel ->insert($dataArr);
		if ($id == false)
		{
			$this ->__errormsg('写入失败');
		} else {
			$dataArr = array(
					'ordersn' =>'0088'.$id,
					'user_id' =>$user_id,
					'money' =>$money
			);
			$this->__outmsg($dataArr);
		}
	}
	
	
	/**
	 * @method 支付宝支付，回调处理，适用于用户充值
	 * @author jkr
	 */
	public function live_alipay()
	{
		$this->load->library ( 'Alipay_api' );
		//验证数据
		$status = $this ->alipay_api ->get_verifyNotify();
		//$status = true;
		if ($status == false)
		{
			echo 'fail'; //支付宝验证失败
		}
		else
		{
			$ordersn = $_POST['out_trade_no'];//商户订单号
			$trade_no = $_POST['trade_no'];//支付宝交易号
			$money = $_POST['total_fee'];//交易金额
			$trade_status = $_POST['trade_status'];//交易状态
			$addtime = empty($_POST['gmt_payment']) ? date('Y-m-d H:i:s' ,time()) : $_POST['gmt_payment'];
			$recharge_id = substr($ordersn ,4);
			if ($trade_status == 'TRADE_FINISHED' || $trade_status =='TRADE_SUCCESS')
			{
				$this->load_model('live/live_recharge_model' ,'rechargeModel');
				$rechargeData = $this ->rechargeModel ->row(array('id' =>$recharge_id));
				if (empty($rechargeData) || $rechargeData['status'] !=0)
				{
					echo 'fail';//支付订单不存在或已支付
					exit;
				}
				$balance = abs($rechargeData['money'] - $money);
				if ($balance > 0.0001)
				{
					echo 'fail';//支付金额不正确
					exit;
				}
				$rechargeArr = array(
						'umoney' =>round($money * $this->urate),
						'addtime' =>$addtime,
						'serial' =>$trade_no,
						'pay_way' =>'支付宝',
						'status' =>1
				);
				$status = $this ->rechargeModel ->userRecharge($rechargeData['user_id'] ,$rechargeArr ,$recharge_id);
				if ($status == false) {
					echo 'fail';//更新数据失败
				} else {
					echo 'success';//支付处理成功
				}
			}
			else 
			{
				echo 'fail';//支付宝返回状态表示支付失败
			}
		}
	}
	/**
	 * @method 微信支付，回调处理，适用于用户充值
	 * @author jkr
	 */
	public function live_weixin()
	{
		
	}
	
	/**
	 * @method 会员购买礼物接口
	 * @author jkr
	 */
	public function user_buy_gift()
	{
		$user_id = intval($this ->input ->post('user_id')); //用户ID
		$gift_id = intval($this ->input ->post('gift_id')); //礼物ID
		$anchor_id = intval($this ->input ->post('anchor_id')); //主播ID
		$room_id = intval($this ->input ->post('room_id')); //房间ID
		$num = intval($this ->input ->post('num')); //购买礼物数量
		
// 		$num = 2;
// 		$room_id = 1;
// 		$anchor_id = 1;
// 		$user_id = 2;
// 		$gift_id = 1;
		
		if ($gift_id < 1) {
			$this ->__errormsg('请选择购买礼物');
		}
		if ($num < 1) {
			$this ->__errormsg('请填写购买的礼物数量');
		}
		if ($user_id < 1 || $anchor_id < 1 || $room_id < 1)
		{
			$this ->__errormsg('缺少参数');
		}
		$this ->load_model('live/live_room_model' ,'roomModel');
		$this ->load_model('live/live_gift_record_model' ,'recordModel');
		$this ->load_model('live/live_gift_model' ,'giftModel');
		$this ->load_model('live/anchor_model' ,'anchorModel');
		//查询当前主播是否在直播
		$roomData = $this ->roomModel ->row(array('anchor_id' =>$anchor_id ,'room_id' =>$room_id));
		if (empty($roomData) || $roomData['status'] != 1)
		{
			$this ->__errormsg('主播并未在该房间直播');
		}
		//查询礼物
		$giftData = $this ->giftModel ->row(array('gift_id' =>$gift_id ,'status' =>1));
		if (empty($giftData))
		{
			$this ->__errormsg('礼物不存在');
		}
		//查询会员
		$userData = $this ->anchorModel ->getUserUMoney($user_id);
		if (empty($userData))
		{
			$this ->__errormsg('用户不存在');
		}
		//计算U币是否足够
		$giftUMoney = $giftData['worth']*$num;
		if ($userData['umoney'] < $giftUMoney)
		{
			$this ->load_model('live/live_recharge_model' ,'rechargeModel');
			$dataArr = array(
					'user_id' =>$user_id,
					'money' =>$money,
					'status' =>0,
					'addtime' =>date('Y-m-d H:i:s' ,time())
			);
			$id = $this ->rechargeModel ->insert($dataArr);
			
			$recharge_u = $giftUMoney - $userData['umoney']; //不足的U币数量
			$this->result_data = array(
					'balance_u' =>$userData['umoney'],
					'recharge_u' =>$recharge_u,
					'money' =>round($recharge_u/$this->urate ,2),
					'gift_name' =>$giftData['gift_name'],
					'ordersn' =>'0088'.$id
			);
			//$this ->__errormsg('U币不足，请充值' ,6000);
			$this ->__successmsg($this->result_data);
		}
		//更改用户U币余额，购买礼物
		$buyGift = array(
				'gift_id' =>$gift_id,
				'anchor_id' =>$anchor_id,
				'room_id' =>$room_id,
				'room_code' =>$roomData['room_code'],
				'user_id' =>$user_id,
				'num' =>$num,
				'worth' =>$giftUMoney,
				'addtime' =>date('Y-m-d H:i:s' ,time()),
				'pic' =>$giftData['pic']
		);

		$status = $this ->anchorModel ->userBuyGift($user_id ,$buyGift);
		if ($status === FALSE)
		{
			$this ->__errormsg('购买失败');
		} else {
			//写入缓存，作为聊天信息
			$contentArr = array(
					'nickname' =>$userData['name'],
					'type' =>2,
					'gift_name' =>$giftData['gift_name'],
					'number' =>$num,
					'pic' =>$giftData['pic'],
					'unit' =>$giftData['unit']
			);
			$this ->cache ->redis ->publish('live_'.$roomData['room_code'].$room_id ,serialize($contentArr));
			//主播本次直播获得的U币
			$this->cache->redis->incrby ('anchor_u_'.$roomData['room_code'].$room_id ,$giftUMoney);
			$this->cache->redis->expire('anchor_u_'.$roomData['room_code'].$room_id ,10*3600);
			//贡献排行缓存
			$userUmoney = $this->cache->redis->zscore ('rankingrl_'.$roomData['room_code'].$room_id ,$user_id.'#0#'.$userData['name']);
			$countUmoney = round($userUmoney + $giftUMoney);
			$this->cache->redis->zadd('rankingrl_'.$roomData['room_code'].$room_id ,$countUmoney ,$user_id.'#0#'.$userData['name']);
			$this->cache->redis->expire('rankingrl_'.$roomData['room_code'].$room_id ,10*3600);
			
			$giftData['num'] = $num;
			$giftData['umoney'] = $giftUMoney;
			$this->__outmsg($giftData);
		}
	}
	
	
	
	/**
	 * @method 聊天记录写入
	 * @author jkr
	 */
	public function insertChat()
	{
		$room_id = intval($this ->input ->post('room_id')); //房间ID
		$room_code = trim($this ->input ->post('room_code' ,true)); //房间标识
		$user_id = intval($this ->input ->post('user_id')); //用户ID
		$nickname = trim($this ->input ->post('nickname' ,true)); //用户名称
		$content = trim($this ->input ->post('content' ,true)); //聊天内容
		
		if (empty($content))
		{
			$this ->__errormsg('请输入聊天内容');
		}
		if ($room_id <1 || $user_id < 1 || empty($nickname) || empty($room_code))
		{
			$this ->__errormsg('缺少参数');
		}
		
		$chatArr = array(
				'room_id' =>$room_id,
				'room_code' =>$room_code,
				'user_id' =>$user_id,
				'nickname' =>$nickname,
				'content' =>$content,
				'addtime' =>date('Y-m-d H:i:s' ,time())
		);
		$this ->load_model('live/live_room_chat_model' ,'chatModel');
		//写入缓存
		$contentArr = array(
				'nickname' =>$nickname,
				'content' =>$content,
				'type' =>1
		);
		$num = $this ->cache ->redis ->publish('live_'.$room_code.$room_id ,serialize($contentArr));
		if ($num > 0) {
			//写入数据库
			$chatId = $this ->chatModel ->insert($chatArr);
			//记录聊天人数
			$this->cache->redis->sadd('chat_people_'.$room_code.$room_id ,$user_id);
			$this->__outmsg($chatArr);
		} else {
			$this ->__errormsg('发送失败');
		}
	}
	
	/**
	 * @method 实时数据，1-聊天人数，2-主播获得的贡献
	 * @author jkr
	 * @since  2016-06-03
	 */
	public function real_time_data()
	{
		$room_code = trim($this ->input ->post('room_code' ,true)); //房间标识
		$anchor_id = intval($this ->input ->post('anchor_id'));//主播ID
		$room_id = intval($this ->input ->post('room_id')); //房间ID
// 		$room_code = '123456';
// 		$anchor_id = 1;
// 		$room_id = 1;
		//聊天人数
		$chatCount = $this->cache->redis->scard('chat_people_'.$room_code.$room_id);
		//获得的U币
		$umoney = $this ->anchor_contribute($room_code ,$anchor_id ,$room_id);
		
		$dataArr = array(
				'chatCount' =>$chatCount,
				'umoney' =>$umoney
		);
		$this->__outmsg($dataArr);
	}
	
	/**
	 * @method 主播当次直播获得的U币
	 * @author jkr
	 */
	public function anchor_contribute($room_code ,$anchor_id ,$room_id)
	{
		if (empty($room_code) || $anchor_id < 1 || $room_id < 1) 
		{
			$this ->__errormsg('缺少参数');
		}
		$umoney = $this->cache->redis->get ('anchor_u_'.$room_code.$room_id);
		if ($umoney == false)
		{
			$this ->load_model('live/live_gift_record_model' ,'recordModel');
			$sumArr = $this ->recordModel ->anchorUMoneySum($anchor_id ,$room_id ,$room_code);
			$umoney = empty($sumArr) ? 0 : $sumArr['umoney'];
			$this->cache->redis->setex ('anchor_u_'.$room_code.$room_id ,10*3600 ,$umoney);
		}
		return $umoney;
	}
	/**
	 * @method 会员对主播的贡献排行
	 * @author jkr
	 */
	public function user_contribute_ranking()
	{
		$room_code = trim($this ->input ->post('room_code' ,true)); //房间标识
		$anchor_id = intval($this ->input ->post('anchor_id'));//主播ID
		$room_id = intval($this ->input ->post('room_id')); //房间ID
// 		$room_code = '123456';
// 		$anchor_id = 1;
// 		$room_id = 1;
		if (empty($room_code) || $anchor_id < 1 || $room_id < 1)
		{
			$this ->__errormsg('缺少必要参数');
		}
		$key = 'rankingrl_'.$room_code.$room_id; //贡献排行在redis中的key值
		$rankingRedis = $this->cache->redis->zrevrangebyscore($key ,'+inf' ,0,true ,array(0,5));
		if (empty($rankingRedis))
		{
			$this ->load_model('live/live_gift_record_model' ,'recordModel');
			$rankingArr = $this ->recordModel ->contributeRanking($anchor_id ,$room_id ,$room_code);
			//var_dump($this->recordModel->db->queries);
			if (!empty($rankingArr))
			{
				foreach($rankingArr as $val)
				{
					$a = $this->cache->redis->zadd($key ,$val['umoney'] ,$val['user_id'].'#0#'.$val['username']);
				}
				$this->cache->redis->expire($key ,3600*10);//保存10个小时
			}
		}
		else 
		{
			$rankingArr = array();
			foreach($rankingRedis as $key=>$val)
			{
				$keyArr = explode('#0#', $key);
				$rankingArr[] = array(
						'username' =>$keyArr[1],
						'umoney' =>$val
				);
			}
		}
		if (empty($rankingArr))
		{
			$this ->__nullmsg();
		} else {
			$this ->__outmsg($rankingArr);
		}
	}
	/**
	 * @method 礼物数据接口
	 * @author jkr
	 */
	public function live_gift_data()
	{
		$giftData = $this->cache->redis->get('live_gift_data');
		
		if (empty($giftData))
		{
			$this ->load_model('live/live_gift_model' ,'giftModel');
			$giftData = $this ->giftModel ->getGiftData(array('status' =>1) ,'showorder asc');
			$this->cache->redis->set('live_gift_data' ,serialize($giftData));
			$this->cache->redis->expire('live_gift_data' ,3600);
		} else {
			$giftData = unserialize($giftData);
		}
		if (empty($giftData))
		{
			$this->__nullmsg();
		} else {
			$this->__outmsg($giftData);
		}
	}
	/**
	 * @method 用户充值记录接口
	 * @author jkr
	 * @param user_id:用户ID
	 */
	public function user_recharge_data()
	{
		$user_id = intval($this ->input ->post('user_id')); //用户ID
		$page = intval($this ->input ->post('page')); //当前页
		$pagesize = intval($this ->input ->post('pagesize')); //每页条数
		//$user_id = 1;
		if ($user_id < 1) {
			$this ->__errormsg('缺少用户参数');
		}
		$page = $page < 1 ? 1 :$page;
		$pagesize = $pagesize < 1 ? 10 :$pagesize;
		$this ->load_model('live/live_recharge_model' ,'rechargeModel');
		$rechargeData = $this ->rechargeModel ->getAppRechargeData($user_id ,$page ,$pagesize);
		if (empty($rechargeData))
		{
			$this->__nullmsg();
		} else {
			$this->__outmsg($rechargeData);
		}
	}
	/**
	 * @method 用户购买礼物记录接口
	 * @author jkr
	 * @param user_id:用户ID
	 */
	public function gift_buy_record_data()
	{
		$user_id = intval($this ->input ->post('user_id')); //用户ID
		$page = intval($this ->input ->post('page')); //当前页
		$pagesize = intval($this ->input ->post('pagesize')); //每页条数
		//$user_id = 2;
		if ($user_id < 1) {
			$this ->__errormsg('缺少参数');
		}
		$page = $page < 1 ? 1 :$page;
		$pagesize = $pagesize < 1 ? 10 :$pagesize;
		$this ->load_model('live/live_gift_record_model' ,'recordModel');
		$recordData = $this ->recordModel ->getAppRecordData($user_id ,$page ,$pagesize);
		if (empty($recordData))
		{
			$this->__nullmsg();
		} else {
			$this->__outmsg($recordData);
		}
	}
	
}

/* End of file webservices.php */
/* Location: ./application/controllers/webservices.php */