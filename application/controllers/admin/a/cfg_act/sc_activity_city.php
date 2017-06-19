<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年01月15日11:35:53
 * @author		wangxiaofeng
 * @Class 		深窗活动城市
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sc_activity_city extends UA_Controller {
	public $controllerName = '深窗活动城市';
	public function __construct() {
		parent::__construct ();
		$this->load_model('admin/a/sc_activity_model/sc_activity_city_model','activity_city');
	}

	function index(){
		//获取活动分类
		$this ->load_model('admin/a/sc_activity_model/ac_activity_model' ,'ac_activity_model');
		$data['act_name'] = $this ->ac_activity_model ->all(array('status' =>1));
		$this->load_view ( 'admin/a/cfg_activity/sc_activity_city_view',$data);
	}

	public function getCityList() {
		$data=$this->activity_city->getCityData();
		echo json_encode($data);
	}
	//增加
	public function add() {
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->activity_city ->insert($dataArr);
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"添加失败");
			$this->callback->exit_json();
		} else {
			$this ->log(1,3,'深窗活动城市','增加城市，名称：'.$title);
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
		$status = $this ->activity_city ->update($dataArr ,array('id' =>intval($postArr['id'])));
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
		if(empty($postArr['act_id'])){
			$this->callback->set_code ( 4000 ,"请选择活动");
			$this->callback->exit_json();
		}
		if(empty($postArr['start_city'])){
			$this->callback->set_code ( 4000 ,"请选择出发地");
			$this->callback->exit_json();
		}
		if(empty($postArr['city_name'])){
			$this->callback->set_code ( 4000 ,"请填写活动城市");
			$this->callback->exit_json();
		}
		return array(
				'act_id' =>$postArr['act_id'],
				'name' => $postArr['city_name'],
				'startcityid' =>$postArr['start_city'],
				'showorder' =>$postArr['showorder'],
				'isopen' =>$postArr['is_open'],
				'status' =>1
		);
	}

	//获取某条数据
	public function getOneData () {
		$id = intval($this ->input ->post('id'));
		$whereArr=array('sac.id='=>$id);
		$data=$this->activity_city->getCityData($whereArr);
		if (empty($data)) {
			echo false;
			exit;
		} else {
			//获取出发城市的上级
		$this ->load_model('common/u_startplace_model' ,'start_model');
		$startData = $this ->start_model ->row(array('id' =>$data['data'][0]['startcityid']));
		$data['data'][0]['start_province'] = $startData['pid'];
		$startData = $this ->start_model ->row(array('id' =>$startData['pid']));
		$data['data'][0]['start_country'] = $startData['pid'];

		$res = $data['data'][0];
		echo json_encode($res);
		}
	}

	//删除
	function delete(){
		$id = intval($this->input->post("id"));
		$status = $this ->activity_city ->update(array('status'=>0),array('id'=>$id));
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