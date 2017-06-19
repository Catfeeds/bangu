<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		汪晓烽
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Exper_detail extends UC_NL_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'exper_detail_model', 'exper_detail' );
	}
	public function index($eid=0) {
		//print_r($eid);exit();
		$whereArr = array();
		$whereArr1 = array();
		$experience_data_res = array();
		//$eid = $this->input->get('eid');
		$postArr = array();
		$whereArr['m.mid']=$eid;
		$whereArr1['tn.userid']=$eid;
		$experience_data = $this->exper_detail->get_experience_data($whereArr);
		if(!empty($experience_data[0])){
			$experience_data_res = $experience_data[0];
		}
		//print_r($experience_data);exit();
		$experience_trip_data = $this->exper_detail->get_experience_trip_data($whereArr1,1);
		//print_r($experience_trip_data);exit();
		$experience_trip_count = count($this->exper_detail->get_experience_trip_data($whereArr1,0));
		$experience_news = $this->exper_detail->get_experience_news();
		$data = array(
			'experience_data'=> $experience_data_res,//$experience_data[0],
			'experience_trip_data'=>$experience_trip_data,
			'experience_news' => $experience_news,
			'experience_trip_count' => $experience_trip_count,
			'eid'			=> $eid,
			'user_id'		=>$this->session->userdata('c_userid')
			);
			$this->load->view ( 'experience/exper_detail_view',$data);
	}


	function get_more_trip(){
		$whereArr = array();
		$page = $this->input->post('page');
		$eid = $this->input->post('eid');
		$whereArr['tn.userid']=$eid;
		$experience_trip_data = $this->exper_detail->get_experience_trip_data($whereArr,$page);
		echo json_encode($experience_trip_data);
	}

	//点赞
	function zan_opera(){
		$note_id = $this->input->post('note_id');
		$insert_data = array();
		$insert_data['note_id'] = $note_id;
		$insert_data['member_id'] = $this->session->userdata('c_userid');
		$insert_data['ip'] = $_SERVER["REMOTE_ADDR"];
		$insert_data['ADDTIME'] = date('Y-m-d H:i:s');
		$this->db->select('count(*) AS c');
		$whereArr['note_id'] = $note_id;
		$whereArr['member_id'] = $this->session->userdata('c_userid');
		$this->db->where($whereArr);
		$this->db->from('travel_note_praise');
		$result=$this->db->get()->result_array();
		if($result[0]['c']>0){
			echo json_encode(array('status'=>300,'msg'=>'已经点赞过了'));
			exit();
		}else{
			$this->db->insert('travel_note_praise',$insert_data);
			if($this->db->insert_id()){
				$sql = "update travel_note set praise_count = praise_count+1 where id=".$note_id;
				$this->db->query($sql);
				echo json_encode(array('status'=>200,'msg'=>'success'));
				exit();
			}else{
				echo json_encode(array('status'=>-200,'msg'=>'Fail'));
				exit();
			}
		}


	}


	/**
	 * 汪晓烽: 咨询体验师
	 */
	function ask_experince(){
		if($this->session->userdata('c_username')==''){
			echo json_encode(array('status'=>-400,'msg'=>'请先登录'));
			exit();
		}
		$member_id = $this->session->userdata('c_userid');
		$c_line_id = $this->input->post('c_line_id');
		$weixin = $this->input->post('weixin');
		$telphone = $this->input->post('telphone');
		$me_id = $this->input->post('me_id');
		$question_txt = $this->input->post('question_txt');

		$sql = "INSERT INTO u_experience_consult(member_id,experience_id,`addtime`,mobile,weixin,line_id,question)VALUES($member_id,$me_id,NOW(),'$telphone','$weixin',$c_line_id,'$question_txt');";
		if($this->db->query($sql)){
			echo json_encode(array('status'=>200,'msg'=>'咨询已提交'));
			exit();
		}else{
			echo json_encode(array('status'=>-200,'msg'=>'操作失败'));
			exit();
		}
	}
}