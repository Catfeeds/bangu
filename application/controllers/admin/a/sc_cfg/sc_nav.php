<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年01月15日11:35:53
 * @author		wangxiaofeng
 * @method 		深窗导航配置
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sc_nav extends UA_Controller {
	public $controllerName = '深窗导航配置';
	public function __construct() {
		parent::__construct ();
		$this->load_model('admin/a/sc_nav_model','sc_nav_model');
	}

	function index(){
		$this->load_view ( 'admin/a/sc_cfg/sc_nav_list');
	}

	public function getNavList() {
		$page_new = intval($this ->input ->post('page_new'));
		$data ['list']=$this->sc_nav_model->result(array() ,$page_new ,sys_constant::A_PAGE_SIZE ,'id desc');
		$count = $this ->getCountNumber($this ->db ->last_query());
		$data['page_string'] = $this ->getAjaxPage($page_new ,$count);
		echo json_encode($data);
	}
	//增加
	public function add() {
		$name = trim($this ->input ->post('name' ,true));
		$link = trim($this ->input ->post('link' ,true));
		$showorder = intval($this ->input ->post('showorder' ,true));
		//$description = trim($this ->input ->post('description' ,true));
		$is_show = intval($this ->input ->post('is_show'));
		$beizhu = intval($this ->input ->post('beizhu'));
		$is_modify = intval($this ->input ->post('is_modify'));
		//$location = intval($this ->input ->post('location'));
		//$pic = trim($this ->input ->post('pic'));
		if (empty($name)) {
			$this->callback->set_code ( 4000 ,"请填写标题");
			$this->callback->exit_json();
		} else {
			$navData = $this ->sc_nav_model ->row(array('name' =>$name));
			if (!empty($navData)) {
				$this->callback->set_code ( 4000 ,"此标题已存在");
				$this->callback->exit_json();
			}
		}
		if (empty($link)) {
			$this->callback->set_code ( 4000 ,"请填写链接地址");
			$this->callback->exit_json();
		}
		$navArr = array(
			'name' =>$name,
			'link' =>$link,
			'beizhu' =>$beizhu,
			'showorder' =>empty($showorder) ? 99 : $showorder,
			'is_show' =>$is_show,
			'is_modify' =>$is_modify
		);
		$status = $this ->sc_nav_model ->insert($navArr);
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"添加失败");
			$this->callback->exit_json();
		} else {
			$this ->log(1,3,'深窗导航配置','增加导航，名称：'.$title);
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
		$dataArr = $this ->commonFunc($postArr);
		$status = $this ->sc_nav_model ->update($dataArr ,array('id' =>intval($postArr['id'])));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"编辑失败");
			$this->callback->exit_json();
		} else {
			$this ->log(3,3,$this->controllerName,'编辑'.$this->controllerName);
			$this->callback->set_code ( 2000 ,"编辑成功");
			$this->callback->exit_json();
		}
	}


	//获取某条数据
	public function getOneData () {
		$id = intval($this ->input ->post('id'));
		$whereArr=array('id'=>$id);
		$data=$this->sc_nav_model->row($whereArr);
		echo json_encode($data);
	}

	//删除
	function delete(){
		$id = intval($this->input->post("id"));
		$status = $this ->sc_nav_model ->delete(array('id'=>$id));
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


		//添加和编辑公用部分
	function commonFunc($postArr) {
		if (empty($postArr['name'])) {
			$this->callback->set_code ( 4000 ,"请填写名称");
			$this->callback->exit_json();
		}
		$rollPicArr = array(
				'name' =>trim($postArr['name']),
				'link' =>trim($postArr['link']),
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'showorder' =>empty($postArr['showorder']) ? 999 : intval($postArr['showorder']),
				'beizhu' =>trim($postArr['beizhu'])
		);
		return $rollPicArr;
	}

}