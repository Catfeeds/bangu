<?php
/**
 * 首页
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年7月18日10:11:07
 * @author		何俊
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends UB2_Controller {
	public function __construct() {
		parent::__construct();
		$this->load_model('admin/b2/home_model', 'home');

	}

	public function index() {
		$home_data = $this->home->get_home_data($this->expert_id);
		$order_status = $this->home->get_order_status();
		//拍照信息
		$this ->load_model('common/u_expert_model','expert_model');
		$museum=$this ->expert_model ->get_museum();
		$expert_museum=$this ->expert_model ->get_e_museum($this->expert_id);
		$expertArr=$this ->expert_model ->row(array('id'=>$this->expert_id));
		$data = array(
			'last_login_time'=>$this->session->userdata('logindatetime'),
			'home_data' => $home_data[0],
			'order_status'=>$order_status,
			'museum'=>$museum,
			'expert_museum'=>$expert_museum,
			'expert_id' => $this->expert_id,
			'e_status'	=>$expertArr['status'],
			'is_commit' => $expertArr['is_commit']
			);
		$this->load_view('admin/b2/home',$data);
	}

	/**
	 * 提现记录控制器(用于Ajax获取数据)
	 */
	function cash_record(){
		$this->load_model('admin/b2/exchange_model', 'exchange');
		$post_arr['userid'] = $this->expert_id;
		$post_arr['exchange_type'] = ROLE_TYPE_EXPERT;
		$number = $this->input->post('pageSize', true);
       		 $page = $this->input->post('pageNum', true);
        		$number = empty($number) ? 15 : $number;
        		$page = empty($page) ? 1 : $page;
		$exchange_info = $this->exchange->get_cash_record($post_arr, $page, $number);//$this->exchange->result($post_arr, $page, $number, 'addtime desc');
		$pagecount = count($this->exchange->all($post_arr));

		 if (($total = $pagecount - $pagecount % $number) / $number == 0) {
               		 $total = 1;
           	 } else {
                	$total = ($pagecount - $pagecount % $number) / $number;
                		if ($pagecount % $number > 0) {
                    			$total +=1;
                		}
            	}
		$data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                	"pageNum" => $page,
	                	"pageSize" => $number,
	               	"rows" => $exchange_info
            	);
		echo json_encode($data);
	}


	function get_unread_bus_msg(){
		$Minutes = $this->input->post('minutes',true);
		$whereArr = array();
		$this->db->select('count(*) AS buniess_msg_count');
		$this->db->from('u_message AS m');
		$whereArr['m.msg_type']=1;
		$whereArr['m.read'] = 0;
		$whereArr['m.receipt_id'] = $this->expert_id;
		$whereArr['m.addtime >='] = date('Y-m-d H:i:s',strtotime("-$Minutes Minute"));
		$whereArr['m.addtime <='] = date('Y-m-d H:i:s');
		$this->db->where($whereArr);
		$buniess_msg_unread = $this->db->get()->result_array();
		echo json_encode($buniess_msg_unread[0]['buniess_msg_count']);
	}
	//管家免费申请拍照
	function save_expert_museum(){
		$photo_shop=$this->input->post('photo_shop');
		if(empty($photo_shop)){
			echo json_encode(array('status'=>-1,'msg'=>'请选择相馆地址'));
			exit;
		}
		//生成二维码
		$qrcodes=$this->get_qrcodes($this->expert_id);
		if($qrcodes){
			$qrcodes='/file/qrcodes/'.$this->expert_id.'_qr.png';
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'生成验证码失败'));
			exit;
		}
		//管家关联相馆表
		$re=$this->home->insert_expert_museum($photo_shop,$qrcodes,$this->expert_id);
		if($re>0){
			echo json_encode(array('status'=>1,'msg'=>'申请成功'));
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'申请失败'));
		}
	}
}