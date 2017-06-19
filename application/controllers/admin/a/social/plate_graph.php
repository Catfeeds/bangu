<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2017-02-17
 * @author		zhangyunfa
 * @method 		社区轮播图
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Plate_graph extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model('admin/a/cfgm_social_plate_graph_model','plate_graph_model');
	}

	public function index()
	{
		$this->view ( 'admin/a/social/plate_graph');
	}
	
	public function getRollPicData()
	{
		$data = $this ->plate_graph_model ->getRollPicData(array());
		echo json_encode($data);
	}
	//增加
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$dataArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->plate_graph_model ->insert($dataArr);
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'添加失败');
		}
		else
		{
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}
	}
	//编辑
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->plate_graph_model ->update($dataArr ,array('id' =>intval($postArr['id'])));
		//echo $this ->db ->last_query();
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'编辑失败');
		}
		else
		{
			$this->callback->setJsonCode ( 2000 ,'编辑成功');
		}
	}
	//添加编辑时公用
	public function commonFunc($postArr ,$type)
	{
		if ($type === 'add'){
			$kind=intval($postArr['kind']);
			$sql="select id from cfgm_social_roll_pic where type=2 and is_show=1 and kind={$kind}";
			$data=$this->db->query($sql)->row_array();
			if (!empty($data)){
				$this->callback->setJsonCode('4000', '该分类已存在,请勿重复添加');
			}
		}
		$showorder = intval($postArr['showorder']);
		if (empty($postArr['pic']))
		{
			$this->callback->setJsonCode ( '4000' ,'请上传图片');
		}
                if (0 == trim($postArr['kind']))
                {
                    $this->callback->setJsonCode('4000', '请选择分类');
                }
		return  array(
				'link ' =>'',
				'pic' =>$postArr['pic'],
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'remark' =>trim($postArr['remark']),
				'showorder' =>empty($showorder) ? 999 : $showorder,
				'name' =>'',
                'kind' => trim($postArr['kind']),
				'type'=>2  //类型 1为轮播图 2为板块图
			);
	}
	//获取某条数据
	public function getDetailJson ()
	{
		$id = intval($this ->input ->post('id'));
		$data=$this ->plate_graph_model ->row(array('id' =>$id));
		echo json_encode($data);
	}
	//删除特价线路
	function delHotLine()
	{
		$id = intval($this->input->post("id"));
		$status = $this ->plate_graph_model ->delete(array('id'=>$id));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'删除失败');
		} 
		else
		{
			$this->callback->setJsonCode ( 2000 ,'删除成功');
		}
	}
}