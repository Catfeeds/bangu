<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年01月18日10:35:53
 * @author		wangxiaofeng
 * @method 		深窗目的地线路配置
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Sc_dest_line extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model('admin/a/sc_dest_line_model','dest_line_model');
	}

	function index()
	{
		$this->load_view ( 'admin/a/sc_cfg/sc_dest_line_list');
	}

	public function getDestLineData()
	{
		//获取数据
		$data = $this ->dest_line_model ->getDestLineData();
		echo json_encode($data);
	}
	//增加首页分类目的地线路
	public function add() {
		$postArr = $this->security->xss_clean($_POST);

		$sellArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->dest_line_model ->insert($sellArr);
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"添加失败");
			$this->callback->exit_json();
		} else {
			$this ->log(1,3,'深窗目的地线路配置','增加深窗目的地线路配置');
			$this->callback->set_code ( 2000 ,"添加成功");
			$this->callback->exit_json();
		}
	}
	//编辑首页分类目的地线路
	public function edit() {
		$postArr = $this->security->xss_clean($_POST);

		if (empty($postArr['id'])) {
			$this->callback->set_code ( 4000 ,"缺少编辑的数据");
			$this->callback->exit_json();
		}
		$sellArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->dest_line_model ->update($sellArr ,array('id' =>intval($postArr['id'])));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"编辑失败");
			$this->callback->exit_json();
		} else {
			$this ->log(3,3,'深窗目的地线路配置','编辑深窗目的地线路');
			$this->callback->set_code ( 2000 ,"编辑成功");
			$this->callback->exit_json();
		}
	}
	//添加编辑时公用
	public function commonFunc($postArr ,$type)
	{
		if(empty($postArr['sc_dest_id']))
		{
			$this->callback->set_code ( 4000 ,'请选择分类目的地');
			$this->callback->exit_json();
		}
		if (empty($postArr['line_id']))
		{
			$this->callback->set_code ( 4000 ,'请选择线路');
			$this->callback->exit_json();
		}
		else
		{
			if ($type == 'add')
			{
				$destLineData = $this ->dest_line_model ->row(array('line_id' =>$postArr['line_id'] ,'dest_id' =>intval($postArr['sc_dest_id'])) ,'arr' ,'' ,'id');
			}
			else
			{
				$destLineData = $this ->dest_line_model ->row(array('line_id'=>$postArr['line_id'] ,'dest_id' =>intval($postArr['sc_dest_id']),'id !='=>$postArr['id'] ));
			}
			if (!empty($destLineData))
			{
				$this->callback->set_code ( 4000 ,'此分类目的地下已配置此线路');
				$this->callback->exit_json();
			}
		}
		if (empty($postArr['pic']))
		{
			$this ->load_model('common/u_line_model' ,'line_model');
			$lineData = $this ->line_model ->row(array('id'=>$postArr['line_id']) ,'arr' ,'' ,'mainpic');
			$pic = $lineData['mainpic'];
		}
		else
		{
			$pic = $postArr['pic'];
		}
		return array(
				'dest_id' =>intval($postArr['sc_dest_id']),
				'line_id ' =>intval($postArr['line_id']),
				'pic' =>$pic,
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'beizhu' =>trim($postArr['beizhu']),
				'showorder' =>empty($postArr['showorder']) ? 999 : intval($postArr['showorder'])
		);
	}

	//获取某条数据
	public function getOneData () {
		$id = intval($this ->input ->post('id'));
		$whereArr=array('sc_ld.id ='=>$id);
		$data=$this ->dest_line_model ->getDestLineData($whereArr);
		if (empty($data)) {
			echo false;
			exit;
		} else {
			$data = $data['data'][0];
			//获取分类目的地的上级
			$this ->load_model('admin/a/index_kind_dest_model','kind_dest_model');
			$kindDestData = $this ->kind_dest_model ->row(array('dest_id' =>$data['dest_id']));
			$data['index_kind_id'] = $kindDestData['index_kind_id'];
			echo json_encode($data);
		}
	}

	/**
	 * @method 获取首页一级分类以及分类目的地
	 * @since  2015-11-24
	 */
	public function getKindDestJson()
	{
		$kindArr = array();
		$this ->load_model('admin/a/index_kind_model' ,'kind_model');
		$this ->load_model('admin/a/index_kind_dest_model','kind_dest_model');
		//一级分类
		$kindData = $this ->kind_model ->all(array('is_show'=>1));
		foreach($kindData as $val)
		{
			if ($val['name'] == '主题游')
			{
				continue;
			}
			$kindArr[$val['id']] = $val;
		}
		//二级分类
		$kindDestData = $this ->kind_dest_model ->getKindDestAll(array('is_show' =>1));
		foreach($kindDestData as $val)
		{
			if (array_key_exists($val['index_kind_id'], $kindArr))
			{
				$kindArr[$val['index_kind_id']]['lower'][] = $val;
			}
		}
		echo json_encode($kindArr);
	}

	//删除首页分类目的地线路
	function delete(){
		$id = intval($this->input->post("id"));
		$status = $this ->dest_line_model ->delete(array('id'=>$id));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"删除失败");
			$this->callback->exit_json();
		}
		else {
			$this ->log(2,3,'深窗目的地线路配置',"平台删除深窗目的地线路配置,记录ID:{$id}");
			$this->callback->set_code ( 2000 ,"删除成功");
			$this->callback->exit_json();
		}
	}

}