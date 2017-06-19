<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月20日11:59:53
 * @author		何俊
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Opportunity extends UA_Controller {
	const pagesize = 10; //分页的页数

	public function __construct() {
		parent::__construct ();
		$this->load->helper ( 'url' );
		$this->load->model ( 'admin/a/opportunity_model', 'opportunity_model' );
	}

	/**
	 * @author 贾开荣
	 * @method 培训公告列表
	 */
	public function opportunity_list() {
		$this->load_view('admin/a/ui/base/opportunity_list');
	}
	public function get_opportunity_data() {
		$whereArr = array ();
		$likeArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$status = intval($this ->input ->post('status'));
		$title = $this ->input ->post('title' ,true);

		$whereArr ['a.status'] = $status;
		//搜索主题
		if (!empty($title)) {
			$likeArr ['a.title'] = trim($title);
		}
		
		$list = $this ->opportunity_model ->get_line_list ( $whereArr, $page_new, sys_constant::A_PAGE_SIZE, $likeArr );
		$count = $this->getCountNumber($this->db->last_query());
		$page_string = $this ->getAjaxPage($page_new ,$count);
		//echo $this ->db ->last_query();
		$data = array(
				'list' =>$list,
				'page_string' =>$page_string
		);
		echo json_encode($data);
	}

	/**
	 * @author 贾开荣
	 * @method 新增学习机会
	 */
	public function add_opportunity() {
		$this->load->library ( 'callback' );
		$data = $this->security->xss_clean($_POST);
		foreach($data as $key =>$val)
		{
			$data [$key] = trim($val);
		}
		if (empty($data['title']))
		{
			$this->callback->set_code ( 4000 ,"请填写主题");
			$this->callback->exit_json();
		}
		if (empty($data['address']))
		{
			$this->callback->set_code ( 4000 ,"请填写地址");
			$this->callback->exit_json();
		}
		if (empty($data['sponsor']))
		{
			$this->callback->set_code ( 4000 ,"请填写主办方");
			$this->callback->exit_json();
		}
		
		if (empty($data['starttime']) || empty($data['endtime']) || empty($data['begintime'])) {
			$this->callback->set_code ( 4000 ,"请填写培训开始时间与截止时间与报名开始时间");
			$this->callback->exit_json();
		} else {
			if ($data['begintime'] > $data['endtime']) {
				$this->callback->set_code ( 4000 ,"报名开始开始时间应小于截止时间");
				$this->callback->exit_json();
			}
			if ($data['starttime'] < $data['endtime']) {
				$this->callback->set_code ( 4000 ,"培训开始时间应大于截止时间");
				$this->callback->exit_json();
			}
		}
		if (empty($data['people'])) {
			$this->callback->set_code ( 4000 ,"请填写容纳人数");
			$this->callback->exit_json();
		}
		$this->load->helper('regexp');
		if (!regexp('numberInteger' ,$data ['spend'])) {
			$this->callback->set_code ( 4000 ,"请填写正确的培训时长");
			$this->callback->exit_json();
		}
		if (empty($data['content'])) {
			$this->callback->set_code ( 4000 ,"请填写培训内容");
			$this->callback->exit_json();
		}
		
		$admin_id = $this->session->userdata ( 'a_user_id' );
// 		var_dump($data);
// 		exit;
		$data ['publisher_type'] = 3;
		$data ['publisher_id'] = $admin_id;
		$data ['addtime'] = date('Y-m-d H:i:s' ,time());
		if (empty($data['id'])) {
			// 新增
			if ($data['is'] == 1) { //保存(新增)
				$data ['status'] = 0;	
			} elseif ($data['is'] == 2) { //保存并发布（新增）
				$data ['status'] = 1;
				//发布同时给管家一条系统通知
				$noticeArr = array(
					'title' =>'有新的培训学习机会',
					'content' =>'详情请查学习机会',
					'addtime' =>$data['addtime'],
					'notice_type' =>1,
					'admin_id' =>$admin_id
				); 
			}
			unset($data['id']);
			unset($data['is']);
			$status = $this ->db ->insert('u_opportunity' ,$data);
			$id = $this ->db ->insert_id();
			$log_type = 1;
			$content = "平台新增培训公告,记录ID：{$id}";
		} else {
			unset($data['is']);
			//编辑
			$whereArr = array('id' =>$data['id']);
			$this ->db ->where($whereArr);
			$status = $this ->db ->update('u_opportunity' ,$data);
			$log_type = 1;
			$content = "平台编辑培训公告,记录ID：{$data['id']}";
		}
		
		if (empty($status))
		{
			$this->callback->set_code ( 4000 ,"操作失败");
			$this->callback->exit_json();
		}
		else
		{
			if (!empty($noticeArr)) {
				$this ->db ->insert('u_notice' ,$noticeArr);
			}
			$this ->log($log_type,3,"培训公告管理",$content);
			$this->callback->set_code ( 2000 ,"操作成功");
			$this->callback->exit_json();
		}

	}
	/**
	 * @method 取消培训公告
	 * @author jiakairong
	 */
	public function cancel(){
		$this->load->library ( 'callback' );
		$id = intval($this ->input ->post('id'));
		$oppArr = array(
				'status' =>2,
				'modtime' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->opportunity_model ->update($oppArr ,array('id' =>$id));
		if ($status == false) {
			$this->callback->set_code ( 4000 ,'取消失败');
			$this->callback->exit_json();
		} else {
			$this ->log(2,3,"培训公告管理","平台取消培训公告：公告ID:{$id}");
			$data = $this ->opportunity_model ->row('id' ,$id);
			//给已报名的人发送消息
			$oppData = $this ->opportunity_model ->get_opp_apply_data($id);
			if (!empty($oppData)) {
				foreach($oppData as $val) {
					$this ->add_message("培训标题:{$data['title']}", 1, $val['expert_id'] ,'平台取消一个培训机会');
				}
			}
			$this->callback->set_code ( 2000 ,'取消成功');
			$this->callback->exit_json();
		}
	}
	/**
	 * @method 删除培训公告
	 * @author jiakairong
	 */
	public function delete() {
		$this->load->library ( 'callback' );
		$id = intval($this ->input ->post('id'));
		$oppArr = array(
			'status' =>-1,
			'modtime' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->opportunity_model ->update($oppArr ,array('id' =>$id));
		if ($status == false) {
			$this->callback->set_code ( 4000 ,'删除失败');
			$this->callback->exit_json();
		} else {
			$this ->log(2,3,"培训公告管理","平台删除培训公告：公告ID:{$id}");
			$this->callback->set_code ( 2000 ,'删除成功');
			$this->callback->exit_json();
		}
	}
	/**
	 * @method 发布培训公告
	 * @author jiakairong
	 */
	public function release() {
		$this->load->library ( 'callback' );
		$id = intval($this ->input ->post('id'));
		$oppArr = array(
				'status' =>1,
				'modtime' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->opportunity_model ->update($oppArr ,array('id' =>$id));
		if ($status == false) {
			$this->callback->set_code ( 4000 ,'发布失败');
			$this->callback->exit_json();
		} else {
			$this ->log(3,3,"培训公告管理","平台发布培训公告：公告ID:{$id}");
			//给管家发送系统通知
			$noticeArr = array(
					'title' =>'有新的培训学习机会',
					'content' =>'详情请查学习机会',
					'addtime' =>date('Y-m-d H:i:s' ,time()),
					'notice_type' =>1,
					'admin_id' =>$this ->admin_id
			);
			$this ->db ->insert('u_notice' ,$noticeArr);
			$this->callback->set_code ( 2000 ,'发布成功');
			$this->callback->exit_json();
		}
	}
	/**
	 * @author 贾开荣
	 * @method 获取一条记录
	 */
	public function get_one_json(){
		$id = intval($_POST['id']);
		$data = $this ->opportunity_model ->get_line_list ( array('a.id' =>$id));
		if (empty($data)) {
			echo false;
		} else {
			switch($data[0]['publisher_type']) {
				case 1:
					$this ->load_model('admin/a/expert_model' ,'expert_model');
					$info = $this ->expert_model ->row(array('id' =>$data [0]['publisher_id']));
					$data [0]['publisher_name'] = $info['realname'];
					$data [0]['publisher_type'] = '专家';
					break;
				case 2:
					$this ->load_model('admin/a/supplier_model' ,'supplier_model');
					$info = $this ->supplier_model ->row(array('id' =>$data [0]['publisher_id']));
					$data [0]['publisher_name'] = $info['company_name'];
					$data [0]['publisher_type'] = '商家';
					break;
				case 3:
					$this ->load_model('admin/a/admin_model' ,'admin_model');
					$info = $this ->admin_model ->row(array('id' =>$data [0]['publisher_id']));
					$data [0]['publisher_name'] = $info['username'];
					$data [0]['publisher_type'] = '平台';
					break;
			}
			switch($data[0]['status']) {
				case 0:
					$data [0]['sname'] = '保存';
					break;
				case 1:
					$data [0]['sname'] = '已发布';
					break;
				case 2:
					$data [0]['sname'] = '已取消';
					break;
			}
			echo json_encode($data[0]);
		}
	}
}