<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @method 		渠道管理
 */
if (! defined ( 'BASEPATH' ))
exit ( 'No direct script access allowed' );

class Channel_manage extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( 'admin/a/member_model', 'member_model' );
	}
	//渠道列表
	public function index()
	{
		$data['pageData']=$this->member_model->u_register_channel(array(),$this->getPage ());
		$this->load_view ('admin/a/ui/member/channel_manage',$data);
	}
	//渠道列表
	function channelData(){
		$param = $this->getParam(array('s_name','s_channel_code'));
		$data = $this->member_model->u_register_channel( $param , $this->getPage ());
		echo  $data ;
	}
	//保存渠道
	function save_channelData(){
		$channel_id=$this->input->post('channel_id');
		$channelArr['name']=$this->input->post('name');
		$channelArr['channel_code']=$this->input->post('channel_code');
		if($channel_id>0){//修改
			
			$flag=$this->member_model->edit_channelData($channelArr,$channel_id);
			
			if($flag){
				
				echo  json_encode(array('status'=>1,'msg'=>'编辑成功'));
			}else{
				
				echo  json_encode(array('status'=>-1,'msg'=>'编辑失败'));
			}
		}else{ //添加
			
			$channel=$this->member_model->insert_channelData($channelArr);
			
			if($channel){
				echo  json_encode(array('status'=>1,'msg'=>'添加成功'));
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'添加失败'));
			}
		}
	}
	//获取会员注册渠道
	function get_channelData(){
		$channelid=$this->input->post('id');
		$channel=$this->member_model->get_channel_data($channelid);
		if(!empty($channel)){
			echo json_encode(array('status'=>1,'channel'=>$channel));
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'获取数据失败'));
		}
	}
	//删除会员注册渠道
	function del_channelData(){
		$channelid=$this->input->post('id');
		if($channelid>0){
			$res=$this->member_model->del_channel_data($channelid);
			if($res){
				echo json_encode(array('status'=>1,'msg'=>'操作成功'));
			}else{
				echo json_encode(array('status'=>-1,'msg'=>'操作失败'));
			}
			
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
		}
	}

}
