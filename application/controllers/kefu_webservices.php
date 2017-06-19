<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @客服接口
 * @path：controllers/kefu_webservices.php
 * ===================================================================

 * ===================================================================
 * @类别：客服插件
 * @作者：何俊 （junhey@qq.com）v1.0 Final
 */

class Kefu_webservices extends CI_Controller {
	private $resultJSON;
	private $result_code;
	private $result_msg;
	private $result_data = array ();
	private $callback;
	public function __construct() {
		parent::__construct ();
		$this->db = $this->load->database ( "default", TRUE );
		$this->callback = $this->input->get ( "callback" );
		header ( "content-type:text/html;charset=utf-8" );
		$this->load->model('kefu/kefu_group_model','kefu_group_model');
		$this->load->model('kefu/kefu_message_model','kefu_message_model');
		$this->load->model('expert_model');
		$this->load->model('member_model');
		//session_start();
		$ip=$this->input->ip_address();
	}
	
	public function index(){
		print_r('test');
	}
	
	/**
	 * 初次对话生成一个组group
	 */
	public function group_open(){
		$member_id=$this->input->get('mid');
		$expert_id=$this->input->get('eid');
		$action=$this->input->get('action');
		$g=$this->kefu_group_model->row(array('member_id'=>$member_id));
		if(!($g&&$g['expert_id']==$expert_id)){
			$dataArr=array(
					'member_id'=>$member_id,
					'expert_id'=>$expert_id,
					'lasttime'=>date('Y-m-d H:i:s'),
					'action'=>$action
			);
			$re=$this->kefu_group_model->insert($dataArr);
			if($re != -1){
				$flag = "success";
			}			
		}
		$reDataArr=array("reg_result"=>$flag);
		$this->_outmsg($reDataArr);
	}
	
	/**
	 * 获取线路的综合排名第一的专家
	 */
	public function get_b2_one_data(){
		$lineid=$this->input->get('lineid');
		$b2_one_data_sql="SELECT e.id FROM u_line_apply AS la LEFT JOIN u_expert AS e ON la.expert_id=e.id WHERE la.line_id={$lineid} AND e.online>=1  AND la.status=2 ORDER BY la.id LIMIT 1";
		$b2_one_data_query=$this->db->query($b2_one_data_sql);
		$reDataArr=$b2_one_data_query->result_array();
		echo json_encode($reDataArr);
	}
	
