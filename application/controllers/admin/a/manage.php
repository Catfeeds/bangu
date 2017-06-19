<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
* @version		1.0
* @since		2015年6月3日16:43
* @author		jiakairong
*
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
include './application/controllers/admin/commonExpert.php';
class Manage extends UA_Controller {
	const PAGESIZE = 10;
	
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin/a/travel_agent_model', 'travel_agent_model' );
	}
	
	//旅行社列表
	public function travel_agent() {
		$whereArr = array();
		$likeArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1: $page_new;
		$name = trim($this ->input ->post('name' ,true));
		$is = intval($this ->input ->post('is'));
		$pagesize = intval($this ->input ->post('pagesize'));
		$pagesize = empty($pagesize) ? self::PAGESIZE :$pagesize;
		
		//搜索名称
		if (!empty($name)) {
			$likeArr ['name'] = $name;
		}
		
		//获取数据
		$list = $this ->travel_agent_model ->get_travel_agent_data($whereArr ,$page_new ,$pagesize ,1 ,$likeArr);
		$count = $this->getCountNumber($this->db->last_query());
		$page_str = $this ->getAjaxPage($page_new ,$count);
		
		$data = array(
			'page_string' =>$page_str,
			'list' =>$list
		);
		if ($is == 1) {
			echo json_encode($data);
			exit;
		}
		$this->load_view ( 'admin/a/ui/manage/travel_agent',$data);
	}
	//添加旅行社
	public function add_travel_agent() {
		$this->load->library ( 'callback' );
		$name = trim($this ->input ->post('name' ,true));
		$beizhu = trim($this ->input ->post('beizhu' ,true));
		if (empty($name)) {
			$this->callback->set_code ( 4000 ,"请填写旅行社名称");
			$this->callback->exit_json();
		}
		//检查这个旅行社是否存在
		$travel_info = $this ->travel_agent_model ->row(array('name' =>$name));
		if (!empty($travel_info)) {
			$this->callback->set_code ( 4000 ,"此旅行社已存在");
			$this->callback->exit_json();
		}
		$data = array(
			'name' =>$name,
			'beizhu' =>$beizhu,
			'addtime' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->db ->insert('sp_travel_agent' ,$data);
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"添加失败");
			$this->callback->exit_json(); 
		} else {
			$id = $this ->db ->insert_id();
			$this ->log(1,3,'旅行社管理',"添加旅行社，ID：{$id}");
			$this->callback->set_code ( 2000 ,"添加成功");
			$this->callback->exit_json();
		}
	}
	//编辑旅行社
	public function edit_travel_agent() {
		$this->load->library ( 'callback' );
		$name = trim($this ->input ->post('name' ,true));
		$beizhu = trim($this ->input ->post('beizhu' ,true));
		$id = intval($this ->input ->post('id'));
		if (empty($name)) {
			$this->callback->set_code ( 4000 ,"请填写旅行社名称");
			$this->callback->exit_json();
		}
		//检查这个旅行社是否存在
		$travel_info = $this ->travel_agent_model ->row(array('name' =>$name ,'id !=' =>$id));
		if (!empty($travel_info)) {
			$this->callback->set_code ( 4000 ,"此旅行社已存在");
			$this->callback->exit_json();
		}
		$data = array(
				'name' =>$name,
				'beizhu' =>$beizhu
		);
		$this ->db ->where(array('id' =>$id));
		$status = $this ->db ->update('sp_travel_agent' ,$data);
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"编辑失败");
			$this->callback->exit_json();
		} else {
			$id = $this ->db ->insert_id();
			$this ->log(3,3,'旅行社管理',"编辑旅行社，ID：{$id}");
			$this->callback->set_code ( 2000 ,"编辑成功");
			$this->callback->exit_json();
		}
	}
	
	//获取旅行社某条数据
	public function get_one_json() {
		$id = intval($this ->input ->post('id'));
		$whereArr = array('id' =>$id);
		$data = $this ->travel_agent_model ->get_travel_agent_data($whereArr);
		if (!empty($data)) {
			echo json_encode($data[0]);
		} else {
			echo false;
		}
	}
	/************营业部*******************/
	//营业部列表
	public function sells_depart() {
		$this ->load_model ('admin/a/sells_depart_model' ,'sells_depart_model');
		$whereArr = array();
		$likeArr = array();
		
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1: $page_new;
		$name = trim($this ->input ->post('name' ,true));
		$is = intval($this ->input ->post('is'));
		
		
		//搜索名称
		if (!empty($name)) {
			$likeArr ['sd.name'] = $name;
		}

		//获取数据
		$list = $this ->sells_depart_model ->get_sells_depart_data($whereArr ,$page_new ,self::PAGESIZE ,1 ,$likeArr);
		$count = $this->getCountNumber($this->db->last_query());
		$page_str = $this ->getAjaxPage($page_new ,$count);
		
		$data = array(
				'page_string' =>$page_str,
				'list' =>$list
		);
		if ($is == 1) {
			echo json_encode($data);
			exit;
		}
		
		$this->load_view ( 'admin/a/ui/manage/sells_depart',$data);
		
	}
	//添加营业部
	public function add_sells_depart() {
		$this->load->library ( 'callback' );
		$this ->load_model ('admin/a/sells_depart_model' ,'sells_depart_model');
		
	//	$agent_id = intval($this ->input ->post('agent_id')); //旅行社ID
		$name = trim($this ->input ->post('name' ,true)); //营业部名称
		$beizhu = trim($this ->input ->post('beizhu' ,true)); //备注
		//验证旅行社
/* 		if (empty($agent_id)) {
			$this->callback->set_code ( 4000 ,"请选择旅行社");
			$this->callback->exit_json();
		} else {
			$travel_info = $this ->travel_agent_model ->row(array('id' =>$agent_id));
			if (empty($travel_info)) {
				$this->callback->set_code ( 4000 ,"您选择的旅行社不存在");
				$this->callback->exit_json();
			}
		} */
		//验证名称
		if (empty($name)) {
			$this->callback->set_code ( 4000 ,"请填写营业部名称");
			$this->callback->exit_json();
		}
		$name = explode('，',$name);
		foreach($name as $val) {
			$data = array(
				'name' =>$val,
				'beizhu' =>$beizhu,
			//	'agent_id' =>$agent_id,
				'addtime' =>date('Y-m-d H:i:s')
			);
			$status = $this ->db ->insert('sp_sells_depart' ,$data);
			if (!empty($status)) {
				$id = $this ->db ->insert_id();
				//写入操作日志
				$this ->log(1,3,'营业部管理',"添加营业部，ID：{$id}");
			}
		}
		$this->callback->set_code ( 2000 ,"添加成功");
		$this->callback->exit_json();
	}
	//编辑营业部
	public function edit_sells_depart() {
		$this->load->library ( 'callback' );
		$this ->load_model ('admin/a/sells_depart_model' ,'sells_depart_model');
		
	//	$agent_id = intval($this ->input ->post('agent_id')); //旅行社ID
		$name = trim($this ->input ->post('name' ,true)); //营业部名称
		$beizhu = trim($this ->input ->post('beizhu' ,true)); //备注
		$id = intval($this ->input ->post('id'));
		//验证旅行社
/* 		if (empty($agent_id)) {
			$this->callback->set_code ( 4000 ,"请选择旅行社");
			$this->callback->exit_json();
		} else {
			$travel_info = $this ->travel_agent_model ->row(array('id' =>$agent_id));
			if (empty($travel_info)) {
				$this->callback->set_code ( 4000 ,"您选择的旅行社不存在");
				$this->callback->exit_json();
			}
		} */
		//验证名称
		if (empty($name)) {
			$this->callback->set_code ( 4000 ,"请填写营业部名称");
			$this->callback->exit_json();
		}

		$data = array(
				'name' =>$name,
				'beizhu' =>$beizhu,
				//'agent_id' =>$agent_id,
				'addtime' =>date('Y-m-d H:i:s')
		);
		$this ->db ->where(array('id' =>$id));
		$status = $this ->db ->update('sp_sells_depart' ,$data);
		if (!empty($status)) {
			$id = $this ->db ->insert_id();
			//写入操作日志
			$this ->log(1,3,'营业部管理',"添加营业部，ID：{$id}");
			$this->callback->set_code ( 2000 ,"编辑成功");
			$this->callback->exit_json();
		} else {
			$this->callback->set_code ( 4000 ,"编辑失败");
			$this->callback->exit_json();
		}
 
		
	}
	
	//获取营业部一条数据
	public function get_depart_one_json() {
		$this ->load_model ('admin/a/sells_depart_model' ,'sells_depart_model');
		$id = intval($this ->input ->post('id'));
		$whereArr = array(
			'sd.id' =>$id
		);
		$data = $this ->sells_depart_model ->get_sells_depart_data($whereArr);
		if (empty($data)) {
			echo false;
		} else {
			echo json_encode($data['0']);
		}
	}
	//营业部管家
	function sales_expert(){
		$data['pageData']=$this->travel_agent_model->get_expert_depart(array('status'=>1),$this->getPage ());
		$this->load_view ( 'admin/a/ui/manage/sales_expert',$data);
	}
	//分页查询
	function pageData(){
		$param = $this->getParam(array('status','expertname','departtname'));
		$data=$this->travel_agent_model->get_expert_depart($param,$this->getPage ());
	//	echo $this->db->last_query();
		echo $data;
	}
	//添加营业部管家
	function add_sales_expert(){
		$this ->load_model ('admin/a/sells_depart_model' ,'sells_depart_model');
		$data['depart']=$this ->sells_depart_model->all();
		
		//目的地
		$data['destArr'] = $this ->getDestData();
		
		$this->load_view ( 'admin/a/ui/manage/add_sales_expert',$data);
	}
	public function getDestData()
	{
		$destArr = array();
		$this->load_model('dest/dest_base_model' ,'dest_base_model');
		$destData = $this ->dest_base_model ->all(array('level <=' =>2) ,'level asc');
		if (!empty($destData))
		{
			foreach($destData as $val)
			{
				if ($val['level'] == 1)
				{
					$destArr[$val['id']] = $val;
				}
				elseif ($val['level'] == 2)
				{
					if (array_key_exists($val['pid'], $destArr))
					{
						$destArr[$val['pid']]['lower'][] = $val;
					}
				}
			}
		}
		return $destArr;
	}
	//保存营业部管家
	function save_sales_expert(){
		$expertNew = new CommonExpert($_POST);
		$expertNew ->addAExpert();
	}

}