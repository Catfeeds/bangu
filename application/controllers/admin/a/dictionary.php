<?php
/**
 *
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since 2015年5月26日11:59:53
 * @author 何俊
 * @method 数据库字典   
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
	class Dictionary extends UA_Controller {
		const pagesize = 10;
		
		public function __construct() {
			parent::__construct ();
			$this->load->model ( 'admin/a/dictionary_model', 'dictionary' );
			$this->load->library ( 'callback' );
		}

	/**
	 * @method 数据库字典列表
	 * @author 贾开荣
	 * @since 2015-05-27
	 */
	public function index() {
		$where = array();
		$like = array();
		$page = $this ->input ->post('page' ,true);
		$is = $this ->input ->post('is' ,true);
		$name = trim($this ->input ->post('name' ,true));
		$pid = $this ->input ->post('pid' ,true);
		$page = empty($page)?1:$page;
		if (!empty($name)) {
			$like ['description'] = $name;
		}
		if (!empty($pid)) {
			$where ['pid'] = $pid;
		}
		
		$list = $this ->dictionary ->get_list_data($where ,$page ,self::pagesize ,$like);
		$count = $this->getCountNumber($this->db->last_query());
		$page_str = $this ->getAjaxPage($page ,$count);
		//获取上级
		foreach($list as $key =>$val) {
			$parent_name = '';
			if (!empty($val ['pid'])) {
				$data = $this ->dictionary ->row(array('dict_id' =>$val['pid']));
				if (!empty($data)) {
					$parent_name = $data ['description'];
				}
			}
			$list [$key] ['parent_name'] = $parent_name;
		}
		//获取顶级
		$parent_list = $this ->dictionary ->all(array('pid' =>0));
		
		$data = array(
			'page_str' =>$page_str,
			'list' =>$list,
			'parent_list' =>$parent_list
		);
		if ($is == 1) {
			echo json_encode($data);
			exit;
		}
		$this->load_view ( 'admin/a/ui/dictionary/index' ,$data);
	}
	
	/**
	 * @method 添加或编辑
	 * @author 贾开荣
	 * @since 2015-05-27
	 */
	public function change_dict() {
		$dict_id = $this ->input ->post('dict_id' ,true);
		$description = trim($this ->input ->post('description' ,true)); //名称/描述
		$showorder = $this ->input ->post('showorder' ,true); //排序
		$pid = intval($_POST['pid']); //上级
		$dict_code = trim($this ->input ->post('dict_code' ,true)); //唯一标识
		$pic = trim($this ->input ->post('pic'));//图片
		if (empty($description)) {
			$this->callback->set_code ( 4000 ,"请填写名称");
			$this->callback->exit_json();
		}
		if (!empty($dict_code)) {
			if (empty($dict_id)) {
				$data = $this ->dictionary ->row(array('dict_code' =>$dict_code));
			} else {
				$data = $this ->dictionary ->row(array('dict_code' =>$dict_code ,'dict_id !=' =>$dict_id));
			}
			if (!empty($data)) {
				$this->callback->set_code ( 4000 ,"唯一标识符已存在");
				$this->callback->exit_json();
			}
		}
		$showorder = empty($showorder)?999:$showorder;
		
		$data = array(
			'description' =>$description,
			'showorder' =>$showorder,
			'pid' =>$pid,
			'dict_code' =>$dict_code,
			'pic' =>$pic
		);
		if (!empty($dict_id)) { //编辑
			$this ->db ->where(array('dict_id' =>$dict_id));
			$status = $this ->db ->update('u_dictionary' ,$data);
			$log_type = 3;
			$log_message = '平台编辑数据库字典,ID:'.$dict_id;
		} else {
			$status = $this ->db ->insert('u_dictionary' ,$data);
			$id = $this ->db ->insert_id();
			$log_type = 1;
			$log_message = '平台新增数据库字典,ID:'.$id;
		}
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"操作失败");
			$this->callback->exit_json();
		} else {
			$this ->log($log_type,3,'平台运营设置->数据库字典',$log_message);
			$this->callback->set_code ( 2000 ,"操作成功");
			$this->callback->exit_json();
		}
	}
	
	/**
	 * @method 获取一条数据
	 * @author 贾开荣
	 * @since 2015-05-27
	 */
	public function get_one_json() {
		$dict_id = $this ->input ->post('id');
		$data = $this ->dictionary ->get_list_data(array('dict_id' =>$dict_id));
		if (!empty($data)) {
			echo json_encode($data[0]);
			exit;
		}
		echo json_encode(array());
	}
	/**
	 * @method 删除记录
	 * @author 贾开荣
	 * @since 2015-05-27
	 */
	public function delete() {
		$dict_id = intval($_POST['id']);
		$data = $this ->dictionary ->get_list_data(array('pid' =>$dict_id) ,1,1);
		
		if (!empty($data)) {
			$this->callback->set_code ( 4000 ,"请先删除下级");
			$this->callback->exit_json();
		}
		$this ->db ->where(array('dict_id' =>$dict_id));
		$status = $this ->db ->delete('u_dictionary');
		
		if (!empty($status)) {
			$this ->log(2,3,'运营设置->数据库字典',"平台删除数据库字典,记录ID:{$dict_id}");
			$this->callback->set_code ( 2000 ,"删除成功");
			$this->callback->exit_json();
		} else {
			$this->callback->set_code ( 4000 ,"删除失败");
			$this->callback->exit_json();
		}
	}
	
}