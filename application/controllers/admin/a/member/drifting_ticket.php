<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @method 		漂流门票的设置
 */
if (! defined ( 'BASEPATH' ))
exit ( 'No direct script access allowed' );

class Drifting_ticket extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( 'admin/a/member_model', 'member_model' );
	}
	//漂流门票的设置
	public function index()
	{
		$data['pageData']=$this->member_model->get_wx_drifting(array(),$this->getPage ());
		$this->load_view ('admin/a/ui/member/drifting_ticket',$data);
	}
	 
	//漂流门票列表
	function driftingData(){
		$param = $this->getParam(array('s_name','s_channel_code'));
		$data = $this->member_model->get_wx_drifting( $param , $this->getPage ());
		echo  $data ;
	}
	
	//保存漂流门票
	function save_wx_activity(){
		$name=$this->input->post('wx_name',true);
		$code=$this->input->post('wx_code',true);
		$num=$this->input->post('wx_num',true);
		$wx_id=$this->input->post('wx_id',true);
		$data=array(
			'name'=>$name,
			'code'=>$code,
			'num'=>$num,
			'status'=>1
		);
		if($wx_id>0){  //编辑
			
			$status=$this->member_model->edit_wx_activity($data,$wx_id);
			if($status){
				echo  json_encode(array('status'=>1,'msg'=>'编辑成功'));
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'编辑失败'));
			}
			
		}else{       //添加
			
			$res=$this->member_model->insert_wx_activity($data);	
			if($res>0){
				echo  json_encode(array('status'=>1,'msg'=>'添加成功'));
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'添加失败'));
			}
		}
	}
	//获取某一条数据的门票信息
	function get_wx_activity(){
		$id=$this->input->post('id',true);
		$activity=$this->member_model->get_wx_activity($id);
		if(!empty($activity)){
			echo json_encode(array('status'=>1,'activity'=>$activity));
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'获取数据失败'));
		}
	}
	//删除门票信息
	 function del_wx_activity(){
	 	$id=$this->input->post('id');
	 	if($id>0){
	 		$res=$this->member_model->del_activity_data($id);
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
