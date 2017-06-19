<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
* @version		1.0
* @since		2015年6月30日14:46:53
* @author		何俊
*
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_friend_link extends UA_Controller {
	const pagesize = 10;

	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin/a/friend_link_model', 'friend_link_model' );
		$this->load->library ( 'callback' );

	}


	public function friend_link_list() {
		$whereArr = array();
		$likeArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$name = trim($this ->input ->post('name' ,true));
		$is = intval($this ->input ->post('is'));
		
		if (!empty($name)) {
			$likeArr ['name'] = $name;
		}
		
		//获取数据
		$list = $this ->friend_link_model ->get_friend_link_data($whereArr ,$page_new ,self::pagesize ,$likeArr);
		$count = $this->getCountNumber($this->db->last_query());
		$page_string = $this ->getAjaxPage($page_new ,$count);
		$list = $this ->handle_array($list);
		
		
		$data = array(
				'page_string' =>$page_string,
				'list' =>$list
		);
		if ($is == 1) {
			echo json_encode($data);
			exit;
		}
		$this ->load_view('admin/a/ui/index_config/index_friend_link' ,$data);
	}
	/**
	 * @method 对获得的数组进行处理
	 * @since  2015-06-11
	 * @author 贾开荣
	 * @param  array $data 要处理的数组
	 */
	public function handle_array($data) {
		foreach($data as $key =>$val) {
			switch($val['link_type']) {
				case 1:
					$data [$key]['link_type'] = '图片';
					break;
				case 2:
					$data [$key]['link_type'] = '合作';
					break;
				case 3:
					$data [$key]['link_type'] = '文字';
					break;
			}
			
			if (empty($val ['icon'])) {
				$data [$key] ['icon'] = '无';
			} else {
				$data [$key] ['icon'] = "<img src='{$val['icon']}' width='65' height='65'>";
			}
		}
		return $data;
	}
	
	//添加  或编辑
	public function edit_friend_link() {
		$link_type= trim($this ->input ->post('link_type' ,true));
		$name= trim($this ->input ->post('name' ,true));
		$url= trim($this ->input ->post('url' ,true));
		$icon= trim($this ->input ->post('icon' ,true));
		$showorder = empty($_POST['showorder'])?99:intval($_POST['showorder']);
		$id = intval($_POST['id']);
		if (empty($name))
		{
			$this->callback->set_code ( 4000 ,"请填写链接名");
			$this->callback->exit_json();
		}
		if (empty($url)) {
			$this->callback->set_code ( 4000 ,"请填写链接地址");
			$this->callback->exit_json();
		}
		$data = array(
			'name' =>$name,
			'link_type' =>$link_type,
			'url' =>$url,
			'icon' =>$icon,
			'showorder' =>$showorder
		);

		if (empty($id))
		{
			$status = $this ->friend_link_model->insert($data);			
			$id = $this ->db ->insert_id();
		}
		else
		{			
			$status = $this ->friend_link_model->update($data ,array('id' =>$id));
			
		}
		if (empty($status))
		{
			$this->callback->set_code ( 4000 ,"操作失败");
			$this->callback->exit_json();
		} else {
			$this->cache->redis->delete('SYFriendLinkPic10');
			$this->cache->redis->delete('SYFriendLinkWord30');
			$this->callback->set_code ( 2000 ,"操作成功");
			$this->callback->exit_json();
		}
	}
	//获取某条数据
	public function get_one_json () {
		$id = intval($_POST['id']);
		$data = $this ->friend_link_model ->row(array('id' =>$id));
		echo json_encode($data);
	}

	//删除
	public function delete() {
		$id = intval($_POST['id']);
		$status=$this->friend_link_model->delete(array('id' =>$id));		
		if (empty($status))
		{
			$this->callback->set_code ( 4000 ,"操作失败");
			$this->callback->exit_json();
		}else{
			$this->callback->set_code ( 2000 ,"操作成功");
			$this->callback->exit_json();
		}		
	}


}