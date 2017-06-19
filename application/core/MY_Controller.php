<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月16日18:00:01
 * @author		徐鹏
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class MY_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		if(class_exists('SeasLog')){
			register_shutdown_function(array($this, "__do_all_action_seas_log")) OR set_error_handler(array($this, "__do_all_action_seas_log"),E_ALL); // 同时注册两个函数.
		}
		header ( 'Content-Type:text/html; charset=UTF-8' );
		date_default_timezone_set('Asia/Shanghai');
		$this->load->helper ( 'url' );
		$this->load->helper("my_error");
		$this->load->library('session');
		$this->load->driver('cache');
		$this->CI = & get_instance ();
		$this->get_web();//
		$this ->dataFileExists();
		//$this->db->trans_begin();
	}
	/**
	 * @method 插件数据文件检测是否存在，不存在创建
	 * @author jkr
	 * @since  2016-05-20
	 */
	public function dataFileExists()
	{
		if (!file_exists('./assets/js/staticState/areaSelectJson.js'))
		{
			$this->load_model('admin/a/area_model','area_model');
			$areaData = $this ->area_model ->getSelectAreaAll();
			//select下拉数据
			$this ->createSelectJson($areaData ,'selectAreaJson' ,'./assets/js/staticState/areaSelectJson.js');
			//地区选择插件数据
			$this ->chioceDataPlugins($areaData ,'./assets/js/staticState/chioceAreaJson.js' ,'chioceAreaJson');
			//unset($this ->area_model);
		}
		if (!file_exists('./assets/js/staticState/chioceDestJson.js'))
		{
			$this->load->model ( 'dest/dest_base_model', 'dest_base_model' );
			$whereArr = array('level <=' =>3);
			$destData = $this ->dest_base_model ->getDestBaseAllData($whereArr);
			//目的地选择插件数据
			$this ->chioceDataPlugins($destData ,'./assets/js/staticState/chioceDestJson.js' ,'chioceDestJson');
			//unset($this ->dest_model);
		}
		if (!file_exists('./assets/js/staticState/chioceStartCityJson.js'))
		{
			$this->load->model ( 'admin/a/startplace_model', 'startplace_model' );
			$startData = $this ->startplace_model ->getStartAllData();
			//出发城市选择插件数据
			$this ->chioceDataPlugins($startData ,'./assets/js/staticState/chioceStartCityJson.js' ,'chioceStartCityJson');
			//头部插件数据
			$this ->createHeaderStartJson();
			//unset($this ->startplace_model);
		}
	}
	/**
	 * 全局网站配置
	 */
	public function get_web(){
		if (!defined('ICON')){
			$this->load->model ( 'common/cfg_web_model','cfg_web_model');
			$data=$this->cfg_web_model->row(array('id'=>'1'));
			if (!empty($data))
			{
				define('TITLE', $data['title']);
				define('ICON', $data['icon']);
				define('CHAT_URL' ,$data['expert_question_url']);
				define('WEBNAME',$data['webname']);
				define('BANGU_URL' ,$data['url']);
				define('WEB_URL' ,$data['url']);
				define('WEB_ICP' ,$data['icp']);
				define('WEB_TELEPHONE' ,$data['telephone']);
				define('SERVER_IP' ,$data['serverIp']); //服务器ip地址
				define('APP_VERSION' ,$data['app_api_version']); //APP版本
			}
		}
	}
	/**
	 * 获取数据字典
	 * @param String $code 第一层Code编码
	 * @return result_array
	 */
	protected function get_dict_data($code){
		$this->load->model ( 'admin/a/dictionary_model');
		return $this->dictionary_model->get_dict_data( $code );
	}
	/**
	 * 根据 ids 获取数据字典 可以单个 可以多个
	 * @param unknown $ids
	 * @return result_array
	 */
	protected function get_dict_detail($ids){
		$this->load->model ( 'admin/a/dictionary_model');
		return $this->dictionary_model->get_dict_detail( $ids );
	}

	protected function getPage() {
		$pageNum = 1;
		if (isset ( $_REQUEST['pageNum'] )) {
			$pageNum = $_REQUEST['pageNum'];
		}
		if (isset ( $_REQUEST['pageSize'] )) {
			$config['pageSize'] = $_REQUEST['pageSize'];
		}else{
			$config['pageSize'] = sys_constant::A_PAGE_SIZE;
		}
		if (isset ( $_REQUEST['orderCol'] )) {
			$config['orderCol'] = $_REQUEST['orderCol'];
		}
		if (isset ( $_REQUEST['orderType'] )) {
			$config['orderType'] = $_REQUEST['orderType'];
		}
		$config['pageNum'] = $pageNum;
		$this->load->library ( 'PageJson' ); // 加载分页类
		// 		print_r( $config );
		$this->pagejson->initialize ( $config );
		// 		print_r($this->pagejson);
		return $this->pagejson;
	}
	//单个参数获取
	protected function get($names) {
		$val = null;
		if (isset ( $_REQUEST[$names] )) {
			$val = $_REQUEST[$names];
		}
		return $val;
	}
	//获取多个参数
	protected function getParam($names,$vals = null) {
		$values = array();
		if(null!=$vals){
			foreach($vals as $key=>$v){
				$values[$key] = $v;
			}
		}
		if(null!=$names){
			$v=null;
			foreach($names as $name){
				if (isset ( $_REQUEST[$name] )) {
					$v = $_REQUEST[$name];
					if(''!=$v){
						$values[$name] = $v;
					}
				}
			}
		}
		return $values;
	}

	/**
	 * 写入管理员日志
	 * 使用方法:
	 * $this->log($operate,$user_type,$module, $message);
	 * @param unknown $operate 操作类型(1,增,2删,3改,4查,5审批)
	 * @param unknown $user_type 操作人类型(实体类型)
	 * @param unknown $module 模块
	 * @param unknown $message 操作明细
	 */
	public function log($operate,$user_type,$module, $message) {
		$this->CI->load->model ( 'admin/admin_log_model' );
		return $this->CI->admin_log_model->insert ( $operate,$user_type,$module, $message );
	}

	/**
	 * 插入订单账单日志信息
	 * @param unknown $order_id 订单ID
	 * @param unknown $type 操作类型(1:应收; 2:应付; 3:保险; 4:平台佣金)
	 * @param unknown $num 人数
	 * @param unknown $amount 总价
	 * @param unknown $user_type (实体类型)
	 * @param unknown $user_id (用户登录ID)
	 * @param unknown $content (内容)
	 */
	public function bill_log($order_id, $type, $num, $amount, $user_type, $user_id, $content) {
		$this->CI->load->model ( 'admin/admin_log_model' );
		return $this->CI->admin_log_model->write_bill_log ( $order_id, $type, $num, $amount, $user_type, $user_id, $content);
	}
	/**
	 * 载入模型
	 *
	 * @param string $file
	 * @param string $name
	 * @return boolean
	 */
	protected function load_model($file = TRUE, $name = NULL) {
		$this->load->model ( $file, $name );
	}

	/**
	 * 载入视图
	 *
	 * @param string $page_view
	 * @param string $param
	 */
	protected function load_view($page_view, $param = NULL) {
		$this->load->view ( $page_view, $param );
	}

	/**
	 * 载入不需要头部和尾部的视图
	 *
	 * @param unknown $page_view
	 * @param string $param
	 */
	public function load_self_view($page_view, $param = NULL) {
		$this->load->view($page_view, $param);
	}

	/**
	 * 是否为数据提交模式
	 *
	 * 封装此接口用于后期对数据提交模式的高级检测（如攻击访问等）。
	 */
	protected function is_post_mode() {
		return isset ( $_POST ) && (count ( $_POST ) > 0);
	}
	protected function json_echo($data = NULL, $flag = TRUE, $reason = NULL) {
		$data_packet = array (
				'data' => $data,
				'flag' => $flag,
				'$reason' => $reason
		);
		echo json_encode ( $data_packet );
	}

	/**
	 * @method 截取字符串
	 * @author 贾开荣
	 * @param string $string 要截取的字符串
	 * @param intval $length 截取的长度
	 */
	public function sub_string($string ,$length) {
		if (!empty($string)) {
			$string = strip_tags($string);
			if (mb_strlen($string) > $length) {
				$string = mb_substr($string,0,$length).'...';
			}
		}
		return $string;
	}
	/**
	 * @method 一对一消息写入
	 * @param string $content 消息内容
	 * @param intval $msg_type 接收人实体类型 （0:用户,1:B2,2:B1）
	 * @param intval $receipt_id 接收人ID
	 * @param string $title 消息标题
	 */
	public function add_message($content,$msg_type,$receipt_id ,$title='') {
		$time = date('Y-m-d H:i:s' ,time());
		if (empty($title)) {
			$title = mb_substr($content ,0 ,20);
		}
		$data = array(
			'title' =>$title,
			'content' =>$content,
			'addtime' =>$time,
			'msg_type' =>$msg_type,
			'receipt_id' =>$receipt_id,
			'read' =>0,
			'modtime' =>$time
		);
		$status = $this ->db ->insert('u_message' ,$data);
		if (!empty($status)) {
			return $this ->db ->insert_id();
		} else {
			return false;
		}
	}
	/**
	 * @method 获取IP地址
	 * @author jiakairong
	 */
	public function getip() {
		$unknown = 'unknown';
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		if (false !== strpos($ip, ',')) $ip = reset(explode(',', $ip));
		return $ip;
	}

	/**
	 * @method 发送手机信息
	 * @param  string $mobile 手机号
	 * @param  string $content 内容
	 */
	public function send_message($mobile ,$content){


		if (empty($mobile) || empty($content)) {
			return false;
		}
		$post_data = array();
		$post_data['account'] = iconv('GB2312', 'GB2312',"sz_bangyw");
		$post_data['pswd'] = iconv('GB2312', 'GB2312',"Tch259606");
		$post_data['mobile'] =$mobile;
		$post_data['needstatus'] =false;
		$post_data['msg']=mb_convert_encoding($content,'UTF-8', 'auto');
		$url='http://222.73.117.156/msg/HttpBatchSendSM?';
		//$url='http://115.182.84.226/msg/HttpBatchSendSM?';
		$o="";
		foreach ($post_data as $k=>$v)
		{
			$o.= "$k=".urlencode($v)."&";
		}
		$post_data=substr($o,0,-1);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$result = curl_exec($ch);//20160428104842,108 返回码，逗号后0代表成功
		if (!empty($result)) {
			$resultArr = explode(',', $result);
			if (count($resultArr) == 2 && $resultArr[1] == 0) {
				$this ->insertResord($mobile ,$content);
				return true;
			} else  {
				return false;
			}
		} else {
			return false;
		}
	}
	/**
	 *
	 * @param  $post_url:url地址;
	 *         $data:传递的数据
	 * @return 数组
	 */
	protected function curl($post_url,$data)
	{
		//$post_url = "http://www.1b1u.com/wx/pl/api/save_wx_member";
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $post_url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		$output = curl_exec ( $ch );
		curl_close ( $ch );
		return json_decode($output,true); // true 表示数组形式
	}
	//发送短信计数
	public function insertResord($mobile ,$msg)
	{
		$dataArr = array(
				'mobile' =>$mobile,
				'message' =>$msg,
				'addtime' =>date('Y-m-d H:i:s')
		);
		$this ->db ->insert('u_sms_record' ,$dataArr);
	}
	//sql检测
	protected function check_inject($string)
	{
		return preg_match('/select|insert|and|or|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile/i',$string);

	}

	/**
	 * @method 生成联动的json数据，并保存到js文件中
	 * @author jkr
	 * @since  2016-05-19
	 * @param  $data  保存的数据
	 * @param  $dataName  json数据储存的名称
	 * @param  $fileUrl   数据保存的文件路径
	 */
	public function createSelectJson($data , $dataName,$fileUrl)
	{
		// 		$data = array(
		// 				0 =>array('id'=>1 ,'name' =>'名称' ,'enname' =>'拼音' ,'isopen' =>'是否启用'),
		// 		);
		$dataArr = array();
		if (!empty($data))
		{
			foreach($data as $val)
			{
				$pid = $val['pid'];
				unset($val['pid']);
				unset($val['simplename']);
				unset($val['level']);
				unset($val['ishot']);
				if ($pid == 0)
				{
					$dataArr['defaultArr'][] = $val;
				}
				else
				{
					if ($pid == 2) //国内
					{
						$dataArr['domesticArr'][] = $val;
					}
					elseif ($pid == 1) //境外
					{
						$dataArr['abroadArr'][] = $val;
					}
					$dataArr[$pid][] = $val;
				}
			}
		}
		//写入文件
		$file = fopen($fileUrl ,'w');
		$status = fwrite($file ,'var '.$dataName.' ='.json_encode($dataArr));
		fclose($file);
	}
	/**
	 * @method 生成网站头部的json数据
	 * @author jkr
	 * @since  2016-05-19
	 */
	public function createHeaderStartJson()
	{
		$this->load->model ( 'admin/a/startplace_model', 'startplace_model' );
		$startData = $this ->startplace_model ->all(array('isopen' =>1,'level' =>3) ,'' ,'arr' ,'simplename,id,cityname as name,ishot');
		$startArr = array(
				'热门城市' => array(),
				'ABCDEFG' =>array(),
				'HIJKLMN' =>array(),
				'OPQRST' =>array(),
				'UVWXYZ' =>array()
		);
		foreach($startArr as $key =>$val)
		{
			if ($key == '热门城市') continue;
			$keyLen = strlen($key);
			$i = 0;
			for($i ;$i<$keyLen ;$i++)
			{
				$startArr[$key][$key[$i]] = array();
			}
		}
		if (!empty($startData))
		{
			foreach($startData  as $val)
			{
				if (empty($val['name']) || empty($val['simplename'])) continue;
				if ($val['ishot'] == 1)
				{
					$startArr['热门城市'][] = $val;
				}
				$firstStr = strtoupper(substr($val['simplename'] ,0 ,1));
				switch($firstStr)
				{
					case 'A':
					case 'B':
					case 'C':
					case 'D':
					case 'E':
					case 'F':
					case 'G':
						$startArr['ABCDEFG'][$firstStr][] = $val;
						break;
					case 'H':
					case 'I':
					case 'J':
					case 'K':
					case 'L':
					case 'M':
					case 'N':
						$startArr['HIJKLMN'][$firstStr][] = $val;
						break;
					case 'O':
					case 'P':
					case 'Q':
					case 'R':
					case 'S':
					case 'T':
						$startArr['OPQRST'][$firstStr][] = $val;
						break;
					case 'U':
					case 'V':
					case 'W':
					case 'X':
					case 'Y':
					case 'Z':
						$startArr['UVWXYZ'][$firstStr][] = $val;
						break;
				}
			}
		}
		$url = './assets/js/staticState';
		if (!file_exists($url)) {
			mkdir($url ,'0777');
		}
		$file = fopen($url.'/chioceHeaderCityJson.js' ,'w');
		fwrite($file ,'var chioceHeaderCityJson ='.json_encode($startArr));
		fclose($file);
	}


	/**
	 * @method 生成选择插件的json数据
	 * @author jkr
	 * @since  2016-05-19
	 */
	public function chioceDataPlugins($data ,$fileUrl ,$dataName)
	{
		$startArr = array();
		$threeStartArr = array();
		foreach($data as $key=>$val)
		{
			if (empty($val['name']))
			{
				continue;
			}
			switch($val['level']) {
				case 1: //顶级
					if ($val['id'] == 1) //国外
					{
						$startArr['abroad'] = $val;
					}
					elseif ($val['id'] == 2) //国内
					{
						$startArr['domestic'] = $val;
					}
					break;
				case 2:
					if ($val['pid'] == 1)
					{
						$startArr['abroad']['two'][$val['id']] = $val;
					}
					elseif ($val['pid'] == 2)
					{
						$startArr['domestic']['two'][$val['id']] = $val;
					}
					break;
				case 3:
					$threeStartArr[] = $val;
					break;
				case 4:
					$threeStartArr[] = $val;
					break;
			}
		}
		foreach($threeStartArr as $val)
		{
			foreach($startArr as $index =>$item)
			{
				if (!isset($item['two']))
				{
					unset($startArr[$index]); //没有第二级，则删除掉
				}
				else
				{
					foreach($item['two'] as $k =>$v)
					{
						if ($val['pid'] == $v['id'])
						{
							$startArr[$index]['two'][$k]['three'][] = $val;
						}
					}
				}
			}
		}
		//过滤第三级为空的情况
		foreach($startArr as $key=>$val)
		{
			foreach($val['two'] as $k=>$v)
			{
				if (empty($v['three']))
				{
					unset($startArr[$key]['two'][$k]);
				}
			}
		}
		$url = './assets/js/staticState';
		if (!file_exists($url)) {
			mkdir($url ,'0777');
		}
		$file = fopen($fileUrl ,'w');
		fwrite($file ,'var '.$dataName.' ='.json_encode($startArr));
		fclose($file);
	}
	/**
	 * @method 删除线路详情静态文件
	 * @author jkr
	 * @param unknown $overcity 线路目的地
	 * @param unknown $lineid 线路ID
	 */
	public function del_cache($lineid) {
		$CFG =& load_class('Config', 'core');
		$cache_path = ($CFG->item('cache_path') == '') ? APPPATH.'cache/' : $CFG->item('cache_path');

		$uri =	$CFG->item('base_url').$CFG->item('index_page').'line/'.$lineid.'.html';
		$filepath = $cache_path.md5($uri);
		if (file_exists($filepath))
		{
			unlink($filepath);
		}
	}
	
	/**
	 * @method 新增订单，或修改订单向供应商推送微信消息
	 * @author jkr
	 * @param array $dataArr = array(
	 * 					'orderid' =>'订单ID',(必须)
	 * 					'type' =>'发送类型 1：新增订单，2：更改订单成本，3：退团',(必须),5:添加参团人
	 * 					'yfId' =>'应付表ID',(选填，管家改供应商成本时必须要有)
	 * 					'refundId' =>'退款表ID',(选填，管家退团时必须要有)
	 * 					'num' =>'添加参团人的总人数',(添加参团人必填),
	 * 					'price' =>'添加参团人的总成本',(添加参团人必填)
	 * 				);
	 */
	public function sendMsgOrderWX($dataArr=array())
	{
		$dataArr['server_name'] = empty($_SERVER['SERVER_NAME']) ? '' : $_SERVER['SERVER_NAME'];
		// 创建一个新cURL资源
		$ch = curl_init();
		//启用时会发送一个常规的POST请求
		curl_setopt($ch, CURLOPT_POST, 1);
	
		curl_setopt($ch, CURLOPT_HEADER, 0);
		//设置cURL允许执行的最长秒数
		curl_setopt($ch, CURLOPT_TIMEOUT,30);
		//需要获取的URL地址
		curl_setopt($ch, CURLOPT_URL,'http://supplier.1b1u.com/supplier/message_push/sendMsgOrder');
		//curl_setopt($ch, CURLOPT_URL,'xiaoxi.com/supplier/message_push/sendMsgOrder');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataArr);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	
		//抓取URL并把它传递给浏览器
		$result = curl_exec($ch);
	
		// 关闭cURL资源，并且释放系统资源
		curl_close($ch);
	}
	
	/**
	 * @method 申请额度向供应商推送微信消息(经理通过，并且向供应商申请时)
	 * @author jkr
	 * @param array $dataArr = array(
	 * 					'applyId' =>'额度申请表ID',必须
	 * 				);
	 */
	public function sendMsgQuotaWX($dataArr=array())
	{
		$dataArr['server_name'] = empty($_SERVER['SERVER_NAME']) ? '' : $_SERVER['SERVER_NAME'];
		// 创建一个新cURL资源
		$ch = curl_init();
		//启用时会发送一个常规的POST请求
		curl_setopt($ch, CURLOPT_POST, 1);
	
		curl_setopt($ch, CURLOPT_HEADER, 0);
		//设置cURL允许执行的最长秒数
		curl_setopt($ch, CURLOPT_TIMEOUT,30);
		//需要获取的URL地址
		curl_setopt($ch, CURLOPT_URL,'http://supplier.1b1u.com/supplier/message_push/applyQuotaSendMsg');
		//curl_setopt($ch, CURLOPT_URL,'xiaoxi.com/supplier/message_push/applyQuotaSendMsg');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataArr);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	
		//抓取URL并把它传递给浏览器
		$result = curl_exec($ch);
	
		// 关闭cURL资源，并且释放系统资源
		curl_close($ch);
	}
	
	/**
	 * 写错误日志使用seaslog
	 * */
	public function __do_all_action_seas_log($errno=0 ,$errstr=0 , $errfile=0 ,$errline=0){		
		if($errno && $errfile){
			if(true){
				$earr = array();
				$earr['type'] = $errno;
				$earr['message'] = $errstr;
				$earr['file'] = $errfile;
				$earr['line'] = $errline;
			}
		}else{
			$earr = error_get_last();
		}		
		if(class_exists('SeasLog') && !empty($earr) ){
			//if($earr['type'] =='error'){
				$request =  var_export($_REQUEST,true);	
				$post =  var_export($_POST,true);	
				$get =  var_export($_GET,true);	
				$cookie =  var_export($_COOKIE,true);	
				$session =  var_export($_SESSION,true);	
				$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				$dba = $this->db->queries;
				$sqlerr = $this->db->sql_error_info;	
				//$sqlerr = "";
				if(isset($this->live_db)){
					$dba = array_merge($this->db->queries,$this->live_db->queries);
					$sqlerr = array_merge($this->db->sql_error_info,$this->live_db->sql_error_info);				
				}
				$viewdata = $this->load->get_all_var();
				$viewdata = var_export($viewdata,true);				
				$sql = var_export($dba,true);
				$sqlerr = var_export($sqlerr,true);
				SeasLog::debug('debug type:{type} message:{message} file:{file} line:{line} debug',array('{type}' => $earr['type'],'{message}' =>$earr['message'],'{file}' =>$earr['file'],'{line}' =>$earr['line'])); 
				SeasLog::info('info | url:{url} | request:{request} | post:{post} | get:{get} | cookie:{cookie} | session:{session} | sql:{sql}  | sqlerr:{sqlerr} | viewdata:{viewdata}',
				array('{url}' => $url,'{request}' =>$request,'{post}' =>$post,'{get}' =>$get,'{cookie}' =>$cookie,'{session}' =>$session,'{sql}' =>$sql,'{sqlerr}' =>$sqlerr,'{viewdata}' =>$viewdata));					
			//}
		}	
	}
	
	/**
	 * 析构方法
	 * */
	function __destruct()
	{	
// 		if ($this->db->trans_status() === FALSE)
// 		{
// 			$this->db->trans_rollback();
// 		}
// 		else
// 		{
// 			$this->db->trans_commit();
// 		}
	}
	//end
}
include_once 'UB1_Controller.php';
include_once 'UB2_Controller.php';
include_once 'UA_Controller.php';
include_once 'UC_NL_Controller.php';
include_once 'UC_Controller.php';
include_once 'APP_Controller.php';
include_once 'T33_Controller.php';
require_once("constant/sys_constant.php");
require_once("constant/sess_constant.php");
