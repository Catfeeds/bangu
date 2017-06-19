<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年01月15日11:35:53
 * @author		wangxiaofeng
 * @Class 		深窗活动分类目的地配置
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sc_activity_dest extends UA_Controller {
	public $controllerName = '深窗活动分类目的地配置';
	public function __construct() {
		parent::__construct ();
		$this->load_model('admin/a/sc_activity_model/Sc_activity_dest_model','activity_dest');
	}

	function index(){
		//获取活动分类
		$this ->load_model('admin/a/sc_activity_model/sc_activity_city_model' ,'sc_activity_city_model');
		$data['act_city_name'] = $this ->sc_activity_city_model ->all(array('status' =>1));
		$this ->load_model('admin/a/index_kind_model' ,'kind_model');
		$data['kindData'] = $this ->kind_model ->all(array('dest_id >' =>0 ,'is_show' =>1));
		$data['kind'] = $this ->kind_model ->all(array('is_show' =>1));
		$this->load_view ( 'admin/a/cfg_activity/sc_activity_dest_view',$data);
	}

	public function getDestData() {
		$data=$this->activity_dest->getDestData();
		echo json_encode($data);
	}
	//增加
	public function add() {
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->activity_dest ->insert($dataArr);
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"添加失败");
			$this->callback->exit_json();
		} else {
			$this ->log(1,3,'深窗活动分类目的地配置','增加广告，名称：'.$title);
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
		$status = $this ->activity_dest ->update($dataArr ,array('id' =>intval($postArr['id'])));
		if ($status==0) {
			$this->callback->set_code ( 4000 ,"没有修改任何数据");
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

		if(empty($postArr['kind_id'])){
			$this->callback->set_code ( 4000 ,"请填选择类别");
			$this->callback->exit_json();
		}

		if(empty($postArr['name'])){
			$this->callback->set_code ( 4000 ,"请填写名称");
			$this->callback->exit_json();
		}
		return array(
				'activity_city_id' =>$postArr['act_city_id'],
				'index_kind_id' => $postArr['kind_id'],
				'showorder' =>$postArr['showorder'],
				'dest_id' =>empty($postArr['destTwo']) ? intval($postArr['destOne']) :intval($postArr['destTwo']),
				'name' =>$postArr['name'],
				'status' =>1
		);
	}

	//获取某条数据
	public function getOneData () {
		$id = intval($this ->input ->post('id'));
		$whereArr=array('sr.id='=>$id);
		$data=$this->activity_dest->getDestData($whereArr);
		if (empty($data)) {
			echo false;
			exit;
		} else {
			//获取目的地的上级
			$this ->load_model('common/u_destinations_model' ,'destinations_model');
			$destData = $this ->destinations_model ->row(array('id' =>$data['data'][0]['dest_id']));
			//var_dump($destData);
			$data['data'][0]['destOne'] = $destData['pid'];

			//判断是一级分类是否是周边游
			if ($kindDest[0]['ikname'] == '周边游') {
				$this ->load_model('common/cfg_round_trip_model' ,'trip_model');
				$data['data'][0]['trip'] = $this ->trip_model ->getRoundTripData(array('crt.startplaceid' =>$kindDest[0]['startplaceid'] ,'crt.isopen' =>1) ,0);
			}

			$res = $data['data'][0];
			echo json_encode($res);
		}
	}

	//删除
	function delete(){
		$id = intval($this->input->post("id"));
		$status = $this ->activity_dest ->update(array('status'=>0),array('id'=>$id));
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