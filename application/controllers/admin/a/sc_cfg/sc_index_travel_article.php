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
class Sc_index_travel_article extends UA_Controller {
	public $controllerName = '深窗首页旅游曝光台文章';
	public function __construct() {
		parent::__construct ();
		$this->load_model('admin/a/sc_cfg_model/sc_index_travel_article_model','travel_article');
	}

	function index(){

		$this->load_view ( 'admin/a/sc_cfg/sc_index_travel_article');
	}

	public function getDataList() {
		$whereArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1: $page_new;
		//获取数据
		$data = $this ->travel_article ->getData($whereArr ,$page_new ,sys_constant::A_PAGE_SIZE);
		echo json_encode($data);
	}
	//增加
	public function add() {
		$postArr = $this->security->xss_clean($_POST);
		$navArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->travel_article ->insert($navArr);
		$travel_article_id = $this->db->insert_id();
		if (empty($status)) {

			$this->callback->set_code ( 4000 ,"添加失败");
			$this->callback->exit_json();
		} else {
			$this->db->insert('sc_travel_article_detail', array('content'=>$postArr['article_content'],'sc_index_travel_article_id'=>$travel_article_id,'content_paper'=>strip_tags($postArr['article_content'])));
			$this ->log(1,3,'深窗首页旅游曝光台文章','深窗首页旅游曝光台文章');
			$this->callback->set_code ( 2000 ,"添加成功");
			$this->callback->exit_json();
		}
	}
	//编辑
	public function edit() {
		$postArr = $this->security->xss_clean($_POST);
		if (empty($postArr['article_id'])) {
			$this->callback->set_code ( 4000 ,"缺少编辑的数据");
			$this->callback->exit_json();
		}
		$dataArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->travel_article ->update($dataArr ,array('id' =>intval($postArr['article_id'])));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"编辑失败");
			$this->callback->exit_json();
		} else {

			$this->db->update('sc_travel_article_detail', array('content'=>$postArr['article_content'],'content_paper'=>strip_tags($postArr['article_content'])), array('id' => intval($postArr['article_detail_id'])));
			$this ->log(3,3,$this->controllerName,'编辑'.$this->controllerName);
			$this->callback->set_code ( 2000 ,"编辑成功");
			$this->callback->exit_json();
		}
	}


	public function commonFunc($postArr ,$type){
		if (empty($postArr['title'])){
			$this->callback->set_code ( 4000 ,"请填写名称");
			$this->callback->exit_json();
		}else if(empty($postArr['pic'])){
			$this->callback->set_code ( 4000 ,"缺少图片");
			$this->callback->exit_json();
		}
		return array(
			'title' =>$postArr['title'],
			'pic' =>$postArr['pic'],
			'showorder' =>empty($postArr['showorder']) ? 99 : $postArr['showorder'],
			'addtime' =>  date('Y-m-d H:i:s'),
			'modtime' => date('Y-m-d H:i:s'),
			'admin_id' => $this->session->userdata('a_user_id')
		);
	}

	//获取某条数据
	public function getOneData () {
		$id = intval($this ->input ->post('id'));
		$whereArr=array('st.id='=>$id);
		$data=$this->travel_article->getData($whereArr);
		echo json_encode($data['data'][0]);
	}

	//删除
	function delete(){
		$article_id = intval($this->input->post("article_id"));
		$article_detail_id = intval($this->input->post("article_detail_id"));
		$status = $this ->travel_article ->delete(array('id'=>$article_id));
		if (empty($status)) {
			$this->db->delete('sc_travel_article_detail', array('id' => $article_detail_id));
			$this->callback->set_code ( 4000 ,"删除失败");
			$this->callback->exit_json();
		} else {
			$this ->log(2,3,$this->controllerName,'平台删除'.$this->controllerName.',记录ID:'.$id);
			$this->callback->set_code ( 2000 ,"删除成功");
			$this->callback->exit_json();
		}
	}

}