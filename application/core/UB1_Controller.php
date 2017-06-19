<?php
/**
 * 2015-5-21 下午2:42:16
 * 谢明丽
 *
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class UB1_Controller extends MY_Controller {
	public $need_login = true;
	public function __construct() {
		parent::__construct ();
		$this->load->library ( 'session' );
	//	$this->check_login ();
		$this->supplier_id = $this->session->userdata('loginSupplier');
		if (!isset($this->supplier_id) || empty($this->supplier_id)){
			redirect('admin/b1/index');
		}
		//消息的统计
		$statis_msg = $this->get_unread_msg();
		$this->session->set_userdata('mess',$statis_msg);
		
		//订单修改消息通知
		$count=$this->get_order_msg();
		$this->session->set_userdata(array('order_msg' =>$count));

	}
	public function getLoginSupplier(){
		$session_data = $this->session->userdata ( 'loginSupplier' );
		return $session_data;
	}
	private function check_login() {
		if ($this->need_login) {
			$session_data = $this->session->userdata ( 'loginSupplier' );
			if (! $session_data) {
				$url = "admin/b1/index";
				echo "<script language='javascript' type='text/javascript'>";
				echo "window.location.href='$url'";
				echo "</script>";
				exit ();
			}
		}
	}
	//消息的统计
	public function get_unread_msg(){
		$this->load->model('admin/b1/messages_model');
		$supplier= $this->session->userdata('loginSupplier');

		//系统通知
		$count_res = array();
		$sys_msg_unread = $this->messages_model->sys_msg_data($supplier['id']);
		//业务通知
		$buniess_msg_unread = $this->messages_model->buniess_msg_data($supplier['id']);
		
		$count_res['sys'] = $sys_msg_unread[0]['sys_msg_count'];
		$count_res['buniess'] = $buniess_msg_unread[0]['buniess_msg_count'];
		$count_res['sum_msg'] = $sys_msg_unread[0]['sys_msg_count']+$buniess_msg_unread[0]['buniess_msg_count'];

		return $count_res;
	}
	//修改退团的消息通知
	public function get_order_msg(){
	    //test	
	    $this->load->model('admin/b1/order_status_model','order');
	    $supplier= $this->session->userdata('loginSupplier');
	    $Ty=$this->order->get_order_bill_msg($supplier['id']);
	    $count=0;
	    if(!empty($Ty)){
	        $count=count($Ty);
	    }

	   return $count;
	   
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
	public function view($page_view, $param = NULL) {
		$this->load->view('admin/b1/common/header.html');
		$this->load->view($page_view, $param);
		$this->load->view('admin/b1/common/footer.html');
// 		$this->load->view('admin/b2/footer.html');
	}
	
	/*
	 * 写订单操作日志
	* */
	public function write_order_log($order_id ,$content=''){
		$order_row=$this->db->query("select id,status,expert_id,supplier_id from u_member_order where id=".$order_id)->row_array();
		$log=array(
				'addtime'=>date("Y-m-d H:i:s"),
				'op_type'=>'2',
				'order_id'=>$order_id
		);
		
		if(!empty($order_row))
		{
			$log['order_status']=$order_row['status'];
			$log['content']='供应商'.$content;
			$log['userid']=$order_row['supplier_id'];
		}
		
		$insert_id=$this->db->insert("u_member_order_log",$log);
		return $this->db->insert_id();
	}
	function filter_str($data){
		if(!is_array($data)){
			$html_string= array("\\", "/", "\"", "\n", "\r", "\t", "<", ">");
			$data = str_replace($html_string,"",$data);
		}
		return $data;
	}
}