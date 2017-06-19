<?php
/**
 * 抢定制订单
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月22日15:50:11
 * @author		汪晓烽
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Shanghai');
class ComboBox extends UB2_Controller {

	public function __construct() {
		parent::__construct();
	}

	//获取地区数据
	public function get_area_data() {
		$area = cache_get("area");
		if (empty($area)) {
			 $this->db->select("id,name,enname,simplename");
   			$whereArr = array('isopen' =>1);
   			$this->db->where($whereArr);
   			$this->db->order_by('id','asc');
			$this->db->from('u_area');
			$area=$this->db->get()->result_array();
			cache_set("area" ,$area);
		}
		echo json_encode($area);
	}

		//获取出发地数据
	public function get_start_data() {
		 $this->db->select("id,cityname,enname,simplename");
		$whereArr = array('isopen' =>1,'level'=>3);
		$this->db->where($whereArr);
		$this->db->order_by('id','asc');
		$this->db->from('u_startplace');
		$start_place=$this->db->get()->result_array();
		echo json_encode($start_place);
	}


	//获取商家(商家尚未写入缓存)
	public function get_supplier_data () {
			$this->db->select('id,company_name,realname');
			$this->db->from('u_supplier');
			$this->db->where(array('status' =>2));
			$supplier = $this ->db ->get() ->result_array();
			foreach($supplier as &$val) {
				if (empty($val['company_name'])) {
					$val['company_name'] = $val['realname'];
				}
			}
		echo json_encode($supplier);
	}

	//获取管家
	public function get_expert_data() {
		$this->db->select('*');
			$this->db->from('u_expert');
			$this->db->where(array('status' =>2));
			$expert = $this ->db ->get() ->result_array();
		//$expert = $this ->expert_model ->all(array('status' =>2));
		echo json_encode($expert);
	}
    //获取会员
    public function get_member_data(){
    	$this->load->model ( 'admin/a/member_model','member_model' );   //线路详情页用到
    	$member=$this->member_model->all();
    	echo json_encode($member);
    }
    //获取会员
    public function get_row_member(){
        $id=$this->input->post('id',true);
    	$this->load->model ( 'admin/a/member_model','member_model' );   //线路详情页用到
    	$member=$this->member_model->all(array('mid'=>$id));
    	echo json_encode($member[0]);
    }
	//获取目的地
	public function get_destinations_data() {
		$destinations = cache_get('destinations_data');
		if (empty($destinations)) {
			$this->db->select('*');
			$this->db->from('u_dest_base');
			$destinations = $this ->db ->get() ->result_array();
			//$destinations = $this ->dest_model ->all(array(),'id asc');
			cache_set("destinations_data" ,$destinations);
		}
		echo json_encode($destinations);
	}

	/**
	 * 数型数据:目的地
	 * */
	public function api_tree_dest()
	{
        $content=$this->input->post("value",true);
		$this->load->model('admin/t33/common_model','common_model');
		$expert=$this->expertInfo();
		$result=$this->common_model->tree_destData(array('level'=>'4','content'=>$content,'city'=>$expert['city']));
		$this->__data($result);
	}


}