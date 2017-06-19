<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_consult extends UA_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'admin/a/consult_model', 'consult_model' );
	}
	
	function index(){
		$data['pageData']=$this->consult_model->get_cfg_consult(null,$this->getPage ());
		$this->load_view ( 'admin/a/cfg/index_consult',$data);
	}
	//资讯分页
	function cfg_consult(){
		$param = $this->getParam(array('title','consultType'));
		$data = $this->consult_model->get_cfg_consult( $param , $this->getPage ());
		
		echo  $data ;
	}
	//资讯信息
	function get_consult(){
		$whereArr = array();
		$likeArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1: $page_new;
		$name = trim($this ->input ->post('name' ,true));
		$consult_type = intval($this ->input ->post('type'));
		$is = intval($this ->input ->post('is'));
		$pagesize = intval($this ->input ->post('pagesize'));
		$pagesize = empty($pagesize) ? self::PAGESIZE :$pagesize;
		//搜索名称
		if (!empty($name)) {
			$likeArr ['title'] = $name;
		}
		if($consult_type>0){
			$likeArr ['type'] = $consult_type;
		}
		//搜索类型
		//value="1"
		//获取数据
		$list = $this ->consult_model ->get_cfg_consult_data($whereArr ,$page_new ,$pagesize ,1 ,$likeArr);
		//echo $this->db->last_query();
		$count = $this->getCountNumber($this->db->last_query());
		//var_dump($count);
		$page_str = $this ->getAjaxPage($page_new ,$count,18);
		//echo $this->db->last_query();
		$data = array(
				'page_string' =>$page_str,
				'list' =>$list
		);	
		echo json_encode($data);
		exit;
	}
	//添加资讯的配置
	function add_cfg_consult(){
		//咨询配置表
		$insert_Cfg['location']=$this->input->post('location');  //位置
		$insert_Cfg['pic']=$this->input->post('cfg_pic');  //图片
		$insert_Cfg['is_modify']=$this->input->post('is_modify');  //是否更改
		$insert_Cfg['is_show']=$this->input->post('is_show'); //是否显示
		$insert_Cfg['beizhu']=$this->input->post('beizhu');
		$insert_Cfg['consult_id']=intval($this->input->post('consult_id'));
		$insert_Cfg['showorder']=$this->input->post('showorder');
		if(empty($insert_Cfg['consult_id'])){
			echo json_encode(array('status'=>-1,'msg'=>'请选择资讯'));
			exit;
		}
		$typeid=intval($this->input->post('typeid'));
		if($typeid>0){ //编辑
			$re=$this->consult_model ->update_table('cfg_consult',array('id'=>$typeid),$insert_Cfg);
			if($re>0){
				echo json_encode(array('status'=>1,'msg'=>'编辑成功'));
			}else{
				echo json_encode(array('status'=>-1,'msg'=>'编辑失败'));
			}
		}else{  //添加
			$id=$this ->consult_model ->insert_table_data('cfg_consult',$insert_Cfg);
			if($id>0){
				echo json_encode(array('status'=>1,'msg'=>'添加成功'));
			}else{
				echo json_encode(array('status'=>-1,'msg'=>'添加失败'));
			}	
		}
	}
	//资讯配置
	function get_consult_rowdata(){
		$id=$this->input->post('id');
		
		if($id>0){
			$data=$this ->consult_model ->get_cfg_rowdata(array('cf.id'=>$id));
			echo json_encode(array('status'=>1,'msg'=>'获取数据成功','data'=>$data));
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'获取数据失败'));
		}
	}
}
