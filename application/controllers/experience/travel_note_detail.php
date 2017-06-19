<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		汪晓烽
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Travel_note_detail extends UC_NL_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'travel_note_detail_model', 'travel_note' );
	}
	public function index($page=1) {
		$travel_note_id = 1;
		$whereArr['tn.id'] = $travel_note_id;
		//$res = $this->travel_note->get_pic_data($travel_note_id);
		$res = $this->travel_note->get_travel_detail($whereArr);
		$data = array(
			'res'=>$res
			);
		$this->load->view ( 'experience/travel_note_detail_view',$data);
	}


	//ajax添加评论
	public function ajax_add_comment(){
		$insert_data = array();
		$mid = $this->input->post('mid');
		$nid  = $this->input->post('nid');
		$comment = $this->input->post('comment');
		$insert_data['member_id']  = $mid;
		$insert_data['note_id']  = $nid;
		$insert_data['reply_content']  = $comment;
		$insert_data['addtime']  = date('Y-m-d H:i:s');
		$comment_id = $this->travel_note->add_comment($insert_data);
		echo json_encode($comment_id);
	}

	//ajax获取评论
	public function ajax_get_comment(){
		$whereArr = array();
		$tn_id = $this->input->post('tn_id');
		$whereArr['tn.id'] = $tn_id;
		$travel_note = $this->travel_note->get_travel_data($whereArr,$page);
		$travel_note_count = count($this->travel_note->get_travel_data($whereArr,0));
		$data = array(
			'travel_note' => $travel_note,
			'travel_note_count' => $travel_note_count
			);
		echo json_encode($travel_note);
	}


}