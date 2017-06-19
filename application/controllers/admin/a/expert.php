<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月20日11:59:53
 * @author		何俊
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Expert extends UA_Controller {
	const pagesize = 10; //分页的页数

	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'admin/a/expert_model', 'expert_model' );
	}

	/**
	 * @author 贾开荣
	 * @method 获取地区
	 */
	public function get_area_data ($pid) {
		$sql = "select id,name from u_area where pid = {$pid}";
		$query = $this ->db ->query($sql);
		$data = $query ->result_array();

		if (!empty($data))
			return $data;
		else
			return false;
	}
	/**
	 * @author 贾开荣
	 * 获取地区 返回json数据
	 */
	public function get_area_json (){
		$pid = intval($_POST['id']);
		$sql = "select id,name from u_area where pid = {$pid}";
		$query = $this ->db ->query($sql);
		$data = $query ->result_array();
		if (empty($data)) {
			echo false;
		} else {
			echo json_encode($data);
		}
	}


	public function get_destinations() {
		$id = intval($this ->input ->post('id'));
		$this ->load_model('dest/dest_base_model' ,'dest_base_model');
		$list = $this ->dest_base_model ->all(array('pid' =>$id));
		if (empty($list)) {
			echo false;
		} else {
			echo json_encode($list);
		}
	}


	public function expert_dest_list() {
		$this->load_view ( 'admin/a/ui/expert/expert_dest_list' );
	}


	/**
	 * 投诉列表
	 * @author汪晓峰
	 * @param number $page
	 */
	public function complain_list($page=1) {
		$this->load->helper ( 'my_text' );
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/expert/complain_list/';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $this->uri->segment (5, 0 );
		$post_arr = array();

		if($this->uri->segment (5)!=''){//没有分页的时候，就是点击标题进入页面的时候
			# 产品名称
			if ($this->session->userdata('line_name') != '') {
				$post_arr['productname LIKE']= '%' .$this->session->userdata('line_name'). '%';
			}

			# 投诉人
			if ($this->session->userdata('complainant') != '') {
				$post_arr['truename LIKE']= '%' .$this->session->userdata('complainant') . '%';
			}

			# 状态
			if ($this->session->userdata('status') != '') {
				$status = $this->session->userdata('status');
				if ($status == 9)
					$status = 0;
				$post_arr['c.status']= $status;
			}
		} else {
			unset($post_arr['productname LIKE']);
			$this->session->unset_userdata('line_name');
			unset($post_arr['truename LIKE']);
			$this->session->unset_userdata('complainant');
			unset($post_arr['c.status']);
			$this->session->unset_userdata('status');
		}




		if ($this->is_post_mode()) {
			# 产品名称
			if ($this->input->post('line_name') != '') {
				$post_arr['productname LIKE']= '%' . $this->input->post('line_name') . '%';
				$this->session->set_userdata(array('line_name' => $this->input->post('line_name')));
			}else{
				unset($post_arr['productname LIKE']);
				$this->session->unset_userdata('line_name');
			}

			#投诉人
			if ($this->input->post('complainant') != '') {
				$post_arr['truename LIKE']= '%' . $this->input->post('complainant') . '%';
				$this->session->set_userdata(array('complainant' => $this->input->post('complainant')));
			}else{
				unset($post_arr['truename LIKE']);
				$this->session->unset_userdata('complainant');
			}

			# 状态
			if ($this->input->post('status') != '') {
				$status = $this->input->post('status');
				if ($status == 9)
					$status = 0;
				$post_arr['c.status'] = $status;
				$this->session->set_userdata(array('status' => $this->input->post('status')));
			}else{
				unset($post_arr['c.status']);
				$this->session->unset_userdata('status');
			}
		}

		$this->load_model ( 'admin/a/expert_model', 'expert_model' );
                     $config ['pagecount'] = count($this->expert_model->get_complain_list($post_arr,0, $config['pagesize']));
                     $complain_list_data = $this->expert_model->get_complain_list($post_arr,$page, $config['pagesize']);
                   //  var_dump($complain_list_data);
                     $data =  array(
                     		'complain_list'=>$complain_list_data,
                     		'line_name'=> $this->session->userdata('line_name'),
                     		'truename'=> $this->session->userdata('complainant'),
                     		'status'=> $this->session->userdata('status')
                     	);
		$this->page->initialize ( $config );
		
		$this->load_view ( 'admin/a/ui/expert/complain_list',$data);
	}

	/**
	 * 获取一条投诉信息
	 * 贾开荣
	 */
	public function get_complain_json() {
		$id = intval($_POST['id']);
		$data = $this->expert_model->get_complain_list(array('c.id' =>$id));
		echo json_encode($data [0]);
	}
	/**
	 * 处理投诉
	 * 贾开荣
	 */
	public function complain_change() {
		$id = intval($_POST['id']);
		$remark = $this ->input ->post('remark' ,true);
		$modtime = date('Y-m-d H:i:s' ,time());
		$data = array(
			'remark' =>$remark,
			'modtime' =>$modtime,
			'status' =>1
		);
		$this ->db ->where(array('id' =>$id));
		$status = $this ->db ->update('u_complain' ,$data);
		if (empty($status))
		{
			$this->callback->set_code ( 4000 ,"操作失败");
			$this->callback->exit_json();
		}
		$this ->log(3,3,'平台专家管理->投诉列表',"处理用户投诉,记录ID:{$id}");
		$this->callback->set_code ( 2000 ,"操作成功");
		$this->callback->exit_json();
	}

	/**
	 * @method 提现管理
	 * @author 贾开荣
	 * @since  2015-08-05
	 */
	public function exchange_list() {
		$this->load_view ( 'admin/a/ui/expert/exchange_list');
	}
	/**
	 * @method 提现管理数据
	 * @author 贾开荣
	 * @since 2015-08-05
	 */
	public function get_exchange_data() {
		$whereArr = array(
				'ec.exchange_type' =>1
		);
		$likeArr = array();
		$status = intval($this ->input ->post('status'));
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1: $page_new;
		$realname = trim($this ->input ->post('search_name' ,true));
		$addtime = trim($this ->input ->post('addtime' ,true));
		switch($status) {
			case 1: //新申请
				$whereArr ['ec.status'] = 0;
				$order_by = 'ec.id';
				break;
			case 2: //已审核
				$whereArr ['ec.status'] = 1;
				$order_by = 'ec.modtime';
				break;
			case 3: //已拒绝
				$whereArr ['ec.status'] = 2;
				$order_by = 'ec.modtime';
				break;
			default: //默认新申请
				$whereArr ['ec.status'] = 0;
				$order_by = 'ec.id';
				break;
		}
		$whereArr['ec.approve_type'] = 0;
		
		if(!empty($realname)) {
			$likeArr ['e.realname'] = $realname;
		}
		if (!empty($addtime)) {
			$time = explode('-',$addtime);
			$starttime = $time[0].'-'.rtrim($time[2]).'-'.$time[1];
			$endtime = ltrim($time['3']).'-'.$time['5'].'-'.$time['4'];
			$whereArr ['ec.addtime <='] = $endtime;
			$whereArr ['ec.addtime >='] = $starttime;
		}

		//获取数据
		$list = $this ->expert_model ->get_exchange_data($whereArr ,$page_new ,sys_constant::A_PAGE_SIZE ,$likeArr ,$order_by);
		$count = $this->getCountNumber($this->db->last_query());
		$page_string = $this ->getAjaxPage($page_new ,$count);
		//echo $this ->db ->last_query();
		$data = array(
			'list' =>$list,
			'page_string' =>$page_string
		);
		echo json_encode($data);
	}

	/**
	 * @method 拒绝管家提现
	 * @author jiakairong
	 */
	public function refused_apply(){
		$id = intval($this->input->post('refuse_id'));
		$beizhu = trim($this->input->post('beizhu' ,true));
		try {
			if (empty($beizhu)) {
				throw new Exception('请填写拒绝理由');
			}
			$this ->load_model('common/u_exchange_model' ,'exchange_model');
			$exchangeData = $this ->exchange_model ->row(array('id' =>$id) ,'arr' ,'' ,'is_remit,id,status,amount,exchange_type,userid');
			if (empty($exchangeData)) {
				throw new Exception('您操作的记录不存在');
			} else {
				if ($exchangeData['is_remit'] != 0 || $exchangeData['status'] != 0) {
					throw new Exception('您操作的记录已处理');
				}
			}
			$this->db->trans_begin(); //事务开始
			$time = date('Y-m-d H:i:s' ,time());
			switch($exchangeData['exchange_type']) {
				case 1:
					//把提现金额返回给管家
					$sql = "update u_expert set amount = amount+{$exchangeData['amount']},modtime='{$time}' where id = {$exchangeData['userid']}";
					break;
				case 2:
					//把提现金额返给商家

					break;
			}
			$status = $this ->db ->query($sql);
			if ($status == false) {
				throw new Exception('操作失败');
			}

			$dataArr = array(
					'is_remit' =>2,
					'admin_id' =>$this ->admin_id,
					'modtime' =>$time,
					'remark' =>$beizhu,
					'status' =>2
			);
			$this ->db ->where(array('id' =>$id));
			$status = $this ->db ->update('u_exchange' ,$dataArr);
			if ($status == false) {
				throw new Exception("操作失败");
			}
			if ($this->db->trans_status() === FALSE) { //判断此组事务运行结果
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
			$this ->log (5,3,'管家提现管理',"平台拒绝提现申请,记录ID:{$id}");
			$this->callback->set_code ( 2000 ,"操作成功");
			$this->callback->exit_json();

		} catch (Exception $e) {
			$this->callback->set_code ( 4000 ,$e ->getMessage());
			$this->callback->exit_json();
		}

	}


	/**
	 * @method 通过管家提现
	 * @author jiakairong
	 */
	public function through_apply(){
		$id = intval($this->input->post('id'));
		$user_id = $this->session->userdata('a_user_id');
		$time = date('Y-m-d H:i:s' ,time());
		$dataArr = array(
				'is_remit' =>1,
				'admin_id' =>$user_id,
				'modtime' =>$time,
				'status' =>1
		);
		$this ->db ->where(array('id' =>$id));
		$status = $this ->db ->update('u_exchange' ,$dataArr);
		if ($status == false) {
			$this->callback->set_code ( 4000 ,"操作失败");
			$this->callback->exit_json();
		} else {
			$this ->log (5,3,'管家提现管理',"平台通过提现申请,记录ID:{$id}");
			$this->callback->set_code ( 2000 ,"操作成功");
			$this->callback->exit_json();
		}
	}
	/**
	 * 贾开荣
	 * 获取某一条提现记录的数据
	 */
	public function get_exchange_json() {
		$id = intval($this ->input ->post('id'));
		$whereArr = array('ec.id' =>$id);
		$data = $this ->expert_model ->get_exchange_data($whereArr);
		if (empty($data)) {
			echo false;
		} else {
			echo json_encode($data [0]);
		}
	}
	/**
	 * @method 管家相片管理
	 * @author xml
	 */
	public function expert_museum(){
		$data['pageData']=$this->expert_model->get_expert_museum(array('status'=>0),$this->getPage ());
	//	echo $this->db->last_query();
		$this->load_view ( 'admin/a/ui/expert/expert_museum' ,$data);
	}
	/**
	 * @method 管家相片管理 tab切换
	 * @author xml
	 */
	public function expertData(){
		$param = $this->getParam(array('status','realname'));
		$data = $this->expert_model->get_expert_museum( $param , $this->getPage ());
		echo  $data ;
	}
}