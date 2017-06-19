<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		jiakairong
 * @method 		首页主题线路
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sc_consult extends UA_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load_model('admin/a/sc_consult_model','sc_consult');
	}
	function index(){
		$consult_res = $this->sc_consult->get_consult();
		$this ->load_model('admin/a/index_kind_model' ,'kind_model');
		$data['kindData'] = $this ->kind_model ->all();
		$data['consult'] =  $consult_res;
		$this->load_view ( 'admin/a/sc_cfg/sc_consult_list',$data);
	}
	public function getListData() {
		$whereArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1: $page_new;
		//获取数据
		$data = $this ->sc_consult ->getData($whereArr ,$page_new ,sys_constant::A_PAGE_SIZE);
		echo json_encode($data);
	}
	//增加首页分类主题线路
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		$sellArr = $this ->commonSell($postArr, 'add');
		$status = $this ->sc_consult ->insert($sellArr);
		if (empty($status))
		{
			$this->callback->set_code ( 4000 ,'添加失败');
			$this->callback->exit_json();
		}
		else
		{
			$this ->log(1,3,'深窗资讯配置','深窗资讯');
			$this->callback->set_code ( 2000 ,'添加成功');
			$this->callback->exit_json();
		}
	}
	//编辑首页分类主题线路
	public function edit() {
		$postArr = $this->security->xss_clean($_POST);
		if (empty($postArr['id'])) {
			$this->callback->set_code ( 4000 ,"缺少编辑的数据");
			$this->callback->exit_json();
		}
		$sellArr = $this ->commonSell($postArr, 'edit');
		$status = $this ->sc_consult ->update($sellArr ,array('id' =>intval($postArr['id'])));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"编辑失败");
			$this->callback->exit_json();
		} else {
			$this ->log(3,3,'深窗资讯配置','编辑深窗资讯');
			$this->callback->set_code ( 2000 ,"编辑成功");
			$this->callback->exit_json();
		}
	}
	//添加编辑时公用
	public function commonSell($postArr ,$type)
	{
		if(empty($postArr['consult_id'])){
			$this->callback->set_code ( 4000 ,"请选择资讯");
			$this->callback->exit_json();
		}else{
			$consult_res = $this->sc_consult->get_consult(array('id='=>$postArr['consult_id']));
		}
		if(empty($postArr['pic'])){
			$pic = '';
		}else{
			$pic = $postArr['pic'];
		}
		return array(
				'consult_id' =>rtrim($postArr['consult_id'],','),
				'dest_id' =>$consult_res[0]['dest_id'],
				'pic' =>$pic,
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'index_kind_id'=>$postArr['kind_id'],
				'beizhu' =>trim($postArr['beizhu']),
				'showorder' =>empty($postArr['showorder']) ? 999 : intval($postArr['showorder'])
		);
	}

	//获取某条数据
	public function getOneData () {
		$id = intval($this ->input ->post('id'));
		$whereArr=array('tl.id ='=>$id);
		$data=$this ->sc_consult ->getData($whereArr);
		if (!empty($data)) {
			echo json_encode($data['data'][0]);
		}
	}

	//删除首页主题线路
	function delete(){
		$id = intval($this->input->post("id"));
		$status = $this->sc_consult->delete(array('id'=>$id));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"删除失败==>".$status);
			$this->callback->exit_json();
		}
		else {
			$this ->log(2,3,'深窗资讯配置',"平台删除深窗资讯,记录ID:{$id}");
			$this->callback->set_code ( 2000 ,"删除成功");
			$this->callback->exit_json();
		}
	}


}