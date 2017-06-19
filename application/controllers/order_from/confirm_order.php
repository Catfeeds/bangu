<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月23日15:36:00
 * @author		贾开荣
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	
class Confirm_order extends UC_Controller {
	const certificate_type = "DICT_CERTIFY_WAY"; //证件类型
	
	public function __construct() {
		parent::__construct ();
		
		$this->load->model ( 'order_info_model', 'order_model' );
	}
	
	//成功提示
	public function order_success() {
		$this->load->library('session');
		$order_id = intval($this ->input ->get('oid' ,true));
		$this ->load->view('order/order_success' ,array('id' =>$order_id));
	}
	
	//出游人信息页面
	public function message() {
		$this->load->library('session');
		$order_id = $this ->session ->userdata('cOrderId');
		//获取游客信息
		$this ->load_model('member_traver_model' ,'traver_model');
		$whereArr = array(
			'mom.order_id' =>$order_id
		);
		$traver = $this ->traver_model ->get_traver_data($whereArr);

		//获取证件类型
		$this->load->model ( 'dictionary_model', 'dictionary_model' );
		$dict_data = $this ->dictionary_model ->get_dictionary_data(self::certificate_type);
		//国籍
		$sql = "select id,name from u_area where pid = 0 and isopen = 1";
		$query = $this ->db ->query($sql);
		$country = $query ->result_array();
	
		//获取当前年
		$cyear = date('Y',time());
		//出生年的范围
		$year = range(1930,$cyear);
		rsort($year);
	
		$eyear = $cyear + 50;
		//证件有效期的范围
		$cyear = range($cyear,$eyear);
		//月份
		$month = range(1,12);
		$data = array(
				'id' =>$order_id,
				'year' =>$year,
				'cyear' =>$cyear,
				'month' =>$month,
				'traver' =>$traver,
				'dict_data' =>$dict_data,
				'country' =>$country
		);
		$this ->load->view('order/message' ,$data);
	}
	
	
	// 修改出游人信息
	public function edit_message() {
		$this->load->library ( 'callback' );
		$this->load->helper ( 'regexp' );
		$traverArr = array();
		
		$order_id = $this ->session ->userdata('cOrderId');
		$post = $this ->security ->xss_clean($_POST);
		foreach($post as $key =>$val)
		{
			$post [$key] = trim($val);
		}
		$this ->load_model('member_traver_model' ,'traver_model');
		$whereArr = array(
				'mom.order_id' =>$order_id
		);
		$traver = $this ->traver_model ->get_traver_data($whereArr);
		$new_year = date('Y-m-d' ,time());
		$addtime = date('y-m-d H:i:s' ,time());
		$a = 1;	
		foreach($traver as $key =>$val) {
			//姓名
			if(empty($post["username{$a}"]))
			{
				$this->callback->set_code ( 4000 ,"请填写第{$a}位游客的姓名");
				$this->callback->exit_json();
			}
			//国籍
			if (empty($post["country{$a}"]))
			{
				$this->callback->set_code ( 4000 ,"请选择第{$a}位游客国籍");
				$this->callback->exit_json();
			}
// 			//证件类型
// 			if (empty($post["type{$a}"])) {
// 				$this->callback->set_code ( 4000 ,"请选择第{$a}位游客证件类型");
// 				$this->callback->exit_json();
// 			}
// 			//证件号
// 			if (empty($post["number{$a}"])) {
// 				$this->callback->set_code ( 4000 ,"请选择第{$a}位游客证件号");
// 				$this->callback->exit_json();
// 			}
// 			//证件有效期
// 			if (!empty($data ["c_year{$a}"]) && !empty($data ["c_month{$a}"]) && !empty($data ["c_day{$a}"]))
// 			{
// 				$endtime = $post["cyear{$a}"].'-'.$post["cmonth{$a}"].'-'.$post["cday{$a}"];
// 				if ($new_year >= $endtime)
// 				{
// 					$this->callback->set_code ( 4000 ,"第{$a}位游客证件已过期");
// 					$this->callback->exit_json();
// 				}
// 			}
// 			else
// 			{
// 				$this->callback->set_code ( 4000 ,"请填写第{$a}位游客证件有效期");
// 				$this->callback->exit_json();
// 			}
// 			//签发地
// 			if (empty($post["sign_place{$a}"])) {
// 				$this->callback->set_code ( 4000 ,"请填写第{$a}位游客签发地");
// 				$this->callback->exit_json();
// 			}
			//证件有效期
			if (!empty($post ["c_year{$a}"]) && !empty($post ["c_month{$a}"]) && !empty($post ["c_day{$a}"]))
			{
				$endtime = $post["c_year{$a}"].'-'.$post["c_month{$a}"].'-'.$post["c_day{$a}"];
				if ($new_year >= $endtime)
					{
						$this->callback->set_code ( 4000 ,"第{$a}位游客证件已过期");
						$this->callback->exit_json();
					}
			}
			else {
				$endtime = '';
			}
			//性别
			switch($post["sex{$a}"]) {
				case 0:
				case 1:
					break;
				default:
					$this->callback->set_code ( 4000 ,"请填写第{$a}位游客性别");
					$this->callback->exit_json();
					break;
			}
			//出生日期
			if (!empty($post ["year{$a}"] ) && !empty($post ["month{$a}"]) && !empty($post ["day{$a}"]) )
			{
				$birthday = $post["year{$a}"].'-'.$post["month{$a}"].'-'.$post["day{$a}"];
				if ($new_year < $birthday)
				{
					$this->callback->set_code ( 4000 ,"第{$a}位游客的出生日期");
					$this->callback->exit_json();
				}
			}
			else
			{
				$this->callback->set_code ( 4000 ,"请填写第{$a}位游客的出生日期");
				$this->callback->exit_json();
			}
			//手机
			if (!empty($post["telephone{$a}"])) {
				if (!regexp('mobile' ,$post ["telephone{$a}"])) {
					$this->callback->set_code ( 4000 ,"请填写第{$a}位游客的手机号不正确");
					$this->callback->exit_json();
				}
			}

			$traverArr[] = array(
					'name' =>$post["username{$a}"],
					'enname' =>$post["eusername{$a}"],
					'certificate_type' =>$post["type{$a}"],
					'certificate_no' =>$post["number{$a}"],
					'endtime' =>$endtime,
					'telephone' =>$post["telephone{$a}"],
					'sex' =>$post["sex{$a}"],
					'birthday' =>$birthday,
					'modtime' =>$addtime,
					'country' =>$post["country{$a}"],
					'id' =>$val['id']
			);
			$a ++;
		}
		foreach($traverArr  as $val){
			$this ->traver_model ->update($val,array('id' =>$val['id']));
		}
	//	$this ->session ->unset_userdata('cOrderId');
		$this->callback->set_code ( 2000 ,$order_id);
		$this->callback->exit_json();
	
	}
	
}