<?php
class api extends UC_NL_Controller {
	public function __construct() {
		parent::__construct ();
		set_error_handler('customError');
		$this->db = $this->load->database ( "default", TRUE );
		$this->load_model ( 'wx/wx_member_model', 'wx_member_model' );
		$this->load->model ( 'member_model' );
		//$this->load->library ( 'callback' );
	}
	
	public function getActivityNumber(){
		$num =  $this->wx_member_model->getActivityNumber(sys_constant::WX_REG_PL);
		echo empty($num) || ""==$num ? 0 : $num;
	}
	
	public function get_member(){
		$openid = trim($this ->input->post('openid' ,true));
		
		echo empty($wx_member) ? 0 : 1;
	}
	
	public function updateMemberStatus(){
		
		echo $status ? 1 : 0;
	}
	
	public function save_wx_member(){
		$wx_member['openid'] = trim($this ->input->post('openid' ,true));
		$wx_member['nickname'] = trim($this ->input->post('nickname' ,true));
		$wx_member['sex'] = trim($this ->input->post('sex' ,true));
		$wx_member['province'] = trim($this ->input->post('province' ,true));
		$wx_member['city'] = trim($this ->input->post('city' ,true));
		$wx_member['country'] = trim($this ->input->post('country' ,true));
		$wx_member['headimgurl'] = trim($this ->input->post('headimgurl' ,true));
		$wx_member['recDate'] = date('Y-m-d H:i:s');
		$wx_member['privilege'] = "";
		$wx_member['unionid'] = "";
		$wx_member['member_id'] = 0;
		$raw_wx_member =  $this->wx_member_model->getMemberByOpenId($wx_member['openid']);
		if(empty($raw_wx_member)){
			$wx_member =  $this->wx_member_model->save_wx_member($wx_member);
			if(array_key_exists("id",$wx_member) && ""!=$wx_member["id"] && $wx_member["id"]>0){
				$wx_member['status'] = 1;
			}else{
				$wx_member['status'] = 0;
			}	
			echo json_encode($wx_member);
		}else{
			$raw_wx_member['status'] =3;
			echo json_encode($raw_wx_member);
		}
	}
	
	public function getMemberById(){
		$id = null;
		if (isset ( $_REQUEST["id"] )){
			$id = $_REQUEST["id"];
			$wx_member =  $this->wx_member_model->getMemberById($id);
			$wx_member['status'] = 1;
			echo json_encode($wx_member);
		}else{
			$wx_member['status'] = 0;
			echo json_encode($wx_member);
		}
	}
	
	
}