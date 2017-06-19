<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年01月15日11:35:53
 * @author		wangxiaofeng
 * @Class 		深窗活动促销配置
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Ac_activity extends UA_Controller {
	public $controllerName = '深窗活动促销配置';
	public function __construct() {
		parent::__construct ();
		$this->load_model('admin/a/sc_activity_model/ac_activity_model','ac_activity');
	}

	function index(){
		$this->load_view ( 'admin/a/cfg_activity/ac_activity_view');
	}

	public function getAcList() {
		$data=$this->ac_activity->getAcData();
		echo json_encode($data);
	}
	//增加
	public function add() {
		$title = trim($this ->input ->post('title' ,true));
		$description = trim($this ->input ->post('description' ,true));
		if (empty($title)) {
			$this->callback->set_code ( 4000 ,"请填写标题");
			$this->callback->exit_json();
		} else {
			$navData = $this ->ac_activity ->row(array('name' =>$title));
			if (!empty($navData)) {
				$this->callback->set_code ( 4000 ,"此标题已存在");
				$this->callback->exit_json();
			}
		}
		$navArr = array(
			'name' =>$title,
			'adminid' =>$this->session->userdata('a_user_id'),
			'addtime' => date('Y-m-d H:i:s'),
			'description' =>$description,
			'status' =>1
		);
		$status = $this ->ac_activity ->insert($navArr);
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"添加失败");
			$this->callback->exit_json();
		} else {
			$this ->log(1,3,'深窗广告配置','增加广告，名称：'.$title);
			$this->callback->set_code ( 2000 ,"添加成功");
			$this->callback->exit_json();
		}
	}
	//编辑
	public function edit() {
		$postArr = $this->security->xss_clean($_POST);
		if (empty($postArr['id'])) {
			$this->callback->set_code ( 4000 ,"缺少编辑的数据");
			$this->callback->exit_json();
		}
		$dataArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->ac_activity ->update($dataArr ,array('id' =>intval($postArr['id'])));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"编辑失败");
			$this->callback->exit_json();
		} else {
			$this ->log(3,3,$this->controllerName,'编辑'.$this->controllerName);
			$this->callback->set_code ( 2000 ,"编辑成功");
			$this->callback->exit_json();
		}
	}

	//添加编辑时公用
	public function commonFunc($postArr ,$type)
	{
		if(empty($postArr['title']))
		{
			$this->callback->set_code ( 4000 ,"标题不能为空");
			$this->callback->exit_json();
		}
		return array(
				'name' =>$postArr['title'],
				'description' =>trim($postArr['description'])
		);
	}

	//获取某条数据
	public function getOneData () {
		$id = intval($this ->input ->post('id'));
		$whereArr=array('ac.id='=>$id);
		$data=$this->ac_activity->getAcData($whereArr);
		if (empty($data)) {
			echo false;
			exit;
		} else {
			$data = $data['data'][0];
			echo json_encode($data);
		}
	}

	//删除
	function delete(){
		$id = intval($this->input->post("id"));
		$status = $this ->ac_activity ->update(array('status'=>0),array('id'=>$id));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"删除失败");
			$this->callback->exit_json();
		}
		else {
			$this ->log(2,3,$this->controllerName,'平台删除'.$this->controllerName.',记录ID:'.$id);
			$this->callback->set_code ( 2000 ,"删除成功");
			$this->callback->exit_json();
		}
	}

}