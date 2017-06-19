<?php
/**
 *
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since 2015年07月28日11:59:53
 * @author jiakairong
 *        
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Search_condition extends UA_Controller {
	const pagesize = 10; // 分页的页数
	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'admin/a/search_condition_model', 'search_model' );
	}
	
	public function index() {
		//获取顶级
		$top_condition = $this ->search_model ->all(array('pid' =>0));
		$data = array('top' =>$top_condition);
		$this->load_view ( 'admin/a/ui/search_condition/index' ,$data);
	}
	//返回json数据
	public function get_json_data () {
		$whereArr = array();
		$pid = intval($this ->input ->post('top'));
		$page_new = intval($this ->input ->post('page_new'));
		
		if ($pid > 0) {
			$whereArr ['sc.pid'] = $pid;
		}

		//获取数据
		$list = $this ->search_model ->get_data($whereArr ,self::pagesize ,$page_new);
		$count = $this->getCountNumber($this->db->last_query());
		$page_string = $this ->getAjaxPage($page_new ,$count);
		$data = array(
			'list' =>$list,
			'page_string' =>$page_string
		);
		echo json_encode($data);
	}
	
	//添加或编辑
	public function update () {
		$this->load->library ( 'callback' );
		$post = $this->security->xss_clean($_POST);
		if ($post['minvalue'] < 1 && $post['maxvalue'] < 1 ) {
			if (empty($post ['description'])) {
				$this->callback->set_code ( 4000 ,"若您没有填写最大和最小值则描述必填");
				$this->callback->exit_json();
			}
			if (empty($post ['code'] )) {
				$this->callback->set_code ( 4000 ,"若您没有填写最大和最小值则标识码必填");
				$this->callback->exit_json();
			}
		}
		if (empty($post['code']) || empty($post['description'])) {
			if ($post['minvalue'] < 1 && $post['maxvalue'] < 1) {
				$this->callback->set_code ( 4000 ,"若您没有将标志码和描述填写完整则最大值和最小值最少填一个");
				$this->callback->exit_json();
			}
		}
		$post['showorder'] = empty($post['showorder']) ? 999 : $post['showorder'];
		$post['minvalue'] = intval($post['minvalue']);
		$post['maxvalue'] = intval($post['maxvalue']);
		if ($post['id'] > 0) {
			//编辑
			$log_type = 3;
			$log_message = '平台编辑搜索条件:ID:'.$post['id'];
			$whereArr = array('id' =>$post['id']);
			$status = $this ->search_model ->update($post ,$whereArr);
		} else {
			//添加
			unset($post['id']);
			$status = $this ->search_model ->insert($post);
			$log_type = 1;
			$log_message = '平台增加搜索条件，ID:'.$status;
		}
		if (!empty($status)) {
			$this->cache->redis->delete('SYSearchPriceAll');
			$this->cache->redis->delete('SYSearchDayAll');
			$this ->log($log_type,3,'搜索条件管理',$log_message);
			$this->callback->set_code ( 2000 ,"操作成功");
			$this->callback->exit_json(); 
		} else {
			$this->callback->set_code ( 4000 ,"操作失败");
			$this->callback->exit_json();
		}
 	}
 	//删除数据
 	public function delete() {
 		$this->load->library ( 'callback' );
 		$id = intval($this ->input ->post('id'));
 		$status = $this ->search_model ->delete(array('id' =>$id));
 		if ($status == false) {
 			$this->callback->set_code ( 4000 ,"操作失败");
 			$this->callback->exit_json();
 		} else {
 			$this->cache->redis->delete('SYSearchPriceAll');
 			$this->cache->redis->delete('SYSearchDayAll');
 			$this ->log(2,3,'搜索条件管理',"删除数据：ID：{$id}");
 			$this->callback->set_code ( 2000 ,"操作成功");
 			$this->callback->exit_json();
 		}
 	}
 	
 	public function get_one_json() {
 		$id = $this ->input ->post('id');
 		$data = $this ->search_model ->row(array('id' =>$id));
 		if (empty($data)) {
 			echo false;
 		} else {
 			echo json_encode($data);
 		}
 	}

}