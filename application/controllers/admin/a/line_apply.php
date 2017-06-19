<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月20日11:59:53
 * @author		jiakairong
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_apply extends UA_Controller {
	const pagesize=10;
	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'admin/a/line_model', 'line_model' );
	}
	
	//商家给管家升级
	public function index() {
		$status = intval($this ->input ->get('status'));
		// 管家级别
		$this ->load_model('admin/a/expert_grade_model','grade_model');
		$gradeData = $this ->grade_model ->all();
		$gradeArr = array();
		foreach($gradeData as $val) {
			$gradeArr[$val['grade']] = $val['title'];
		}
		
		$data = array(
				'status' =>$status,
				'gradeArr' =>$gradeArr
		);
		$this->load_view ( 'admin/a/ui/line/line_no_apply_list' ,$data);
	}
	//管家升级数据
	public function get_expert_upgrade_json() {
		
		$whereArr = array();
		$likeArr = array();
		$post = $this->security->xss_clean($_POST);
		$status = intval($this ->input ->post('status'));
		$page_new = intval($this ->input ->post('page_new'));
		
		
		switch($status) {
			case 1:
				$whereArr ['eu.status'] = 1;
				break;
			case 2:
				$whereArr ['eu.status'] = -2;
				break;
			default:
				$whereArr ['eu.status'] = 1;
				break;
		}
		//线路名称搜索
		if (!empty($post['linename'])) {
			$likeArr ['l.linename'] = trim($post['linename']);
		}
		//供应商
		if (!empty($post['supplier_id'])) {
			$whereArr ['s.id'] = intval($post['supplier_id']);
		} elseif (!empty($post['company_name'])) {
			$this ->load_model ('admin/a/supplier_model' ,'supplier_model');
			$supplier = $this ->supplier_model ->all(array('company_name like' =>"%{$post['company_name']}%" ,'status' =>2));
			if (empty($supplier)) {
				echo false;exit;
			} else {
				$supp_id = '';
				foreach($supplier as $val) {
					$supp_id .= $val['id'].',';
				}
				$whereArr['s.id'] = rtrim($supp_id ,',');
			}
		}
		//目的地
		if (!empty($post['destinations']) && !empty($post['overcity'])) {
			$whereArr['l.overcity'] = array(intval($post['overcity']));
		} elseif (!empty($post['destinations'])) {
			$this ->load_model ('admin/a/destination_model' ,'dest_model');
			$dest = $this ->dest_model ->all(array('kindname like' =>"%{$post['destinations']}%"));
			if (empty($dest)) {
				echo false;exit;
			} else {
				$dest_id = array();
				foreach($dest as $val) {
					$dest_id[] = $val['id'];
				}
				$whereArr['l.overcity'] = $dest_id;
			}
		}
		//出发城市
		if (!empty($post['startcity']) && !empty($post['startcity_id'])) {
			$whereArr ['l.startcity'] = intval($post['startcity_id']);
		} elseif(!empty($post['startcity'])) {
			$this ->load_model('admin/a/startplace_model' ,'start_model');
			$start = $this ->start_model ->all(array('cityname like' =>"%{$post['startcity']}%" ,'isopen' =>1));
			if (empty($start)) {
				echo false;exit;
			} else {
				$start_id = '';
				foreach($start as $val) {
					$start_id .= $val['id'].',';
				}
				$whereArr['l.startcity'] = rtrim($start_id ,',');
			}
		}
		//管家名
		if (!empty($post['expert_id'])) {
			$whereArr ['e.id'] = intval($post['expert_id']);
		} elseif (!empty($post['expert_name'])) {
			$this ->load_model('admin/a/expert_model' ,'expert_model');
			$expert = $this ->expert_model ->all(array('realname like' =>"%{$post['expert_name']}%" ,'status' =>2));
			if (empty($expert)) {
				echo false;exit;
			} else {
				$eid = '';
				foreach($expert as $val) {
					$eid .= $val['id'].',';
				}
				$whereArr ['e.id'] = rtrim($eid ,',');
			}
		}

		//获取数据
		$list = $this ->line_model ->get_expert_upgrade_data($whereArr ,$page_new ,self::pagesize ,$likeArr);
		$count = $this->getCountNumber($this->db->last_query());
		$page_string = $this ->getAjaxPage($page_new ,$count);
		$data = array(
			'list' => $list,
			'page_string' =>$page_string
		);

		echo json_encode($data);
	}


	//已申请
	public function applied_line($page=1) {
		// 管家级别
		$this ->load_model('admin/a/expert_grade_model','grade_model');
		$gradeData = $this ->grade_model ->all();
		$gradeArr = array();
		foreach($gradeData as $val) {
			$gradeArr[$val['grade']] = $val['title'];
		}
		
		$this->load_view ( 'admin/a/ui/line/line_appplied_list',array('gradeArr' =>$gradeArr));
	}
	public function get_applied_line() {
		$whereArr = array();
		$likeArr = array();
		$post = $this->security->xss_clean($_POST);
		$status = intval($this ->input ->post('status'));
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1 : $page_new;
		switch($status) {
			case 2:
				$whereArr ['la.status'] = 2;
				break;
			default:
				$whereArr ['la.status'] = 2;
				break;
		}
		//线路名称搜索
		if (!empty($post['linename'])) {
			$likeArr ['l.linename'] = trim($post['linename']);
		}
		//供应商
		if (!empty($post['supplier_id'])) {
			$whereArr ['s.id'] = intval($post['supplier_id']);
		} elseif (!empty($post['company_name'])) {
			$this ->load_model ('admin/a/supplier_model' ,'supplier_model');
			$supplier = $this ->supplier_model ->all(array('company_name like' =>"%{$post['company_name']}%" ,'status' =>2));
			if (empty($supplier)) {
				echo false;exit;
			} else {
				$supp_id = '';
				foreach($supplier as $val) {
					$supp_id .= $val['id'].',';
				}
				$whereArr['s.id'] = rtrim($supp_id ,',');
			}
		}
		//目的地
		if (!empty($post['destinations']) && !empty($post['overcity'])) {
			$whereArr['l.overcity'] = array(intval($post['overcity']));
		} elseif (!empty($post['destinations'])) {
			$this ->load_model ('admin/a/destination_model' ,'dest_model');
			$dest = $this ->dest_model ->all(array('kindname like' =>"%{$post['destinations']}%"));
			if (empty($dest)) {
				echo false;exit;
			} else {
				$dest_id = array();
				foreach($dest as $val) {
					$dest_id[] = $val['id'];
				}
				$whereArr['l.overcity'] = $dest_id;
			}
		}
		//出发城市
		if (!empty($post['startcity']) && !empty($post['startcity_id'])) {
			$whereArr ['l.startcity'] = intval($post['startcity_id']);
		} elseif(!empty($post['startcity'])) {
			$this ->load_model('admin/a/startplace_model' ,'start_model');
			$start = $this ->start_model ->all(array('cityname like' =>"%{$post['startcity']}%" ,'isopen' =>1));
			if (empty($start)) {
				echo false;exit;
			} else {
				$start_id = '';
				foreach($start as $val) {
					$start_id .= $val['id'].',';
				}
				$whereArr['l.startcity'] = rtrim($start_id ,',');
			}
		}
		//管家名
		if (!empty($post['expert_id'])) {
			$whereArr ['e.id'] = intval($post['expert_id']);
		} elseif (!empty($post['expert_name'])) {
			$this ->load_model('admin/a/expert_model' ,'expert_model');
			$expert = $this ->expert_model ->all(array('realname like' =>"%{$post['expert_name']}%" ,'status' =>2));
			if (empty($expert)) {
				echo false;exit;
			} else {
				$eid = '';
				foreach($expert as $val) {
					$eid .= $val['id'].',';
				}
				$whereArr ['e.id'] = rtrim($eid ,',');
			}
		}
		
		//获取数据
		$list = $this ->line_model ->get_line_list($whereArr ,$page_new ,self::pagesize ,$likeArr);
		
		$count = $this->getCountNumber($this->db->last_query());
		$page_string = $this ->getAjaxPage($page_new ,$count);
		$data = array(
				'list' => $list,
				'page_string' =>$page_string
		);
		echo json_encode($data);
	}
	
	
	public function get_line_json () {
		$id = intval($this ->input ->post('id'));
		$data = $this ->line_model ->get_line_list(array('la.id' =>$id));
		if (empty($data)) {
			echo false;
		} else {
			echo json_encode($data[0]);
		}
	}
	
	//获取一条数据
	public function get_one_json () {
		$id = intval($this ->input ->post('id'));
		$data = $this ->line_model ->get_expert_upgrade_data(array('eu.id' =>$id));
		if (empty($data)) {
			echo false;
		} else {
			echo json_encode($data[0]);
		}
		
	}

	// 通过申请
	function through(){
		$this->load->library ( 'callback' );
		$id = intval($this->input->post('id'));
		$modtime = date('Y-m-d H:i:s' ,time());
		$admin_id= $this->session->userdata('a_user_id');
		try{
			$this->db->trans_begin(); //事务开始
			$expert_upgrade = $this ->line_model ->get_expert_upgrade_data(array('eu.id' =>$id));
			if (empty($expert_upgrade)) {
				throw new Exception('不存在此记录');
			}
			//更改专家线路申请表
			$apply = array(
				'grade' => $expert_upgrade[0]['grade'],
				'modtime' =>$modtime
			);
			$whereArr = array(
				'expert_id' =>$expert_upgrade[0]['expert_id'],
				'line_id' =>$expert_upgrade[0]['line_id']
			);
			$this ->db ->where($whereArr);
			$status = $this ->db ->update('u_line_apply' ,$apply);
			if ($status == false) {
				throw new Exception('操作失败');
			}
			//操作日志
			$this ->log(5,3,'售卖权管理',"平台通过专家升级,线路ID:{$expert_upgrade[0]['line_id']},专家ID：{$expert_upgrade[0]['expert_id']}，表：line_apply");
			
			//更新申请升级表
			$upgrade = array(
				'deal_type' =>3,
				'user_id' =>$admin_id,
				'status' =>2
			);
			$this ->db ->where(array('id' =>$id));
			$status = $this ->db ->update('u_expert_upgrade' ,$upgrade);
			if ($status == false) {
				throw new Exception('操作失败1');
			}
			//操作日志
			$this ->log(5,3,'售卖权管理',"平台通过专家升级,记录ID:{$id},表：expert_upgrade");
			
			if ($this->db->trans_status() === FALSE) { //判断此组事务运行结果
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}
			$this->callback->set_code ( 2000 ,"操作成功");
			$this->callback->exit_json();
				
		} catch (Exception $e) {
			$this->db->trans_rollback(); //出现错误执行回滚
			$error = $e->getMessage();
			$this->callback->set_code ( 4000 ,$error);
			$this->callback->exit_json();
		}
	}
	
	//拒绝申请
	function refuse() {
		$this->load->library ( 'callback' );
		$id = intval($this->input->post('id'));
		$remark = trim($this->input->post('refuse_remark' ,true));
		if (empty($remark)) {
			$this->callback->set_code ( 4000 ,"请填写拒绝原因");
			$this->callback->exit_json();
		}
		$admin_id= $this->session->userdata('a_user_id');
		$upgrade = array(
			'refuse_remark' =>$remark,
			'status' =>-2,
			'deal_type' =>3,
			'user_id' =>$admin_id
		);
		$whereArr = array('id' =>$id);
		$this ->db ->where($whereArr);
		$status = $this ->db ->update('u_expert_upgrade' ,$upgrade);
		if ($status == false)
		{
			$this->callback->set_code ( 4000 ,'操作失败');	
		} else {
			$this ->log(5,3,'售卖权管理',"平台拒绝专家升级,记录ID:{$id},表：expert_upgrade");
			$this->callback->set_code ( 2000 ,'操作成功');
		}
		$this->callback->exit_json();
	}
	//删除管家线路
	function delete_line() {
		$this->load->library ( 'callback' );
		$id = intval($this ->input ->post('id'));
		$whereArr = array(
			'id' =>$id
		);
		$apply = array(
			'status' =>-1,
			'modtime' =>date('Y-m-d H:i:s' ,time())
		);
		$this ->db ->where($whereArr);
		$status = $this ->db ->update('u_line_apply' ,$apply);
		if ($status == false) {
			$this->callback->set_code ( 4000 ,'操作失败');
		} else {
			$this ->log(2,3,'售卖权管理',"平台删除数据,记录ID:{$id},表：line_apply");
			//给b2发送系统消息
			$data = $this ->line_model ->get_line_list(array('la.id' =>$id) ,1 ,1);
			$content = "供应商：{$data[0]['supplier_name']} <br/>线路名称：{$data[0]['line_title']} <br/>平台将您的售卖权关闭";
			$this ->add_message($content ,1,$data[0]['expert_id'] ,'平台关闭您的线路售卖权');
			$this->callback->set_code ( 2000 ,'操作成功');
		}
		$this->callback->exit_json();
	}

	 // 调整级别
	function change_expert_grade(){
		$this->load->library ( 'callback' );
		$id = intval($this->input->post('change_id'));
		//$remark = trim($this->input->post('reason' ,true));
		$this ->load_model('common/u_line_apply_model' ,'apply_model');
		$applyData = $this ->apply_model ->row(array('id' =>$id));
		
		$grade = intval($this->input->post('grade'));
		$gradeArr = array(
			'grade' =>$grade,
			'modtime' =>date('Y-m-d H:i:s' ,time())
		);
		$this ->db ->where('id',$id);
		$status = $this ->db ->update('u_line_apply' ,$gradeArr);
		if ($status == false) {
			$this->callback->set_code ( 4000 ,'调整级别失败');
			$this->callback->exit_json();
		} else {
			//给升级表写入数据
			$upgradeArr = array(
				'expert_id' =>$applyData['expert_id'],
				'line_id' =>$applyData['line_id'],
				'grade_before' =>$applyData['grade'],
				'grade_after' =>$grade,
				'deal_type' =>3,
				'user_id' =>$this ->admin_id,
				'status' =>2,
				'addtime' =>date('Y-m-d H:i:s' ,time())
			);
			$this ->load_model('common/u_expert_upgrade_model' ,'upgrade_model');
			$this ->upgrade_model ->insert($upgradeArr);
			
			$this ->log(3,3,'专家管理->线路申请管理',"平台专家申请的线路级别,记录ID:{$id}");
			//给b2发送系统消息
			$data = $this ->line_model ->get_line_list(array('la.id' =>$id) ,1 ,1);
			//获取级别
			$this ->load_model('admin/a/expert_grade_model','grade_model');
			$gradeData = $this ->grade_model ->row(array('grade' =>$grade));
			$content = "供应商：{$data[0]['supplier_name']} <br/>线路名称：{$data[0]['line_title']} <br/>平台将您的售卖级别调整为：{$gradeData['title']}";
			$this ->add_message($content ,1,$data[0]['expert_id'] ,'平台调整您的线路售卖级别');
			$this->callback->set_code ( 2000 ,'调整成功');
			$this->callback->exit_json();
		}
	}
	public function __destruct(){
		$this ->db ->close();
	}
}