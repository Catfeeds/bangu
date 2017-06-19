<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		jiakairong
 * @method 		特价线路
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Index_line_Sell extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model('admin/a/index_line_sell_model','sell_model');
	}
	public function index()
	{
		$this->view ( 'admin/a/cfg/index_line_sell_list');
	}
	public function getlineSellData()
	{
		$whereArr = array();
		$name = trim($this ->input ->post('name' ,true));
		$stime = trim($this ->input ->post('stime' ,true));
		$etime = trim($this ->input ->post('etime' ,true));
		$city = intval($this ->input ->post('city'));
		$province = intval($this ->input ->post('province'));
		if (!empty($name))
		{
			$whereArr ['l.linename like '] = '%'.$name.'%';
		}
		if (!empty($city))
		{
			$whereArr ['ils.startplaceid ='] = $city;
		}
		elseif (!empty($province))
		{
			$whereArr['s.pid ='] = $province;
		}
		if (!empty($stime))
		{
			$whereArr ['ils.starttime >='] = $stime; 
		}
		if (!empty($etime))
		{
			$whereArr ['ils.endtime <='] = $etime.' 23:59:59';
		}
		//获取数据
		$data = $this ->sell_model ->getLineSellData($whereArr);
		echo json_encode($data);
	}
	//增加特价线路
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		
		$dataArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->sell_model ->insert($dataArr);
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'添加失败');
		}
		else
		{
			$this->cache->redis->delete('SYhomeLineSell');
			$this ->log(1,3,'特价线路配置','增加特价线路');
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}
	}
	//编辑特价线路
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->sell_model ->update($dataArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'编辑失败');
		}
		else
		{
			$this->cache->redis->delete('SYhomeLineSell');
			$this ->log(3,3,'特价线路配置','编辑特价线路');
			$this->callback->setJsonCode ( 2000 ,'编辑成功');
		}
	}
	//添加编辑时公用
	public function commonFunc($postArr ,$type)
	{
		$city = empty($postArr['city']) ? 0 : intval($postArr['city']);
		$lineId = intval($postArr['lineId']);
		$showorder = intval($postArr['showorder']);
		$starttime = trim($postArr['starttime']);
		$endtime = trim($postArr['endtime']);
		if (empty($city))
		{
			$this->callback->setJsonCode ( 4000 ,'请选择出发城市');
		}
		if (empty($lineId))
		{
			$this->callback->setJsonCode ( 4000 ,'请选择线路');
		} 
		else
		{
			if ($type == 'add')
			{
				$sellData = $this ->sell_model ->row(array('line_id' =>$lineId ,'startplaceid' =>$city));
			} 
			else 
			{
				$sellData = $this ->sell_model ->row(array('line_id'=>$lineId ,'id !='=>intval($postArr['id']) ,'startplaceid' =>$city));
			}
			if (!empty($sellData))
			{
				$this->callback->setJsonCode ( 4000 ,'当前出发城市下已有此线路，请重新选择');
			}
		}
		$this ->load_model('common/u_line_model' ,'line_model');
		$lineData = $this ->line_model ->row(array('id'=>$lineId ,'status' =>2) ,'arr' ,'' ,'mainpic');
		if (empty($lineData))
		{
			$this->callback->setJsonCode ( 4000 ,'线路不存在');
		}
		if (empty($starttime) || empty($endtime))
		{
			$this->callback->setJsonCode ( 4000 ,'请选择开始或结束时间');
		}
		else
		{
			if ($starttime >= $endtime)
			{
				$this->callback->setJsonCode ( 4000 ,'结束时间要大于开始时间');
			}
		}
		return array(
				'line_id ' =>$lineId,
				'pic' =>empty($postArr['pic']) ? $lineData['mainpic'] : $postArr['pic'],
				'is_modify' =>intval($postArr['is_modify']),
				'is_show' =>intval($postArr['is_show']),
				'beizhu' =>trim($postArr['beizhu']),
				'showorder' =>empty($showorder) ? 999 : intval($showorder),
				'startplaceid' =>$city,
				'endtime' =>$endtime,
				'starttime' =>$starttime
		);
	}
	
	//获取某条数据
	public function getDetailJson()
	{
		$id = intval($this ->input ->post('id'));
		$data=$this ->sell_model ->getDetailData($id);
		if (!empty($data))
		{
			echo json_encode($data[0]);
		}
	}

	//删除特价线路
	function delLineSell()
	{
		$id = intval($this->input->post("id"));
		$status = $this ->sell_model ->delete(array('id'=>$id));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'删除失败');
		} 
		else
		{
			$this->cache->redis->delete('SYhomeLineSell');
			$this ->log(2,3,'特价线路配置','平台删除特价线路');
			$this->callback->setJsonCode ( 2000 ,'删除成功');
		}
	}
}