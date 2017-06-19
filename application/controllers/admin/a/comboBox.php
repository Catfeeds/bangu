<?php
/**
 *
* @copyright 深圳海外国际旅行社有限公司
* @version 1.0
* @since 2015年7月20日
* @author jiakairong
* @method 用于搜索框的一个模糊搜索插件以及各类联动
*/
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class ComboBox extends MY_Controller {

	public function __construct() {
		parent::__construct ();
	}
	//管理员数据
	public function getAdminData()
	{
		$this ->load_model('admin/a/admin_model');
		$adminData = $this ->admin_model ->all();
		echo json_encode($adminData);
	}

	//获取地区数据
	public function get_area_data() {
		$this->load->model ( 'admin/a/area_model', 'area_model' );
		//$area = cache_get("area");
		//if (empty($area)) {
			$whereArr = array('isopen' =>1);
			$area = $this ->area_model ->all($whereArr ,'id asc');
			//cache_set("area" ,$area);
		//}
		echo json_encode($area);
	}
	//获取商家(商家尚未写入缓存)
	public function get_supplier_data () {
		$this ->load_model('admin/a/supplier_model' ,'supplier_model');
		$supplier = $this ->supplier_model ->all(array('status' =>2));
		foreach($supplier as &$val) {
			if (empty($val['company_name'])) {
				$val['company_name'] = $val['realname'];
			}
		}
		echo json_encode($supplier);
	}
	//获取管家
	public function get_expert_data() {
		$this ->load_model ('admin/a/expert_model' ,'expert_model');
		$expert = $this ->expert_model ->all(array('status' =>2));
		echo json_encode($expert);
	}

	//获取管家
	public function get_member_data() {
		$this ->load_model ('admin/a/member_model' ,'member_model');
		$member = $this ->member_model ->all();
		echo json_encode($member);
	}
	//获取目的地
	public function get_destinations_data() {
			$this ->load_model ('dest/dest_base_model' ,'dest_model');
			$destinations = $this ->dest_model ->all(array(),'id asc');
		echo json_encode($destinations);
	}
	//获取出发城市
	public function get_startcity_data () {
		$this ->load_model('startplace_model');
		$startplace = $this ->startplace_model ->all(array('isopen' =>1,'level'=>3),'id asc');

		$country = $this ->startplace_model ->getCountryStart();
		//var_dump($country);
		if (!empty($country))
		{
			$startplace[] = $country[0];
		}
		echo json_encode($startplace);
	}

	//城市联动
	public function get_area_json() {
		$id = intval($this ->input ->post('id'));
		$this ->load_model('admin/a/area_model' ,'area_model');
		$whereArr = array(
			'isopen' =>1,
			'pid' =>$id
		);
		$area = $this ->area_model ->all($whereArr);
		if (empty($area)) {
			echo false;exit;
		} else {
			echo json_encode($area);
		}
	}

	//获取子部门
	public function get_child_depart() {
		$id = intval($this ->input ->post('depart_id'));
		$this ->load_model('admin/t33/b_depart_model' ,'depart_model');

		$depart = $this ->depart_model ->all('FIND_IN_SET(\''.$id.'\',depart_list)>0');
		if (empty($depart)) {
			echo false;exit;
		} else {
			echo json_encode($depart);
		}
	}
}