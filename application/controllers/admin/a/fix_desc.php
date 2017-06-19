<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015-12-11
 * @author		jiakairong
 * @method 		广告配置
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Fix_desc extends UA_Controller
{	
	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( 'fix_desc_model', 'fix_desc_model' );
	}

	public function index()
	{
		$this->load_view ( 'admin/a/fix_desc');
	}
	
	public function getFixDescJson()
	{
		$whereArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$page_new = empty($page_new) ? 1: $page_new;
		$starttime = trim($this ->input ->post('starttime'));
		$endtime = trim($this ->input ->post('endtime'));
		
		if (!empty($starttime))
		{
			$whereArr['starttime >'] = $starttime;
		}
		if (!empty($endtime))
		{
			$whereArr['endtime <'] = $endtime.' 23:59:59';
		}
		//获取数据
		$data['list'] = $this ->fix_desc_model ->getFixDescData($whereArr ,$page_new ,sys_constant::A_PAGE_SIZE);
		$count = $this->getCountNumber($this->db->last_query());
		$data ['page_string'] = $this ->getAjaxPage($page_new ,$count);
		
		echo json_encode($data);
	}
	//增加
	public function addFixDesc()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$this ->commonFunc($postArr ,'add');
		$dataArr = array(
			'dict_code' =>trim($postArr['code']),
			'url' =>trim($postArr['url']),
			'starttime' =>$postArr['starttime'],
			'endtime' =>$postArr['endtime'],
			'showorder' =>empty($postArr['showorder']) ? 99 : intval($postArr['showorder']),
			'pic' =>$postArr['pic'],
			'description' =>trim($postArr['description']),
			'no_description' =>trim($postArr['no_description']),
			'enable' =>0,
			'isdelete' =>intval($postArr['isdelete'])
		); 
		$status = $this ->fix_desc_model ->insert($dataArr);
		if (empty($status))
		{
			$this->callback->set_code ( 4000 ,'添加失败');
			$this->callback->exit_json();
		}
		else
		{
			$this ->log(1,3,'广告管理'.'添加广告');
			$this->callback->set_code ( 2000 ,'添加成功');
			$this->callback->exit_json();
		}
	}
	//编辑
	public function editFixDesc() {
	$postArr = $this->security->xss_clean($_POST);
		
		$this ->commonFunc($postArr ,'edit');
		$dataArr = array(
			'url' =>trim($postArr['url']),
			'starttime' =>$postArr['starttime'],
			'endtime' =>$postArr['endtime'],
			'showorder' =>empty($postArr['showorder']) ? 99 : intval($postArr['showorder']),
			'pic' =>$postArr['pic'],
			'description' =>trim($postArr['description'])
		); 
		$status = $this ->fix_desc_model ->update($dataArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->set_code ( 4000 ,'编辑失败');
			$this->callback->exit_json();
		}
		else
		{
			$this ->log(1,3,'广告管理'.'编辑广告');
			$this->callback->set_code ( 2000 ,'编辑成功');
			$this->callback->exit_json();
		}
	}
	//添加编辑时公用
	public function commonFunc($postArr ,$type)
	{
		if ($type == 'add')
		{
			if (empty($postArr['code']))
			{
				$this->callback->set_code ( 4000 ,'请填写固定标识');
				$this->callback->exit_json();
			} 
		}
		if (empty($postArr['url']))
		{
			$this->callback->set_code ( 4000 ,'请填写跳转地址');
			$this->callback->exit_json();
		}
		if (empty($postArr['starttime']))
		{
			$this->callback->set_code ( 4000 ,'请填写开始时间');
			$this->callback->exit_json();
		}
		if (empty($postArr['endtime']))
		{
			$this->callback->set_code ( 4000 ,'请填写结束时间');
			$this->callback->exit_json();
		}
		if ($postArr['endtime'] <= $postArr['starttime'])
		{
			$this->callback->set_code ( 4000 ,'结束时间必须大于开始时间');
			$this->callback->exit_json();
		}
		$timenow = date('Y-m-d H:i:s' ,time());
		if ($postArr['endtime'] <= $timenow)
		{
			$this->callback->set_code ( 4000 ,'结束时间必须在今日之后');
			$this->callback->exit_json();
		}
		if (empty($postArr['pic'])) 
		{
			$this->callback->set_code ( 4000 ,'请上传图片');
			$this->callback->exit_json();
		}
	}
	
	//获取某条数据
	public function getFixDescDetail ()
	{
		$id = intval($this ->input ->post('id'));
		$fixDesc = $this ->fix_desc_model ->row(array('id' =>$id));
		echo json_encode($fixDesc);
	}

	//删除
	function delete(){
		$id = intval($this->input->post("id"));
		$status = $this ->fix_desc_model ->delete(array('id'=>$id));
		if (empty($status))
		{
			$this->callback->set_code ( 4000 ,'删除失败');
			$this->callback->exit_json();
		} 
		else
		{
			$this ->log(2,3,'广告管理','平台删除广告，ID:'.$id);
			$this->callback->set_code ( 2000 ,'删除成功');
			$this->callback->exit_json();
		}
	}
}