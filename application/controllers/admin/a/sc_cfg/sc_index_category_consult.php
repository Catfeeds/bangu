<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年01月30日14:22:35
 * @author		wangxiaofeng
 * @method 		深窗文章标签配置
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sc_index_category_consult extends UA_Controller {
	public $controllerName = '深窗首页分类咨询配置';
	public function __construct() {
		parent::__construct ();
		$this->load_model('admin/a/sc_cfg_model/sc_index_category_consult_model','category_consult');
	}

	function index(){
		$this->load_model('admin/a/sc_cfg_model/sc_index_category_model','category');
		$this->load_model('admin/a/sc_cfg_model/sc_article_attr_model','article_attr');
		$this->load_model('consult_model','consult');
		$data['category'] = $this->category->all();
		$data['article_attr'] = $this->article_attr->all();
		$data['consult'] = $this->consult->all();
		$this->load_view ( 'admin/a/sc_cfg/sc_index_category_consult',$data);
	}

	public function getDataList() {
		$whereArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1: $page_new;
		//获取数据
		$data = $this ->category_consult ->getData($whereArr ,$page_new ,sys_constant::A_PAGE_SIZE);
		echo json_encode($data);
	}
	//增加
	public function add() {
		$postArr = $this->security->xss_clean($_POST);
		$navArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->category_consult ->insert($navArr);
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"添加失败");
			$this->callback->exit_json();
		} else {
			$this ->log(1,3,'深窗首页分类咨询配置','分类咨询配置');
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
		$status = $this ->category_consult ->update($dataArr ,array('id' =>intval($postArr['id'])));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"编辑失败");
			$this->callback->exit_json();
		} else {
			$this ->log(3,3,$this->controllerName,'编辑'.$this->controllerName);
			$this->callback->set_code ( 2000 ,"编辑成功");
			$this->callback->exit_json();
		}
	}


	public function commonFunc($postArr ,$type){
		if (empty($postArr['category'])){
			$this->callback->set_code ( 4000 ,"请选择模块");
			$this->callback->exit_json();
		}else if(empty($postArr['article_attr'])){
			//$this->callback->set_code ( 4000 ,"请选择属性标签");
		//	$this->callback->exit_json();
		}else if(empty($postArr['consult'])){
			$this->callback->set_code ( 4000 ,"请选资讯");
			$this->callback->exit_json();
		}
		$this->load_model('consult_model','consult');  //属性标签
		$AttridArr=$this->consult->all(array('id'=>$postArr['consult']));
		return array(
			'sc_index_category_id' =>$postArr['category'],
			//'article_attr_id' =>$postArr['article_attr'],
			'consult_id' =>$postArr['consult'],
			'showorder' =>empty($postArr['showorder']) ? 99 : $postArr['showorder'],
			'is_top'=>$postArr['is_top'],
			'article_attr_id'=>$AttridArr[0]['article_attr_id']
		);
	}

	//获取某条数据
	public function getOneData () {
		$id = intval($this ->input ->post('id'));
		$whereArr=array('scc.id='=>$id);
		$data=$this->category_consult->getData($whereArr);
		echo json_encode($data['data'][0]);
	}

	//删除
	function delete(){
		$id = intval($this->input->post("id"));
		$status = $this ->category_consult ->delete(array('id'=>$id));
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