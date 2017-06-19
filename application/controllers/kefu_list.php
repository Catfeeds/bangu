<?php
/**
 * 投诉维权
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年6月16日18:00:01
 * @author		何俊
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Kefu_list extends UC_NL_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'kefu/kefu_group_model', 'kefu_group_model' );
		$this->load->model ( 'kefu/kefu_message_model', 'kefu_message_model' );
		$this->load->library ( 'callback' );
	}
	public function index() {
		
		// 显示页面
		$this->load_view ( 'kefu_list_view' );
	}
	public function mess_list() {
		$action = $this->input->get ( 'action' );
		$this->callback = $this->input->get ( "callback" );
		$page = 1;
		$num = 5;
		if ($action == "0") {
			$member_id = $this->input->get ( 'member_id' );
			$whereArr = array (
					'member_id' => $member_id,
					'action' => '0' 
			);
		} else if ($action == "1") {
			$expert_id = $this->input->get ( 'expert_id' );
			$whereArr = array (
					'expert_id' => $expert_id,
					'action' => '1' 
			);
		}
		$orderby = 'addtime';
		$reDataArr = $this->kefu_group_model->result ( $whereArr, $page, $num, $orderby );
		$reDataArr = $this->handle_array ( $reDataArr, $member_id, $expert_id, $action );
		if (sizeof ( $reDataArr ) == 0) {
			$result_code = "4001";
			$result_msg = "data empty";
		} else {
			$result_code = "2000";
			$result_msg = "success";
			$dataArr = array (
					'status' => '1' 
			);
			$this->kefu_message_model->update ( $dataArr, $whereArr );
		}
		$this->result_msg = $result_msg;
		$this->result_code = $result_code;
		$this->result_data = $reDataArr;
		$this->resultJSON = array (
				"msg" => $this->result_msg,
				"code" => $this->result_code,
				"data" => $this->result_data 
		);
		echo $this->callback . "(" . json_encode ( $this->resultJSON ) . ")";
	}
}