<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年01月15日11:35:53
 * @author		wangxiaofeng
 * @Class 		深窗活动目的地线路配置
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Activity_dest_line extends UA_Controller {
	public $controllerName = '深窗活动目的地线路配置';
	public function __construct() {
		parent::__construct ();
		$this->load_model('admin/a/sc_activity_model/Activity_dest_line_model','activity_dest_line');
	}

	function index(){
		//获取活动分类
		$this ->load_model('admin/a/sc_activity_model/sc_activity_city_model' ,'sc_activity_city_model');
		$data['act_city_name'] = $this ->sc_activity_city_model ->all(array('status' =>1));
		$this ->load_model('admin/a/sc_activity_model/sc_activity_dest_model' ,'sc_activity_dest_model');
		$data['act_city_dest'] = $this ->sc_activity_dest_model ->all(array('status' =>1));
		$this->load_view ( 'admin/a/cfg_activity/activity_dest_line_view',$data);
	}

	public function getDestLineData() {
		$data=$this->activity_dest_line->getDestLineData();
		echo json_encode($data);
	}
	//增加
	public function add() {
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->activity_dest_line ->insert($dataArr);
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"添加失败");
			$this->callback->exit_json();
		} else {
			$this ->log(1,3,'深窗活动目的地线路配置','目的地线路，名称：'.$title);
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
		$status = $this ->activity_dest_line ->update($dataArr ,array('id' =>intval($postArr['id'])));
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
		if(empty($postArr['act_city_id'])){
			$this->callback->set_code ( 4000 ,"请选择活动城市");
			$this->callback->exit_json();
		}
		if(empty($postArr['act_dest_id'])){
			$this->callback->set_code ( 4000 ,"请选活动目的地");
			$this->callback->exit_json();
		}
		if(empty($postArr['line_id'])){
			$this->callback->set_code ( 4000 ,"请选择线路");
			$this->callback->exit_json();
		}
		return array(
				'activity_city_id' =>$postArr['act_city_id'],
				'sc_activity_dest_id' =>$postArr['act_dest_id'],
				'line_id' => $postArr['line_id'],
				'showorder' =>$postArr['showorder'],
				'status' =>1
		);
	}

	//获取某条数据
	public function getOneData () {
		$id = intval($this ->input ->post('id'));
		$whereArr=array('sr.id='=>$id);
		$data=$this->activity_dest_line->getDestLineData($whereArr);
		if (empty($data)) {
			echo false;
			exit;
		} else {
			$res = $data['data'][0];
			echo json_encode($res);
		}
	}

	//删除
	function delete(){
		$id = intval($this->input->post("id"));
		$status = $this ->activity_dest_line ->update(array('status'=>0),array('id'=>$id));
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