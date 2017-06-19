<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
* @version		1.0
* @since		2015年09月21日
* @author 	jiakairong
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Hire extends UA_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'common/cfg_hire_model', 'hire_model' );
	}
	
	public function index() {
		$this->load_view ( 'admin/a/cfg/hire' );
	}
	
	/**
	 * @method 招聘管理数据分页
	 */
	public function getHireData() {
		$whereArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$title = trim($this ->input ->post('title' ,true));
		$start_time = trim($this ->input ->post('start_time' ,true));
		$end_time = trim($this ->input ->post('end_time' ,true));
		
		if (!empty($title)) {
			$whereArr ['title like'] = "%$title%";
		}
		if (!empty($start_time) && !empty($end_time)) {
			$whereArr ['modtime >='] = $start_time.' 00:00:00';
			$whereArr ['modtime <='] = $end_time.' 23:59:59';
		} elseif (!empty($start_time)) {
			$whereArr ['modtime >='] = $start_time.' 00:00:00';
		} elseif (!empty($end_time)) {
			$whereArr ['modtime <='] = $end_time.' 23:59:59';
		}
		$data ['list'] = $this ->hire_model ->result($whereArr ,$page_new ,sys_constant::A_PAGE_SIZE ,'modtime desc');
		$count = $this ->getCountNumber($this->db->last_query());
		//获取分页
		$data['page_string'] = $this ->getAjaxPage($page_new ,$count);
		
		echo json_encode($data);
	}
	//添加招聘
	public function addSubmitForm() {
		$title = trim($this ->input ->post('title' ,true)); 
		$hire_num = intval($this ->input ->post('hire_num' ,true));
		$responsibility = trim($this ->input ->post('responsibility' ,true));
		$requirement = trim($this ->input ->post('requirement' ,true));
		try {
			if (empty($title)) {
				throw new Exception('请填写标题');
			}
			if (empty($hire_num)) {
				throw new Exception('请填写招聘人数');
			}
			if (empty($responsibility)) {
				throw new Exception('请填写岗位职责');
			}
			if (empty($requirement)) {
				throw new Exception('请填写岗位要求');
			}
			$time = date('Y-m-d H:i:s' ,time());
			$hireArr = array(
				'title' =>$title,
				'hire_num' =>$hire_num,
				'responsibility' =>$responsibility,
				'requirement' =>$requirement,
				'enable' =>1,
				'addtime' =>$time,
				'modtime' =>$time
			);
			$hireId = $this ->hire_model ->insert($hireArr);
			if (empty($hireId)) {
				throw new Exception('添加失败');
			} else {
				$this ->log(1,3,'招聘管理','添加招聘信息,招聘标题：'.$title);
				$this->callback->set_code ( 2000 ,'添加成功');
				$this->callback->exit_json();
			}
			
		} catch (Exception $e) {
			$this->callback->set_code ( 4000 ,$e ->getMessage());
			$this->callback->exit_json();
		}
	}
	
	//发布
	public function hireRelease() {
		$id = intval($this ->input ->post('id'));
		$time = date('Y-m-d H:i:s' ,time());
		$hireArr =array(
			'enable' =>1,
			'modtime' =>$time
		);
		$status = $this ->hire_model ->update($hireArr ,array('id' =>$id));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,'发布失败');
			$this->callback->exit_json();
		} else {
			$this ->log(3,3,'招聘管理','发布招聘信息,招聘ID:'.$id);
			$this->callback->set_code ( 2000 ,'发布成功');
			$this->callback->exit_json();
		}
	}
	
	//取消发布
	public function hireCancel() {
		$id = intval($this ->input ->post('id'));
		$time = date('Y-m-d H:i:s' ,time());
		$hireArr =array(
				'enable' =>0,
				'modtime' =>$time
		);
		$status = $this ->hire_model ->update($hireArr ,array('id' =>$id));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,'取消发布失败');
			$this->callback->exit_json();
		} else {
			$this ->log(3,3,'招聘管理','取消发布招聘信息,招聘ID:'.$id);
			$this->callback->set_code ( 2000 ,'取消发布成功');
			$this->callback->exit_json();
		}
	}
	//编辑
	public function editHire() {
		$title = trim($this ->input ->post('title' ,true));
		$hire_num = intval($this ->input ->post('hire_num' ,true));
		$responsibility = trim($this ->input ->post('responsibility' ,true));
		$requirement = trim($this ->input ->post('requirement' ,true));
		$id = intval($this ->input ->post('id'));
		try {
			if (empty($title)) {
				throw new Exception('请填写标题');
			}
			if (empty($hire_num)) {
				throw new Exception('请填写招聘人数');
			}
			if (empty($responsibility)) {
				throw new Exception('请填写岗位职责');
			}
			if (empty($requirement)) {
				throw new Exception('请填写岗位要求');
			}
			$time = date('Y-m-d H:i:s' ,time());
			$hireArr = array(
					'title' =>$title,
					'hire_num' =>$hire_num,
					'responsibility' =>$responsibility,
					'requirement' =>$requirement,
					'modtime' =>$time
			);
			$hireId = $this ->hire_model ->update($hireArr ,array('id' =>$id));
			if (empty($hireId)) {
				throw new Exception('编辑失败');
			} else {
				$this ->log(3,3,'招聘管理','编辑招聘信息,招聘标题：'.$title);
				$this->callback->set_code ( 2000 ,'编辑成功');
				$this->callback->exit_json();
			}
				
		} catch (Exception $e) {
			$this->callback->set_code ( 4000 ,$e ->getMessage());
			$this->callback->exit_json();
		}
	}
	
	//获取招聘详情
	public function getHireDetail() {
		$id = intval($this ->input ->post('id'));
		$hireData = $this ->hire_model ->row(array('id' =>$id));
		if (empty($hireData)) {
			echo false;
		} else {
			echo json_encode($hireData);
		}
	}
	
}