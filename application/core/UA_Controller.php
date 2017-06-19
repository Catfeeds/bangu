<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月3日11:03:55
 * @author		何俊
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class UA_Controller extends MY_Controller {
	public $defaultArr = array(
			'count' =>0,
			'data' => array()
	);
	public $admin_id;
	public $realname;
	
	public function __construct()
	{
		parent::__construct();
		//判断浏览器
// 		if(preg_match('/MSIE\s+[6789]/',$_SERVER['HTTP_USER_AGENT'])){
// 			header("Location: ".base_url()."admin/update");
// 		}
		
		$this->admin_id = $this ->session ->userdata('a_user_id');
		$this->realname = $this ->session ->userdata('a_realname');
		//判断是否登录，未登录则跳转登录页面
		if (empty($this->admin_id))
		{
			redirect('admin/a/login/index');
		}
		$this->load->library ( 'callback' );
	}
	
	public function view($view_url ,$param = '')
	{
		$this->load->view('admin/a/common/header_new');
		$this->load->view($view_url, $param);
		$this->load->view('admin/a/common/footer_new');
	}
	
	public function load_view($page_view, $param = NULL) {
		$this->load->view('admin/a/common/header');
		$this->load->view($page_view, $param);
		$this->load->view('admin/a/common/footer');
	}
	
	/**
	 * 通过出发城市的ID，或者名称获取ID组，第三级返回自己的ID，第二级返回自己的ID和PID，
	 * @param unknown $id
	 * @param unknown $name
	 */
	public function get_startcity_sd($id ,$name='')
	{
		$this ->load_model('startplace_model');
		$ids='';
		$pids='';
		if ($id)
		{
			$startData = $this ->startplace_model ->all(array('id' =>$id));
		}
		elseif (!empty($name))
		{
			$startData = $this ->startplace_model ->all(array('cityname like' =>'%'.$name.'%'));
		}
		
		if (!empty($startData))
		{
			foreach($startData as $v)
			{
				if ($v['level'] == 3)
				{
					$ids .= $v['id'].',';
				}
				elseif ($v['level'] ==2)
				{
					$ids .= $v['id'].',';
					$pids .= $v['id'].',';
				}
				else
				{
					//第一级
					$data = $this ->startplace_model ->all(array('pid' =>$v['id']));
					foreach($data as $v)
					{
						$pids .= $v['id'].',';
					}
				}
			}
		}
		return array(
				'ids' =>rtrim($ids,','),
				'pids' =>rtrim($pids,',')
		);
	}
	
	/**
	 * @method 获取分页
	 * @author jiakairong
	 * @param intval $page_new 当前页
	 * @param intval $count 总页数
	 */
	public function getAjaxPage($page_new ,$count ,$num=sys_constant::A_PAGE_SIZE) {

		if ($page_new < 1) {
			$page_new = 1;
		} else {
			$page_count = ceil($count / $num);
			if ($page_new > $page_count) {
				$page_new = $page_count;
			}
		}
		$this->load->library ( 'Page_ajax' ); //加载分页类
		$config ['pagesize'] = $num;
		$config ['page_now'] = $page_new;
		$config ['pagecount'] = $count;
		$this->page_ajax->initialize ( $config );
		return $this ->page_ajax ->create_page();
	}

	/**
	 * @method 获取记录总条数
	 * @author jiakairong
	 * @param string $sql sql语句
	 * @param string $fieldStr  统计的字段
	 * @return unknown
	 */
	public function getCountNumber($sql) {
		if (stripos($sql ,'limit')) {
			$sql = substr($sql ,0 ,stripos($sql ,'limit'));
		}
		
		$query = $this->db->query("SELECT COUNT(*) AS num FROM (".$sql.") va");
		$result = $query->result();
		$totalRecords = $result[0]->num;
		return $totalRecords;
	}
	
	/**
	 * @name：私有函数：输出数据,$len是长度 输出的图片地址不带域名
	 * @author: 张允发
	 * @param: $reDataArr (array)
	 * @return: json
	 *
	 */
	
protected function __data($reDataArr,$common=array()) {
		$len="1";
		if(empty($reDataArr))
		{
			$code="4001";
			$msg="data empty";
			$data=array();
		}
		else 
		{
			if(is_array($reDataArr))
			$len=count($reDataArr);
		
			$reDataArr = $this->strip_slashes ( $reDataArr );
			$data=$reDataArr;
			$code="2000";
			$msg="success";
		}
        
		$output= json_encode ( array (
				"msg" => $msg,
				"code" => $code,
				"data" => $data,
				"total" => $len,
				'common'=>$common
		), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
		$jsoncallback = '';
		if(isset($_GET['jsoncallback']))$jsoncallback = $_GET['jsoncallback'];
		if(isset($_POST['jsoncallback']))$jsoncallback = $_POST['jsoncallback'];		
		if(!empty($jsoncallback)){//用于跨域
			echo $jsoncallback . "(".$output.")";
		}else{
			echo $output;
		}		
		exit ();
	}
	
	function strip_slashes($str)
	{
		if (is_array($str))
		{
			foreach ($str as $key => $val)
			{
				$str[$key] = $this->strip_slashes($val);
			}
		}
		else
		{
			$str = stripslashes($str);
		}
	
		return $str;
	}
	
	/**
	 * @name：私有函数：错误输出，已-3为标志
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	protected function __errormsg($msg = "", $code = "-3") {
		$this->result_code = $code;
		if ($msg == "") {
			$this->result_msg = "null";
		} else {
			$this->result_msg = $msg;
		}
		$lastData ['rows'] = "";
		$this->result_data = $lastData;
		$this->resultJSON = json_encode ( array (
				"msg" => $this->result_msg,
				"code" => $this->result_code,
				"data" => $this->result_data,
				"total" => "0"
		) , JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
	
		$jsoncallback = '';
		if(isset($_GET['jsoncallback']))$jsoncallback = $_GET['jsoncallback'];
		if(isset($_POST['jsoncallback']))$jsoncallback = $_POST['jsoncallback'];
		if(!empty($jsoncallback)){//用于跨域
			echo $jsoncallback . "(".$this->resultJSON.")";
		}else{
			echo $this->resultJSON;
		}
		exit ();
	}
	
	//获取随机数
	public function get_rand(){
		$input=time().mt_rand(1000000,9999999);
		$base32 = array (
				'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
				'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p',
				'q', 'r', 's', 't', 'u', 'v', 'w', 'x',
				'y', 'z', '0', '1', '2', '3', '4', '5'
		);
		
		$hex = md5($input);
		$hexLen = strlen($hex);
		$subHexLen = $hexLen / 8;
		$output = array();
		
		for ($i = 0; $i < $subHexLen; $i++) {
			//把加密字符按照8位一组16进制与0x3FFFFFFF(30位1)进行位与运算
			$subHex = substr ($hex, $i * 8, 8);
			$int = 0x3FFFFFFF & (1 * ('0x'.$subHex));
			$out = '';
		
			for ($j = 0; $j < 6; $j++) {
		
				//把得到的值与0x0000001F进行位与运算，取得字符数组chars索引
				$val = 0x0000001F & $int;
				$out .= $base32[$val];
				$int = $int >> 5;
			}
		
// 			$output[] = $out;
		}
// 		$str = null;
// 		$strPol="1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
// 		$strPol=str_shuffle($strPol);
// 		$max = strlen($strPol)-1;
// 		for($i=0;$i<7;$i++){
// 			$str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
// 		}
// 		$str.=mt_rand(1000000,9999999);
// 		$strs=substr(str_shuffle($str),0,7);
		return $out;
	}
}