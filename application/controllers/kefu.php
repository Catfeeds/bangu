<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @客服
 * @path：controllers/kefu.php
 * ===================================================================

 * ===================================================================
 * @类别：客服插件
 * @作者：何俊 （junhey@qq.com）v1.0 Final
 */

class Kefu extends UC_NL_Controller {
		
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kefu/kefu_group_model','kefu_group_model');
        $this->load->model('kefu/kefu_message_model','kefu_message_model');
        $this->load->model('expert_model');
        $this->load->model('member_model');
        $this->load->library ( 'callback' );
        //session_start();
        $ip=$this->input->ip_address();
    }
    public function index()
    {
    	$member_id=$this->input->get('member_id');
    	$expert_id=$this->input->get('expert_id');
    	$action=$this->input->get('action');
    	$e=$this->expert_model->row(array('id'=>$expert_id),$type='arr', $orderby = "",$fieldsArr=array('status'));    	
    	if($e['status']!=2){
    		$cancel_url=base_url();
    		echo "<script language='javascript'>";
    		echo "function cancel(){location='".$cancel_url."';}";
    		echo " alert('管家不存在,将在3秒后跳转首页');setTimeout(cancel(),3000);";
    		echo "</script>";
    	}
    	if(!(empty($member_id))){	    		
	    		$g=$this->kefu_group_model->row(array('member_id'=>$member_id,'expert_id'=>$expert_id));
	    		if(sizeof($g)==0){
	    			$dataArr=array(
	    					'member_id'=>$member_id,
	    					'expert_id'=>$expert_id,
	    					'lasttime'=>date('Y-m-d H:i:s'),
	    					'action'=>$action
	    			);
	    			$this->kefu_group_model->insert($dataArr);
	    			$dataArr_b2=array(
	    					'member_id'=>$member_id,
	    					'expert_id'=>$expert_id,
	    					'lasttime'=>date('Y-m-d H:i:s'),
	    					'action'=>!$action
	    			);
	    			$this->kefu_group_model->insert($dataArr_b2);		    		
	    		}
	    		//显示页面
	    		$this->load->view('kefu_view');
    	}else{
    		$session_id = $this->session->userdata('session_id');
//     		$kefu_url=base_url().'/kefu?member_id='.$session_id.'&expert_id='.$expert_id.'&action=0';
//     		echo "<script language='javascript'>";
// 			echo " location='".$kefu_url."';";
// 			echo "</script>";
    		$g=$this->kefu_group_model->row(array('member_id'=>$session_id,'expert_id'=>$expert_id));
    		if(sizeof($g)==0){
    			$dataArr=array(
    					'member_id'=>$session_id,
    					'expert_id'=>$expert_id,
    					'lasttime'=>date('Y-m-d H:i:s'),
    					'action'=>$action
    			);
    			$this->kefu_group_model->insert($dataArr);
    			$dataArr_b2=array(
    					'member_id'=>$session_id,
    					'expert_id'=>$expert_id,
    					'lasttime'=>date('Y-m-d H:i:s'),
    					'action'=>!$action
    			);
    			$this->kefu_group_model->insert($dataArr_b2);
    		}
    		//显示页面
    		$this->load->view('kefu_view');
    	}
    }
    
    /*
     * 发送给对方消息
     */
    public function send(){
    	$content=strip_tags($this->input->get('content'));
    	$member_id=$this->input->get('member_id');    	
    	$expert_id=$this->input->get('expert_id');
    	$action=$this->input->get('action');
    	$ip=$this->input->ip_address();
		$source=($ip=="::1") ? "127.0.0.1" : $ip;
		$default_photo="/static/img/kefu_photo.png";
		$flag=1;
		if($member_id==""){
			$flag=0;
			$member_id=$this->session->userdata('session_id');
		}		
    	$whereArr=array(
    			'member_id'=>$member_id,
    			'expert_id'=>$expert_id
    	);
    	
    	$dataArr_group=array(
				'lastcontent'=>$content,
    			'lasttime'=>date('Y-m-d H:i:s')
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
    		//print_r($reDataArr);exit();
    		if($action=='0'){
    		    if($flag=="0"){    		    	
    				$reDataArr['photo']=$default_photo;
    				$reDataArr['loginname']=$source;
    			}else{
    				$member=$this->member_model->row(array('mid'=>$member_id));
    				$reDataArr['photo']=$member['litpic'];
    				$reDataArr['loginname']=$member['loginname'];
    			}
    		}else if($action=='1'){
    			$expert=$this->expert_model->row(array('id'=>$expert_id));
    			$reDataArr['photo']=$expert['small_photo'];
    			$reDataArr['loginname']=$expert['login_name'];
    		}
    		$this->callback->set_code_data ( 2000 ,$reDataArr);
    	} else {
    		$this->callback->set_code ( 4000 ,"发送失败");
    	}
    	echo $this->callback->exit_json();
    }
    
    /**
     * 读取对方未读聊天信息
     */
    public function receive(){    	
    	$member_id=$this->input->get('member_id');
    	$expert_id=$this->input->get('expert_id');
    	$action=$this->input->get('action');
    	if($action=='0'){
    		$action="1";
    	}else{
    		$action="0";
    	}
    	if($member_id==""){
    		$member_id=$this->session->userdata('session_id');
    	}
    	//print_r($member_id.$expert_id.$action);
    	$this->callback = $this->input->get ( "callback" );
    	$group=$this->search_groupid($member_id,$expert_id,$action);
    	//print_r($group);exit();
    	$whereArr=array(
    			'group_id'=>$group['id'],
    			'status'=>'0'
    	);
    	$orderby='addtime desc';
    	$reDataArr=$this->kefu_message_model->all($whereArr,$orderby);
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
	 * 查询组id
	 * @param unknown $member_id
	 * @param unknown $expert_id
	 * @param unknown $action
	 * @return unknown
	 */
    public function search_groupid($member_id,$expert_id,$action){
    	if($member_id==""){
    		$member_id=$this->session->userdata('session_id');
    	}
    	$whereArr=array(
    			'member_id'=>$member_id,
    			'expert_id'=>$expert_id,
    			'action'=>$action
    	);
    	$group=$this->kefu_group_model->row($whereArr);
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
    	$this->load_model('expert_model');
    	$this->load_model('member_model');
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

    
}

/* End of file kefu.php */
/* Location: ./application/controllers/kefu.php */