	/**
	 * 获取B2的用户数据
	 */
	public function get_b2_data(){
		$eid = $this->input->get ( "eid" );
		$b2_data_sql = "SELECT e.id,e.online AS online,e.mobile AS mobile,e.small_photo AS 'photo',e.nickname,e.realname AS 'loginname',e.sex AS 'sex',eg.title AS 'title',
								e.satisfaction_rate AS 'satisfaction_rate',e.service_score AS 'service_score',e.profession_score AS 'profession_score'
								FROM u_expert AS e LEFT JOIN u_expert_grade AS eg ON e.grade=eg.grade
								WHERE e.id=".$eid;
		$b2_data_query=$this->db->query($b2_data_sql);
		$reDataArr=$b2_data_query->result_array();
		echo json_encode($reDataArr);
	}
	/**
	 * 获取c用户数据
	 */
	public function get_c_data(){
		$mid = $this->input->get ( "mid" );
		$b2_data_sql = "SELECT e.mid,e.loginname as loginname,e.litpic as photo	FROM u_member AS e WHERE e.mid=".$mid;
		$b2_data_query=$this->db->query($b2_data_sql);
		$reDataArr=$b2_data_query->result_array();
		echo json_encode($reDataArr);
	
	}
	/**
	 * kuangmingai b2duan
	 */
	public function get_user_message(){
		$eid = $this->input->get ( "eid" );
		$where = array (
				"expert_id" => $eid,
				"action"=>'1',
				"status"=>"0"
		);
		$orderby="lasttime desc ";
		$fieldsArr='member_id';
		$reDataArr = $this->kefu_group_model->result( $where,$page = 1, $number = 30, $orderby = "", $type='arr',$joinArr='',$fieldsArr);
		//print_r($reDataArr);exit();
		foreach($reDataArr as $key =>$val)
		{	
			//print_r($reDataArr[$key]);exit();			
			$group=$this->search_groupid($reDataArr[$key]['member_id'],$eid,'0');
			$whereArr=array(
					'group_id'=>$group['id'],
					'status'=>'0'
			);
			$orderby='addtime asc';
			$fieldsArrMsg=array('addtime','content');
			$reDataArrmsg=$this->kefu_message_model->all($whereArr, $orderby, $type='arr',$fieldsArrMsg);
			if (sizeof ( $reDataArrmsg ) == 0) {
					$msg="";
			} else {				
				$dataArr=array('status'=>'1');
				$this->kefu_message_model->update($dataArr,$whereArr);
				$whereArr_gorup=array(
						'id'=>$group['id'],
						'status'=>'0'
				);
				$this->kefu_group_model->update($dataArr,$whereArr_gorup);
			}
			$reDataArr[$key]['msgs']=$reDataArrmsg;		
		}
		foreach($reDataArr as $key =>$val)
		{
			$member=$this->member_model->row(array('mid'=>$reDataArr[$key]['member_id']));
			if(empty($member)){
				$reDataArr[$key]['photo']="/static/img/kefu_photo.png";;
				$reDataArr[$key]['loginname']=$this->input->ip_address();
			}else{
				$reDataArr[$key]['photo']=$member['litpic'];
				$reDataArr[$key]['loginname']=$member['loginname'];
			}
		}
		$this->_outmsg($reDataArr);
	}
	
	
	/**
	 * 通过专家id查所有该专家的用户列表
	 * para:eid 专家id
	 * para:page 页数，默认1
	 * para:number 记录数，默认10
	 * para:action 发送标志
	 * return：json
	 */
	public function get_c_message_list() {
		$page = $this->input->get ( "page" );
		$number = $this->input->get ( "number" );
		$eid = $this->input->get ( "eid" );
		$action=$this->input->get("action");
		$where = array (
				"expert_id" => $eid,
				"action"=>$action
		);
		$orderby=" status asc, lasttime desc ";
		$reDataArr = $this->kefu_group_model->result( $where,$page = 1, $number = 10,$orderby);
		//print_r($reDataArr);exit();
		foreach($reDataArr as $key =>$val)
		{	
			$member=$this->member_model->row(array('mid'=>$reDataArr[$key]['member_id']));
			if(empty($member)){
				$reDataArr[$key]['photo']="/static/img/kefu_photo.png";;
				$reDataArr[$key]['loginname']=$this->input->ip_address();
			}else{
				$reDataArr[$key]['photo']=$member['litpic'];
				$reDataArr[$key]['loginname']=$member['loginname'];
			}
		}
		$this->_outmsg($reDataArr);
	}
	/**
	 * 通过会员id查专家列表
	 * para:eid 专家id
	 * para:page 页数，默认1
	 * para:number 记录数，默认10
	 * return：json
	 */
	public function get_message_list() {
		$page = $this->input->get ( "page" );
		$number = $this->input->get ( "number" );
		$mid = $this->input->get ( "mid" );
		$eid = $this->input->get ( "eid" );
		$action=$this->input->get("action");
		if($action==0){			
			$where = array (
					"member_id" => $mid,
					"action"=>$action
			);
			$orderby=" status asc, lasttime desc ";
			$reDataArr = $this->kefu_group_model->all( $where,$orderby);
			//print_r($reDataArr);exit();
			foreach($reDataArr as $key =>$val)
			{
				$expert=$this->expert_model->row(array('id'=>$val['expert_id']));
				$reDataArr[$key]['photo']=$expert['small_photo'];
				$reDataArr[$key]['loginname']=$expert['login_name'];
			}
			$this->_outmsg($reDataArr);
		}else if($action==1){
			$where = array (
					"expert_id" => $eid,
					"action"=>$action
			);
			$orderby=" status asc, lasttime desc ";
			$reDataArr = $this->kefu_group_model->all( $where,$orderby);
			//print_r($reDataArr);exit();
			foreach($reDataArr as $key =>$val)
			{
				$member=$this->member_model->row(array('mid'=>$reDataArr[$key]['member_id']));
				if(empty($member)){
					$reDataArr[$key]['photo']="/static/img/kefu_photo.png";;
					$reDataArr[$key]['loginname']=$this->input->ip_address();
				}else{
					$reDataArr[$key]['photo']=$member['litpic'];
					$reDataArr[$key]['loginname']=$member['loginname'];
				}
			}
			$this->_outmsg($reDataArr);
		}
		
	}

