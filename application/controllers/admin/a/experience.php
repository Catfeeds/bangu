<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Experience extends UA_Controller {
	const pagesize = 10; //分页的页数

	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'admin/a/experience_model', 'experience' );
	}

	/**
	 * 体验师列表
	 * @author xml
	 */
	public function experience_list() {
		$data['pageData']=$this->experience->get_experience_list(array('status'=>0),$this->getPage ());
		$this->load_view ( 'admin/a/ui/experience/experience_list',$data);
	}
	//分页查询
	public function pageData(){
		$param = $this->getParam(array('status','nickname','linename'));
		$data=$this->experience->get_experience_list($param,$this->getPage ());
		echo $data;
	}
	//选会员
	public function get_member_list(){
		$whereArr = array();
		$likeArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1: $page_new;
		$name = trim($this ->input ->post('name' ,true));
		$is = intval($this ->input ->post('is'));
		$pagesize = intval($this ->input ->post('pagesize'));
		$pagesize = empty($pagesize) ? self::PAGESIZE :$pagesize;
		
		//搜索名称
		if (!empty($name)) {
			$likeArr ['m.nickname'] = $name;
		}
		
		//获取数据
		$list = $this ->experience ->get_member_list($whereArr ,$page_new ,$pagesize ,1 ,$likeArr);
		$count = $this->getCountNumber($this->db->last_query());
		$page_str = $this ->getAjaxPage($page_new ,$count);
		
		$data = array(
				'page_string' =>$page_str,
				'list' =>$list
		);
		if ($is == 1) {
			echo json_encode($data);
			exit;
		}
	}
	//筛选订单
	public function get_member_order(){
		$memberid=$this->input->post('memberid');
		if($memberid>0){
			$member=$this ->experience ->get_member_order(array('mo.memberid'=>$memberid));
			echo json_encode(array('status'=>1,'member'=>$member));
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'获取数据失败'));
		}
	}
	//添加体验师
	public function add_experience(){
		$order_id=$this->input->post('order_id');
		$memberid=$this->input->post('agent_id');
		$nickname=$this->input->post('agent_name');
		if(empty($memberid) || empty($nickname) ){
			 echo json_encode(array('status'=>-1,'message'=>'请选择会员'));
			 exit();
		}
		if(empty($order_id)){
			echo json_encode(array('status'=>-1,'message'=>'请选择订单线路'));
			exit();
		}	
		$where='member_id = '.$memberid.' and status!=-1';
		$eid=$this ->experience ->all($where);
		if(!empty($eid)){
			if($eid[0]['status']==1){
				echo json_encode(array('status'=>-1,'message'=>'你申请的这个会员的体验师已经通过了'));
				exit();
			}else if($eid[0]['status']==0){
				echo json_encode(array('status'=>-1,'message'=>'你申请的这个会员的体验师已在审核中'));
				exit();
			}
		}else{
			$insert=array(
				'order_id'=>$order_id,
				'member_id'=>$memberid,
			);
			$type_id=$this->input->post('type_id');
			if($type_id=='pass_form'){
				$insert['status']=1;
			}else{
				$insert['status']=0;
			}

			$insert_id=$this->experience->insert($insert);  //提交体验师
			if($insert_id>0){
				echo json_encode(array('status'=>1,'message'=>'申请成功'));
			}else{
				echo json_encode(array('status'=>-1,'message'=>'申请失败'));
			}
		}
	}
	//修改体验师
	public function update_experience(){
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		if($id>0){
			$re=$this ->experience->update(array('status'=>$status),array('id'=>$id));
			if($re){
				echo json_encode(array('status'=>1,'message'=>'提交成功'));
			}else{
				echo json_encode(array('status'=>-1,'message'=>'提交失败'));
			}
		}else{
			echo json_encode(array('status'=>-1,'message'=>'提交失败'));
		}
	}
}