	/**
	 * 发送消息
	 * return：json
	 */
	public function send_message() {
		$content=strip_tags($this->input->get('content'));
		$member_id=$this->input->get('mid');
		$expert_id=$this->input->get('eid');
		$action=$this->input->get('action');
		$ip=$this->input->ip_address();
		$source=($ip=="::1") ? "127.0.0.1" : $ip;
		$whereArr=array(
				'member_id'=>$member_id,
				'expert_id'=>$expert_id
		);		 
		$dataArr_group=array(
				'lastcontent'=>$content,
				'lasttime'=>date('Y-m-d H:i:s'),
				'status'=>'0'
		);
		$re_group=$this->kefu_group_model->update($dataArr_group,$whereArr);
		$group=$this->search_groupid($member_id,$expert_id,$action);
		$dataArr=array(
				'addtime'=> date('Y-m-d H:i:s'),
				'content'=>$content,
				'group_id'=>$group['id'],
				'source'=>$source
		);
		$re=$this->kefu_message_model->insert($dataArr);
		if ($re_group>0&&$re > 0) {
			$reDataArr=$this->kefu_message_model->row(array('id'=>mysql_insert_id()));
			if($action=='0'){
				$member=$this->member_model->row(array('mid'=>$member_id));
				$reDataArr['photo']=$member['litpic'];
				$reDataArr['loginname']=$member['loginname'];
			}else if($action=='1'){
				$expert=$this->expert_model->row(array('id'=>$expert_id));
				$reDataArr['photo']=$expert['small_photo'];
				$reDataArr['loginname']=$expert['login_name'];
			}
			$this->result_code = "2000";
			$this->result_msg = "success";
		} else {
			$this->result_code = "4001";
			$this->result_msg = "data empty";
		}
		$this->result_data = $reDataArr;
		$this->resultJSON = array (
				"msg" => $this->result_msg,
				"code" => $this->result_code,
				"data" => $this->result_data
		);
		echo $this->callback . "(" . json_encode ( $this->resultJSON ) . ")";
	}
	/**
	 * 读取对方未读聊天信息
	 * return:json
	 */
	public function get_message() {
		$member_id=$this->input->get('mid');
		$expert_id=$this->input->get('eid');
		$action=$this->input->get('action');
		$page = $this->input->get ( "page" );
		$number = $this->input->get ( "number" );
		if($action=='0'){
			$action="1";
		}else{
			$action="0";
		}
		$this->callback = $this->input->get ( "callback" );
		$group=$this->search_groupid($member_id,$expert_id,$action);
		$whereArr=array(
				'group_id'=>$group['id'],
				'status'=>'0'
		);
		$orderby='addtime';		
		$reDataArr=$this->kefu_message_model->result($whereArr,$page=1,$number=10,$orderby);
		$reDataArr=$this->handle_array($reDataArr, $member_id, $expert_id, $action);
		if (sizeof ( $reDataArr ) == 0) {
			$result_code = "4001";
			$result_msg = "data empty";
		} else {
			$result_code = "2000";
			$result_msg = "success";
			$dataArr=array('status'=>'1');
			$this->kefu_message_model->update($dataArr,$whereArr);
			$whereArr_gorup=array(
					'id'=>$group['id'],
					'status'=>'0'
			);
			$this->kefu_group_model->update($dataArr,$whereArr_gorup);
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

	/**
	 * 获取历史聊天记录
	 * @param unknown $member_id        	
	 * @param unknown $expert_id        	
	 * @param unknown $action        	
	 * @return unknown $page
	 */
	public function get_all_message(){
		$member_id=$this->input->get('mid');
		$expert_id=$this->input->get('eid');
		$page=$this->input->get ( "page" );
		$page = empty($page)?'':$page;
		$num = $this->input->get ( "number" );
		$num = empty($num)?'8':$num;
		if($page==0) $page=1;
		$offset=($page-1)*$num;	
		$group=$this->search_groupid($member_id,$expert_id);
		$group_id=array(
				$group['0']['id'],
				$group['1']['id']
		);
		$this->db->where_in('group_id', $group_id);		
		$orderby='kefu_message.addtime DESC';
		if(!empty($orderby)){
			$orderby = str_replace("@"," ",$orderby);
			$this->db->order_by($orderby);
		}
		$this->db->join('kefu_group', 'kefu_group.id = kefu_message.group_id');
		$query = $this->db->get('kefu_message',$num,$offset);		
		$reDataArr=$query->result_array();
		foreach($reDataArr as $key =>$val)
		{
			if($reDataArr [$key]['action']=='0'){
				$member=$this->member_model->row(array('mid'=>$member_id));
				$reDataArr [$key]['photo']=$member['litpic'];
				$reDataArr [$key]['loginname']=$member['loginname'];
			}else if($reDataArr [$key]['action']=='1'){				
				$expert=$this->expert_model->row(array('id'=>$expert_id));
				$reDataArr [$key]['photo']=$expert['small_photo'];
				$reDataArr [$key]['loginname']=$expert['realname'];
			}
		}
		if (sizeof ( $reDataArr ) == 0) {
			$this->result_code = "4001";
		} else {
			$this->result_code = "2000";
		}
		$this->result_data = $reDataArr;
		$this->resultJSON = array (
				"code" => $this->result_code,
				"data" => $this->result_data
		);
		echo $this->callback . "(" . json_encode ( $this->resultJSON ) . ")";
	}
	/**
	 * 获得历史消息的总条数
	 */
	public function get_total_message(){
		$member_id=$this->input->get('mid');
		$expert_id=$this->input->get('eid');
		$num = $this->input->get ( "number" );
		$num = empty($num)?'6':$num;
		if($member_id==""){//判断是不是访客
			$flag=0;			
			$member_id=$this->session->userdata('session_id');
		}
		$group=$this->search_groupid($member_id,$expert_id);
		$group_id=array(
				$group['0']['id'],
				$group['1']['id']
		);
		$query_total = $this->db->query('SELECT * FROM kefu_message WHERE group_id IN ('.$group['0']['id']." , ".$group['1']['id'].")");
		$this->result_total = ceil($query_total->num_rows()/$num);
		if (sizeof ( $this->result_total ) == 0) {
			$this->result_code = "4001";
		} else {
			$this->result_code = "2000";
		}
		$this->resultJSON = array (
				"total" => $this->result_total,
				"code" => $this->result_code
		);
		echo $this->callback . "(" . json_encode ( $this->resultJSON ) . ")";
	}
	
	/**
	 * 查询组id
	 *
	 * @param unknown $member_id        	
	 * @param unknown $expert_id        	
	 * @param unknown $action        	
	 * @return unknown
	 */
	public function search_groupid($member_id, $expert_id, $action="") {
		if ($action!="") {
			$whereArr = array (
					'member_id' => $member_id,
					'expert_id' => $expert_id,
					'action' => $action 
			);
			$group = $this->kefu_group_model->row ( $whereArr );			
		} else {
			$whereArr = array (
					'member_id' => $member_id,
					'expert_id' => $expert_id 
			);
			$group = $this->kefu_group_model->all ( $whereArr );			
		}
		return $group;
		
	}
	
	
	/**
	 * 更新数组里的数据,获取发送人信息
	 * @param unknown $reDataArr
	 * @param unknown $member_id
	 * @param unknown $expert_id
	 * @param unknown $action
	 */
	protected function handle_array($reDataArr,$member_id="",$expert_id="",$action){
		foreach($reDataArr as $key =>$val)
		{
			if($action=='0'){
				if($member_id==""){
	    				$reDataArr [$key]['photo']="/static/kefu_photo.png";
	    				$reDataArr [$key]['loginname']=$this->input->ip_address();
	    			}else{
	    				$member=$this->member_model->row(array('mid'=>$member_id));
	    				$reDataArr [$key]['photo']=$member['litpic'];
	    				$reDataArr [$key]['loginname']=$member['loginname'];
	    			}
			}else if($action=='1'){
				$expert=$this->expert_model->row(array('id'=>$expert_id));
				$reDataArr [$key]['photo']=$expert['small_photo'];
				$reDataArr [$key]['loginname']=$expert['login_name'];
			}
		}
		return $reDataArr;
		 
	}

	/**
	 * 关闭数据库连接
	 */
	public function __destruct(){
		$this ->db ->close();
	}
	
	/**
	 *  定义输出格式化
	 * @param unknown $reDataArr
	 */
	private function _outmsg($reDataArr){
		if (sizeof ( $reDataArr ) == 0) {
			$this->result_code = "4001";
			$this->result_msg = "data empty";
		} else {
			$this->result_code = "2000";
			$this->result_msg = "success";
		}
		$this->result_data = $reDataArr;
		$this->resultJSON = array (
				"msg" => $this->result_msg,
				"code" => $this->result_code,
				"data" => $this->result_data
		);
		echo $this->callback . "(" . json_encode ( $this->resultJSON ) . ")";
	}
}

/* End of file webservice.php */
/* Location: ./application/controllers/kefu_webservice.php */